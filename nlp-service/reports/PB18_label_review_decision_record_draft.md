# PB-18 Label Review Decision Record

Status: CONSOLIDATED DRAFT — pending Henry and Starween sign-off
Scope: Sprint 3, PB-18 exploratory TF-IDF + Naive Bayes category baseline
Source of truth: IntRENEt_concern_dataset_v0.2_working.csv
Created: 2026-10-26

## 1. Review ownership

- Henry: project lead, data-analysis coordination, review/sign-off.
- Starween: review/sign-off for category interpretation and personnel-facing workflow implications.
- Marc: Scrum coordination, decision tracking, dependency management, and handoff.
- Joemar: Sprint 3 tester. Verify pipeline behavior and reports against the signed-off decisions; do not independently change labels or inclusion decisions.

## 2. Consolidated working policy

1. Each report has one primary category.
2. Categorize the main reported concern and impact. Do not assume an unverified cause.
3. Obstruction caused by accumulated garbage remains Community Concern; record blocked access as an impact/note. Obstruction caused primarily by disorderly conduct may warrant Peace and Order review.
4. Multi-issue reports retain one primary category and may be flagged for personnel review.
5. Urgency and potential hazard are separate from the category label.
6. Chemical exposure, violations, and other allegations are not established facts merely because they appear in a report.
7. The model suggests a category only. It must not decide whether an allegation is true or make final urgency/escalation decisions.
8. Do not change labels to improve model metrics. Preserve the original working CSV.

## 3. Record-level working proposals

| Record | Proposed category | Proposed baseline decision | Rationale / follow-up |
|---|---|---|---|
| C0002 | Community Concern | Retain | Uncollected garbage and odor. |
| C0004 | Community Concern | Retain | Garbage obstructs pedestrian passage; record obstruction as impact. |
| C0005 | Community Concern | Retain | Blocked drainage and recurring flooding. |
| C0006 | Community Concern | Retain | Improper waste disposal and segregation. |
| C0007 | Community Concern | Retain | Accumulated garbage blocks passage; record obstruction as impact. |
| C0008 | Community Concern | Retain | Delayed garbage collection; representative of near-duplicate pair ND01. |
| C0011 | Community Concern | Exclude provisionally | Near-duplicate of C0008 with only a greeting prefix. |
| C0013 | Community Concern | Retain provisionally | Exact duplicate of C0069; retain C0013 and exclude C0069 to avoid duplicate leakage. |
| C0014 | Community Concern | Retain provisionally | Exact duplicate of C0074; retain C0014 and exclude C0074 to avoid duplicate leakage. Flag multi-issue/personnel review. |
| C0061 | Community Concern, provisional | Retain provisionally | Construction compliance and alleged chemical/air exposure. Potential hazard and urgency require separate human review; allegation remains unverified. |

These are proposals, not formal approval. All original records remain needs_review until the review owners confirm the final decisions.

## 4. Duplicate handling

- ND01: C0008 / C0011 — near-duplicate pair. Proposed representative: C0008.
- D01: C0013 / C0069 — exact duplicate pair. Proposed representative: C0013.
- D02: C0014 / C0074 — exact duplicate pair. Proposed representative: C0014.
- Keep duplicate groups together when splitting data for evaluation. Do not allow duplicate text to leak across training and test sets.
- Confirm that retaining the proposed representatives is acceptable before using the revised candidate set.

## 5. Urgency and hazard boundaries

- Category and urgency are separate decisions.
- Potential hazard is a review signal, not proof of exposure or a violation.
- Personnel make final urgency and escalation decisions using criteria approved by the project adviser/team.
- Do not implement automatic Kapitan escalation based solely on classifier output or category confidence.
- Exact urgency thresholds, notification ownership, and out-of-hours handling remain subject to policy confirmation.

## 6. PB-18 evaluation caution

The revised 42-candidate exploratory evaluation showed 0 recall for Community Concern: all nine Community Concern examples were predicted as Peace and Order Concern. This is a material failure signal, not a reason to relabel records or claim the model is ready.

Before interpreting performance:
- obtain explicit review approval for labels and baseline inclusion;
- verify preprocessing and feature-generation consistency;
- prevent respondent/duplicate leakage in evaluation;
- document class-level metrics and the majority-class baseline;
- keep the result exploratory until an approved dataset and defensible evaluation split exist.

## 7. Required sign-off

Henry and Starween should confirm or amend:
- the single-primary-category policy;
- the proposed representative for each duplicate group;
- C0061's provisional category and separate hazard-review treatment;
- whether multi-issue/personnel-review flags are retained;
- which records are approved for baseline inclusion.

Record reviewer names, date, and any changes before changing the working dataset or treating the baseline as approved.

## 8. Joemar's tester checklist

After the review owners sign off, test that:
- the pipeline refuses to train on records that are not approved;
- excluded duplicates do not enter the approved baseline;
- duplicate groups cannot leak across evaluation splits;
- class counts and evaluation reports match the approved candidate set;
- Community Concern predictions and errors are reported transparently;
- no category prediction is represented as a verified allegation or final urgency decision;
- the test run does not modify the original working CSV.

## 9. Safe handoff boundary

This record is a separate draft artifact. It does not approve labels, change inclusion flags, train a production model, alter Laravel integration, or authorize deployment. Preserve all existing uncommitted files and changes. Any later dataset edits should be made only after sign-off, in a separately named approved dataset/version.
