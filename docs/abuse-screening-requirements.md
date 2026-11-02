# PB-22 — Abuse-Screening Requirements

**Project:** IntRENEt (Internet Barangay System)
**Task:** PB-22 — Abuse-Screening Requirements
**Sprint:** Sprint 3 — October 19–November 1, 2026
**Owner:** Starween
**Status:** Revised requirements document — aligned with PB-11 v2.1; policy-dependent decisions and implementation remain subject to confirmation
**Related Tasks:** PB-11 — Laravel–Chatbot/AI Orchestrator Contract; PB-20 — Service Intent and Workflow Analysis; PB-23 — Chatbot Conversation Design and AI Orchestrator; PB-24 — Data Model; PB-25 — Laravel–AI Orchestrator Implementation; PB-33a — Incident-Legitimacy Verification Research; PB-35 — Urgency and Escalation Policy

> **Status note:** This document defines abuse-screening requirements and proposed safeguards. It does not establish official Barangay policy or confirm that an abuse-detection capability has been implemented. Screening labels, model capabilities, review procedures, urgency criteria, notification recipients, channels, and retention rules require the appropriate team and Barangay confirmation before implementation.

## 1. Purpose

PB-22 defines requirements for identifying messages that may contain abusive, threatening, harassing, or otherwise unsafe content in the IntRENEt chatbot and reporting workflows.

The purpose of screening is to support safe handling and appropriate human review while preserving citizens' ability to submit legitimate concerns.

Screening must not be used as proof that an allegation is true, that a citizen has committed wrongdoing, or that a reported person is responsible for an incident.

This document complements PB-20's general classification, uncertainty, urgency, privacy, and workflow requirements. It focuses specifically on abuse-screening behavior, its limitations, and the risks associated with automated interpretation of citizen messages.

## 2. Scope and Limitations

### 2.1 Proposed Screening Scope

The proposed abuse-screening capability may consider:

- Potential threats of harm toward a person or group.
- Targeted harassment, intimidation, or repeated abusive language.
- Content that may require additional safety review.
- Context needed to distinguish abusive content from legitimate reporting, criticism, or quoted speech.
- Messages whose wording or context may indicate a potential safety concern.

Screening should consider Filipino, English, Taglish, informal expressions, spelling variations, slang, and relevant conversational context.

Actual language coverage and performance must be evaluated rather than assumed. A screening capability must not be represented as reliable for a language or expression type that has not been appropriately tested.

### 2.2 Distinction Between Routine Screening and Abuse Screening

PB-22 must distinguish abuse screening from the routine screening capability documented in PB-11 v2.1.

**Routine screening in PB-11 v2.1:**

- Uses the `screening_flag` response field.
- Covers routine rule-based near-duplicate submissions from the same respondent within a short time window and empty or placeholder-only content.
- Provides an advisory screening signal.
- Does not automatically reject a citizen's submission.
- Does not establish that a message contains abuse, a threat, or harassment.

**Abuse screening in PB-22:**

- Focuses on potential threats, harassment, intimidation, and other unsafe content.
- Requires its own agreed screening capability and evaluation.
- Must consider message context and the possibility of legitimate reporting or quoted speech.
- Requires an approved process for human review when appropriate.
- Must not be assumed to exist merely because PB-11 already defines `screening_flag`.

The two capabilities must not be treated as interchangeable.

### 2.3 API Limitation and PB-11 Alignment

PB-11 v2.1 defines the current proposed `/classify` interface and its response fields:

- `category`
- `confidence`
- `screening_flag`
- `urgency`

The existing `screening_flag` is limited to routine duplicate/spam-related screening. PB-11 does not define a dedicated abuse-detection field, abuse classification capability, or complete moderation response.

Therefore:

- PB-22 must not assume that the current `/classify` endpoint performs abuse detection.
- The existing `screening_flag` must not be reused or interpreted as an abuse indicator.
- Any additional abuse-screening field, response structure, or endpoint requires review and agreement with the PB-11 owner and project team.
- Any new field names and response values remain provisional until documented and approved.
- Abuse-screening implementation must be coordinated with PB-25 and the relevant technical decisions.

PB-11 v2.1 is an approved interface design contract, not evidence that the integration or abuse-screening capability has been implemented.

### 2.4 Relationship to Incident-Legitimacy Verification

Abuse screening and incident-legitimacy verification are separate concerns.

