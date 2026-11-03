# PB-22 — Abuse-Screening Requirements

**Project:** IntRENEt (Internet Barangay System)
**Task:** PB-22 — Abuse-Screening Requirements
**Owner:** Starween
**Sprint:** Sprint 3 — October 19–November 1, 2026
**Status:** Finalized requirements document — aligned with PB-11 v2.1, PB-18 approved label-review policy, PB-20 finalized workflow requirements, and PB-21 finalized knowledge-base requirements
**Related Tasks:** PB-11 — Laravel–Chatbot/AI Orchestrator Contract; PB-18 — Citizen Concern Dataset Review and Label Policy; PB-20 — Service Intent and Workflow Analysis; PB-21 — Knowledge Base and Checklist; PB-23 — Chatbot Conversation Design and AI Orchestrator; PB-24 — Data Model; PB-25 — Laravel–AI Orchestrator Implementation; PB-33a — Incident-Legitimacy Verification Research; PB-35 — Urgency and Escalation Policy

## 1. Purpose

PB-22 defines the requirements and safeguards for identifying messages that may contain abusive, threatening, harassing, or otherwise unsafe content in the IntRENEt chatbot and reporting workflows.

The purpose of abuse screening is to support safer message handling and appropriate human review while preserving citizens' ability to submit legitimate concerns, complaints, and requests for assistance.

Screening must not be treated as proof that an allegation is true, that a citizen has committed wrongdoing, or that a reported person is responsible for an incident.

This document complements the requirements established in PB-11, PB-18, PB-20, and PB-21. It specifically addresses:

- The distinction between routine duplicate/placeholder screening and abuse screening.
- Potential threats, harassment, intimidation, and other unsafe content.
- Contextual interpretation and language limitations.
- Human review and uncertainty handling.
- False-positive and false-negative risks.
- Submission preservation and screening failure behavior.
- Privacy, access control, and auditability.
- Evaluation requirements and dependencies for implementation.

**Finalization boundary:** PB-22 finalizes the project's abuse-screening requirements and safeguards. It does not independently establish official Barangay policy, approve punitive measures, confirm a notification procedure, or certify that an abuse-detection capability has been implemented.

## 2. Scope and Limitations

### 2.1 Proposed Abuse-Screening Scope

An abuse-screening capability, if approved for implementation, may consider:

- Potential threats of harm toward a person or group.
- Targeted harassment, intimidation, or repeated abusive language.
- Content that may require additional safety review.
- Context needed to distinguish abusive content from legitimate reporting, criticism, or quoted speech.
- Messages whose wording or surrounding conversation may indicate a potential safety concern.

Screening should consider Filipino, English, Taglish, informal expressions, spelling variations, slang, and relevant conversational context.

Actual language coverage and performance must be evaluated rather than assumed. A screening capability must not be represented as reliable for a language or expression type that has not been appropriately tested.

### 2.2 Distinction Between Routine Screening and Abuse Screening

PB-22 must distinguish abuse screening from the routine screening capability documented in PB-11 v2.1.

**Routine screening under PB-11 v2.1**

The existing `screening_flag`:

- Covers routine rule-based near-duplicate submissions from the same respondent within a short time window.
- Covers empty or placeholder-only content.
- Provides an advisory screening signal.
- Must not automatically reject a citizen's submission.
- Does not establish that a message contains abuse, a threat, or harassment.
- Does not establish whether an incident or allegation is legitimate.

**Abuse screening under PB-22**

Abuse screening:

- Focuses on potential threats, harassment, intimidation, and other unsafe content.
- Requires its own agreed screening capability and evaluation.
- Must consider message context and the possibility of legitimate reporting or quoted speech.
- May recommend human review when supported by an approved capability.
- Must not be assumed to exist merely because PB-11 defines `screening_flag`.

The two capabilities must not be treated as interchangeable.

### 2.3 PB-11 v2.1 API Boundary

PB-11 v2.1 defines the current proposed `/classify` interface and the following response fields:

