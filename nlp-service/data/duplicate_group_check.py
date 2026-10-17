import re
from pathlib import Path

import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics import accuracy_score, f1_score
from sklearn.model_selection import LeaveOneGroupOut
from sklearn.naive_bayes import MultinomialNB
from sklearn.pipeline import make_pipeline


DATASET = Path(__file__).parent / "IntRENEt_concern_dataset_v0.2_working.csv"


def preprocess(text):
    text = str(text).lower()
    text = re.sub(r"[^\w\s]", " ", text)
    return re.sub(r"\s+", " ", text).strip()


df = pd.read_csv(DATASET, dtype=str).fillna("")
df = df[df["include_in_baseline"] == "Y"].reset_index(drop=True)

# Use recorded duplicate groups; give ungrouped rows their own group.
groups = df["dup_group"].where(
    df["dup_group"].str.strip() != "",
    "ROW_" + df["id"],
)

X = df["text"].map(preprocess)
y = df["category"]

print("Baseline rows:", len(df))
print("Unique evaluation groups:", groups.nunique())
print("\nGroup sizes:")
print(groups.value_counts().to_string())

if groups.nunique() == len(df):
    print(
        "\nNo included rows share a recorded duplicate group."
        "\nThis split cannot test duplicate leakage using the current flags."
    )
else:
    predictions = pd.Series(index=df.index, dtype=object)
    splitter = LeaveOneGroupOut()

    for train_idx, test_idx in splitter.split(X, y, groups):
        model = make_pipeline(
            TfidfVectorizer(ngram_range=(1, 2), sublinear_tf=True),
            MultinomialNB(alpha=1.0),
        )
        model.fit(X.iloc[train_idx], y.iloc[train_idx])
        predictions.iloc[test_idx] = model.predict(X.iloc[test_idx])

    print(
        "\nGroup-held-out accuracy:",
        round(accuracy_score(y, predictions), 3),
    )
    print(
        "Group-held-out macro F1:",
        round(f1_score(y, predictions, average="macro"), 3),
    )
    print("\nDiagnostic only, not final model evaluation.")