Abuse screening considers whether message content may contain threats, harassment, or other unsafe language.

Incident-legitimacy verification concerns whether a reported incident or allegation can be substantiated. This is not established by identifying abusive language.

PB-33a remains a separate research track for incident-legitimacy verification. PB-22 must not claim that abuse screening verifies the truth of a report or determines whether an incident actually occurred.

## 3. Core Safety Principles

The system should follow these principles:

1. **Screening is advisory.** A model result is a signal for possible review, not proof of abuse, intent, guilt, or the truth of an allegation.
2. **Preserve legitimate reporting.** A citizen must not lose access to the reporting workflow solely because screening is uncertain or unavailable.
3. **Context matters.** Consider whether the citizen is quoting a threat, reporting abuse, describing an incident, joking, criticizing a service, or directing a threat at someone.
4. **No automatic punishment.** Model output alone must not trigger report rejection, account sanctions, public labeling, or other punitive action.
5. **Human judgment is required.** Ambiguous and potentially serious cases must follow a human-review process approved by the team and Barangay.
6. **Use minimum necessary data.** Restrict access to flagged messages and screening results according to approved privacy and access-control rules.
7. **Do not overpromise.** The chatbot must not claim that a threat is verified, a person has been contacted, or action has been taken unless the system confirms it.
8. **Preserve citizen dignity.** Screening must not discourage legitimate complaints, criticism, or requests for assistance.
9. **Separate technical signals from administrative decisions.** AI-generated screening results must not replace authorized Barangay procedures.

## 4. Distinguishing Content and Context

Screening and review should distinguish between different message situations. The following examples are proposed test scenarios, not definitive classification rules.

| Situation | Example | Proposed handling |
|---|---|---|
| Direct threat | A message appears to threaten imminent physical harm toward a person. | Preserve the submission and follow the approved urgent human-review procedure. |
| Reported or quoted threat | "May nag-message po sa akin na sasaktan daw niya ako." | Recognize that the citizen may be reporting a threat, not making one. Route according to the approved reporting workflow. |
| Targeted harassment | Repeated insults or intimidation directed at an identifiable person. | Flag for review when supported by an approved screening capability; do not determine guilt automatically. |
| Angry but legitimate complaint | "Galit na po ako dahil ilang linggo nang walang aksyon." | Do not treat anger or dissatisfaction alone as abuse. Continue the normal complaint workflow. |
| Civic criticism | Criticism of a Barangay service, official decision, or process. | Do not flag solely because the message is negative or critical. |
| Profanity or slang | Informal or profane language without a clear threat or targeted harassment. | Interpret in context; profanity alone must not establish abuse. |
| Ambiguous or joking statement | Sarcasm, hyperbole, a joke, or unclear wording. | Avoid definitive conclusions and use the approved clarification or human-review path. |
| Spam or repeated submission | Repeated identical messages or irrelevant content. | Treat as a separate routine screening concern; do not automatically equate repetition with abusive conduct. |

### 4.1 Contextual Interpretation

The screening process should consider the surrounding conversation when sufficient context is available and its use is authorized.

Relevant contextual questions may include:

- Is the citizen reporting something another person said or did?
- Is the potentially threatening language quoted or directed at someone?
- Is the citizen describing a past incident or expressing an intention to cause harm?
- Is the message a legitimate complaint about a service or administrative process?
- Does the conversation clarify wording that would otherwise appear threatening?
- Is there insufficient context to make a reliable interpretation?

The system must avoid treating individual keywords, profanity, or negative sentiment as conclusive evidence of abuse.

### 4.2 Representative Language Coverage

Test examples should include:

- Filipino expressions and informal wording.
- English threats and harassment-related expressions.
- Taglish sentences and mixed-language messages.
- Common abbreviations and spelling variations.
- Slang and context-dependent expressions.
- Quoted messages and reported speech.
- Sarcasm, jokes, and figurative language.

These examples must be reviewed and evaluated before the system claims that its screening capability supports the corresponding language patterns.

## 5. Proposed Screening Outcomes

The following are conceptual outcomes for discussion. They are not confirmed API values, implemented statuses, or official administrative decisions.

