"""PB-17: Isolated TF-IDF exploration on the provisional reviewed dataset."""
from pathlib import Path
import pickle

import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer

SCRIPT_DIR = Path(__file__).resolve().parent
INPUT_PATH = SCRIPT_DIR / "data" / "IntRENEt_concern_dataset_v0.2_preprocessed_REVIEWED.csv"
ARTIFACT_DIR = SCRIPT_DIR / "artifacts"
REPORT_DIR = SCRIPT_DIR / "reports"

VECTOR_PATH = ARTIFACT_DIR / "pb17_tfidf_vectorizer_REVIEWED.pkl"
MATRIX_PATH = ARTIFACT_DIR / "pb17_tfidf_matrix_REVIEWED.pkl"
REPORT_PATH = REPORT_DIR / "PB17_tfidf_report_REVIEWED.txt"

EXPECTED_COUNTS = {
    "Peace and Order Concern": 14,
    "Noise Complaint": 10,
    "Community Concern": 9,
    "Barangay Assistance": 9,
}
EXPECTED_RESPONDENTS = 14


def require(condition: bool, message: str) -> None:
    if not condition:
        raise ValueError(message)


def main() -> None:
    root = SCRIPT_DIR.resolve()
    outputs = [VECTOR_PATH, MATRIX_PATH, REPORT_PATH]

    for path in [INPUT_PATH, *outputs]:
        require(
            path.resolve().is_relative_to(root),
            f"Path escapes isolated pipeline: {path}",
        )
    require(INPUT_PATH.is_file(), f"Preprocessed input missing: {INPUT_PATH}")
    for path in outputs:
        require(not path.exists(), f"Refusing to overwrite: {path}")

    df = pd.read_csv(INPUT_PATH, dtype=str).fillna("")
    required = {
        "id", "text", "preprocessed_text", "category",
        "respondent_id", "review_status", "include_in_baseline", "dup_group",
    }
    require(required.issubset(df.columns), f"Missing columns: {sorted(required - set(df.columns))}")

    candidates = df.loc[
        df["include_in_baseline"].str.strip().str.upper().eq("Y")
        & df["category"].str.strip().ne("")
        & df["preprocessed_text"].str.strip().ne("")
    ].copy()

    require(len(candidates) == 42, f"Expected 42 candidates; found {len(candidates)}")
    require(candidates["id"].is_unique, "Candidate IDs are not unique.")
    require(
        candidates["respondent_id"].nunique() == EXPECTED_RESPONDENTS,
        f"Expected {EXPECTED_RESPONDENTS} respondents; found {candidates['respondent_id'].nunique()}",
    )
    actual_counts = candidates["category"].value_counts().to_dict()
    require(
        actual_counts == EXPECTED_COUNTS,
        f"Candidate category counts differ from expected: {actual_counts}",
    )

    included_groups = candidates.loc[
        candidates["dup_group"].str.strip().ne(""), "dup_group"
    ]
    duplicate_groups = included_groups.value_counts()
    duplicate_groups = duplicate_groups[duplicate_groups > 1]
    require(
        duplicate_groups.empty,
        f"Multiple included rows share duplicate groups: {duplicate_groups.to_dict()}",
    )

    # Preserve the original PB-17 TF-IDF configuration.
    vectorizer = TfidfVectorizer(
        ngram_range=(1, 2),
        min_df=1,
        lowercase=False,
        sublinear_tf=True,
    )
    matrix = vectorizer.fit_transform(candidates["preprocessed_text"].tolist())
    feature_names = vectorizer.get_feature_names_out().tolist()

    require(matrix.shape[0] == 42, f"Unexpected matrix row count: {matrix.shape[0]}")
    require(matrix.shape[1] > 0, "TF-IDF produced no features.")

    status_counts = candidates["review_status"].value_counts().to_dict()
    report_lines = [
        "PB-17 TF-IDF EXPLORATORY REPORT",
        "Status: PROVISIONAL; labels have not been approved.",
        "",
        f"Input: {INPUT_PATH}",
        f"Candidate rows: {len(candidates)}",
        f"Unique respondents: {candidates['respondent_id'].nunique()}",
        f"TF-IDF matrix shape: {matrix.shape[0]} rows x {matrix.shape[1]} features",
        f"Review-status counts: {status_counts}",
        "",
        "Candidate counts by category:",
    ]
    for category in EXPECTED_COUNTS:
        report_lines.append(f"  {category}: {actual_counts[category]}")

    report_lines.extend([
        "",
        "Vectorizer configuration:",
        "  ngram_range=(1, 2)",
        "  min_df=1",
        "  lowercase=False",
        "  sublinear_tf=True",
        "",
        "First 30 vocabulary terms (alphabetical feature order):",
    ])
    report_lines.extend(f"  {term}" for term in feature_names[:30])
    report_lines.extend([
        "",
        "Limitations:",
        "- This is exploratory feature extraction, not model training or deployment.",
        "- All included labels remain provisional and require human review.",
        "- TF-IDF features do not establish the truth or legitimacy of a concern.",
        "- Small dataset; results must not be treated as production performance.",
        "",
    ])

    # Create only isolated output directories, then write new files.
    ARTIFACT_DIR.mkdir(parents=True, exist_ok=True)
    REPORT_DIR.mkdir(parents=True, exist_ok=True)
    for path in outputs:
        require(not path.exists(), f"Refusing to overwrite: {path}")

    with VECTOR_PATH.open("wb") as file:
        pickle.dump(vectorizer, file)
    with MATRIX_PATH.open("wb") as file:
        pickle.dump(
            {
                "matrix": matrix,
                "ids": candidates["id"].tolist(),
                "categories": candidates["category"].tolist(),
                "respondents": candidates["respondent_id"].tolist(),
                "review_statuses": candidates["review_status"].tolist(),
                "duplicate_groups": candidates["dup_group"].tolist(),
            },
            file,
        )
    REPORT_PATH.write_text("\n".join(report_lines), encoding="utf-8")

    # Read back artifacts to catch incomplete writes.
    with VECTOR_PATH.open("rb") as file:
        saved_vectorizer = pickle.load(file)
    with MATRIX_PATH.open("rb") as file:
        saved_data = pickle.load(file)
    require(
        len(saved_vectorizer.get_feature_names_out()) == matrix.shape[1],
        "Saved vectorizer feature count mismatch.",
    )
    require(
        saved_data["matrix"].shape == matrix.shape
        and saved_data["ids"] == candidates["id"].tolist(),
        "Saved matrix artifact failed verification.",
    )
    require(REPORT_PATH.is_file() and REPORT_PATH.stat().st_size > 0, "Report write failed.")

    print("Isolated PB-17 TF-IDF complete.")
    print("Status: PROVISIONAL; exploratory only.")
    print(f"Candidates: {len(candidates)}")
    print(f"Unique respondents: {candidates['respondent_id'].nunique()}")
    print(f"Matrix shape: {matrix.shape}")
    print(f"Vocabulary size: {len(feature_names)}")
    print(f"Vectorizer: {VECTOR_PATH}")
    print(f"Matrix: {MATRIX_PATH}")
    print(f"Report: {REPORT_PATH}")


if __name__ == "__main__":
    main()
