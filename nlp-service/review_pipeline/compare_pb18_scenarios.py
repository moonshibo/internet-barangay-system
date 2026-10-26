"""Read-only comparison of original, relabeled-only, and reviewed PB-18 scenarios."""

from pathlib import Path
import sys

import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics import accuracy_score, classification_report, confusion_matrix
from sklearn.model_selection import LeaveOneGroupOut
from sklearn.naive_bayes import MultinomialNB
from sklearn.pipeline import Pipeline

NLP_DIR = Path(__file__).resolve().parent.parent
SOURCE_PATH = NLP_DIR / "data" / "IntRENEt_concern_dataset_v0.2_working.csv"

sys.path.insert(0, str(NLP_DIR))
from preprocess import preprocess_text  # noqa: E402

CATEGORIES = [
    "Barangay Assistance",
    "Community Concern",
    "Noise Complaint",
    "Peace and Order Concern",
]

RELABELS = {
    "C0009": "Peace and Order Concern",
    "C0010": "Peace and Order Concern",
}
EXCLUSIONS = {"C0011", "C0012", "C0045"}


def require(condition, message):
    if not condition:
        raise ValueError(message)


def prepare_candidates(source):
    require(SOURCE_PATH.exists(), f"Source dataset missing: {SOURCE_PATH}")
    require(len(source) == 77, f"Expected 77 source rows, got {len(source)}")
    require(source["id"].is_unique, "Source IDs are not unique")

    candidates = source[
        source["include_in_baseline"].str.strip().str.upper().eq("Y")
    ].copy()

    require(len(candidates) == 45, f"Expected 45 original candidates, got {len(candidates)}")
    require(set(RELABELS).issubset(set(candidates["id"])), "Relabel target missing")
    require(EXCLUSIONS.issubset(set(candidates["id"])), "Exclusion target missing")

    candidates["preprocessed_text"] = candidates["text"].apply(preprocess_text)
    require(
        candidates["preprocessed_text"].str.strip().ne("").all(),
        "An original candidate becomes empty after preprocessing",
    )
    require(
        candidates["category"].isin(CATEGORIES).all(),
        "Original candidates contain unsupported categories",
    )
    require(
        candidates["respondent_id"].str.strip().ne("").all(),
        "An original candidate has a blank respondent ID",
    )
    return candidates


def evaluate(name, frame):
    frame = frame.copy().reset_index(drop=True)
    y = frame["category"].tolist()
    groups = frame["respondent_id"].tolist()
    texts = frame["preprocessed_text"].tolist()

    require(len(frame) in (42, 45), f"{name}: unexpected row count {len(frame)}")
    require(set(y).issubset(set(CATEGORIES)), f"{name}: unsupported category")
    require(len(set(groups)) == 14, f"{name}: expected 14 respondents")

    logo = LeaveOneGroupOut()
    predictions = [None] * len(frame)
    baseline_predictions = [None] * len(frame)
    fold_count = 0

    for train_idx, test_idx in logo.split(texts, y, groups):
        fold_count += 1
        train_y = [y[i] for i in train_idx]
        test_y = [y[i] for i in test_idx]
        train_groups = {groups[i] for i in train_idx}
        test_groups = {groups[i] for i in test_idx}

        require(not (train_groups & test_groups), f"{name}: respondent leakage")
        missing = set(test_y) - set(train_y)
        require(
            not missing,
            f"{name}: held-out category absent from training fold: {sorted(missing)}",
        )

        model = Pipeline([
            ("tfidf", TfidfVectorizer(
                ngram_range=(1, 2),
                min_df=1,
                lowercase=False,
                sublinear_tf=True,
            )),
            ("nb", MultinomialNB()),
        ])
        model.fit([texts[i] for i in train_idx], train_y)
        fold_predictions = model.predict([texts[i] for i in test_idx])

        majority = pd.Series(train_y).value_counts().idxmax()
        for position, prediction in zip(test_idx, fold_predictions):
            predictions[position] = prediction
            baseline_predictions[position] = majority

    require(fold_count == 14, f"{name}: expected 14 folds, got {fold_count}")
    require(all(p is not None for p in predictions), f"{name}: missing predictions")

    print("\n" + "=" * 72)
    print(name)
    print("=" * 72)
    print("Candidates:", len(frame))
    print("Unique respondents:", len(set(groups)))
    print("Category counts:", pd.Series(y).value_counts().reindex(CATEGORIES, fill_value=0).to_dict())
    print("Validation: Leave-One-Respondent-Out, 14 folds")
    print(f"Accuracy: {accuracy_score(y, predictions):.3f}")
    print(f"Per-fold training-majority baseline: {accuracy_score(y, baseline_predictions):.3f}")
    print("\nClassification report:")
    print(classification_report(
        y, predictions, labels=CATEGORIES, zero_division=0, digits=3
    ))
    print("Confusion matrix (rows=true, columns=predicted):")
    print(pd.DataFrame(
        confusion_matrix(y, predictions, labels=CATEGORIES),
        index=CATEGORIES,
        columns=CATEGORIES,
    ).to_string())


def main():
    source = pd.read_csv(SOURCE_PATH, dtype=str).fillna("")
    original = prepare_candidates(source)

    relabeled = original.copy()
    for row_id, category in RELABELS.items():
        relabeled.loc[relabeled["id"].eq(row_id), "category"] = category

    reviewed = relabeled[~relabeled["id"].isin(EXCLUSIONS)].copy()

    require(len(relabeled) == 45, "Relabel-only scenario should retain 45 candidates")
    require(len(reviewed) == 42, "Reviewed scenario should contain 42 candidates")

    print("PB-18 scenario comparison")
    print("Status: exploratory only; labels remain unapproved.")
    print("No files are written by this script.")
    print("Preprocessing and model settings are identical across scenarios.")
    print("Relabels:", RELABELS)
    print("Exclusions:", sorted(EXCLUSIONS))

    evaluate("Scenario 1: Original 45 candidates and original labels", original)
    evaluate("Scenario 2: 45 candidates, two category changes only", relabeled)
    evaluate("Scenario 3: 42 candidates, category changes plus three exclusions", reviewed)


if __name__ == "__main__":
    main()
