# PB-20 — Service Intent and Workflow Analysis

**Project:** IntRENEt (Internet Barangay System)
**Sprint:** Sprint 3 — October 19–November 1, 2026
**Owner:** Starween
**Status:** Revised requirements document — aligned with approved PB-11 v2.1; pending final team review and Barangay validation
**Related tasks:** PB-11 — Laravel–Chatbot/AI Orchestrator Contract; PB-18 — Model Evaluation and Label Review; PB-19 — Classifier Evaluation; PB-21 — Service Knowledge Base and Checklist; PB-22 — Abuse-Screening Requirements; PB-23 — Chatbot Conversation Design and AI Orchestrator; PB-24 — Data Model; PB-25 — Laravel–AI Orchestrator Implementation; PB-35 — Urgency and Escalation Policy

## 1. Purpose

PB-20 defines how the IntRENEt chatbot should understand what Filipino citizens need, identify the appropriate service or concern workflow, ask clarifying questions, and explain the next steps in language that ordinary citizens can understand.

Citizens may communicate using Filipino, English, Taglish, informal expressions, regional vocabulary, abbreviations, spelling variations, or incomplete sentences. They may also be unfamiliar with official document names, administrative procedures, online forms, or the distinction between a service inquiry and a formal complaint.

The objective is not simply to translate an English chatbot into Filipino. It is to create an accessible, respectful, and reliable service experience that helps citizens understand and navigate Barangay services.

This document establishes:

- Citizen conversation-intent categories and their intended workflows.
- The distinction between conversation intent and concern classification.
- Service inquiry and document-transaction guidance.
- Community concern and report-submission workflows.
- Assistance inquiries, reporting questions, and follow-up behavior.
- Clarification, uncertainty, and human-review requirements.
- Language, privacy, accessibility, and trust requirements.
- Responsibilities of the chatbot/AI orchestrator and Laravel application.
- Dependencies on the approved PB-11 v2.1 interface contract.

PB-20 serves as a requirements reference for PB-21 and PB-23. It does not independently define the API implementation, database schema, official Barangay policies, or final administrative procedures.

### 1.1 Document status and authority

PB-11 v2.1 was approved as an interface design contract on October 31, 2026, by its joint owners, Marc Laurence I. Pabalan and Henry Jr. Bue.

This revision aligns PB-20 with that approved contract.

The approval of PB-11 establishes the agreed interface design; it does not mean that the orchestrator, API endpoint, Laravel integration, or chatbot workflows have already been implemented or tested. PB-25 tracks the implementation work for Sprint 4.

Requirements in this document are distinguished as follows:

- **Agreed interface behavior:** Requirements explicitly established by PB-11 v2.1.
- **Workflow requirements:** Expected chatbot behavior and boundaries documented by PB-20.
- **Pending decisions:** Items that require team, adviser, Barangay, or PB-24 confirmation before implementation or operational use.

No unresolved requirement should be represented as an approved Barangay policy or an existing system capability.

## 2. Filipino-Citizen-Centered Design Principles

The chatbot must follow these principles throughout every conversation.

### 2.1 Understand the citizen's need, not just their wording

Citizens should not need to know an official service name to receive help.

For example, a citizen asking, “Paano po kumuha ng papel na nagpapatunay na dito ako nakatira?” may be asking about a Certificate of Residency.

The chatbot should use the citizen's wording and conversation context to identify the likely service. It should confirm its interpretation when multiple services or meanings are plausible.

### 2.2 Communicate naturally and respectfully

The chatbot should use clear, polite, and conversational Filipino or English, depending on the citizen's preference and the system's evaluated language capabilities.

Responses should avoid unnecessarily formal wording, unexplained technical terms, or language that makes citizens feel that their question is inappropriate.

### 2.3 Help citizens who are unfamiliar with digital processes

The chatbot should explain what to do next, what information is needed, and why it is being requested.

It should not assume that citizens understand online reporting, document uploads, reference numbers, or administrative terminology.

### 2.4 Ask rather than assume

If a citizen's message could refer to multiple services or concerns, the chatbot should ask a simple clarifying question instead of confidently selecting the wrong workflow.

It should avoid repeatedly asking for information the citizen has already provided.

### 2.5 Provide only verified information

Requirements, fees, eligibility, office hours, processing times, and service procedures must come from an approved knowledge base or another authorized source.

