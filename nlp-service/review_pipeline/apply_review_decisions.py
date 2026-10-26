"""Create an isolated dataset from the provisional v2 review proposal.

Only the five explicitly expected cells may change. This does not approve labels.
"""
from pathlib import Path

import pandas as pd


SCRIPT_DIR = Path(__file__).resolve().parent
NLP_DIR = SCRIPT_DIR.parent
PIPELINE_DIR = SCRIPT_DIR
SOURCE_PATH = NLP_DIR / "data" / "IntRENEt_concern_dataset_v0.2_working.csv"
PROPOSAL_PATH = NLP_DIR / "data" / "IntRENEt_label_review_proposal_preview_v2.csv"
OUTPUT_PATH = PIPELINE_DIR / "data" / "IntRENEt_concern_dataset_v0.2_working_REVIEWED.csv"

EXPECTED_CATEGORY_CHANGES = {
    "C0009": ("Community Concern", "Peace and Order Concern"),
    "C0010": ("Community Concern", "Peace and Order Concern"),
}
EXPECTED_INCLUSION_CHANGES = {
    "C0011": ("Y", "N"),
    "C0012": ("Y", "N"),
    "C0045": ("Y", "N"),
}


def require(condition: bool, message: str) -> None:
    if not condition:
        raise ValueError(message)


def main() -> None:
    pipeline_root = PIPELINE_DIR.resolve()
    output_resolved = OUTPUT_PATH.resolve()

    require(
        output_resolved.is_relative_to(pipeline_root),
        f"Output path escapes the isolated pipeline: {output_resolved}",
    )
    require(SOURCE_PATH.is_file(), f"Source dataset missing: {SOURCE_PATH}")
    require(PROPOSAL_PATH.is_file(), f"Review proposal missing: {PROPOSAL_PATH}")
    require(not OUTPUT_PATH.exists(), f"Refusing to overwrite: {OUTPUT_PATH}")

    source = pd.read_csv(SOURCE_PATH, dtype=str).fillna("")
    proposal = pd.read_csv(PROPOSAL_PATH, dtype=str).fillna("")

    required_source = {
        "id", "category", "include_in_baseline", "review_status",
    }
    required_proposal = {
        "id", "proposed_category", "revised_include_in_baseline",
        "final_reviewer_decision",
    }
    require(
        required_source.issubset(source.columns),
        f"Source missing columns: {sorted(required_source - set(source.columns))}",
    )
    require(
        required_proposal.issubset(proposal.columns),
        f"Proposal missing columns: {sorted(required_proposal - set(proposal.columns))}",
    )
    require(source["id"].is_unique, "Source IDs are not unique.")
    require(proposal["id"].is_unique, "Proposal IDs are not unique.")
    require(len(source) == 77, f"Expected 77 source rows; found {len(source)}.")
    require(len(proposal) == 45, f"Expected 45 proposal rows; found {len(proposal)}.")
    require(
        proposal["final_reviewer_decision"].str.strip().eq("").all(),
        "Proposal contains a final reviewer decision; stop for manual review.",
    )

    source_candidates = source.loc[
        source["include_in_baseline"].str.strip().str.upper().eq("Y"), "id"
    ]
    require(
        set(source_candidates) == set(proposal["id"]),
        "Proposal IDs do not exactly match the source's original Y candidates.",
    )

    source_by_id = source.set_index("id")
    proposal_by_id = proposal.set_index("id")

    # Confirm the proposed category differs from the source only for the two
    # expected category changes.
    category_diffs = {
        row_id
        for row_id in proposal_by_id.index
        if proposal_by_id.at[row_id, "proposed_category"]
        != source_by_id.at[row_id, "category"]
    }
    require(
        category_diffs == set(EXPECTED_CATEGORY_CHANGES),
        f"Unexpected proposed category differences: {sorted(category_diffs)}",
    )
    for row_id, (old, new) in EXPECTED_CATEGORY_CHANGES.items():
        require(
            source_by_id.at[row_id, "category"] == old
            and proposal_by_id.at[row_id, "proposed_category"] == new,
            f"Unexpected category values for {row_id}.",
        )

    # Confirm inclusion differences are exactly the three expected exclusions.
    inclusion_diffs = {
        row_id
        for row_id in proposal_by_id.index
        if proposal_by_id.at[row_id, "revised_include_in_baseline"]
        != source_by_id.at[row_id, "include_in_baseline"]
    }
    require(
        inclusion_diffs == set(EXPECTED_INCLUSION_CHANGES),
        f"Unexpected proposed inclusion differences: {sorted(inclusion_diffs)}",
    )
    for row_id, (old, new) in EXPECTED_INCLUSION_CHANGES.items():
        require(
            source_by_id.at[row_id, "include_in_baseline"] == old
            and proposal_by_id.at[row_id, "revised_include_in_baseline"] == new,
            f"Unexpected inclusion values for {row_id}.",
        )

    # Apply only the two approved-for-proposal columns; preserve all other cells.
    reviewed = source.copy()
    for row_id, (_, new_category) in EXPECTED_CATEGORY_CHANGES.items():
        reviewed.loc[reviewed["id"].eq(row_id), "category"] = new_category
    for row_id, (_, new_flag) in EXPECTED_INCLUSION_CHANGES.items():
        reviewed.loc[reviewed["id"].eq(row_id), "include_in_baseline"] = new_flag

    require(
        reviewed["review_status"].eq(source["review_status"]).all(),
        "Review statuses changed unexpectedly.",
    )
    require(
        reviewed.columns.tolist() == source.columns.tolist()
        and len(reviewed) == len(source),
        "Output structure differs from the source.",
    )

    # Independent cell-level diff check before writing.
    differences = []
    for row_index in range(len(source)):
        for column in source.columns:
            if source.iloc[row_index][column] != reviewed.iloc[row_index][column]:
                differences.append(
                    (source.iloc[row_index]["id"], column,
                     source.iloc[row_index][column], reviewed.iloc[row_index][column])
                )
    expected_differences = {
        (row_id, "category", old, new)
        for row_id, (old, new) in EXPECTED_CATEGORY_CHANGES.items()
    } | {
        (row_id, "include_in_baseline", old, new)
        for row_id, (old, new) in EXPECTED_INCLUSION_CHANGES.items()
    }
    require(
        set(differences) == expected_differences and len(differences) == 5,
        f"Cell-level diff mismatch: {differences}",
    )

    OUTPUT_PATH.parent.mkdir(parents=True, exist_ok=True)
    require(not OUTPUT_PATH.exists(), f"Refusing to overwrite: {OUTPUT_PATH}")
    reviewed.to_csv(OUTPUT_PATH, index=False, encoding="utf-8-sig")

    # Read back and verify the written artifact.
    saved = pd.read_csv(OUTPUT_PATH, dtype=str).fillna("")
    require(saved.equals(reviewed), "Written CSV failed read-back verification.")

    print("Isolated review dataset created.")
    print("Status: PROVISIONAL; no labels approved.")
    print(f"Rows: {len(saved)}")
    print(f"Columns: {len(saved.columns)}")
    print("Cell changes: 5")
    print("Category changes:", sorted(EXPECTED_CATEGORY_CHANGES))
    print("Inclusion changes:", sorted(EXPECTED_INCLUSION_CHANGES))
    print(
        "Included candidates:",
        int(saved["include_in_baseline"].str.strip().str.upper().eq("Y").sum()),
    )
    print(f"Output: {OUTPUT_PATH}")


if __name__ == "__main__":
    main()