- `category`
- `confidence`
- `screening_flag`
- `urgency`

The existing `screening_flag` is limited to routine duplicate/placeholder screening. PB-11 does not define a dedicated abuse-detection field, abuse classification capability, or complete moderation response.

Therefore:

1. PB-22 must not assume that the current `/classify` endpoint performs abuse detection.
2. The existing `screening_flag` must not be reused or interpreted as an abuse indicator.
3. Any additional abuse-screening field, response structure, or endpoint requires review and agreement with the PB-11 owner and project team.
4. Any proposed field names and response values remain provisional until documented and approved.
5. Abuse-screening implementation must be coordinated with PB-24 and PB-25.
6. The interface contract must be updated if the team approves an additional abuse-screening capability.

PB-11 v2.1 is an approved interface design contract, not evidence that the integration or abuse-screening capability has been implemented.

### 2.4 Relationship to Incident-Legitimacy Verification

Abuse screening and incident-legitimacy verification are separate concerns.

**Abuse screening** considers whether message content may contain threats, harassment, intimidation, or other unsafe language.

**Incident-legitimacy verification** concerns whether a reported incident or allegation can be substantiated.

Identifying abusive language does not establish that an incident occurred. Likewise, a legitimate report may contain quoted threats, offensive language, or descriptions of abusive behavior.

PB-33a remains a separate research track for incident-legitimacy verification. PB-22 must not claim that abuse screening verifies the truth of a report or determines whether an incident actually occurred.

## 3. Core Safety Principles

The system must follow these principles:

1. **Screening is advisory.** A model result is a signal for possible review, not proof of abuse, intent, guilt, or the truth of an allegation.
2. **Preserve legitimate reporting.** A citizen must not lose access to the reporting workflow solely because screening is uncertain or unavailable.
3. **Context matters.** The system must consider whether the citizen is quoting a threat, reporting abuse, describing an incident, joking, criticizing a service, or directing a threat at someone.
4. **No automatic punishment.** Model output alone must not trigger report rejection, account sanctions, public labeling, or other punitive action.
5. **Human judgment is required.** Ambiguous and potentially serious cases must follow an approved human-review process when such a process is available.
6. **Use minimum necessary data.** Access to flagged messages and screening results must follow approved privacy and access-control rules.
7. **Do not overpromise.** The chatbot must not claim that a threat is verified, a person has been contacted, or action has been taken unless the application confirms it.
8. **Preserve citizen dignity.** Screening must not discourage legitimate complaints, criticism, or requests for assistance.
9. **Separate technical signals from administrative decisions.** AI-generated screening results must not replace authorized Barangay procedures.
10. **Preserve uncertainty.** When the system cannot reliably interpret a message, it must not present an uncertain result as a confirmed finding.

## 4. Distinguishing Content and Context

Screening and review should distinguish between different message situations. The following examples are test scenarios and proposed handling guidance, not definitive classification rules or official findings.

| Situation | Example | Required handling |
|---|---|---|
| Direct threat | A message appears to threaten imminent physical harm toward a person. | Preserve the submission and follow the approved urgent human-review procedure, if applicable. |
| Reported or quoted threat | "May nag-message po sa akin na sasaktan daw niya ako." | Recognize that the citizen may be reporting a threat, not making one. Follow the applicable reporting workflow. |
| Targeted harassment | Repeated insults or intimidation directed at an identifiable person. | May be flagged for review if supported by an approved screening capability. Do not determine guilt automatically. |
| Angry but legitimate complaint | "Galit na po ako dahil ilang linggo nang walang aksyon." | Do not treat anger or dissatisfaction alone as abuse. Preserve the normal complaint workflow. |
| Civic criticism | Criticism of a Barangay service, official decision, or process. | Do not flag solely because the message is negative or critical. |
| Profanity or slang | Informal or profane language without a clear threat or targeted harassment. | Interpret in context. Profanity alone does not establish abuse. |
| Ambiguous or joking statement | Sarcasm, hyperbole, a joke, or unclear wording. | Avoid definitive conclusions. Use an approved clarification or human-review path where appropriate. |
| Spam or repeated submission | Repeated identical messages or irrelevant content. | Treat as a separate routine screening concern. Do not automatically equate repetition with abusive conduct. |

