# PB-20 — Service Intent and Workflow Analysis

**Project:** IntRENEt (Internet Barangay System)
**Sprint:** Sprint 3 — October 19–November 1, 2026
**Owner:** Starween
**Status:** Finalized requirements — aligned with approved PB-11 v2.1, approved PB-18 label-review policy, and revised PB-21/PB-22 requirements
**Related tasks:** PB-11 — Laravel–Chatbot/AI Orchestrator Contract; PB-15–PB-19 — Concern Classification and Evaluation; PB-21 — Service Knowledge Base and Checklist; PB-22 — Abuse-Screening Requirements; PB-23 — Chatbot Conversation Design and AI Orchestrator; PB-24 — Data Model; PB-25 — Laravel–AI Orchestrator Implementation; PB-35 — Urgency and Escalation Policy

## 1. Purpose

PB-20 defines how the IntRENEt chatbot identifies what citizens need, selects the appropriate conversation workflow, asks clarifying questions, and explains available services and next steps in understandable language.

Citizens may communicate in Filipino, English, Taglish, informal expressions, regional vocabulary, abbreviations, spelling variations, or incomplete sentences. They may also be unfamiliar with official document names, administrative procedures, online forms, and the distinction between a service inquiry and a formal concern report.

The chatbot must therefore understand the citizen's intended purpose rather than depend solely on exact keywords or formal terminology.

This document establishes:

- The ten conversation-intent categories and their intended workflows.
- The distinction between conversation intent and concern classification.
- The routing rules connecting citizen intents to service, assistance, reporting, and follow-up workflows.
- The distinction between assistance inquiries and actual assistance requests.
- Clarification and uncertainty-handling requirements.
- Filipino, English, Taglish, and informal-language requirements.
- The responsibilities of the chatbot, AI orchestrator, and Laravel application.
- The relationship between routine screening, abuse screening, urgency, and potential hazards.
- The requirements and dependencies that PB-23 and subsequent implementation tasks must follow.

PB-20 is the workflow and requirements reference for PB-23. PB-21 supplies verified service information. PB-11 v2.1 defines the approved AI orchestrator interface design. PB-24 and PB-25 govern the corresponding data-model and implementation work.

## 2. Document Authority and Status

### 2.1 Approved project decisions

This revision incorporates the following established project decisions:

| Reference | Decision incorporated into PB-20 |
|---|---|
| PB-11 v2.1 | Approved Laravel–AI orchestrator interface design, including save-first submission behavior, classification request and response requirements, confidence interpretation, routine screening, urgency signaling, and failure handling. |
| PB-18 | Approved concern-label review policy, including one primary category per report, category-boundary rules, duplicate handling, and separation of category labels from urgency and hazard judgments. |
| PB-20 | Ten conversation intents and their corresponding workflow requirements. |
| PB-21 | Verified service information and checklist requirements for citizen-facing document and service guidance. |
| PB-22 | Separate abuse-screening requirements; abuse screening must not be confused with PB-11 routine duplicate/placeholder screening. |

These decisions are requirements and design agreements. They do not establish that the related software features have already been implemented or tested.

### 2.2 Authority and implementation boundaries

The following distinctions apply throughout this document:

- **Approved requirement:** A project decision or interface behavior already established by the relevant approved task.
- **Implementation responsibility:** Work that must be completed in PB-24, PB-25, or another assigned implementation task.
- **Policy-dependent operation:** A procedure that requires an authorized Barangay policy or operational decision before it can be used in practice.

PB-20 does not independently authorize new Barangay policies, invent service requirements, or declare unimplemented capabilities operational.

Where a task owns a specific implementation or policy decision, that task remains responsible for completing it. This does not prevent PB-23 and other dependent tasks from proceeding with the requirements already established here.

## 3. Citizen-Centered Design Principles

### 3.1 Understand the citizen's need, not just the wording

Citizens should not need to know an official service name to receive assistance.

For example:

**Citizen:** “Paano po kumuha ng papel na nagpapatunay na dito ako nakatira?”

The chatbot should recognize that the citizen may be asking about a Certificate of Residency and confirm the interpretation when necessary.

### 3.2 Communicate naturally and respectfully

The chatbot should use clear, polite, conversational Filipino or English according to the citizen's language and the system's supported capabilities.

It should avoid unnecessary technical terminology, overly formal wording, and responses that make citizens feel their questions are inappropriate.

### 3.3 Support citizens unfamiliar with digital processes

The chatbot should explain:

- What the citizen can do next.
- What information is required.
- Why particular information is being requested.
- How to proceed when the citizen cannot complete a digital step.

It must not assume that citizens understand online reporting, document uploads, reference numbers, or administrative terminology.

### 3.4 Ask rather than assume

When multiple interpretations are plausible, the chatbot should ask a focused clarifying question instead of confidently selecting the wrong workflow.

It should not repeatedly request information the citizen has already provided.

### 3.5 Provide verified information

Requirements, fees, eligibility, office hours, processing times, and procedures must come from the approved PB-21 knowledge base or another authorized source.

If information is unavailable, incomplete, outdated, or unverified, the chatbot must explain the limitation and provide an appropriate way to obtain confirmation.

It must not invent requirements, fees, deadlines, eligibility conditions, or service availability.

