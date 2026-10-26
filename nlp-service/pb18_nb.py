
"""PB-18: Exploratory TF-IDF + Multinomial Naive Bayes evaluation.

All current candidate labels are unapproved. Results are for testing the
evaluation pipeline only and must not be reported as validated performance.
TF-IDF is fitted separately inside each respondent-held-out training fold.
"""

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


BASE_DIR = Path(__file__).resolve().parent
DATA_PATH = (
    BASE_DIR
    / "data"
    / "IntRENEt_concern_dataset_v0.2_preprocessed.csv"
)
REPORT_DIR = BASE_DIR / "reports"
REPORT_PATH = REPORT_DIR / "PB18_exploratory_evaluation.txt"

CANDIDATE_CATEGORIES = [
    "Barangay Assistance",
    "Community Concern",
    "Noise Complaint",
    "Peace and Order Concern",
]


def main() -> None:
    if not DATA_PATH.exists():
        raise FileNotFoundError(f"Dataset not found: {DATA_PATH}")

    df = pd.read_csv(DATA_PATH, dtype=str).fillna("")

    required = {
        "id",
        "preprocessed_text",
        "category",
        "respondent_id",
        "review_status",
        "include_in_baseline",
        "dup_group",
    }
    missing = required - set(df.columns)
    if missing:
        raise ValueError(f"Dataset missing required columns: {sorted(missing)}")

    candidates = df[
        df["include_in_baseline"].str.strip().str.upper().eq("Y")
    ].copy()

    if candidates.empty:
        raise ValueError("No baseline candidates found.")

    candidates["category"] = candidates["category"].str.strip()
    candidates["respondent_id"] = candidates["respondent_id"].str.strip()
    candidates["preprocessed_text"] = (
        candidates["preprocessed_text"].str.strip()
    )

    # Never silently discard incomplete or unsupported candidate rows.
    invalid = candidates[
        candidates["category"].eq("")
        | candidates["preprocessed_text"].eq("")
        | candidates["respondent_id"].eq("")
        | ~candidates["category"].isin(CANDIDATE_CATEGORIES)
    ]
    if not invalid.empty:
        print("Evaluation stopped: candidate rows need attention.")
        print(
            invalid[
                ["id", "category", "respondent_id", "review_status"]
            ].to_string(index=False)
        )
        return

    # This exploratory version expects one included representative per
    # duplicate group. Excluded duplicate copies remain outside candidates.
    grouped = candidates[candidates["dup_group"].str.strip().ne("")]
    duplicate_counts = grouped.groupby("dup_group").size()
    if (duplicate_counts > 1).any():
        print("Evaluation stopped: multiple included rows share a duplicate group.")
        print(duplicate_counts[duplicate_counts > 1].to_string())
        return

    # Do not imply these labels have been approved.
    status_counts = candidates["review_status"].str.strip().str.lower().value_counts()
    if not status_counts.index.isin(["approved"]).all():
        print("WARNING: candidate labels are not all approved.")
        print("All resulting metrics are EXPLORATORY / PROVISIONAL only.")
        print(status_counts.to_string())

    y = candidates["category"].to_numpy()
    groups = candidates["respondent_id"].to_numpy()
    texts = candidates["preprocessed_text"].to_numpy()
    labels = CANDIDATE_CATEGORIES

    logo = LeaveOneGroupOut()
    predictions = [None] * len(candidates)
    fold_notes = []
    majority_correct = 0

    for fold_number, (train_idx, test_idx) in enumerate(
        logo.split(texts, y, groups), start=1
    ):
        train_labels = set(y[train_idx])
        test_labels = set(y[test_idx])
        missing_train = sorted(test_labels - train_labels)

        if missing_train:
            fold_notes.append(
                f"Fold {fold_number}: held-out respondent "
                f"{groups[test_idx[0]]}; categories absent from training: "
                f"{', '.join(missing_train)}"
            )

        model = Pipeline(
            [
                (
                    "tfidf",
                    TfidfVectorizer(
                        ngram_range=(1, 2),
                        min_df=1,
                        lowercase=False,
                        sublinear_tf=True,
                    ),
                ),
                ("classifier", MultinomialNB()),
            ]
        )
        model.fit(texts[train_idx], y[train_idx])
        fold_predictions = model.predict(texts[test_idx])

        for index, prediction in zip(test_idx, fold_predictions):
            predictions[index] = prediction

        train_counts = pd.Series(y[train_idx]).value_counts()
        majority_category = train_counts.idxmax()
        majority_correct += int(
            (y[test_idx] == majority_category).sum()
        )

    if any(prediction is None for prediction in predictions):
        raise RuntimeError("Some candidate rows did not receive predictions.")

    predictions = list(predictions)
    accuracy = accuracy_score(y, predictions)
    majority_accuracy = majority_correct / len(y)
    matrix = confusion_matrix(y, predictions, labels=labels)
    report = classification_report(
        y,
        predictions,
        labels=labels,
        target_names=labels,
        zero_division=0,
        digits=3,
    )

    REPORT_DIR.mkdir(parents=True, exist_ok=True)
    with REPORT_PATH.open("w", encoding="utf-8") as file:
        file.write("PB-18 Exploratory Evaluation Report\n")
        file.write("=" * 45 + "\n\n")
        file.write("STATUS: EXPLORATORY / PROVISIONAL\n")
        file.write(
            "All current candidate labels are unapproved. These metrics "
            "are not validated model performance and must not be used as "
            "final accuracy claims.\n\n"
        )
        file.write(f"Source: {DATA_PATH}\n")
        file.write(f"Candidate rows evaluated: {len(candidates)}\n")
        file.write(f"Unique respondents: {candidates['respondent_id'].nunique()}\n")
        file.write(f"Cross-validation: Leave-One-Respondent-Out\n")
        file.write("Pipeline: TF-IDF (unigrams+bigrams) + MultinomialNB\n")
        file.write("TF-IDF fitted separately inside every training fold.\n\n")
        file.write("Review-status counts:\n")
        file.write(status_counts.to_string() + "\n\n")
        file.write(f"Exploratory accuracy: {accuracy:.3f}\n")
        file.write(f"Majority-class baseline accuracy: {majority_accuracy:.3f}\n\n")
        file.write("Per-class metrics:\n")
        file.write(report + "\n")
        file.write("Confusion matrix (rows=true, columns=predicted):\n")
        file.write(pd.DataFrame(matrix, index=labels, columns=labels).to_string())
        file.write("\n\nFold coverage warnings:\n")
        if fold_notes:
            file.write("\n".join(fold_notes) + "\n")
        else:
            file.write("No held-out category was absent from its training fold.\n")
        file.write(
            "\nLimitations:\n"
            "- Small dataset with only 45 candidate examples.\n"
            "- All labels remain unapproved.\n"
            "- Results are exploratory and may change after label review.\n"
            "- They do not establish report legitimacy or incident truth.\n"
        )

    print("PB-18 exploratory evaluation completed.")
    print("Status: EXPLORATORY / PROVISIONAL")
    print(f"Candidate rows: {len(candidates)}")
    print(f"Unique respondents: {candidates['respondent_id'].nunique()}")
    print(f"Exploratory accuracy: {accuracy:.3f}")
    print(f"Majority-class baseline accuracy: {majority_accuracy:.3f}")
    print("\nPer-class metrics:")
    print(report)
    print("Confusion matrix (rows=true, columns=predicted):")
    print(pd.DataFrame(matrix, index=labels, columns=labels).to_string())
    if fold_notes:
        print("\nFold coverage warnings:")
        print("\n".join(fold_notes))
    print(f"\nReport saved to: {REPORT_PATH}")


if __name__ == "__main__":
    main()