| Proposed outcome | Description |
|---|---|
| No screening concern identified | No abuse-related concern was identified by the available screening process. This does not guarantee that the message is safe. |
| Review recommended | Content or context warrants review by an authorized person. |
| Potential urgent safety concern | The message may describe an immediate threat or serious risk and requires the approved urgent-review pathway. |
| Uncertain or insufficient context | The screening process cannot reliably determine how the content should be interpreted. |
| Screening unavailable | The screening component failed, timed out, or returned an unusable result. |

### 5.1 Interpretation Restrictions

The proposed outcomes must not be treated as:

- Final findings that a person committed abuse.
- Proof that a threat is genuine or that an allegation is true.
- Official case or application statuses.
- Automatic reasons to reject a citizen's submission.
- Automatic grounds for sanctions or account restrictions.
- Confirmed API enumeration values.

The team must decide whether these outcomes are needed, how they map to API fields and internal statuses, and which authorized personnel can access them.

No proposed outcome should be implemented as an official status until it has been reviewed and approved.

## 6. Human Review and Urgent Concerns

### 6.1 Human Review Requirements

The approved review process must be defined before the system claims to provide human review.

It should specify:

- Which authorized personnel may review flagged content.
- How reviewers receive and access the original message and relevant context.
- What information is available to reviewers.
- How reviewers record a decision or correction.
- How uncertain or disputed cases are handled.
- How review actions are recorded in the audit history.
- What happens when an authorized reviewer is unavailable.
- How unauthorized access to flagged content is prevented.

An authorized reviewer must consider the original message and relevant context before recording a review decision.

Any administrative action must follow approved Barangay procedures and applicable authorization rules.

The screening model must not independently impose sanctions, determine the truth of an allegation, or replace review of the original message. A model score must not replace human judgment.

### 6.2 Potentially Urgent Safety Concerns

A message that appears to describe imminent danger should not be delayed by unnecessary classification questions.

The system should preserve the submission and follow an approved urgent-review process.

The team and Barangay must confirm:

- The criteria for a potentially urgent threat.
- Who receives urgent notifications.
- Which notification channels are authorized.
- What happens outside office hours.
- What fallback applies if the notification or screening service fails.
- What wording the chatbot may use while action is pending.
- How notification attempts and confirmed outcomes are recorded.

PB-11 v2.1 describes a proposed urgent signal where a returned `urgency` value of `urgent` is intended to trigger notification to the Kapitan's account regardless of the hour. However, the urgency criteria and notification behavior remain subject to the relevant policy and adviser decisions under PB-35.

This urgency signal is separate from abuse screening. An abuse-screening result must not automatically determine the final urgency or escalation decision.

No particular abuse threshold, recipient, channel, response time, or after-hours procedure is established by this document.

The chatbot must not claim that emergency services or Barangay personnel have been contacted unless the system confirms that the notification or contact action actually occurred.

## 7. False Positives, False Negatives, and Uncertainty

A **false positive** occurs when legitimate content is flagged as potentially abusive.

A **false negative** occurs when harmful or threatening content is not flagged.

Both risks must be evaluated.

### 7.1 Examples of False Positives

Possible false positives include:

- Quoted threats included in a legitimate report.
- Reports of harassment or abuse.
- Criticism of public services or officials.
- Angry complaints expressing dissatisfaction.
- Profanity without a clear threat.
- Sarcasm, jokes, and figurative expressions.
- Informal wording that is misunderstood by the screening process.

### 7.2 Examples of False Negatives

Possible false negatives include:

- Indirect threats.
- Slang or unfamiliar expressions.
- Misspellings and deliberate word variations.
- Sarcasm or coded language.
- Context-dependent threats.
- Mixed-language expressions that are not recognized correctly.
- Harmful content expressed without obvious threatening keywords.

### 7.3 Uncertainty Requirements

The system must follow these requirements:

- Screening output must be treated as advisory.
- Uncertain cases must not be assigned a definitive abuse finding.
- Lack of a screening flag must not be presented as proof that a message is safe.
- Legitimate reports must not be automatically rejected based only on a model result.
- Screening uncertainty must not prevent preservation of a citizen's submission.
- Human corrections should be recorded through an approved process.
- Corrected data may be used for evaluation only under approved data-governance rules.

No numeric confidence threshold is established by this document. Any threshold or decision rule must be evaluated and approved before use.

## 8. Failure Handling and Laravel Responsibilities

### 8.1 Laravel Responsibilities

Laravel remains the system of record and is responsible for:

- Authentication and authorization.
- Request validation and persistence.
- Official application and report status management.
- Authorized workflow routing.
- Notifications and notification records.
- Audit history.
- Authorized personnel corrections.
- Access restrictions for private citizen records.
- Handling application-level failures and approved fallback behavior.

The AI screening component must not independently decide:

- Whether an allegation is true.
- Final administrative outcomes.
- Official case or request status.
- Final urgency and escalation decisions.
- Whether a citizen should be punished or sanctioned.
- Whether a citizen's report should be permanently rejected.

### 8.2 Submission Preservation

The reporting workflow must not depend on successful abuse-screening execution to preserve a citizen's submission.

If screening fails, times out, or returns an invalid response:

- Preserve the original citizen submission through the approved reporting workflow.
- Do not silently discard the message.
- Do not treat a technical failure as evidence of abuse.
- Record screening availability or failure through the approved application and logging design.
- Use a pending or unreviewed state only if that behavior is supported and approved in the system design.
- Follow the approved fallback for any potential urgent concern.
- Avoid presenting the citizen's report as fully reviewed when screening or review has not completed.

### 8.3 Relationship to PB-11 Failure Handling

PB-11 v2.1 establishes that Laravel saves a citizen's request and assigns a reference number before calling the classification service.

If the classification service is unavailable, unreachable, times out, or returns an invalid response, the saved request must remain preserved and be placed into the agreed pending-classification handling path.

The proposed `pending_classification` status name remains subject to final data-model decisions in PB-24.

These PB-11 failure-handling rules apply to the documented classification integration. A separate abuse-screening capability must have its own agreed failure-handling behavior if it is introduced.

The precise retry behavior, fallback states, and any additional API contract must be agreed with the team and documented in PB-11 and related implementation tasks.

### 8.4 No Silent Rejection

A technical screening failure or uncertain result must not silently prevent a citizen from submitting a legitimate concern.

Any decision to restrict access, suspend an account, reject a report, or impose another administrative consequence must follow an independently approved process and must not be triggered solely by an AI screening result.

## 9. Privacy, Access Control, and Auditability

The proposed requirements are:

- Limit access to flagged messages, screening results, and reviewer notes to authorized roles.
- Collect and expose only the information needed for screening and review.
- Protect original messages and personal information from unauthorized disclosure.
- Record relevant screening failures, review actions, and authorized corrections in accordance with the approved audit design.
- Avoid logging unnecessary message content or sensitive personal details.
- Apply the project's approved privacy, access-control, security, and retention requirements.
- Ensure that public chatbot responses do not disclose internal screening results or reviewer notes.
- Ensure that access to screening records follows Laravel authorization and other approved application controls.

### 9.1 Data Minimization

Only information necessary for the screening and review purpose should be processed.

The system should avoid collecting additional personal information solely because a message has been flagged.

### 9.2 Access Restrictions

Flagged messages and screening results must not automatically become visible to all Barangay personnel or chatbot users.

Access should be limited to the roles and purposes approved by the project and Barangay.

### 9.3 Auditability

Where supported by the approved system design, audit records should identify:

- The screening event.
- The relevant request or message reference.
- The screening service result or failure.
- The authorized reviewer, if a review occurred.
- The review action or correction.
- The date and time of relevant actions.

Audit records must follow approved access and retention rules.

This document does not establish a new retention period or authorize broader access to citizen messages. Those details require confirmation against project policy and applicable requirements.

## 10. Evaluation and Testing

Before any abuse-screening capability is treated as production-ready, the team should evaluate it using a reviewed and appropriately governed test set.

### 10.1 Required Test Scenarios

The test set should include:

- Direct and indirect threats.
- Reported or quoted threats.
- Reports of harassment or abuse.
- Legitimate angry complaints and civic criticism.
- Profanity without a clear threat.
- Sarcasm, jokes, and ambiguous statements.
- Filipino, English, and Taglish examples.
- Informal spelling, slang, and relevant regional expressions.
- Messages containing mixed or incomplete context.
- Screening timeouts.
- Invalid responses.
- Service unavailability.
- Duplicate submissions that should be distinguished from abuse-related content.

### 10.2 Evaluation Considerations

Evaluation should examine:

- False-positive frequency.
- False-negative frequency.
- Performance across relevant language and scenario groups.
- Ability to distinguish reported threats from direct threats.
- Ability to preserve legitimate complaints and criticism.
- Behavior when context is insufficient.
- Handling of screening failures and unavailable services.
- Consistency of results across representative examples.