### 3.6 Preserve citizen control and dignity

The chatbot must not pressure citizens to disclose unnecessary personal information or imply that a report is invalid because it is informal, incomplete, or contains spelling mistakes.

### 3.7 Keep official decisions under human and system control

AI-generated intent predictions, concern categories, confidence scores, screening signals, and urgency indicators are advisory.

Laravel remains the system of record for authentication, authorization, validation, persistence, official status management, assignment, routing, notifications, audit history, and authorized personnel corrections.

The chatbot and orchestrator must not independently determine the truth of allegations, make final administrative decisions, impose sanctions, or claim that an issue has been resolved without confirmation.

## 4. Conversation Intent and Concern Classification

The system must distinguish two separate concepts.

**Conversation intent** identifies what the citizen wants to accomplish during the conversation. It determines which chatbot workflow should be followed.

**Concern category** identifies the type of community issue when a citizen is actually submitting a concern or report. It is handled through the concern-classification process defined by PB-11 v2.1.

The chatbot must identify the applicable conversation workflow before invoking concern classification.

A citizen asking about Barangay Clearance, for example, must not be sent through the concern classifier merely because the conversation mentions a Barangay service.

### 4.1 The ten approved conversation intents

PB-20 establishes the following ten conversation intents for use by PB-23.

| No. | Conversation intent | Meaning | Example | Intended workflow |
|---:|---|---|---|---|
| 1 | Service or document inquiry | The citizen asks about a Barangay service or document. | “Ano po requirements para sa barangay clearance?” | Retrieve verified service information from PB-21. |
| 2 | Service-process guidance | The citizen asks how to complete a service or transaction. | “Saan po ako magsisimula kung kukuha ako ng residency?” | Explain the verified process and next steps. |
| 3 | Eligibility or requirements clarification | The citizen asks whether a requirement or eligibility condition applies. | “Kailangan po ba ng valid ID?” | Answer using verified service rules only. |
| 4 | Community concern or report | The citizen describes an issue requiring Barangay attention or intends to submit a report. | “Hindi po nakokolekta ang basura sa amin.” | Determine whether a report is being submitted and follow the concern-submission workflow. |
| 5 | Reporting-process inquiry | The citizen asks how to report or complain about an issue. | “Paano po magreklamo tungkol sa maingay na kapitbahay?” | Explain the reporting process and offer the submission workflow when appropriate. |
| 6 | Assistance inquiry | The citizen asks what assistance or support is available. | “May tulong po ba para sa senior citizen?” | Retrieve verified assistance information or provide an approved referral. |
| 7 | Assistance request | The citizen actively asks the Barangay for help or assistance. | “Kailangan po namin ng tulong dahil wala po kaming makain.” | Clarify the requested help and follow the assistance-request workflow. |
| 8 | Follow-up or status inquiry | The citizen asks about an existing report or service request. | “May update na po ba sa report ko?” | Use the authorized status-checking process. |
| 9 | Ambiguous or mixed intent | The message is unclear or contains multiple possible requests. | “May problema po kami sa kalsada. Puwede po ba magpatulong?” | Ask a focused clarification or separate supported requests. |
| 10 | Other or unclassified | The message cannot be reliably assigned to a supported conversation intent. | A message unrelated to available workflows or still unclear after clarification. | Offer an approved alternative, clarification, or human assistance. |

These are conversation-level categories. They are not additional concern-classifier labels and must not automatically become database enum values. Any required persistence or representation must be coordinated through PB-24.

### 4.2 The eight PB-11 v2.1 orchestrator category names

PB-11 v2.1 establishes eight category names for the overall orchestrator and workflow agreement:

1. Barangay Clearance/Certification
2. Certificate of Residency
3. Certificate of Indigency
4. Community Concern
5. Noise Complaint
6. Peace and Order Concern
7. Barangay Assistance
8. Other/Unclassified

These labels do not all belong to the same concern-classification task.

The agreed distinction is:

- **Document-service labels:** Barangay Clearance/Certification, Certificate of Residency, and Certificate of Indigency are handled through conversation intent recognition and the document-service workflow.
- **Concern-classification labels:** Community Concern, Noise Complaint, Peace and Order Concern, and Barangay Assistance are the four concern labels covered by the PB-15 to PB-19 concern-classification dataset and evaluation.
- **Fallback label:** Other/Unclassified is used when the agreed concern-classification conditions do not support a reliable concern label.

A document-service inquiry must not be sent through the four-label concern classifier.

### 4.3 Approved concern-label principles from PB-18

The following PB-18 policy decisions govern concern-category interpretation:

1. Each report receives one primary concern category.
2. The primary category reflects the main reported concern and its impact.
3. The system must not assume that an unverified cause or allegation is established fact.
4. A multi-issue report retains one primary category and may be flagged for personnel review.
5. Urgency and potential hazard are separate from the primary concern category.
6. Accumulated garbage that obstructs pedestrian movement remains Community Concern; obstruction is recorded as an impact or supporting detail.
7. Obstruction primarily caused by disorderly conduct may warrant Peace and Order review.
8. Chemical exposure, regulatory violations, and other allegations are not verified facts merely because they appear in a report.
9. AI suggests a category; it does not verify the incident, establish guilt, or make the final administrative decision.
10. Approved duplicate groups must be handled consistently and kept together during dataset splitting to prevent evaluation leakage.