### 4.1 Contextual Interpretation

When sufficient context is available and its use is authorized, the screening process should consider:

- Is the citizen reporting something another person said or did?
- Is the potentially threatening language quoted or directed at someone?
- Is the citizen describing a past incident or expressing an intention to cause harm?
- Is the message a legitimate complaint about a service or administrative process?
- Does the conversation clarify wording that would otherwise appear threatening?
- Is there insufficient context to make a reliable interpretation?

The system must avoid treating individual keywords, profanity, or negative sentiment as conclusive evidence of abuse.

### 4.2 Representative Language Coverage

Evaluation examples should include:

- Filipino expressions and informal wording.
- English threats and harassment-related expressions.
- Taglish sentences and mixed-language messages.
- Common abbreviations and spelling variations.
- Slang and context-dependent expressions.
- Quoted messages and reported speech.
- Sarcasm, jokes, and figurative language.

These examples must be reviewed and evaluated before the system claims that its screening capability supports the corresponding language patterns.

### 4.3 Legitimate Reporting and Criticism

A citizen must be allowed to describe threats, harassment, conflict, or other unpleasant experiences without automatically being treated as the source of abusive content.

Likewise, criticism of a Barangay service, public process, or administrative decision must not be treated as abuse solely because it is negative, emotional, or strongly worded.

The screening capability must distinguish, as far as its validated performance permits, between:

- Content directed at another person.
- Content reporting something another person said or did.
- Content quoted as evidence or context.
- Legitimate criticism or dissatisfaction.
- Content that remains ambiguous.

When the distinction cannot be made reliably, the system must preserve the submission and avoid a definitive abuse finding.

## 5. Proposed Screening Outcomes

The following are conceptual outcomes for requirements and evaluation discussions. They are not confirmed API values, implemented statuses, or official administrative decisions.

| Proposed outcome | Description |
|---|---|
| No screening concern identified | The available screening process did not identify an abuse-related concern. This does not guarantee that the message is safe. |
| Review recommended | Content or context may warrant review by an authorized person. |
| Potential urgent safety concern | The message may describe an immediate threat or serious risk and requires the approved urgent-review pathway. |
| Uncertain or insufficient context | The screening process cannot reliably determine how the content should be interpreted. |
| Screening unavailable | The screening component failed, timed out, or returned an unusable result. |

### 5.1 Interpretation Restrictions

Proposed outcomes must not be treated as:

- Final findings that a person committed abuse.
- Proof that a threat is genuine or that an allegation is true.
- Official case or application statuses.
- Automatic reasons to reject a citizen's submission.
- Automatic grounds for sanctions or account restrictions.
- Confirmed API enumeration values.
- Evidence that a human reviewer has already assessed the message.

The team must decide whether these outcomes are needed, how they map to API fields and internal records, and which authorized personnel may access them.

No proposed outcome should be implemented as an official application status or administrative decision without the required review and approval.

### 5.2 No Abuse Score as an Automatic Decision

If a future implementation produces an abuse-related score or confidence value, it must be treated as a technical signal whose meaning and limitations are documented.

No score or threshold may independently:

- Reject a report.
- Restrict a citizen's account.
- Establish that a person made a genuine threat.
- Establish that a reported person committed wrongdoing.
- Replace authorized human review.
- Determine final urgency or escalation.

Any threshold used to recommend review must be evaluated and approved before operational use.

## 6. Human Review and Urgent Concerns

### 6.1 Human Review Requirements

Before the system claims to provide human review, the approved review process must define:

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

The project and appropriate Barangay representatives must confirm:

- The criteria for a potentially urgent threat.
- Who receives urgent notifications.
- Which notification channels are authorized.
- What happens outside office hours.
- What fallback applies if the notification or screening service fails.
- What wording the chatbot may use while action is pending.
- How notification attempts and confirmed outcomes are recorded.

PB-11 v2.1 describes a proposed urgent signal in which a returned `urgency` value of `urgent` is intended to trigger notification to the Kapitan's account regardless of the hour.

However, the urgency criteria and exact notification behavior remain subject to the policy and adviser decisions under PB-35.

This urgency signal is separate from abuse screening. An abuse-screening result must not automatically determine the final urgency or escalation decision.

No particular abuse threshold, recipient, channel, response time, or after-hours procedure is established by PB-22 alone.

The chatbot must not claim that emergency services or Barangay personnel have been contacted unless the system confirms that the notification or contact action actually occurred.

### 6.3 Human Review Is Not Incident Verification

A reviewer assessing potentially abusive content is not automatically determining whether the reported incident occurred.

Reviewing a message for safety concerns must remain distinct from investigating or verifying the underlying allegation.

The system must preserve this distinction in its records, chatbot responses, and administrative workflows.

## 7. False Positives, False Negatives, and Uncertainty

A **false positive** occurs when legitimate content is flagged as potentially abusive.

A **false negative** occurs when harmful or threatening content is not flagged.

Both risks must be evaluated before any abuse-screening capability is treated as suitable for operational use.

### 7.1 Examples of False Positives

Possible false positives include:

- Quoted threats included in a legitimate report.
- Reports of harassment or abuse.
- Criticism of public services or officials.
- Angry complaints expressing dissatisfaction.
- Profanity without a clear threat.
- Sarcasm, jokes, and figurative expressions.
- Informal wording that is misunderstood by the screening process.
- Messages describing a threat made by another person.

### 7.2 Examples of False Negatives

Possible false negatives include:

- Indirect threats.
- Slang or unfamiliar expressions.
- Misspellings and deliberate word variations.
- Sarcasm or coded language.
- Context-dependent threats.
- Mixed-language expressions that are not recognized correctly.
- Harmful content expressed without obvious threatening keywords.
- Messages whose threatening meaning depends on prior conversation.

### 7.3 Uncertainty Requirements

The system must follow these requirements:

- Screening output must be treated as advisory.
- Uncertain cases must not be assigned a definitive abuse finding.
- Lack of a screening flag must not be presented as proof that a message is safe.
- Legitimate reports must not be automatically rejected based only on a model result.
- Screening uncertainty must not prevent preservation of a citizen's submission.
- Human corrections should be recorded through an approved process.
- Corrected data may be used for evaluation only under approved data-governance rules.
- A screening failure must not be interpreted as a positive abuse result.

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

1. Preserve the original citizen submission through the approved reporting workflow.
2. Do not silently discard the message.
3. Do not treat a technical failure as evidence of abuse.
4. Record screening availability or failure through the approved application and logging design.
5. Use a pending or unreviewed state only if that behavior is supported and approved in the system design.
6. Follow the approved fallback for any potential urgent concern.
7. Avoid presenting the citizen's report as fully reviewed when screening or review has not completed.

### 8.3 Relationship to PB-11 Failure Handling

PB-11 v2.1 establishes that Laravel saves a citizen's request and assigns a reference number before calling the classification service.

If the classification service is unavailable, unreachable, times out, or returns an invalid response, the saved request must remain preserved and follow the agreed pending-classification handling path.

The proposed `pending_classification` status name remains subject to the final data-model decisions in PB-24.

These PB-11 failure-handling rules apply to the documented classification integration. A separate abuse-screening capability must have its own agreed failure-handling behavior if it is introduced.

The precise retry behavior, fallback states, and any additional API contract must be agreed with the team and documented in PB-11 and related implementation tasks.

### 8.4 No Silent Rejection

A technical screening failure or uncertain result must not silently prevent a citizen from submitting a legitimate concern.