If information is unavailable, incomplete, outdated, or unverified, the chatbot should explain the limitation and provide an approved way to obtain confirmation.

It must not invent requirements, fees, deadlines, eligibility conditions, or service availability.

### 2.6 Preserve citizen control and dignity

The chatbot should not pressure citizens to disclose unnecessary personal information, make unsupported assumptions about their situation, or imply that a report is invalid because it is incomplete, informal, or written with spelling mistakes.

### 2.7 Keep official decisions under human and system control

AI-generated intent predictions, category suggestions, confidence scores, screening signals, and urgency indicators are advisory.

Laravel remains the system of record for authentication, authorization, validation, persistence, official status management, assignment, routing, notifications, audit history, and authorized personnel corrections.

The chatbot must not independently determine the truth of allegations, make final administrative decisions, impose sanctions, or claim that an issue has been resolved without confirmation.

## 3. Conversation Intent and Concern Classification

The system must distinguish two related but separate concepts:

**Conversation intent** identifies what the citizen wants to accomplish during the conversation. It determines which chatbot workflow should be followed.

**Concern category** identifies the type of community issue when a citizen is actually submitting a concern or complaint. It is the output of the concern-classification step defined by PB-11.

The chatbot must identify the applicable conversation workflow before invoking concern classification. A citizen asking about a Barangay Clearance, for example, must not be sent through the complaint classifier merely because the conversation mentions a Barangay service.

### 3.1 Proposed conversation-intent categories

| Conversation intent | Meaning | Example from a citizen | Expected workflow |
|---|---|---|---|
| Service or document inquiry | The citizen wants to know about a Barangay service or document. | “Ano po requirements para sa barangay clearance?” | Retrieve verified service information or a checklist from PB-21. |
| Service-process guidance | The citizen wants to know how to complete a transaction. | “Saan po ako magsisimula kung kukuha ako ng residency?” | Explain the approved process and clarify details if needed. |
| Service eligibility or requirements clarification | The citizen asks whether a requirement or condition applies to them. | “Kailangan po ba ng valid ID?” | Answer using verified service rules only. |
| Community concern or report | The citizen describes an issue that may need Barangay attention or wants to submit a report. | “Hindi po nakokolekta ang basura sa amin simula pa noong isang araw.” | Follow the concern-reporting workflow. |
| Assistance inquiry | The citizen wants information about available assistance. | “Saan po puwedeng magtanong tungkol sa PWD assistance?” | Provide verified program information or an approved referral. |
| Assistance request | The citizen appears to be actively requesting help rather than merely asking about a program. | “Wala po kaming makain ngayon. May matatakbuhan po ba kami?” | Respond empathetically, clarify the requested help, and provide verified options or approved referrals. |
| Reporting-process inquiry | The citizen asks how to report or complain about an issue. | “Paano po magreklamo tungkol sa maingay na kapitbahay?” | Explain the reporting process and clarify whether the citizen also wants to submit a report. |
| Follow-up or status inquiry | The citizen asks about a previously submitted request or report. | “May update na po ba sa report ko?” | Use the approved status-checking process and authentication rules. |
| Ambiguous or mixed intent | The message is unclear or contains multiple possible requests. | “May problema po kami sa kalsada. Puwede po ba magpatulong?” | Ask a focused question to determine the citizen's need. |
| Other or unclassified intent | The conversation cannot be reliably assigned to an available intent. | A message that does not match a supported workflow. | Clarify, offer an approved alternative, or refer for human assistance. |

These are conversation-level workflow categories. They must not be treated as additional concern-classifier labels or as official database enum values unless separately agreed in PB-24.

### 3.2 Concern categories defined by PB-11 v2.1

PB-11 v2.1 locks the following eight category names for the Sprint 3 and defense scope:

1. Barangay Clearance/Certification
2. Certificate of Residency
3. Certificate of Indigency
4. Community Concern
5. Noise Complaint
6. Peace and Order Concern
7. Barangay Assistance
8. Other/Unclassified

These names belong to the overall orchestrator category and workflow agreement. They do not all belong to the same concern-classification task.

The agreed distinction is:

- The three document-service labels — Barangay Clearance/Certification, Certificate of Residency, and Certificate of Indigency — are handled by the orchestrator's intent-recognition and document-service workflow.
- The four concern labels — Community Concern, Noise Complaint, Peace and Order Concern, and Barangay Assistance — are the labels covered by the PB-15 to PB-19 concern-classification dataset and evaluation.
- Other/Unclassified is the fallback category when the agreed classifier conditions do not support a reliable concern label.

