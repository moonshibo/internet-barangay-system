
"""PB-17: TF-IDF feature extraction for the IntRENEt NLP baseline.

This is an exploratory fit on baseline candidates, not final model evaluation.
All candidate labels must be reviewed before approved training/evaluation.
For PB-18 evaluation, fit TF-IDF separately inside each training fold.
"""

import pickle
from pathlib import Path

import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer


BASE_DIR = Path(__file__).resolve().parent
DATA_PATH = (
    BASE_DIR
    / "data"
    / "IntRENEt_concern_dataset_v0.2_preprocessed.csv"
)
ARTIFACT_DIR = BASE_DIR / "artifacts"
REPORT_DIR = BASE_DIR / "reports"

VECTORIZER_PATH = ARTIFACT_DIR / "pb17_tfidf_vectorizer.pkl"
MATRIX_PATH = ARTIFACT_DIR / "pb17_tfidf_matrix.pkl"
REPORT_PATH = REPORT_DIR / "PB17_tfidf_report.txt"


def main() -> None:
    if not DATA_PATH.exists():
        raise FileNotFoundError(f"Preprocessed dataset not found: {DATA_PATH}")

    df = pd.read_csv(DATA_PATH, dtype=str).fillna("")

    required_columns = {
        "id",
        "text",
        "preprocessed_text",
        "category",
        "respondent_id",
        "review_status",
        "include_in_baseline",
        "dup_group",
    }
    missing = required_columns - set(df.columns)
    if missing:
        raise ValueError(f"Dataset is missing columns: {sorted(missing)}")

    candidates = df[
        df["include_in_baseline"].str.strip().str.upper().eq("Y")
        & df["category"].str.strip().ne("")
        & df["preprocessed_text"].str.strip().ne("")
    ].copy()

    if candidates.empty:
        raise ValueError("No usable baseline candidates found.")

    texts = candidates["preprocessed_text"].tolist()
    ids = candidates["id"].tolist()
    categories = candidates["category"].tolist()
    respondents = candidates["respondent_id"].tolist()
    review_statuses = candidates["review_status"].tolist()
    duplicate_groups = candidates["dup_group"].tolist()

    # Exploratory configuration. These settings do not approve labels.
    vectorizer = TfidfVectorizer(
        ngram_range=(1, 2),
        min_df=1,
        lowercase=False,  # PB-16 already lowercases the text.
        sublinear_tf=True,
        # No stopword list until the team agrees on one.
    )

    matrix = vectorizer.fit_transform(texts)
    vocabulary = vectorizer.get_feature_names_out()

    ARTIFACT_DIR.mkdir(parents=True, exist_ok=True)
    REPORT_DIR.mkdir(parents=True, exist_ok=True)

    with VECTORIZER_PATH.open("wb") as file:
        pickle.dump(vectorizer, file)

    with MATRIX_PATH.open("wb") as file:
        pickle.dump(
            {
                "matrix": matrix,
                "ids": ids,
                "categories": categories,
                "respondents": respondents,
                "review_statuses": review_statuses,
                "duplicate_groups": duplicate_groups,
            },
            file,
        )

    category_counts = candidates["category"].value_counts()
    status_counts = candidates["review_status"].value_counts(dropna=False)
    duplicate_count = candidates["dup_group"].str.strip().ne("").sum()

    with REPORT_PATH.open("w", encoding="utf-8") as file:
        file.write("PB-17 TF-IDF Feature Extraction Report\n")
        file.write("=" * 55 + "\n\n")
        file.write("STATUS: EXPLORATORY / PROVISIONAL\n")
        file.write(
            "This fit does not validate labels or establish model performance.\n"
        )
        file.write(
            "For PB-18 evaluation, refit TF-IDF inside each training fold.\n\n"
        )

        file.write(f"Source: {DATA_PATH}\n")
        file.write(f"Candidate rows fitted: {len(candidates)}\n")
        file.write(f"Vocabulary size: {len(vocabulary)}\n")
        file.write(
            f"Feature matrix shape: {matrix.shape[0]} rows x "
            f"{matrix.shape[1]} features\n\n"
        )

        file.write("TF-IDF settings:\n")
        file.write("  ngram_range=(1, 2)\n")
        file.write("  min_df=1\n")
        file.write("  lowercase=False (PB-16 text is already lowercased)\n")
        file.write("  sublinear_tf=True\n")
        file.write("  stopword removal: none; team decision pending\n\n")

        file.write("Candidate review-status counts:\n")
        for status, count in status_counts.items():
            file.write(f"  {status or '(blank)'}: {count}\n")

        file.write("\nCategory counts (candidate labels, not approved labels):\n")
        for category, count in category_counts.items():
            file.write(f"  {category}: {count}\n")

        file.write(f"\nRows with a duplicate-group value: {duplicate_count}\n")
        file.write(
            "\nLimitation: category counts and features reflect the current "
            "candidate dataset. Label review and duplicate handling remain "
            "unresolved. Do not treat this fit as final evaluation.\n"
        )
        file.write("\nFirst 30 vocabulary terms (alphabetical):\n")
        file.write("  " + ", ".join(sorted(vocabulary)[:30]) + "\n")

    print("PB-17 TF-IDF fit completed.")
    print("Status: EXPLORATORY / PROVISIONAL")
    print(f"Candidate rows fitted: {len(candidates)}")
    print(f"Vocabulary size: {len(vocabulary)}")
    print(f"Feature matrix shape: {matrix.shape}")
    print("\nCandidate review-status counts:")
    print(status_counts.to_string())
    print("\nCategory counts:")
    print(category_counts.to_string())
    print(f"\nVectorizer: {VECTORIZER_PATH}")
    print(f"Matrix:     {MATRIX_PATH}")
    print(f"Report:     {REPORT_PATH}")


if __name__ == "__main__":
    main()