PB-18's approved policy governs labeling. Record-specific matters that remain pending Barangay clarification must not be used to invent broader category rules.

### 4.4 Assistance inquiry versus assistance request

These intents must remain distinct:

**Assistance inquiry**

The citizen wants to know whether a program, service, or form of assistance exists, how it works, or where to ask about it.

Example: “Saan po puwedeng magtanong tungkol sa PWD assistance?”

Expected behavior: Provide verified program information or an approved referral. Do not invoke concern classification solely because assistance is mentioned.

**Assistance request**

The citizen is actively asking the Barangay to provide or help obtain assistance.

Example: “Wala po kaming makain ngayon. May matatakbuhan po ba kami?”

Expected behavior: Respond empathetically, clarify the requested assistance, and follow the approved assistance-request workflow. When an actual concern/request is submitted for classification, Barangay Assistance is the applicable concern category when supported by the approved label definition.

The chatbot must not promise eligibility, approval, funding, availability, or a specific outcome.

## 5. Intent-to-Workflow Routing Table

The following routing table is the authoritative PB-20 workflow reference for PB-23.

| Conversation intent | Primary destination | Required chatbot behavior | Concern classification? |
|---|---|---|---|
| Service or document inquiry | PB-21 knowledge base | Identify the service, retrieve verified information, and explain the available requirements. | No |
| Service-process guidance | PB-21 verified process guidance | Explain the approved steps and guide the citizen through the process. | No |
| Eligibility or requirements clarification | PB-21 verified requirements | Answer only from approved information; explain when confirmation is needed. | No |
| Community concern or report | Laravel concern-submission workflow | Determine whether the citizen intends to submit; collect required details; save first through Laravel. | Yes, after Laravel saves the request |
| Reporting-process inquiry | Reporting guidance | Explain how to report and ask whether the citizen also wants to submit a report. | No, unless the citizen proceeds with an actual concern submission |
| Assistance inquiry | PB-21 verified assistance information or approved referral | Explain available information without promising eligibility or approval. | No |
| Assistance request | Assistance-request workflow | Clarify the requested help and follow the approved submission or referral process. | Yes, when an actual request is submitted for concern classification and the category applies |
| Follow-up or status inquiry | Authenticated Laravel status-checking workflow | Verify authorization and retrieve only the citizen's permitted record. | No |
| Ambiguous or mixed intent | Clarification workflow | Ask one focused question; separate distinct supported requests when necessary. | No, until an actual concern submission is identified |
| Other or unclassified | Approved fallback or human-assistance path | Explain the limitation, clarify when useful, or refer through an approved channel. | Only if a concern is actually submitted and the classifier is invoked |

### 5.1 Routing rules

The following rules apply to all ten intents:

- A request for information is not automatically a formal transaction or concern submission.
- A request for reporting instructions is not automatically a submitted complaint.
- A citizen must not be forced through concern classification merely because a concern-related keyword appears in a question.
- Concern classification is invoked only when an actual concern or applicable assistance request is being submitted.
- Classification takes place after Laravel saves the submission and assigns its reference number.
- Follow-up requests use the authorized Laravel status workflow, not the concern classifier.
- Ambiguous messages should be clarified before selecting a workflow, unless an approved urgent-case procedure requires immediate handling.
- If multiple independent needs are present, the chatbot should separate them rather than silently combine unrelated matters into one request.
- An unclassified conversation intent is not the same as the concern classifier returning Other/Unclassified.

### 5.2 Routing examples

| Citizen message | Intent | Expected handling |
|---|---|---|
| “Ano po requirements para sa barangay clearance?” | Service or document inquiry | Retrieve the verified PB-21 checklist. |
| “Paano po mag-apply ng residency?” | Service-process guidance | Explain the approved process. |
| “Kailangan po ba ng valid ID?” | Eligibility or requirements clarification | Check the verified requirements for the relevant service. |
| “Ang tagal na pong hindi nakokolekta ang basura sa amin.” | Community concern or report | Treat as a potential submission and follow the Laravel save-first workflow. |
| “Paano po mag-report ng tambak na basura?” | Reporting-process inquiry | Explain the reporting process; ask whether the citizen also wants to submit. |
| “May assistance po ba para sa senior citizen?” | Assistance inquiry | Retrieve verified assistance information. |
| “Kailangan po namin ng tulong sa pagkain.” | Assistance request | Clarify the requested assistance and follow the approved workflow. |
| “May update na po ba sa report ko?” | Follow-up or status inquiry | Use authenticated status checking. |
| “May problema po kami. Puwede po ba magpatulong?” | Ambiguous or mixed intent | Ask what happened or what help is needed. |
| A message unrelated to supported workflows | Other or unclassified | Offer an approved alternative or human assistance. |

## 6. Citizen Conversation and Language Requirements

The following examples demonstrate expected chatbot behavior. They are illustrative workflow examples, not independent declarations of Barangay policy.

### 6.1 Informal document description

**Citizen:** “Paano po kumuha ng papel na nagpapatunay na taga-rito ako?”

**Chatbot:** “Maaaring Certificate of Residency po ang kailangan ninyo. Tama po ba, o may iba kayong dokumentong kailangan?”