The chatbot must not send document-service inquiries through the four-label concern classifier.

### 3.3 Category definitions and label limitations

The category names are locked, but the definitions and boundaries of Community Concern, Noise Complaint, Peace and Order Concern, and Barangay Assistance remain subject to PB-18 label review.

The chatbot must not assume that the names alone resolve every classification ambiguity.

For example:

- A citizen asking how to report loud music is making a reporting-process inquiry.
- A citizen actually describing a recurring loud-music issue may be submitting a Noise Complaint.
- A citizen asking for information about assistance is making an assistance inquiry.
- A citizen actively requesting an available assistance service may need the Barangay Assistance workflow.

The system must use the citizen's actual conversational purpose and the approved label definitions rather than relying on isolated keywords.

## 4. Filipino-Citizen-Friendly Conversation Examples

The following examples demonstrate expected chatbot behavior. They are illustrative conversation requirements and do not establish final Barangay policy.

### 4.1 Citizen does not know the official document name

**Citizen:** “Paano po kumuha ng papel na nagpapatunay na taga-rito ako?”

**Chatbot:** “Maaaring Certificate of Residency po ang kailangan ninyo. Tama po ba, o may iba kayong dokumentong kailangan?”

**Expected behavior:** Recognize the likely service from the citizen's description and confirm if needed. Do not require the citizen to know the formal document name.

### 4.2 Citizen asks for requirements

**Citizen:** “Ano po kailangan para makakuha ng barangay clearance?”

**Chatbot:** “Tutulungan ko po kayo. Narito po ang mga requirements na nakalista sa aming opisyal na impormasyon: [verified requirements].”

**Expected behavior:** Retrieve the approved checklist from PB-21. If requirements have not been verified, explain that confirmation is needed instead of inventing a list.

### 4.3 Citizen asks how to report a concern

**Citizen:** “Paano po mag-report ng tambak na basura sa kanto namin?”

**Chatbot:** “Maaari ko po kayong gabayan sa pag-report nito. Gusto po ba ninyong malaman muna ang proseso, o nais na rin po ninyong isumite ang concern?”

**Expected behavior:** Distinguish a request for instructions from an actual submission while making the next step easy.

### 4.4 Citizen is already reporting a concern

**Citizen:** “Ang tagal na pong hindi nakokolekta ang basura sa street namin.”

**Chatbot:** “Nauunawaan ko po. Para maitala natin nang tama ang concern, saang lugar po ito nangyayari?”

**Expected behavior:** Treat the message as a potential report, acknowledge the concern, and request only the details required by the approved reporting workflow. Do not ask for a location if the citizen has already provided it.

### 4.5 Citizen uses Taglish

**Citizen:** “Paano po mag-apply ng barangay clearance? Need ko lang po for work.”

**Chatbot:** “Sige po. Matutulungan ko kayong alamin ang requirements para sa barangay clearance na kailangan ninyo sa trabaho.”

**Expected behavior:** Understand the mixed-language request without forcing the citizen to restate it in one language.

### 4.6 Citizen is unsure what kind of help they need

**Citizen:** “May problema po kami sa kapitbahay namin. Ano po kaya puwedeng gawin?”

**Chatbot:** “Tutulungan po namin kayong malaman ang tamang susunod na hakbang. Maaari po bang ikuwento nang kaunti kung ano ang nangyari?”

**Expected behavior:** Ask a neutral clarifying question without assuming that a crime, violation, or particular type of complaint has occurred.

### 4.7 Citizen asks about assistance

**Citizen:** “May tulong po ba para sa senior citizen?”

**Chatbot:** “Maaari ko po kayong tulungang hanapin ang available na impormasyon tungkol sa assistance para sa senior citizens. Anong uri po ng tulong ang nais ninyong malaman?”

**Expected behavior:** Clarify the type of assistance and use verified program information. Do not promise eligibility or approval.

### 4.8 Citizen asks for an update

**Citizen:** “May update na po ba sa complaint ko?”

**Chatbot:** “Matutulungan ko po kayong alamin ang status nito. Gamitin po natin ang opisyal na proseso ng pag-check ng report upang matiyak na sa tamang record tayo tumitingin.”

**Expected behavior:** Follow authentication and privacy requirements before displaying any record. Do not reveal another citizen's information.

