"""PB-18: Isolated exploratory Naive Bayes evaluation by respondent."""
from pathlib import Path

import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics import (
    accuracy_score,
    classification_report,
    confusion_matrix,
)
from sklearn.model_selection import LeaveOneGroupOut
from sklearn.naive_bayes import MultinomialNB
from sklearn.pipeline import Pipeline

SCRIPT_DIR = Path(__file__).resolve().parent
INPUT_PATH = SCRIPT_DIR / "data" / "IntRENEt_concern_dataset_v0.2_preprocessed_REVIEWED.csv"
REPORT_DIR = SCRIPT_DIR / "reports"
REPORT_PATH = REPORT_DIR / "PB18_exploratory_evaluation_REVIEWED_v2.txt"

CATEGORIES = [
    "Barangay Assistance",
    "Community Concern",
    "Noise Complaint",
    "Peace and Order Concern",
]
EXPECTED_COUNTS = {
    "Peace and Order Concern": 14,
    "Noise Complaint": 10,
    "Community Concern": 9,
    "Barangay Assistance": 9,
}
EXPECTED_CANDIDATES = 42
EXPECTED_RESPONDENTS = 14


def require(condition: bool, message: str) -> None:
    if not condition:
        raise ValueError(message)


def main() -> None:
    root = SCRIPT_DIR.resolve()
    require(INPUT_PATH.resolve().is_relative_to(root), "Input escapes isolated pipeline.")
    require(REPORT_PATH.resolve().is_relative_to(root), "Report escapes isolated pipeline.")
    require(INPUT_PATH.is_file(), f"Preprocessed input missing: {INPUT_PATH}")
    require(not REPORT_PATH.exists(), f"Refusing to overwrite: {REPORT_PATH}")

    df = pd.read_csv(INPUT_PATH, dtype=str).fillna("")
    required = {
        "id", "preprocessed_text", "category", "respondent_id",
        "review_status", "include_in_baseline", "dup_group",
    }
    require(required.issubset(df.columns), f"Missing columns: {sorted(required - set(df.columns))}")

    candidates = df.loc[
        df["include_in_baseline"].str.strip().str.upper().eq("Y")
    ].copy()

    require(
        len(candidates) == EXPECTED_CANDIDATES,
        f"Expected {EXPECTED_CANDIDATES} candidates; found {len(candidates)}",
    )
    require(candidates["id"].is_unique, "Candidate IDs are not unique.")
    require(
        candidates["category"].str.strip().ne("").all(),
        "Candidate with blank category found.",
    )
    require(
        candidates["preprocessed_text"].str.strip().ne("").all(),
        "Candidate with blank preprocessed text found.",
    )
    require(
        candidates["respondent_id"].str.strip().ne("").all(),
        "Candidate with blank respondent ID found.",
    )
    require(
        set(candidates["category"]) == set(CATEGORIES),
        f"Unexpected category set: {sorted(set(candidates['category']))}",
    )

    category_counts = candidates["category"].value_counts().to_dict()
    require(
        category_counts == EXPECTED_COUNTS,
        f"Candidate category counts differ from expected: {category_counts}",
    )
    respondent_count = candidates["respondent_id"].nunique()
    require(
        respondent_count == EXPECTED_RESPONDENTS,
        f"Expected {EXPECTED_RESPONDENTS} respondents; found {respondent_count}",
    )

    included_groups = candidates.loc[
        candidates["dup_group"].str.strip().ne(""), "dup_group"
    ]
    repeated_groups = included_groups.value_counts()
    repeated_groups = repeated_groups[repeated_groups > 1]
    require(
        repeated_groups.empty,
        f"Duplicate-group guard failed: {repeated_groups.to_dict()}",
    )

    review_status_counts = candidates["review_status"].value_counts().to_dict()
    all_approved = candidates["review_status"].str.strip().str.lower().eq("approved").all()

    X = candidates["preprocessed_text"].tolist()
    y = candidates["category"].tolist()
    groups = candidates["respondent_id"].tolist()

    logo = LeaveOneGroupOut()
    predictions = [None] * len(candidates)
    fold_summaries = []
    fold_notes = []
    majority_correct = 0

    for fold_number, (train_idx, test_idx) in enumerate(
        logo.split(X, y, groups=groups), start=1
    ):
        train_groups = {groups[i] for i in train_idx}
        test_groups = {groups[i] for i in test_idx}
        require(
            train_groups.isdisjoint(test_groups),
            f"Respondent leakage detected in fold {fold_number}.",
        )

        train_labels = set(y[i] for i in train_idx)
        test_labels = set(y[i] for i in test_idx)
        missing_train = sorted(test_labels - train_labels)
        if missing_train:
            fold_notes.append(
                f"Fold {fold_number}: held-out respondent "
                f"{", ".join(sorted(test_groups))}; categories absent "
                f"from training: {", ".join(missing_train)}"
            )

        pipeline = Pipeline([
            ("tfidf", TfidfVectorizer(
                ngram_range=(1, 2),
                min_df=1,
                lowercase=False,
                sublinear_tf=True,
            )),
            ("nb", MultinomialNB()),
        ])
        X_train = [X[i] for i in train_idx]
        y_train = [y[i] for i in train_idx]
        X_test = [X[i] for i in test_idx]

        pipeline.fit(X_train, y_train)
        fold_predictions = pipeline.predict(X_test)

        for index, prediction in zip(test_idx, fold_predictions):
            predictions[index] = prediction

        train_counts = pd.Series(y_train).value_counts()
        fold_majority_category = train_counts.idxmax()
        majority_correct += sum(
            y[i] == fold_majority_category for i in test_idx
        )

        fold_summaries.append(
            f"Fold {fold_number}: held-out respondent(s) "
            f"{', '.join(sorted(test_groups))}; "
            f"train={len(train_idx)}, test={len(test_idx)}"
        )

    require(all(prediction is not None for prediction in predictions),
            "Some candidate rows did not receive an out-of-fold prediction.")

    accuracy = accuracy_score(y, predictions)
    majority_accuracy = majority_correct / len(y)
    report = classification_report(
        y,
        predictions,
        labels=CATEGORIES,
        target_names=CATEGORIES,
        zero_division=0,
        digits=3,
    )
    matrix = confusion_matrix(y, predictions, labels=CATEGORIES)

    lines = [
        "PB-18 EXPLORATORY EVALUATION REPORT",
        "Status: PROVISIONAL; labels have not been approved.",
        "",
        f"Input: {INPUT_PATH}",
        f"Candidate examples: {len(candidates)}",
        f"Unique respondents: {respondent_count}",
        f"Review-status counts: {review_status_counts}",
        f"All candidate labels approved: {all_approved}",
        "",
        "Evaluation design:",
        "  Leave-One-Group-Out cross-validation by respondent_id",
        "  Each fold fits a fresh TF-IDF + MultinomialNB pipeline",
        "  TF-IDF: ngram_range=(1, 2), min_df=1, lowercase=False, sublinear_tf=True",
        "  No hyperparameter tuning performed",
        "",
        f"Exploratory accuracy: {accuracy:.3f}",
        f"Majority-class baseline accuracy: {majority_accuracy:.3f}",
        "Majority baseline: each fold predicts its training-set majority category",
        "",
        "Classification report:",
        report.rstrip(),
        "",
        "Confusion matrix (rows=actual, columns=predicted):",
        "Labels: " + " | ".join(CATEGORIES),
    ]
    for label, row in zip(CATEGORIES, matrix):
        lines.append(f"{label}: " + " | ".join(str(int(value)) for value in row))

    lines.extend(["", "Fold summaries:", *fold_summaries])
    lines.extend(["", "Fold category-coverage warnings:"])
    if fold_notes:
        lines.extend(fold_notes)
    else:
        lines.append("No held-out category was absent from its training fold.")
    lines.extend([
        "",
        "Limitations:",
        f"- Only {len(candidates)} candidate examples from {respondent_count} respondents.",
        "- All included labels remain provisional and require human review.",
        "- Performance estimates may change after label adjudication or new data.",
        "- Grouping by respondent reduces respondent leakage but does not establish generalization to all residents.",
        "- The model does not determine whether a report is true or legitimate.",
        "- This evaluation does not train or deploy a production model.",
        "",
    ])

    REPORT_DIR.mkdir(parents=True, exist_ok=True)
    require(not REPORT_PATH.exists(), f"Refusing to overwrite: {REPORT_PATH}")
    REPORT_PATH.write_text("\n".join(lines), encoding="utf-8")

    saved_report = REPORT_PATH.read_text(encoding="utf-8")
    require(
        "Confusion matrix" in saved_report and "Limitations:" in saved_report,
        "Saved report failed verification.",
    )

    print("Isolated PB-18 exploratory evaluation complete.")
    print("Status: PROVISIONAL; exploratory only.")
    print(f"Candidates: {len(candidates)}")
    print(f"Unique respondents: {respondent_count}")
    print(f"Review-status counts: {review_status_counts}")
    print(f"Accuracy: {accuracy:.3f}")
    print(f"Majority baseline accuracy: {majority_accuracy:.3f}")
    if fold_notes:
        print("\nFold category-coverage warnings:")
        print("\n".join(fold_notes))
    else:
        print("No held-out category was absent from its training fold.")
    print("\nClassification report:")
    print(report)
    print("Confusion matrix (rows=actual, columns=predicted):")
    print(pd.DataFrame(matrix, index=CATEGORIES, columns=CATEGORIES).to_string())
    print(f"\nReport: {REPORT_PATH}")


if __name__ == "__main__":
    main()
