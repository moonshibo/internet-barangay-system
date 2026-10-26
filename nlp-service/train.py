
"""Dataset validation for the IntRENEt NLP baseline.

This stage validates candidate rows before model training.
It does not establish whether a citizen report is true or legitimate.
"""

from pathlib import Path

import pandas as pd


BASE_DIR = Path(__file__).resolve().parent
DATASET_PATH = BASE_DIR / "data" / "IntRENEt_concern_dataset_v0.2_working.csv"

REQUIRED_COLUMNS = {
    "id",
    "text",
    "category",
    "review_status",
    "dup_group",
    "include_in_baseline",
}

VALID_CATEGORIES = {
    "Barangay Clearance/Certification",
    "Certificate of Residency",
    "Certificate of Indigency",
    "Community Concern",
    "Noise Complaint",
    "Peace and Order Concern",
    "Barangay Assistance",
}

APPROVED_STATUS = "approved"


def load_dataset(path: Path = DATASET_PATH) -> pd.DataFrame:
    """Load the dataset as strings without changing the source file."""
    if not path.exists():
        raise FileNotFoundError(f"Dataset not found: {path}")

    df = pd.read_csv(path, dtype=str).fillna("")

    missing = REQUIRED_COLUMNS - set(df.columns)
    if missing:
        raise ValueError(f"Dataset is missing required columns: {sorted(missing)}")

    return df


def validate_candidates(df: pd.DataFrame) -> tuple[pd.DataFrame, pd.DataFrame]:
    """Separate approved, valid candidates from rows that need attention."""
    candidates = df[
        df["include_in_baseline"].str.strip().str.upper().eq("Y")
    ].copy()

    candidates["validation_issue"] = ""

    candidates.loc[
        candidates["text"].str.strip().eq(""),
        "validation_issue",
    ] += "empty_text;"

    candidates.loc[
        ~candidates["category"].isin(VALID_CATEGORIES),
        "validation_issue",
    ] += "invalid_or_unapproved_category;"

    candidates.loc[
        ~candidates["review_status"].str.strip().str.lower().eq(APPROVED_STATUS),
        "validation_issue",
    ] += "label_not_approved;"

    # Duplicate groups need an explicit evaluation policy before training.
    candidates.loc[
        candidates["dup_group"].str.strip().ne(""),
        "validation_issue",
    ] += "duplicate_group_requires_review;"

    approved = candidates[candidates["validation_issue"].eq("")].copy()
    needs_attention = candidates[~candidates["validation_issue"].eq("")].copy()

    return approved, needs_attention


def main() -> None:
    df = load_dataset()
    approved, needs_attention = validate_candidates(df)

    print(f"Dataset rows: {len(df)}")
    print(f"Baseline candidates: {df['include_in_baseline'].str.upper().eq('Y').sum()}")
    print(f"Approved and valid rows: {len(approved)}")
    print(f"Rows needing attention: {len(needs_attention)}")

    if not needs_attention.empty:
        print("\nRows needing attention:")
        print(
            needs_attention[
                ["id", "category", "review_status", "dup_group", "validation_issue"]
            ].to_string(index=False)
        )

    if approved.empty:
        print(
            "\nTraining skipped. Approve reviewed labels and resolve duplicate "
            "handling before fitting or evaluating a model."
        )
        return

    print("\nValidated category counts:")
    print(approved["category"].value_counts().to_string())
    print("\nValidation passed. Model training has not been implemented yet.")


if __name__ == "__main__":
    main()
