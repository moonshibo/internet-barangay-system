"""
IntRENEt baseline smoke test (NOT an accuracy result).

Purpose: check that the pipeline (preprocess -> TF-IDF -> Multinomial Naive Bayes)
runs end to end on the v0.2 working dataset, and see how it behaves on inputs it
should not be classifying (service navigation, placeholders, document requests).

Evaluation is leave-one-respondent-out, following spec section 9 (same
respondents are not independent examples). Labels are provisional and the data
is tiny, so numbers here only show whether the pipeline works.

Usage:
    pip install scikit-learn pandas
    python baseline_smoke_test.py IntRENEt_concern_dataset_v0.2_working.csv
"""
import re
import sys
from pathlib import Path

import numpy as np
import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics import accuracy_score, classification_report, confusion_matrix, f1_score
from sklearn.model_selection import LeaveOneGroupOut
from sklearn.naive_bayes import MultinomialNB
from sklearn.pipeline import Pipeline


def preprocess(text: str) -> str:
    """Minimal cleaning for Taglish text. Keeps word forms; no stopword removal yet."""
    text = str(text).lower()
    text = re.sub(r"https?://\S+", " ", text)
    text = re.sub(r"[^\w\s]", " ", text)  # drop punctuation, keep letters and digits
    text = re.sub(r"\s+", " ", text).strip()
    return text


def make_model() -> Pipeline:
    return Pipeline([
        ("tfidf", TfidfVectorizer(preprocessor=preprocess, ngram_range=(1, 2), sublinear_tf=True)),
        ("nb", MultinomialNB(alpha=1.0)),
    ])


def main(path: str) -> None:
    df = pd.read_csv(Path(path), encoding="utf-8-sig", dtype=str).fillna("")
    train = df[df["include_in_baseline"] == "Y"].reset_index(drop=True)
    print(f"Baseline rows: {len(train)}")
    print(train["category"].value_counts().to_string(), "\n")

    X, y, groups = train["text"], train["category"], train["respondent_id"]
    labels = sorted(y.unique())

    # leave-one-respondent-out cross-validation
    pred = pd.Series(index=train.index, dtype=object)
    for tr, te in LeaveOneGroupOut().split(X, y, groups):
        m = make_model().fit(X.iloc[tr], y.iloc[tr])
        pred.iloc[te] = m.predict(X.iloc[te])

    majority = y.value_counts(normalize=True).iloc[0]
    print(f"Majority-class accuracy (reference): {majority:.2f}")
    print(f"Leave-one-respondent-out accuracy:   {accuracy_score(y, pred):.2f}")
    print(f"Macro F1:                            {f1_score(y, pred, average='macro'):.2f}\n")
    print(classification_report(y, pred, labels=labels, zero_division=0))
    print("Confusion matrix (rows = true, cols = predicted):")
    print(pd.DataFrame(confusion_matrix(y, pred, labels=labels), index=labels, columns=labels).to_string(), "\n")

    # Probe: inputs the classifier should NOT be forced to label
    final = make_model().fit(X, y)
    probes = []
    for _, r in df[df["intent_route"] == "service_navigation"].iterrows():
        probes.append(("navigation row " + r["id"], r["text"]))
    for rid in ["C0003", "C0018"]:
        probes.append(("placeholder row " + rid, df.loc[df["id"] == rid, "text"].iloc[0]))
    probes.append(("authored probe: document request", "Ano po ang requirements para sa Certificate of Residency?"))
    probes.append(("authored probe: nonsense", "asdf qwerty zxcv"))

    print("Probe: what the model does with inputs outside its scope")
    for name, text in probes:
        proba = final.predict_proba([text])[0]
        i = int(np.argmax(proba))
        print(f"- {name}: predicted '{final.classes_[i]}' (score {proba[i]:.2f}) | {text[:70]}")
    print("\nNote: scores are model-reported, not calibrated probabilities. "
          "A Naive Bayes model returns some class for every input, so Other/Unclassified needs its own designed logic.")


if __name__ == "__main__":
    if len(sys.argv) != 2:
        sys.exit("Usage: python baseline_smoke_test.py <path to v0.2 CSV>")
    main(sys.argv[1])