## 5. Intent Routing and Workflow Requirements

### 5.1 Service and document inquiries

For document-service inquiries, the chatbot should:

1. Identify the likely document or service even if the citizen describes it informally.
2. Confirm the intended service if more than one interpretation is plausible.
3. Retrieve the approved information from the PB-21 knowledge base.
4. Explain the requirements and steps in accessible language.
5. Ask for additional details only when necessary to provide the correct guidance.
6. Explain how the citizen can obtain confirmation when information is unavailable or unverified.
7. Guide the citizen to the appropriate transaction workflow when they decide to proceed.

The initial document-service scope follows the three PB-11 labels:

- Barangay Clearance/Certification
- Certificate of Residency
- Certificate of Indigency

The actual requirements, fees, eligibility, office hours, processing times, application procedures, and supporting documents must come from verified Barangay sources maintained through PB-21.

The chatbot should not invoke the four-label concern classifier for these inquiries or transactions.

### 5.2 Community concerns and reports

For community concerns and reports, the chatbot should:

1. Recognize whether the citizen is asking about reporting or actually submitting a concern.
2. Acknowledge the concern without deciding whether an allegation is true.
3. Collect the information required by the approved reporting workflow.
4. Submit the citizen's concern through the Laravel application.
5. Follow the save-first behavior defined by PB-11 v2.1.
6. Request concern classification after Laravel has saved the request and assigned its reference number.
7. Present classification, screening, or urgency information only according to the agreed interface and authorization rules.
8. Communicate only submission and status information confirmed by Laravel.

#### 5.2.1 Save-first submission behavior

PB-11 v2.1 establishes that Laravel must save the citizen's request and assign its reference number before requesting AI classification.

The classification operation is a follow-up step applied to an already-saved record. It must not be a precondition for saving a citizen's report.

The intended sequence is:

1. The citizen provides the concern through the chatbot.
2. The chatbot collects the information required by the approved submission workflow.
3. Laravel validates the application request.
4. Laravel saves the request and assigns its reference number.
5. Laravel returns the available confirmation information to the chatbot.
6. Laravel sends the concern text to the orchestrator through `POST /classify`.
7. The orchestrator returns the agreed classification response or a structured error.
8. Laravel handles the result and updates the record according to the approved workflow.
9. Authorized personnel retain responsibility for corrections, routing, and subsequent administrative decisions.

The chatbot must not tell a citizen that a concern has been successfully recorded unless Laravel confirms that it was saved.

If saving fails, the chatbot must not invent a reference number or claim that the report was submitted.

If classification fails after saving, the request must remain preserved. PB-11 v2.1 specifies a pending-classification status, with the exact status name and associated mechanics to be finalized through PB-24.

### 5.3 Assistance inquiries and requests

The chatbot should distinguish among:

- Asking whether an assistance program exists.
- Asking how to apply for assistance.
- Asking whether a requirement or eligibility condition applies.
- Actively requesting help.

It should respond empathetically, explain verified options, and refer the citizen through an approved channel when needed.

The chatbot must not promise financial assistance, eligibility, approval, availability, or a specific outcome without confirmation from an authorized source.

For urgent or vulnerable situations, the chatbot should follow approved referral and escalation procedures rather than improvising promises or unsupported advice.

### 5.4 Reporting-process inquiries

A reporting-process inquiry is not automatically a submitted complaint.

When a citizen asks how to report an issue, the chatbot should explain the approved process and, where appropriate, ask whether the citizen would also like to submit the concern.

The system must not create a formal report solely because a citizen asks about the reporting procedure.

### 5.5 Follow-up and status inquiries

When citizens ask about an existing report or service request, the chatbot should use the approved status-checking workflow.

It should:

- Follow authentication and authorization requirements.
- Retrieve only the record the citizen is permitted to access.
- Avoid disclosing another citizen's information.
- Distinguish between a recorded submission, an ongoing process, and a confirmed resolution.
- Avoid claiming that an issue has been resolved unless Laravel or an authorized personnel action confirms that status.

The exact status-query endpoint and chatbot-to-Laravel request format are outside the scope of the PB-11 `/classify` interface and must be coordinated through PB-24 and PB-25.

### 5.6 Ambiguous or multiple intents

When a message could fit several workflows, the chatbot should:

