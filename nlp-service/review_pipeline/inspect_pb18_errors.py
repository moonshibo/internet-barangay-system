"""Read-only row-level error analysis for the three PB-18 scenarios."""

from pathlib import Path
import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.model_selection import LeaveOneGroupOut
from sklearn.naive_bayes import MultinomialNB
from sklearn.pipeline import Pipeline

NLP_DIR = Path(__file__).resolve().parent.parent
SOURCE = NLP_DIR / "data" / "IntRENEt_concern_dataset_v0.2_working.csv"

import sys
sys.path.insert(0, str(NLP_DIR))
from preprocess import preprocess_text

RELABELS = {
    "C0009": "Peace and Order Concern",
    "C0010": "Peace and Order Concern",
}
EXCLUSIONS = {"C0011", "C0012", "C0045"}


def predict(frame):
    frame = frame.copy().reset_index(drop=True)
    texts = frame["text"].apply(preprocess_text).tolist()
    labels = frame["category"].tolist()
    groups = frame["respondent_id"].tolist()
    predictions = [None] * len(frame)

    splitter = LeaveOneGroupOut()
    for train_idx, test_idx in splitter.split(texts, labels, groups):
        model = Pipeline([
            ("tfidf", TfidfVectorizer(
                ngram_range=(1, 2),
                min_df=1,
                lowercase=False,
                sublinear_tf=True,
            )),
            ("nb", MultinomialNB()),
        ])
        model.fit([texts[i] for i in train_idx], [labels[i] for i in train_idx])
        fold_predictions = model.predict([texts[i] for i in test_idx])
        for index, predicted in zip(test_idx, fold_predictions):
            predictions[index] = predicted

    frame["predicted_category"] = predictions
    frame["correct"] = frame["category"].eq(frame["predicted_category"])
    return frame


def main():
    source = pd.read_csv(SOURCE, dtype=str).fillna("")
    candidates = source[
        source["include_in_baseline"].str.strip().str.upper().eq("Y")
    ].copy()

    candidates["text"] = candidates["text"].astype(str)
    original = candidates.copy()

    relabeled = candidates.copy()
    for row_id, category in RELABELS.items():
        relabeled.loc[relabeled["id"].eq(row_id), "category"] = category

    reviewed = relabeled[~relabeled["id"].isin(EXCLUSIONS)].copy()

    for name, frame in [
        ("ORIGINAL", original),
        ("RELABEL-ONLY", relabeled),
        ("REVIEWED-42", reviewed),
    ]:
        results = predict(frame)
        errors = results[~results["correct"]].copy()

        print("\n" + "=" * 80)
        print(f"{name}: {len(errors)} misclassified of {len(results)}")
        print("=" * 80)

        if errors.empty:
            print("No misclassified rows.")
            continue

        columns = [
            "id", "respondent_id", "category", "predicted_category", "text"
        ]
        print(errors[columns].to_string(index=False))

        community = errors[errors["category"].eq("Community Concern")]
        if not community.empty:
            print(
                "\nCommunity Concern errors:",
                len(community),
                "of",
                int(results["category"].eq("Community Concern").sum()),
            )


if __name__ == "__main__":
    main()