Any decision to restrict access, suspend an account, reject a report, or impose another administrative consequence must follow an independently approved process and must not be triggered solely by an AI screening result.

### 8.5 Screening Must Not Block the Save-First Workflow

The existence of an abuse-screening requirement must not reverse the save-first workflow established by PB-11 v2.1.

The request must be preserved before the classification call. An additional abuse-screening process must not become a precondition for saving a citizen's report unless a separate, explicitly approved policy and technical design establishes otherwise.

## 9. Privacy, Access Control, and Auditability

The system must apply the following safeguards:

- Limit access to flagged messages, screening results, and reviewer notes to authorized roles.
- Collect and expose only the information needed for screening and review.
- Protect original messages and personal information from unauthorized disclosure.
- Record relevant screening failures, review actions, and authorized corrections in accordance with the approved audit design.
- Avoid logging unnecessary message content or sensitive personal details.
- Apply the project's approved privacy, access-control, security, and retention requirements.
- Ensure public chatbot responses do not disclose internal screening results or reviewer notes.
- Ensure access to screening records follows Laravel authorization and other approved application controls.

### 9.1 Data Minimization

Only information necessary for the screening and review purpose should be processed.

The system should avoid collecting additional personal information solely because a message has been flagged.

Where contextual information is required, the system should use only the relevant authorized conversation context.

### 9.2 Access Restrictions

Flagged messages and screening results must not automatically become visible to all Barangay personnel or chatbot users.

Access must be limited to the roles and purposes approved by the project and Barangay.

The chatbot must not disclose internal screening labels, reviewer comments, or restricted administrative information to citizens.

### 9.3 Auditability

Where supported by the approved system design, audit records should identify:

- The screening event.
- The relevant request or message reference.
- The screening service result or failure.
- The authorized reviewer, if a review occurred.
- The review action or correction.
- The date and time of relevant actions.

Audit records must follow approved access and retention rules.

This document does not establish a new retention period or authorize broader access to citizen messages. Those details must be confirmed against project policy and applicable requirements.

## 10. Evaluation and Testing

Before any abuse-screening capability is treated as production-ready, the team must evaluate it using a reviewed and appropriately governed test set.

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
- Whether the screening process introduces inappropriate barriers to citizen reporting.

### 10.3 Evaluation Approval

Metrics, minimum acceptable performance, dataset approval, test ownership, and acceptance criteria must be agreed before acceptance.

Exploratory results must not be described as production validation.

Any evaluation data containing personal or sensitive information must follow approved access, privacy, and data-handling rules.

### 10.4 Evaluation Does Not Establish Truth

Successful screening evaluation measures the capability's performance against the approved test criteria.

It does not establish that:

- A citizen's allegation is true.
- A reported person is guilty.
- A potential threat will necessarily occur.
- A message is harmless merely because it was not flagged.

The screening capability must remain limited to its validated purpose.

## 11. Finalized Requirements and Remaining Decisions

### 11.1 Finalized Project Requirements

The following requirements are finalized for dependent project tasks:

1. Routine screening under PB-11 v2.1 must remain separate from abuse screening.
2. The existing `screening_flag` must not be interpreted as an abuse-detection result.
3. Abuse screening, if implemented, must focus on potential threats, harassment, intimidation, and other unsafe content.
4. Message context must be considered when distinguishing direct threats from reported or quoted threats.
5. Legitimate criticism, angry complaints, and reports of abuse must not automatically be treated as abusive content.
6. Screening results must remain advisory.
7. AI output alone must not cause automatic report rejection, sanctions, or punitive administrative action.
8. Uncertain or unavailable screening must not prevent preservation of a legitimate submission.
9. Laravel remains responsible for authentication, authorization, persistence, official status, notifications, and audit records.
10. Abuse screening must remain separate from incident-legitimacy verification under PB-33a.
11. Urgency criteria and escalation decisions remain under PB-35.
12. Any additional API field or screening endpoint must be reviewed and agreed before implementation.
13. Privacy, access-control, and audit requirements must apply to screening records.
14. Screening capability must be evaluated before being represented as production-ready.

