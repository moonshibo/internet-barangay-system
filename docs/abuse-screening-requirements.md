# PB-22 — Abuse-Screening Requirements

**Project:** IntRENEt (Internet Barangay System)
**Sprint:** Sprint 3 — October 19–November 1, 2026
**Owner:** Starween
**Status:** Draft for team review and Barangay validation
**Related tasks:** PB-11 — API Contract; PB-20 — Service Intent and Workflow Analysis; PB-23 — Chatbot Conversation Design and AI Orchestrator; PB-24 — Data Model

> **Status note:** This document defines proposed requirements, not approved Barangay policy. Screening labels, model capabilities, review procedures, urgency criteria, notification recipients, channels, and retention rules must be confirmed before implementation.

## 1. Purpose

PB-22 defines requirements for identifying messages that may contain abusive, threatening, harassing, or otherwise unsafe content in the IntRENEt chatbot and reporting workflows.

The purpose of screening is to support safe handling and appropriate human review while preserving citizens' ability to submit legitimate concerns. Screening must not be used as proof that an allegation is true or that a citizen has committed wrongdoing.

This document complements PB-20's general classification, uncertainty, urgency, privacy, and workflow requirements. It focuses on abuse-screening behavior and its risks.

## 2. Scope and Limitations

Proposed screening scope:

- Potential threats of harm toward a person or group.
- Targeted harassment, intimidation, or repeated abusive language.
- Content that may require additional safety review.
- Context needed to distinguish abusive content from legitimate reporting, criticism, or quoted speech.

Screening must consider Filipino, English, Taglish, informal expressions, spelling variations, slang, and relevant conversational context. Actual language coverage and performance must be evaluated rather than assumed.

**API limitation:** The currently documented PB-11 `/classify` example returns a concern category and confidence score. It does not define an abuse-detection field, moderation capability, or abuse-screening response. PB-22 must not assume these capabilities already exist. Any API extension requires review and agreement with the team.

## 3. Core Safety Principles

The system should follow these principles:

1. **Screening is advisory.** A model result is a signal for review, not proof of abuse, intent, guilt, or the truth of an allegation.
2. **Preserve legitimate reporting.** A citizen must not lose access to the reporting workflow solely because screening is uncertain or unavailable.
3. **Context matters.** Consider whether the citizen is quoting a threat, reporting abuse, describing an incident, joking, criticizing a service, or directing a threat at someone.
4. **No automatic punishment.** Model output alone must not trigger report rejection, account sanctions, public labeling, or other punitive action.
5. **Human judgment is required.** Ambiguous and potentially serious cases must follow a human-review process approved by the team and Barangay.
6. **Use minimum necessary data.** Restrict access to flagged messages and screening results according to approved privacy and access-control rules.
7. **Do not overpromise.** The chatbot must not claim that a threat is verified, a person has been contacted, or action has been taken unless the system confirms it.

## 4. Distinguishing Content and Context

Screening and review should distinguish between the following situations. These are proposed examples for testing, not definitive classification rules.

| Situation | Example | Proposed handling |
|---|---|---|
| Direct threat | A message appears to threaten imminent physical harm toward a person. | Preserve the submission and follow the approved urgent human-review procedure. |
| Reported or quoted threat | "May nag-message po sa akin na sasaktan daw niya ako." | Recognize that the citizen may be reporting a threat, not making one. Route according to the approved reporting workflow. |
| Targeted harassment | Repeated insults or intimidation directed at an identifiable person. | Flag for review when supported by the approved screening capability; do not determine guilt automatically. |
| Angry but legitimate complaint | "Galit na po ako dahil ilang linggo nang walang aksyon." | Do not treat anger or dissatisfaction alone as abuse. Continue the normal complaint workflow. |
| Civic criticism | Criticism of a Barangay service, official decision, or process. | Do not flag solely because the message is negative or critical. |
| Profanity or slang | Informal or profane language without a clear threat or targeted harassment. | Interpret in context; profanity alone must not establish abuse. |
| Ambiguous or joking statement | Sarcasm, hyperbole, a joke, or unclear wording. | Avoid definitive conclusions and use the approved clarification or human-review path. |
| Spam or repeated submission | Repeated identical messages or irrelevant content. | Treat as a separate screening concern; do not automatically equate repetition with abusive conduct. |