**Expected behavior:** Recognize the likely service and confirm the interpretation if necessary.

### 6.2 Document requirements

**Citizen:** “Ano po kailangan para makakuha ng barangay clearance?”

**Chatbot:** “Tutulungan ko po kayo. Narito po ang mga requirements na nakalista sa aming opisyal na impormasyon: [verified requirements].”

**Expected behavior:** Retrieve the approved PB-21 checklist. If requirements are not verified, explain that confirmation is needed rather than inventing a list.

### 6.3 Asking how to report

**Citizen:** “Paano po mag-report ng tambak na basura sa kanto namin?”

**Chatbot:** “Maaari ko po kayong gabayan sa pag-report nito. Gusto po ba ninyong malaman muna ang proseso, o nais na rin po ninyong isumite ang concern?”

**Expected behavior:** Distinguish reporting-process inquiry from actual submission.

### 6.4 Submitting a concern

**Citizen:** “Ang tagal na pong hindi nakokolekta ang basura sa street namin.”

**Chatbot:** “Nauunawaan ko po. Para maitala natin nang tama ang concern, saang lugar po ito nangyayari?”

**Expected behavior:** Treat the message as a potential report, acknowledge the concern, and request only necessary missing details. Do not ask for information already supplied.

### 6.5 Taglish request

**Citizen:** “Paano po mag-apply ng barangay clearance? Need ko lang po for work.”

**Chatbot:** “Sige po. Matutulungan ko kayong alamin ang requirements para sa barangay clearance na kailangan ninyo sa trabaho.”

**Expected behavior:** Understand mixed-language requests without requiring the citizen to restate them in one language.

### 6.6 Unclear neighbor concern

**Citizen:** “May problema po kami sa kapitbahay namin. Ano po kaya puwedeng gawin?”

**Chatbot:** “Tutulungan po namin kayong malaman ang tamang susunod na hakbang. Maaari po bang ikuwento nang kaunti kung ano ang nangyari?”

**Expected behavior:** Ask neutrally. Do not assume a crime, violation, or particular complaint category.

### 6.7 Assistance inquiry

**Citizen:** “May tulong po ba para sa senior citizen?”

**Chatbot:** “Maaari ko po kayong tulungang hanapin ang available na impormasyon tungkol sa assistance para sa senior citizens. Anong uri po ng tulong ang nais ninyong malaman?”

**Expected behavior:** Clarify the type of assistance and use verified information. Do not promise eligibility or approval.

### 6.8 Assistance request

**Citizen:** “Wala po kaming makain ngayon. May matatakbuhan po ba kami?”

**Chatbot:** “Nauunawaan ko po na kailangan ninyo ng tulong. Maaari ko po bang malaman kung anong uri ng assistance ang kailangan ninyo upang maituro ko ang angkop na available na proseso o referral?”

**Expected behavior:** Respond empathetically, clarify the requested help, and provide only verified options or approved referrals.

### 6.9 Follow-up inquiry

**Citizen:** “May update na po ba sa complaint ko?”

**Chatbot:** “Matutulungan ko po kayong alamin ang status nito. Gamitin po natin ang opisyal na proseso ng pag-check ng report upang matiyak na sa tamang record tayo tumitingin.”

**Expected behavior:** Follow authentication and privacy rules. Do not reveal another citizen's information.

## 7. Workflow Requirements

### 7.1 Service and document inquiries

For document-service inquiries, the chatbot must:

1. Identify the likely document or service even when the citizen describes it informally.
2. Confirm the intended service if more than one interpretation is plausible.
3. Retrieve approved information from PB-21.
4. Explain requirements and steps in accessible language.
5. Ask for additional details only when necessary.
6. Explain how to obtain confirmation when information is unavailable or unverified.
7. Guide the citizen to the appropriate transaction workflow when they decide to proceed.

The initial document-service scope consists of:

- Barangay Clearance/Certification.
- Certificate of Residency.
- Certificate of Indigency.

Actual requirements, fees, eligibility, office hours, processing times, procedures, and supporting documents must come from verified Barangay sources maintained through PB-21.

The chatbot must not invoke the four-label concern classifier for ordinary document-service inquiries or transactions.

### 7.2 Community concerns and reports

For community concerns and reports, the chatbot must:

1. Recognize whether the citizen is asking about reporting or actually submitting a concern.
2. Acknowledge the concern without deciding whether an allegation is true.
3. Collect the information required by the approved reporting workflow.
4. Submit the citizen's concern through Laravel.
5. Follow the save-first behavior established by PB-11 v2.1.
6. Request concern classification only after Laravel saves the request and assigns its reference number.
7. Present classification, screening, or urgency information only according to the approved interface and authorization rules.
8. Communicate only submission and status information confirmed by Laravel.

#### 7.2.1 Save-first submission behavior

PB-11 v2.1 establishes that Laravel saves the citizen's request and assigns its reference number before requesting AI classification.

The classification operation is a follow-up step applied to an already-saved record. It must not be a precondition for saving a citizen's report.

The intended sequence is:

1. The citizen provides a concern through the chatbot.
2. The chatbot collects information required by the approved submission workflow.
3. Laravel validates the application request.
4. Laravel saves the request and assigns its reference number.
5. Laravel returns available confirmation information to the chatbot.
6. Laravel sends the concern text to the orchestrator through `POST /classify`.
7. The orchestrator returns the agreed classification response or a structured error.
8. Laravel handles the result and updates the record according to the approved workflow.
9. Authorized personnel retain responsibility for corrections, routing, and subsequent administrative decisions.

The chatbot must not claim that a concern has been successfully recorded unless Laravel confirms that it was saved.

If saving fails, the chatbot must not invent a reference number or claim that the report was submitted.

If classification fails after saving, the citizen's request must remain preserved. PB-11 v2.1 specifies a pending-classification workflow. PB-24 owns the final status name and associated data-model decisions.

### 7.3 Assistance inquiries and requests

The chatbot must distinguish between asking about available assistance and actively requesting help.

For assistance inquiries, it should retrieve verified information or provide an approved referral.

For assistance requests, it should respond empathetically, clarify the requested help, and follow the approved submission or referral process.

It must not promise financial assistance, eligibility, approval, availability, or a specific outcome without confirmation from an authorized source.

For urgent or vulnerable situations, it must follow approved referral and escalation procedures rather than improvising promises or unsupported advice.

### 7.4 Reporting-process inquiries

A reporting-process inquiry is not automatically a submitted complaint.

When a citizen asks how to report an issue, the chatbot must explain the approved process and, where appropriate, ask whether the citizen also wants to submit the concern.

The system must not create a formal report solely because a citizen asks about reporting procedures.

### 7.5 Follow-up and status inquiries

When citizens ask about an existing report or service request, the chatbot must use the approved status-checking workflow.

It must:

- Follow authentication and authorization requirements.
- Retrieve only records the citizen is permitted to access.
- Avoid disclosing another citizen's information.
- Distinguish between a recorded submission, an ongoing process, and a confirmed resolution.
- Avoid claiming that an issue has been resolved unless Laravel or an authorized personnel action confirms that status.

The exact status-query interface is separate from PB-11's `/classify` endpoint. It must be specified and implemented through PB-24 and PB-25.

### 7.6 Ambiguous or mixed intents

When a message could fit several workflows, the chatbot must:

- Acknowledge the likely meaning.
- Ask one focused clarifying question.
- Avoid repeatedly asking for information already supplied.
- Separate distinct requests only when the system supports that behavior.
- Preserve report information already collected if clarification is needed.
- Use the approved fallback when the intent remains uncertain.

If a message contains both a service inquiry and a community concern, the chatbot should identify the separate needs and guide the citizen through the appropriate supported workflows. It must not silently combine unrelated requests into one record.

## 8. Language Support and Evaluation

The chatbot should support natural citizen communication rather than depend exclusively on formal written Filipino or English.

Requirements:

- Understand common Filipino and English expressions, including Taglish within the evaluated scope.
- Handle common spelling mistakes, informal phrasing, abbreviations, and incomplete sentences where supported by testing.
- Respond in a language the citizen appears comfortable using, where feasible.
- Use respectful, plain language and explain official terms.
- Avoid interpreting informal language, grammar, or spelling as evidence of spam or an invalid report.
- Ask for clarification when a word or expression could change the meaning of a request.
- Evaluate representative examples written in different language styles before relying on the model for operational routing.
- Add support for other Philippine languages only when included in project scope and supported by evaluation.

### 8.1 Language evaluation coverage

Testing should include:

- Formal Filipino.
- Conversational Filipino.
- English.
- Taglish.
- Common spelling variations and typographical errors.
- Informal expressions and abbreviations.
- Short and incomplete messages.
- Messages with multiple possible interpretations.
- Local or context-dependent vocabulary.

Evaluation must measure whether the chatbot identifies the correct intent and follows the appropriate workflow, not merely whether its response sounds fluent.

## 9. Uncertainty, Classification, and Human Review

### 9.1 Intent recognition and concern classification are separate

The orchestrator identifies the citizen's broad conversational intent before selecting the applicable workflow.

The concern classifier suggests a category when the citizen is submitting an actual community concern or applicable assistance request.

Recognizing that a citizen is submitting a report does not guarantee that the correct concern category is known.

Likewise, a correct category prediction does not establish that an allegation is true.

### 9.2 Confidence interpretation

PB-11 v2.1 establishes the following confidence semantics:

- The reported score ranges from 0.0 to 1.0.
- It represents the model-reported confidence for its prediction.
- It must not automatically be interpreted as a calibrated probability that the prediction is correct.
- It is intended for authorized personnel.
- No confidence threshold automatically triggers routing or rejection.
- The agreed threshold governs whether the orchestrator returns a supported concern category or `Other/Unclassified`.

The threshold value and its evaluation basis must follow the PB-11 owners' agreement and PB-18/PB-19 evaluation evidence.

The chatbot must not independently invent or apply a different threshold to make administrative decisions.

### 9.3 Evaluation limitations

PB-19's exploratory evaluation identified classification weaknesses, including difficulty distinguishing Community Concern from Peace and Order Concern and limited Noise Complaint recall.

Those findings are evidence for further evaluation and improvement. They are not production validation and do not justify changing approved dataset labels to improve metrics.

Evaluation must:

- Use approved labels and inclusion decisions.
- Apply consistent preprocessing.
- Prevent duplicate-group leakage across dataset splits.
- Report per-class precision, recall, and F1-score in addition to overall accuracy.
- Compare model results with an appropriate majority-class baseline.
- Review errors involving overlapping categories.
- Include representative Filipino, English, and Taglish examples.
- Evaluate the Other/Unclassified fallback.
- Preserve the original dataset and approved label decisions.

The chatbot must not reject or discard a legitimate citizen report because the classifier is uncertain or model performance is limited.

### 9.4 Unclassified or uncertain messages

When the conversation intent cannot be determined, the chatbot should ask for clarification or use an approved human-assistance path.

When the concern classifier returns `Other/Unclassified`, Laravel must preserve the saved request and follow the personnel-review workflow established by the approved design.

The chatbot must not force a supported category when the agreed fallback conditions are met.

The system must not silently discard a legitimate report because the classifier cannot assign a category.

## 10. Screening, Urgency, and Potential Hazards

These are separate concepts and must not be merged into a single decision.

### 10.1 Routine duplicate and placeholder screening

PB-11 v2.1 defines `screening_flag` as an advisory boolean signal for routine rule-based checks.

It is intended to identify:

- Near-duplicate text from the same respondent within a short time window.
- Empty or placeholder-only submissions.

This signal is separate from the machine-learning concern category.

A true screening flag does not prove that a citizen's concern is false, malicious, or abusive. It must not independently trigger automatic rejection, punishment, or denial of service.

Repeated messages may represent a legitimate follow-up, an ongoing issue, or reports from multiple citizens. Their context must be considered.

### 10.2 Abuse screening

Abuse screening under PB-22 is separate from PB-11 routine duplicate/placeholder screening.

The approved PB-11 v2.1 `/classify` response does not define an abuse-screening field or establish an abuse-detection capability.

The chatbot and orchestrator must not claim that `screening_flag` detects threats, harassment, abusive language, or whether an allegation is legitimate.

Any future abuse-screening capability or API extension must be coordinated with the PB-22 owner and PB-11 owners before implementation.

PB-22 requirements must not be represented as an already implemented PB-11 feature.

### 10.3 Urgency

PB-11 v2.1 defines an advisory `urgency` field with two design values:

- `urgent`
- `non_urgent`

The urgency signal supports the intended escalation workflow. It does not establish that an emergency has been verified or that a particular administrative action has automatically occurred.

Laravel remains responsible for official notifications and workflow behavior.

PB-11 v2.1 proposes that urgent cases be directed to the Kapitan's account regardless of hour. The exact criteria, notification behavior, and operational response remain under PB-35 and the required adviser/Barangay policy confirmation.

The chatbot must not claim that personnel have been notified, an emergency has been verified, responders have been dispatched, or an issue has been resolved unless the corresponding system action or status is confirmed.

### 10.4 Potential hazards

PB-11 v2.1 identifies a provisional `hazard_flag`, but whether it is included in the final `/classify` response and where it is stored remain subject to PB-24 and contract-owner coordination.

PB-20 does not assume that the field is available to the chatbot or define an independent hazard-classification workflow.

Potential hazards must remain distinct from:

- The primary concern category.
- The routine `screening_flag`.
- Abuse-screening requirements.
- The advisory urgency signal.
- Verified incident findings.

An allegation of chemical exposure, dangerous conditions, or a regulatory violation must not be presented as an established fact solely because it appears in a citizen's report.

## 11. Privacy, Accessibility, and Trust

The chatbot and orchestrator must:

- Collect only information necessary for the relevant workflow.
- Explain why requested information is needed.
- Follow approved consent, privacy, access-control, and retention requirements.
- Never disclose another citizen's personal information or report details without authorization.
- Avoid requiring GPS, document uploads, or advanced device features unless the approved workflow genuinely requires them and provides an appropriate alternative.
- Explain when information is unavailable or human review is required.
- Avoid promising outcomes, deadlines, eligibility, or services that have not been confirmed.
- Preserve citizen submissions when AI processing fails.
- Avoid exposing internal model scores, screening logic, implementation errors, or confidential administrative information to unauthorized users.
- Use conversation context only to assist the citizen through the applicable workflow.

The orchestrator's classification request should contain only the text needed for classification. PB-11 does not require citizen names, contact details, account credentials, or other unnecessary personal information in the classification request.

Conversation-state retention and privacy rules must follow the decisions made through PB-24 and the project's applicable privacy requirements.

## 12. System Responsibilities

### 12.1 Chatbot interface

The chatbot interface is responsible for:

- Receiving citizen messages.
- Presenting clear, respectful, understandable responses.
- Maintaining the conversation context required for supported workflows.
- Asking clarifying questions when necessary.
- Guiding citizens to the correct service, reporting, assistance, or follow-up workflow.
- Displaying only information confirmed by Laravel or an approved knowledge source.
- Communicating submission confirmation only after Laravel confirms that a request has been saved.

The chatbot must not independently create official request records, assign reference numbers, update official statuses, or claim that notifications have been sent.

### 12.2 AI orchestrator

The orchestrator supports:

- Conversation-level intent recognition.
- Selection of the appropriate workflow.
- Natural-language understanding and clarification support.
- Concern classification when an actual concern or applicable assistance request is submitted.
- The agreed routine screening signal.
- The agreed advisory urgency signal.
- Structured responses and errors according to PB-11 v2.1.