- Acknowledge the likely meaning.
- Ask one focused clarifying question.
- Avoid repeatedly asking for information already provided.
- Separate multiple requests only when the system supports that behavior.
- Preserve report information already collected if clarification is needed.
- Use the approved fallback if the intent remains uncertain.

The chatbot should not force citizens through an unnecessarily complicated menu when a simple conversational question can resolve the ambiguity.

If the citizen's message contains both a service inquiry and a community concern, the chatbot should identify the separate needs and guide the citizen through the appropriate supported workflows. It must not silently combine unrelated requests into one record.

## 6. Filipino, English, Taglish, and Informal Language

The chatbot should support natural citizen communication rather than relying exclusively on formal written Filipino or English.

Requirements:

- Understand common Filipino and English expressions, including Taglish within the evaluated scope.
- Handle common spelling mistakes, informal phrasing, abbreviations, and incomplete sentences where supported by testing.
- Respond in a language the citizen appears comfortable using, where feasible.
- Use respectful, plain language and explain official terms.
- Avoid interpreting informal language, grammar, or spelling as evidence of spam or an invalid report.
- Ask for clarification when a word or expression could change the meaning of the request.
- Evaluate examples written in different language styles before relying on the model for production routing.
- Add support for other Philippine languages only after confirming project scope and evaluating performance.

Language support must be assessed through representative test examples, not assumed from the model's ability to generate a response in that language.

### 6.1 Language evaluation considerations

Testing should include:

- Formal Filipino.
- Conversational Filipino.
- English.
- Taglish.
- Common spelling variations and typographical errors.
- Informal expressions and abbreviations.
- Short and incomplete messages.
- Messages with multiple possible interpretations.
- Messages containing local or context-dependent vocabulary.

Evaluation should measure whether the chatbot identifies the correct intent and follows the appropriate workflow, not merely whether its response sounds fluent.

## 7. Uncertainty, Classification, and Human Review

### 7.1 Intent recognition and concern classification are separate steps

The orchestrator should identify the citizen's broad conversational intent before selecting the applicable workflow.

The concern classifier may then suggest a category when the conversation involves an actual community concern or report.

Recognizing that a citizen is submitting a report does not guarantee that the correct concern category is known.

Likewise, a correct concern category does not establish that the citizen's allegation is true.

### 7.2 PB-11 confidence interpretation

PB-11 v2.1 establishes the following confidence-score interpretation:

- The reported score ranges from 0.0 to 1.0.
- The score is the model-reported confidence for its prediction.
- It must not automatically be interpreted as a calibrated probability that the prediction is correct.
- Confidence is displayed to authorized personnel for reference.
- No confidence threshold automatically triggers routing or rejection.
- The agreed threshold in PB-11 Section 6 governs only whether the orchestrator returns a supported concern category or `Other/Unclassified`.

The threshold value remains open and must be determined using the PB-18/PB-19 evaluation results and team review.

The chatbot must not independently invent or apply a different confidence threshold to make administrative decisions.

### 7.3 PB-19 evaluation considerations

Marc's reported exploratory evaluation achieved 73.3% accuracy on 45 candidate rows that had not yet received final approval. The evaluation also identified difficulty distinguishing Community Concern from Peace and Order Concern and reported 30% recall for Noise Complaint.

These results are exploratory findings, not production validation or evidence that the classifier is ready for operational use.

They identify areas requiring further review:

- Clearer concern-category definitions.
- Better distinction between overlapping concern categories.
- Further evaluation of Noise Complaint recall.
- Representative Filipino, English, and Taglish examples.
- Testing of ambiguous and incomplete citizen messages.
- Review of the unclassified fallback conditions and threshold.

The chatbot must not reject or discard a legitimate citizen report because exploratory model performance is limited or a category prediction is uncertain.

### 7.4 Unclassified or uncertain messages

When the citizen's intent cannot be determined, the chatbot should ask for clarification or use an approved human-assistance path.

When the concern classifier returns `Other/Unclassified`, Laravel should flag the saved request for personnel review as defined by PB-11.

The chatbot should not force a supported concern category when the classifier's agreed fallback conditions are met.

If a message contains a potentially urgent concern, the approved urgent-case procedure should take precedence over unnecessary clarification.

The system must not silently discard a legitimate report because the classifier cannot assign a category.

## 8. Screening, Urgency, and Escalation

### 8.1 Routine duplicate and spam screening

PB-11 v2.1 defines `screening_flag` as an advisory boolean signal for routine rule-based checks.