These requirements are the finalized PB-22 project baseline. They may be used by dependent tasks for design and implementation planning.

### 11.2 Decisions Requiring Additional Confirmation

The following are not established by PB-22 alone:

- Whether a dedicated abuse-screening capability will be included in the implementation scope.
- Which abuse-related labels or outcomes will be used.
- Whether an additional API field or endpoint is required.
- Which personnel are authorized to review flagged content.
- The exact human-review workflow.
- Urgency criteria and notification behavior.
- Notification recipients and channels.
- After-hours procedures.
- Retention periods for screening results and reviewer notes.
- Minimum evaluation thresholds and production acceptance criteria.

These decisions must be confirmed by the appropriate project owners and Barangay representatives before they are treated as operational policy or implemented behavior.

## 12. Acceptance Criteria

PB-22 documentation is considered finalized when the following requirements are documented:

- [x] Screening purpose, scope, and limitations are documented.
- [x] Routine duplicate/placeholder screening is distinguished from abuse screening.
- [x] The existing PB-11 `screening_flag` is not incorrectly treated as an abuse-detection result.
- [x] Examples distinguish direct threats from quoted threats and legitimate complaints.
- [x] Contextual interpretation and language limitations are documented.
- [x] Human-review and uncertainty requirements are documented.
- [x] False-positive and false-negative risks are addressed.
- [x] Automatic rejection and punishment based solely on model output are prohibited.
- [x] Submission preservation and screening-failure requirements are specified.
- [x] AI responsibilities are separated from Laravel's official responsibilities.
- [x] Privacy, access-control, and audit requirements are documented.
- [x] Proposed outcomes and unconfirmed policy decisions are clearly identified.
- [x] API dependencies and implementation boundaries are documented.
- [x] Evaluation scenarios and acceptance considerations are recorded.
- [x] The document is aligned with PB-11 v2.1, PB-18, PB-20, and PB-21.
- [x] The document is ready to support dependent project tasks.

**Important:** These checkboxes indicate that the PB-22 documentation requirements have been addressed in this document. They do not indicate that an abuse-screening model has been implemented, evaluated, approved, or deployed. They also do not establish that the Barangay has independently approved every policy-dependent decision.

## 13. Next Steps

With the PB-22 requirements finalized, dependent work may proceed using the following responsibilities:

1. **PB-23:** Align chatbot conversation design with the finalized abuse-screening safeguards, context handling, and human-review boundaries.
2. **PB-24:** Determine whether additional data fields or internal records are required for screening results, review actions, and failure handling.
3. **PB-25:** Implement only the agreed and approved technical interface and screening behavior. Coordinate any API changes with the PB-11 owner.
4. **PB-33a:** Keep incident-legitimacy verification as a separate research and evaluation track.
5. **PB-35:** Finalize urgency criteria, escalation rules, notification recipients, channels, and after-hours handling.
6. **Policy confirmation:** Obtain the necessary Barangay confirmation for operational review procedures, access permissions, and notification arrangements.
7. **Evaluation:** Prepare and review representative test data, evaluate false positives and false negatives, and record acceptance results.
8. **Documentation maintenance:** Update PB-22 only when a relevant approved policy or technical contract changes.
9. **Version control:** Commit and share the finalized requirements document according to the team's Git workflow.


**Document status:** Finalized PB-22 requirements document — aligned with PB-11 v2.1, PB-18 approved label-review policy, PB-20 finalized workflow requirements, and PB-21 finalized knowledge-base requirements.

**Document note:** PB-22 finalizes the project's abuse-screening requirements and safeguards. It does not establish official Barangay policy, verify the truth of citizen allegations, authorize automatic punitive action, or certify that a dedicated abuse-screening capability has been implemented, evaluated, or deployed.