The orchestrator must not independently:

- Create, store, assign, or update official request records.
- Determine the truth or legitimacy of a citizen's allegation.
- Make final administrative decisions.
- Assign complaints to specific Barangay personnel.
- Change official request statuses.
- Send official notifications directly.
- Reject or punish citizens based solely on model output.

### 12.3 Laravel application

Laravel remains the system of record and is responsible for:

- Authentication and authorization.
- Validation of incoming application requests.
- Saving citizen submissions and assigning reference numbers before classification.
- Calling the orchestrator through the agreed interface.
- Handling successful classification responses and structured errors.
- Preserving requests when classification fails.
- Maintaining the pending-classification and personnel-review workflow.
- Recording official status changes and authorized personnel corrections.
- Managing assignment, routing, and notifications.
- Maintaining audit history.
- Enforcing access to citizen and administrative information.

Laravel must not treat a failed AI request as a successful classification.

## 13. PB-11 v2.1 Interface Alignment

PB-20 and PB-23 must follow the approved PB-11 v2.1 interface design.

### 13.1 Request and response design

| Property | Agreed design |
|---|---|
| Method | `POST` |
| Endpoint | `/classify` |
| Local demo URL | `http://127.0.0.1:5000/classify` |
| Request content type | `application/json` |
| Required request field | `text` |
| Maximum text length | 5,000 characters |
| Successful response fields | `category`, `confidence`, `screening_flag`, `urgency` |
| Error response | Structured JSON error |
| Starting timeout | 5 seconds |
| Local authentication | None while bound to loopback and not publicly exposed |

The base URL, authentication configuration, and timeout must be configurable rather than hard-coded. These values describe the local demo design and are not a general production deployment specification.

### 13.2 Request validation

The `/classify` request requires a nonblank string in the `text` field.

The agreed validation behavior includes:

- Missing text: `MISSING_TEXT`.
- Blank text: `EMPTY_TEXT`.
- Text exceeding 5,000 characters: `INVALID_REQUEST`.

The orchestrator must return a structured error rather than silently accepting invalid input.

### 13.3 Successful response interpretation

The successful response fields are interpreted as follows:

| Field | Meaning | Restriction |
|---|---|---|
| `category` | Suggested orchestrator category or concern-classification fallback | Advisory; not proof of an incident or final administrative decision. |
| `confidence` | Model-reported score from 0.0 to 1.0 | Not automatically a calibrated probability; for authorized personnel. |
| `screening_flag` | Routine duplicate/placeholder screening signal | Not abuse detection or incident-legitimacy verification. |
| `urgency` | Advisory `urgent` or `non_urgent` signal | Not a verified emergency or proof of notification. |

The provisional `hazard_flag` is not assumed to be a confirmed response field. Its inclusion and storage require the applicable PB-24 and PB-11 decisions.

### 13.4 Classification failure handling

PB-11 v2.1 identifies the following classification failure modes:

1. HTTP 503 with `SERVICE_UNAVAILABLE`.
2. Orchestrator unavailable or unreachable, resulting in a connection-level exception.
3. No response within the configured timeout.
4. Invalid or unparseable response.

Laravel must handle all four conditions.

Because the request is saved before classification, a classification failure must not erase the citizen's submission.

The request must remain in the pending-classification workflow. PB-24 owns the final status name and data-model representation. Retry and manual-review mechanics must be implemented through the relevant PB-24/PB-25 decisions.

The chatbot should communicate only the confirmed submission status. It must not imply that classification or administrative review has completed.

### 13.5 Implementation status

PB-11 v2.1 is an approved interface design contract, not proof of an operational integration.

PB-25 is responsible for implementing and testing:

- The Flask `/classify` endpoint.
- The Python orchestrator behavior.
- Laravel-to-Python HTTP integration.
- Request validation and response handling.
- Structured errors and failure handling.
- Integration tests.

PB-20 defines the required workflow behavior and must not claim that these capabilities are already operational.

## 14. Dependencies and Task Coordination

| Task | Relationship to PB-20 |
|---|---|
| PB-11 — API Contract | Approved interface design, category names, confidence semantics, screening and urgency signals, save-first behavior, and error handling. |
| PB-15–PB-17 — Concern Classification | Concern-classifier scope, dataset, and category development supporting the four concern labels. |
| PB-18 — Label Review | Approved concern-label policy, primary-category rules, duplicate handling, and evaluation safeguards. Record-specific clarifications remain governed by the PB-18 review record. |
| PB-19 — Classifier Evaluation | Evaluation findings and further model-performance review. |
| PB-21 — Knowledge Base and Checklist | Verified document-service requirements, procedures, and citizen-facing information. |
| PB-22 — Abuse-Screening Requirements | Separate abuse-screening requirements; does not redefine PB-11's routine `screening_flag`. |
| PB-23 — Chatbot Conversation Design and AI Orchestrator | Must use the ten intents, routing table, workflow boundaries, clarification rules, and language requirements in PB-20. |
| PB-24 — Data Model | Request fields, pending-classification status naming, conversation-state storage, and provisional hazard-field handling. |
| PB-25 — Laravel–AI Orchestrator Implementation | Implements and tests the approved PB-11 interface and associated integration behavior. |
| PB-35 — Urgency and Escalation Policy | Owns urgency criteria, notification recipients, channels, after-hours handling, and escalation decisions. |