It is intended to identify:

- Near-duplicate text from the same respondent within a short time window.
- Empty or placeholder-only submissions.

This signal is not produced by the machine-learning concern classifier and is not an abuse-screening or legitimacy-verification result.

A true screening flag must not be presented as proof that a citizen's concern is false, malicious, or abusive. It must not independently trigger automatic rejection, punishment, or denial of service.

Repeated messages may represent a legitimate follow-up, an ongoing community issue, or reports from multiple citizens. Their context must be considered.

### 8.2 Abuse screening

Routine duplicate/spam screening under PB-11 is separate from the abuse-screening requirements documented in PB-22.

PB-11 v2.1 does not define an abuse-screening field or an abuse-detection capability in the `/classify` response.

The chatbot and orchestrator must not claim that `screening_flag` detects threats, harassment, abusive language, or whether a citizen's allegation is legitimate.

Any future abuse-screening capability or API extension requires a separate team decision and coordination with Marc and Henry. Until approved, PB-22's proposed abuse-screening behavior must not be represented as an implemented PB-11 feature.

### 8.3 Potentially urgent concerns

PB-11 v2.1 defines an advisory `urgency` field with two design values:

- `urgent`
- `non_urgent`

The urgency signal is intended to support the approved escalation workflow. It does not establish that an emergency has been verified or that a particular administrative action must automatically occur.

PB-11 specifies that the orchestrator may return an urgency signal, while Laravel remains responsible for notifications and official workflow behavior.

The following remain open under PB-35 and adviser review:

- Urgency trigger criteria.
- Notification recipients and authorization.
- Notification channels.
- After-hours handling and fallback procedures.
- Appropriate citizen-facing messages.
- The operational response expected from notified personnel.

The proposed behavior of notifying the Kapitan's account for urgent cases regardless of hour must not be treated as a fully approved operational policy until PB-35 and the adviser review confirm the details.

The chatbot must not claim that personnel have been notified, an emergency has been verified, responders have been dispatched, or an issue has been resolved unless the relevant system action or status is confirmed.

### 8.4 Hazard-related signals

PB-11 v2.1 mentions a provisional `hazard_flag`, but whether it is returned by `/classify` and where it is stored remain open under PB-24.

PB-20 therefore does not define a separate hazard-classification workflow or assume that the field is available to the chatbot.

Any hazard-related behavior must follow the approved contract, data-model decisions, and escalation policy.

## 9. Privacy, Accessibility, and Trust

The chatbot should:

- Collect only information necessary for the relevant service or reporting workflow.
- Explain why requested information is needed.
- Follow approved consent, privacy, access-control, and retention requirements.
- Never disclose another citizen's personal information or report details without authorization.
- Avoid requiring GPS, document uploads, or advanced device features unless the approved workflow genuinely requires them and offers an appropriate alternative.
- Use clear explanations when information is unavailable or human review is needed.
- Avoid promising outcomes, deadlines, eligibility, or services that have not been confirmed.
- Preserve citizen submissions when AI processing fails.
- Avoid exposing internal model scores, screening logic, implementation errors, or confidential administrative information to unauthorized users.
- Use conversation context only for the purpose of assisting the citizen through the applicable workflow.

The orchestrator's classification request should contain only the text needed for classification. PB-11 specifies that citizen names, contact details, account credentials, and other personal information are not required by the classification service.

Conversation-state retention and privacy rules remain open and must be coordinated with the relevant data-model and privacy decisions.

These requirements must be aligned with the project's privacy policy and applicable Barangay procedures.

## 10. System Responsibilities and PB-11 v2.1 Dependency

### 10.1 Chatbot interface

The chatbot interface is responsible for:

- Receiving citizen messages.
- Presenting clear, respectful, and understandable responses.
- Maintaining conversation context needed for supported workflows.
- Asking clarifying questions when necessary.
- Guiding citizens to the appropriate service, reporting, assistance, or follow-up workflow.
- Displaying only information confirmed by the backend or approved knowledge base.
- Communicating submission confirmation only after Laravel confirms that a request has been saved.

The chatbot must not independently create official request records, assign reference numbers, update official statuses, or claim that notifications have been sent.

### 10.2 AI orchestrator

The orchestrator supports:

- Conversation-level intent recognition.
- Selection of the appropriate workflow.
- Natural-language understanding and clarification support.
- Concern classification when the citizen is submitting a community concern.
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