The examples above must be expanded and reviewed using representative Filipino, English, and Taglish messages before evaluation.

## 5. Proposed Screening Outcomes

The following are conceptual outcomes for discussion. They are not confirmed API values or implemented statuses.

- **No screening concern identified:** No abuse-related concern was identified by the available screening process. This does not guarantee that the message is safe.
- **Review recommended:** Content or context warrants review by an authorized person.
- **Potential urgent safety concern:** The message may describe an immediate threat or serious risk and needs the approved urgent-review pathway.
- **Uncertain or insufficient context:** The screening process cannot reliably determine how the content should be interpreted.
- **Screening unavailable:** The screening component failed, timed out, or returned an unusable result.

The team must decide whether these outcomes are needed, how they map to API fields and internal statuses, and which authorized personnel can see them. These outcomes describe possible screening interpretations, not official case statuses, final moderation decisions, or confirmed API enum values. Do not implement these labels as official statuses until approved.

## 6. Human Review and Urgent Concerns

### 6.1 Human review

The approved review process must be defined before the system claims to provide human review. It should specify:

- Which authorized personnel may review flagged content.
- How reviewers receive and access the original message and relevant context.
- How reviewers record a decision or correction.
- How uncertain or disputed cases are handled.
- How review actions are recorded in the audit history.
- What happens when an authorized reviewer is unavailable.

An authorized reviewer must consider the original message and relevant context before recording a review decision. Any administrative action must follow approved Barangay procedures and applicable authorization rules. The screening model must not independently impose sanctions or determine the truth of an allegation. A model score must not replace review of the original message.

### 6.2 Potentially urgent safety concerns

A message that appears to describe imminent danger should not be delayed by unnecessary classification questions. The system should preserve the submission and follow an approved urgent-review process.

The team and Barangay must confirm:

- The criteria for a potentially urgent threat.
- Who receives urgent notifications.
- Which channels are authorized.
- What happens outside office hours.
- What fallback applies if the notification or screening service fails.
- What wording the chatbot may use while action is pending.

No particular threshold, recipient, channel, response time, or after-hours procedure is approved by this draft. The chatbot must not claim that emergency services or Barangay personnel have been contacted unless that action is confirmed.

## 7. False Positives, False Negatives, and Uncertainty

A **false positive** occurs when legitimate content is flagged as potentially abusive. A **false negative** occurs when harmful or threatening content is not flagged.

Both risks must be evaluated. Examples of false positives include quoted threats, legitimate reports of harassment, criticism of public services, and angry complaints. Examples of false negatives may include indirect threats, slang, misspellings, sarcasm, or context-dependent language.

Requirements:

- Screening output must be treated as advisory.
- Uncertain cases must not be assigned a definitive abuse finding.
- Lack of a screening flag must not be presented as proof that a message is safe.
- Legitimate reports must not be automatically rejected based only on a model result.
- Human corrections should be recorded through an approved process and used for evaluation only under approved data-governance rules.

No numeric confidence threshold is established by this document. Any threshold or decision rule must be evaluated and approved before use.

## 8. Failure Handling and Laravel Responsibilities

Laravel remains the system of record and is responsible for authentication, authorization, request validation, persistence, official status management, routing, notifications, audit history, and authorized personnel corrections.

The AI screening component must not independently decide allegation truth, final administrative outcomes, official case status, or final urgency and escalation decisions.

The reporting workflow must not depend on successful abuse-screening execution to preserve a citizen's submission. If screening fails, times out, or returns an invalid response:

- Preserve the original citizen submission through the approved reporting workflow.
- Do not silently discard the message.
- Do not treat a technical failure as evidence of abuse.
- Record screening availability or failure through the approved application and logging design.
- Use a pending or unreviewed state only if that behavior is supported and approved in the system design.
- Follow the approved fallback for any potential urgent concern.

The precise retry behavior, fallback states, and API contract must be agreed with the team and documented in PB-11 and related implementation tasks.

## 9. Privacy, Access Control, and Auditability

Proposed requirements:

- Limit access to flagged messages, screening results, and reviewer notes to authorized roles.
- Collect and expose only the information needed for screening and review.
- Protect original messages and personal information from unauthorized disclosure.
- Record relevant screening failures, review actions, and authorized corrections in accordance with the approved audit design.
- Avoid logging unnecessary message content or sensitive personal details.
- Apply the project's approved privacy, access-control, security, and retention requirements.

This document does not establish a new retention period or authorize broader access to citizen messages. Those details require confirmation against project policy and applicable requirements.

## 10. Evaluation and Testing

Before any screening capability is treated as production-ready, the team should evaluate it with a reviewed and appropriately governed test set.

The test set should include:

- Direct and indirect threats.
- Reported or quoted threats.
- Reports of harassment or abuse.
- Legitimate angry complaints and civic criticism.
- Profanity without a clear threat.
- Sarcasm, jokes, and ambiguous statements.
- Filipino, English, and Taglish examples.
- Informal spelling, slang, and relevant regional expressions.
- Screening timeouts, invalid responses, and service unavailability.

Evaluation should examine false positives, false negatives, and performance by relevant language and scenario groups. Metrics, minimum acceptable performance, dataset approval, and test ownership must be agreed before acceptance.

Do not describe exploratory results as production validation. Any evaluation data containing personal or sensitive information must follow approved access and handling rules.

## 11. Decisions Requiring Team or Barangay Confirmation

- [ ] Is abuse screening within the current sprint's agreed implementation scope?
- [ ] Which message types and abuse-related concerns are in scope?
- [ ] What screening capability, if any, will the AI service support?
- [ ] Does PB-11 need a reviewed API extension for screening results?
- [ ] Which conceptual outcomes or labels should be adopted?
- [ ] Who is authorized to review flagged messages and record corrections?
- [ ] What criteria define an urgent safety concern?
- [ ] Which recipients, notification channels, and after-hours procedures are approved?
- [ ] What fallback applies when screening or notification services fail?
- [ ] What privacy, audit, access-control, and retention rules apply?
- [ ] Which test dataset, metrics, and acceptance criteria will be used?

Until these decisions are confirmed, this document remains a requirements proposal and must not be treated as an approved operational policy.

## 12. Acceptance Criteria

PB-22 can be considered ready for team review when:

- [ ] Screening purpose, scope, and limitations are documented.
- [ ] Examples distinguish threats from quoted threats and legitimate complaints.
- [ ] Human-review and uncertainty requirements are documented.
- [ ] False-positive and false-negative risks are addressed.
- [ ] Automatic rejection and punishment based solely on model output are prohibited.
- [ ] Submission preservation and screening-failure handling are specified.
- [ ] AI responsibilities are separated from Laravel's official responsibilities.
- [ ] Privacy, access-control, and audit requirements are documented.
- [ ] Proposed outcomes and unapproved policy decisions are clearly identified.
- [ ] API dependencies and required team decisions are listed.
- [ ] Evaluation scenarios and acceptance questions are recorded.
- [ ] The team has reviewed the document and the appropriate Barangay personnel have validated policy-dependent decisions.

## 13. Next Steps

1. Ask the team to review the proposed scope and screening outcomes.
2. Coordinate with the PB-11 owner before proposing any API changes.
3. Coordinate with Henry so PB-23 reflects the agreed safety and human-review boundaries.
4. Confirm policy-dependent decisions with the appropriate Barangay personnel.
5. Update this draft to distinguish confirmed decisions from unresolved questions.
6. Record remaining blockers and do not represent unapproved rules as implemented behavior.

**Current status:** Draft for team review and Barangay validation.