Changes to the PB-11 request or response format must be coordinated with its owners and affected implementation owners before integration.

## 15. Remaining Implementation and Policy Dependencies

The workflow requirements and routing decisions in PB-20 are finalized for use by dependent project tasks. The following items are not reasons to reopen the established PB-20 intent model; they are specific work items owned by their respective tasks.

| Item | Owner or coordination | Required next action |
|---|---|---|
| Verified document-service information | PB-21 and authorized Barangay sources | Maintain verified requirements, fees, eligibility, office hours, and procedures. |
| Record-specific PB-18 clarifications | PB-18 owners and authorized Barangay confirmation | Resolve the outstanding record-level questions documented in the PB-18 review activity record, including C0014 and C0055 where still pending. |
| Concern-classifier threshold | PB-11 owners and PB-18/PB-19 coordination | Finalize the value using evaluation evidence and the agreed fallback behavior. |
| Exact request data model | PB-24 | Define fields and relationships without duplicating existing request-type information. |
| Pending-classification status representation | PB-24 | Finalize the status name and associated data-model behavior. |
| Retry and manual-review mechanics | PB-24 and PB-25 | Implement and test the failure-handling workflow. |
| Routine screening implementation details | PB-11 owners and PB-25 | Implement the agreed duplicate/placeholder checks and their configured time window. |
| Abuse-screening implementation or API extension | PB-22, PB-11 owners, and implementation team | Decide separately whether an API extension is needed; do not assume it exists in PB-11 v2.1. |
| Urgency criteria and escalation operations | PB-35, adviser, and authorized Barangay decision-makers | Confirm triggers, recipients, channels, after-hours behavior, and operational response. |
| Provisional `hazard_flag` | PB-24 and PB-11 owners | Decide whether it is returned and stored. |
| Conversation-state retention and privacy | PB-24 and responsible project/privacy reviewers | Define storage, access, and retention behavior. |
| Status-checking interface | PB-24 and PB-25 | Specify and implement the authorized status-query workflow. |
| Language and workflow testing | PB-23 and testing team | Validate the ten intents, routing behavior, and representative language examples. |

No dependent task should interpret an unresolved implementation detail as permission to change the approved PB-20 workflow or claim that an unimplemented feature is operational.

## 16. Acceptance Criteria

PB-20 is finalized as a requirements document when the following requirements are present and consistent:

- [x] Ten conversation intents are documented.
- [x] Each intent has an expected workflow and destination.
- [x] Conversation intent is distinguished from concern classification.
- [x] The three document-service labels and four concern-classifier labels are separated correctly.
- [x] `Other/Unclassified` is distinguished from an unclassified conversation intent.
- [x] Assistance inquiries are distinguished from actual assistance requests.
- [x] Service inquiries, process guidance, requirements clarification, concern reports, reporting-process inquiries, and follow-up inquiries are distinguished.
- [x] The intent-to-workflow routing table is provided for PB-23.
- [x] Filipino, English, Taglish, and informal-language requirements are documented.
- [x] Citizen-facing examples demonstrate respectful clarification and appropriate routing.
- [x] Service guidance depends on verified PB-21 information.
- [x] Concern submission follows Laravel's save-first behavior.
- [x] PB-11 v2.1 confidence semantics and fallback behavior are reflected accurately.
- [x] Routine duplicate/placeholder screening is distinguished from abuse screening.
- [x] Urgency and potential hazards are treated separately from concern categories.
- [x] PB-18's approved primary-category and duplicate-handling policy is incorporated.
- [x] AI responsibilities are separated from Laravel's official system responsibilities.
- [x] Classification failure handling preserves saved citizen submissions.
- [x] Privacy, accessibility, and authorization requirements are documented.
- [x] PB-24, PB-25, and PB-35 dependencies are assigned to their appropriate tasks.
- [x] The document does not claim that the orchestrator or Laravel integration is already implemented or tested.

## 17. Next Steps

1. Use this finalized PB-20 document as the workflow and routing reference for PB-23.
2. Update PB-23's ten-intent routing behavior to match Section 5 exactly.
3. Ensure PB-23's signal definitions match PB-11 v2.1 and the separation of routine screening, abuse screening, urgency, and potential hazards.
4. Continue PB-21 knowledge-base verification and use only approved information in citizen-facing responses.
5. Continue PB-22 work without treating abuse screening as an existing PB-11 API capability.
6. Complete PB-24 data-model decisions for request fields, conversation state, pending classification, and provisional hazard handling.
7. Implement and test the approved interface and failure behavior through PB-25.
8. Complete urgency and escalation policy decisions through PB-35.
9. Preserve the approved PB-18 label policy and resolve any remaining record-specific clarifications through its assigned review process.

**Final document status:** PB-20 workflow requirements and the ten-intent routing model are finalized for dependent project tasks. The document is aligned with the approved PB-11 v2.1 interface design, approved PB-18 label-review policy, and revised PB-21/PB-22 requirements. Remaining work is assigned to the relevant implementation, verification, and policy tasks. This document does not claim that the chatbot, orchestrator, Laravel integration, or outstanding operational policies have already been implemented or activated.