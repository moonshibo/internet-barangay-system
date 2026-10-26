
"""PB-16: Preprocess the IntRENEt concern dataset.

Preserves the original text and writes a separate processed CSV.
Preprocessing does not approve labels or determine report legitimacy.
"""

from pathlib import Path

import pandas as pd

from preprocess import preprocess_text


BASE_DIR = Path(__file__).resolve().parent
INPUT_PATH = BASE_DIR / "data" / "IntRENEt_concern_dataset_v0.2_working.csv"
OUTPUT_PATH = BASE_DIR / "data" / "IntRENEt_concern_dataset_v0.2_preprocessed.csv"


def main() -> None:
    if not INPUT_PATH.exists():
        raise FileNotFoundError(f"Input dataset not found: {INPUT_PATH}")

    df = pd.read_csv(INPUT_PATH, dtype=str).fillna("")

    if "text" not in df.columns:
        raise ValueError("Input dataset must contain a 'text' column.")

    df["preprocessed_text"] = df["text"].apply(preprocess_text)
    df.to_csv(OUTPUT_PATH, index=False, encoding="utf-8-sig")

    candidates = df["include_in_baseline"].str.strip().str.upper().eq("Y")
    empty_candidates = (
        candidates & df["preprocessed_text"].str.strip().eq("")
    ).sum()

    print(f"Input rows: {len(df)}")
    print(f"Baseline candidates: {candidates.sum()}")
    print(f"Candidate rows empty after preprocessing: {empty_candidates}")
    print(f"Output saved to: {OUTPUT_PATH}")
    print("Labels and review statuses were not changed.")


if __name__ == "__main__":
    main()