### 10.3 Laravel application

Laravel remains the system of record and is responsible for:

- Authentication and authorization.
- Validation of incoming application requests.
- Saving citizen submissions and assigning reference numbers before classification.
- Calling the orchestrator through the agreed interface.
- Handling successful classification responses and structured errors.
- Preserving requests when classification fails.
- Maintaining the official pending-classification and review workflow.
- Recording official status changes and authorized personnel corrections.
- Managing assignment, routing, and notifications.
- Maintaining audit history.
- Enforcing access to citizen and administrative information.

Laravel must not treat a failed AI request as a successful classification.

### 10.4 PB-11 v2.1 interface requirements

PB-20 must follow the approved PB-11 v2.1 contract.

The agreed local demo interface includes:

| Property | Agreed design |
|---|---|
| Method | `POST` |
| Endpoint | `/classify` |
| Local base URL | `http://127.0.0.1:5000/classify` |
| Request content type | `application/json` |
| Request field | `text` |
| Maximum text length | 5,000 characters |
| Successful response | `category`, `confidence`, `screening_flag`, `urgency` |
| Error response | Structured JSON error |
| Starting timeout | 5 seconds |
| Local authentication | None while bound to `127.0.0.1` and not publicly exposed |

The base URL, authentication configuration, and timeout must be configurable rather than hard-coded. These values apply to the local demo design and are not a general production deployment specification.

The successful response fields are subject to the definitions in PB-11 Section 5 and Section 5a. The `hazard_flag` field remains provisional and is not assumed to be part of the confirmed response.

### 10.5 Classification failures and saved submissions

PB-11 v2.1 establishes four classification failure modes:

1. The orchestrator returns HTTP 503 with `SERVICE_UNAVAILABLE`.
2. The orchestrator is down or unreachable, resulting in a connection-level exception.
3. The orchestrator does not answer within the configured timeout.
4. The orchestrator returns an invalid or unparseable response.

All four require Laravel-side failure handling.

Because Laravel saves the request first, classification failure must not erase the citizen's submission.

The saved request must be placed in the pending-classification workflow specified by PB-11. The exact status name, retry mechanics, and manual-review procedures remain subject to PB-24.

The chatbot should communicate only the confirmed submission status and should not imply that classification or administrative review has completed.

### 10.6 Implementation status

PB-11 v2.1 explicitly records that the interface is approved as a design contract but is not yet implemented or tested.

The following implementation work is tracked under PB-25:

- The Flask `/classify` endpoint.
- The Python orchestrator implementation.
- The Laravel-to-Python HTTP integration.
- The agreed request and response handling.
- Integration testing and failure handling.

PB-20 defines workflow requirements and must not claim that these integration capabilities are already operational.

## 11. Dependencies and Coordination

| Related task | PB-20 dependency or coordination |
|---|---|
| PB-11 — API Contract | Defines the approved orchestrator interface, category names, confidence semantics, screening and urgency signals, save-first behavior, and error handling. |
| PB-18 — Label Review | Reviews concern-category definitions, label boundaries, and evaluation considerations. |
| PB-19 — Classifier Evaluation | Provides exploratory evaluation findings and evidence for further model review. |
| PB-21 — Knowledge Base and Checklist | Supplies verified document-service requirements, procedures, and citizen-facing service information. |
| PB-22 — Abuse-Screening Requirements | Defines proposed abuse-screening requirements separately from PB-11 routine duplicate/spam screening. |
| PB-23 — Chatbot Conversation Design and AI Orchestrator | Uses PB-20's conversation intents, workflow boundaries, clarification rules, and language requirements. |
| PB-24 — Data Model | Resolves request fields, pending-classification status naming, conversation-state storage, and provisional hazard-field handling. |
| PB-25 — Laravel–AI Orchestrator Implementation | Implements the approved PB-11 interface and associated integration behavior. |
| PB-35 — Urgency and Escalation Policy | Confirms urgency criteria, notification recipients, channels, after-hours handling, and adviser-dependent escalation decisions. |

Changes to the agreed API request or response format must be coordinated with the PB-11 owners and affected implementation owners before integration.

## 12. Open Decisions and Items Requiring Confirmation

The following items must remain visible until the appropriate owner confirms them.