### 10.3 Evaluation Approval

Metrics, minimum acceptable performance, dataset approval, test ownership, and acceptance criteria must be agreed before acceptance.

Exploratory results must not be described as production validation.

Any evaluation data containing personal or sensitive information must follow approved access, privacy, and data-handling rules.

## 11. Decisions Requiring Team or Barangay Confirmation

The following decisions remain subject to confirmation before implementation:

### 11.1 Scope and Capability

- [ ] Is abuse screening within the agreed implementation scope?
- [ ] Which message types and abuse-related concerns are in scope?
- [ ] What screening capability, if any, will the AI service support?
- [ ] Will abuse screening be implemented separately from the existing routine `screening_flag`?
- [ ] Does PB-11 need a reviewed API extension for abuse-screening results?
- [ ] Which conceptual outcomes or labels should be adopted?

### 11.2 Human Review and Escalation

- [ ] Who is authorized to review flagged messages and record corrections?
- [ ] What criteria define a potentially urgent safety concern?
- [ ] Which recipients, notification channels, and after-hours procedures are approved?
- [ ] What fallback applies when screening or notification services fail?
- [ ] What wording may the chatbot use while human review is pending?

### 11.3 Privacy and Governance

- [ ] What privacy, audit, and access-control rules apply?
- [ ] What retention rules apply to original messages, screening results, and reviewer notes?
- [ ] Which personnel may access screening records?
- [ ] How should reviewer corrections be recorded and used?

### 11.4 Evaluation and Acceptance

- [ ] Which test dataset will be used?
- [ ] What metrics and minimum acceptance criteria will apply?
- [ ] Who approves the evaluation results?
- [ ] What language and scenario coverage is required before deployment?

Until these decisions are confirmed, this document must not be treated as an approved operational abuse-screening policy or proof of an implemented capability.

## 12. Acceptance Criteria

PB-22 documentation can be considered ready for team review when:

- [ ] Screening purpose, scope, and limitations are documented.
- [ ] Routine duplicate/spam screening is distinguished from abuse screening.
- [ ] The existing PB-11 `screening_flag` is not incorrectly treated as an abuse-detection result.
- [ ] Examples distinguish direct threats from quoted threats and legitimate complaints.
- [ ] Contextual interpretation and language limitations are documented.
- [ ] Human-review and uncertainty requirements are documented.
- [ ] False-positive and false-negative risks are addressed.
- [ ] Automatic rejection and punishment based solely on model output are prohibited.
- [ ] Submission preservation and screening-failure handling are specified.
- [ ] AI responsibilities are separated from Laravel's official responsibilities.
- [ ] Privacy, access-control, and audit requirements are documented.
- [ ] Proposed outcomes and unapproved policy decisions are clearly identified.
- [ ] API dependencies and required team decisions are listed.
- [ ] Evaluation scenarios and acceptance questions are recorded.
- [ ] The document has been reviewed by the project team.
- [ ] Policy-dependent decisions have been referred to the appropriate Barangay personnel for validation.

These criteria describe documentation readiness. They do not establish that an abuse-screening model has been implemented, evaluated, approved, or deployed.

## 13. Next Steps

1. Review the proposed scope and screening outcomes with the project team.
2. Coordinate with the PB-11 owner before proposing any API changes.
3. Coordinate with the PB-23 owner so chatbot conversation design reflects the agreed safety and human-review boundaries.
4. Coordinate with PB-24 to identify any required data-model changes and approved status handling.
5. Confirm policy-dependent decisions with the appropriate Barangay personnel.
6. Coordinate with PB-35 for urgency criteria and escalation-policy decisions.
7. Keep incident-legitimacy verification separate and refer related research to PB-33a.
8. Update this document to distinguish confirmed decisions from unresolved questions.
9. Record remaining blockers and do not represent unapproved rules as implemented behavior.
10. Commit and share the reviewed document according to the team's Git workflow.

**Document status:** Revised PB-22 requirements document — aligned with PB-11 v2.1, PB-20, and related project requirements; policy-dependent decisions and implementation remain subject to confirmation.

**Document note:** This document defines proposed abuse-screening requirements and safeguards. It does not establish official Barangay policy, verify the truth of citizen allegations, authorize automatic punitive action, or certify that an abuse-screening capability has been implemented.