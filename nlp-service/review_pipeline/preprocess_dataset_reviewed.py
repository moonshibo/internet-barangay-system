"""PB-16 isolated preprocessing for the provisional reviewed dataset."""
from pathlib import Path
import sys

import pandas as pd

SCRIPT_DIR = Path(__file__).resolve().parent
NLP_SERVICE_DIR = SCRIPT_DIR.parent
INPUT_PATH = SCRIPT_DIR / "data" / "IntRENEt_concern_dataset_v0.2_working_REVIEWED.csv"
OUTPUT_PATH = SCRIPT_DIR / "data" / "IntRENEt_concern_dataset_v0.2_preprocessed_REVIEWED.csv"

sys.path.insert(0, str(NLP_SERVICE_DIR))
from preprocess import preprocess_text


def require(condition: bool, message: str) -> None:
    if not condition:
        raise ValueError(message)


def main() -> None:
    pipeline_root = SCRIPT_DIR.resolve()
    require(
        OUTPUT_PATH.resolve().is_relative_to(pipeline_root),
        f"Output escapes isolated pipeline: {OUTPUT_PATH}",
    )
    require(INPUT_PATH.is_file(), f"Reviewed input missing: {INPUT_PATH}")
    require(not OUTPUT_PATH.exists(), f"Refusing to overwrite: {OUTPUT_PATH}")

    source = pd.read_csv(INPUT_PATH, dtype=str).fillna("")
    required = {"id", "text", "category", "review_status", "include_in_baseline"}
    require(required.issubset(source.columns), f"Missing columns: {sorted(required - set(source.columns))}")
    require(len(source) == 77, f"Expected 77 rows; found {len(source)}")
    require(source["id"].is_unique, "Input IDs are not unique.")

    processed = source.copy()
    processed["preprocessed_text"] = processed["text"].apply(preprocess_text)

    candidates = processed["include_in_baseline"].str.strip().str.upper().eq("Y")
    empty_candidates = candidates & processed["preprocessed_text"].str.strip().eq("")
    require(
        not empty_candidates.any(),
        f"Candidate rows empty after preprocessing: {processed.loc[empty_candidates, 'id'].tolist()}",
    )
    require(processed["category"].equals(source["category"]), "Categories changed.")
    require(processed["review_status"].equals(source["review_status"]), "Review statuses changed.")
    require(
        processed["include_in_baseline"].equals(source["include_in_baseline"]),
        "Baseline inclusion flags changed.",
    )

    OUTPUT_PATH.parent.mkdir(parents=True, exist_ok=True)
    require(not OUTPUT_PATH.exists(), f"Refusing to overwrite: {OUTPUT_PATH}")
    processed.to_csv(OUTPUT_PATH, index=False, encoding="utf-8-sig")

    saved = pd.read_csv(OUTPUT_PATH, dtype=str).fillna("")
    require(saved.equals(processed), "Written CSV failed read-back verification.")

    print("Isolated PB-16 preprocessing complete.")
    print("Status: PROVISIONAL; no labels approved.")
    print(f"Rows: {len(saved)}")
    print(f"Baseline candidates: {int(candidates.sum())}")
    print(f"Candidate rows empty after preprocessing: {int(empty_candidates.sum())}")
    print("Labels, review statuses, and inclusion flags unchanged.")
    print(f"Output: {OUTPUT_PATH}")


if __name__ == "__main__":
    main()