| Decision or item | Responsible coordination | Current status |
|---|---|---|
| Initial service and document scope | Team and Barangay | PB-11 defines three document-service labels; actual supported procedures require verification. |
| Official service requirements, fees, eligibility, and processing information | PB-21 owner and authorized Barangay personnel | Requires verified sources. |
| Supported languages for the initial release | Team and PB-23 | Evaluation scope must be confirmed. |
| Definitions and boundaries of the four concern labels | PB-18, Marc, and Henry | Pending label review. |
| Unclassified confidence threshold and fallback conditions | PB-18/PB-19 owners and PB-11 owners | Direction agreed; threshold value and conditions remain open. |
| Exact chatbot-to-Laravel submission request | PB-24 and PB-25 owners | Not defined by the PB-11 `/classify` contract. |
| Exact pending-classification status name | PB-24 owner | Pending confirmation. |
| Retry and manual-review mechanics | PB-24 and PB-25 owners | Pending confirmation. |
| Routine duplicate-screening time window and implementation details | PB-11 owners and implementation team | PB-11 defines the intended signal; operational details require implementation agreement. |
| Abuse-screening capability or API extension | Marc, Henry, and PB-22 owner | Not included in PB-11 v2.1; requires a separate decision. |
| Urgency criteria and notification behavior | PB-35 owner, adviser, and Barangay | Pending approval. |
| Whether `hazard_flag` is returned and stored | PB-24 and PB-11 owners | Open. |
| Conversation-state retention and privacy requirements | PB-24 and responsible project/privacy reviewers | Open. |
| Status-checking interface and authorization workflow | PB-24 and PB-25 owners | Requires separate specification. |

Unresolved decisions must not be treated as approved policies, API capabilities, or implemented behavior.

## 13. Acceptance Criteria

PB-20 can be considered complete as a requirements document when:

- [ ] Conversation intents and their expected workflows are documented.
- [ ] Conversation intent is clearly distinguished from concern classification.
- [ ] The three document-service labels and four concern-classifier labels are correctly separated according to PB-11 v2.1.
- [ ] `Other/Unclassified` is identified as a concern-classification fallback and not confused with an unclassified conversation intent.
- [ ] Service inquiries, process questions, concern reports, assistance requests, reporting-process inquiries, and follow-up inquiries are distinguished.
- [ ] Filipino, English, Taglish, and informal-language requirements are documented.
- [ ] Citizen-facing examples demonstrate clarification and respectful communication.
- [ ] Service guidance depends on verified PB-21 information.
- [ ] The concern-submission workflow follows Laravel's save-first behavior.
- [ ] The approved PB-11 confidence interpretation and unclassified behavior are reflected accurately.
- [ ] Routine duplicate/spam screening is distinguished from abuse screening.
- [ ] Urgency and escalation requirements are identified as advisory and subject to PB-35 approval.
- [ ] AI responsibilities are separated from Laravel's official system responsibilities.
- [ ] Classification failure handling preserves saved citizen submissions.
- [ ] Privacy, accessibility, and authorization requirements are documented.
- [ ] PB-11 v2.1 dependencies and unresolved PB-24, PB-25, and PB-35 decisions are listed.
- [ ] The document does not claim that the orchestrator or Laravel integration is implemented or tested.
- [ ] The team has reviewed the requirements and relevant Barangay-dependent procedures have been validated by authorized personnel.

## 14. Next Steps

1. Share the revised PB-20 with Marc and Henry for alignment with the approved PB-11 v2.1 contract.
2. Coordinate with Henry so PB-23 uses the documented conversation intents and workflow boundaries.
3. Coordinate with Marc and Henry regarding concern-category definitions and PB-18/PB-19 evaluation findings.
4. Ensure PB-21 provides verified information for the supported document-service workflows.
5. Coordinate with the PB-22 owner regarding the separation between routine duplicate/spam screening and proposed abuse screening.
6. Coordinate with the PB-24 owner regarding request fields, conversation state, and pending-classification behavior.
7. Confirm urgency and escalation policy decisions through PB-35 and the adviser.
8. Validate service procedures, citizen-facing information, and policy-dependent requirements with the appropriate Barangay personnel.
9. Record any approved changes, unresolved decisions, and deferred requirements before implementation.

---

**Current document status:** Revised requirements document aligned with approved PB-11 v2.1. Pending final team review and validation of Barangay-dependent procedures. This document describes intended workflow behavior and does not claim that the chatbot, orchestrator, or Laravel integration has been implemented or tested.