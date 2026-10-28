# PB-20 — Service Intent and Workflow Analysis

**Project:** IntRENEt (Internet Barangay System)
**Sprint:** Sprint 3 — October 19–November 1, 2026
**Owner:** Starween
**Status:** Draft for review
**Related tasks:** PB-11 — API Contract; PB-21 — Service Knowledge Base and Checklist; PB-22 — Abuse-Screening Requirements; PB-23 — Chatbot Conversation Design and AI Orchestrator; PB-24 — Data Model

## 1. Purpose

PB-20 defines how the IntRENEt chatbot should understand what Filipino citizens need, identify the appropriate service or concern workflow, ask clarifying questions, and explain the next steps in language that ordinary citizens can understand.

The chatbot should be designed around how people actually communicate with their Barangay. Citizens may use Filipino, English, Taglish, informal expressions, regional vocabulary, abbreviations, spelling variations, or incomplete sentences. They may also be unfamiliar with official document names, administrative procedures, online forms, or the distinction between a service inquiry and a formal complaint.

The objective is not simply to translate an English chatbot into Filipino. It is to create an accessible, respectful, and reliable service experience that helps citizens understand and navigate Barangay services.

This analysis provides the proposed intent categories, conversation rules, service-routing behavior, and workflow boundaries needed to support PB-21 and PB-23.

**Status note:** All proposed categories, requirements, escalation rules, and integration assumptions must be reviewed by the project team and validated with the appropriate Barangay personnel before being treated as approved behavior.

## 2. Filipino-Citizen-Centered Design Principles

The chatbot should follow these principles throughout every conversation.

### 2.1 Understand the citizen's need, not just their wording

Citizens should not need to know an official service name to receive help. For example, a citizen asking “Paano po kumuha ng papel na nagpapatunay na dito ako nakatira?” may be asking about a Certificate of Residency.

The chatbot should use context to identify the likely service and confirm its interpretation when ambiguity remains.

### 2.2 Communicate naturally and respectfully

The chatbot should use clear, polite, and conversational Filipino or English, depending on the citizen's preference and the system's supported capabilities.

Responses should avoid unnecessarily formal wording, unexplained technical terms, or language that makes citizens feel that their question is inappropriate.

### 2.3 Help citizens who are unfamiliar with digital processes

The chatbot should explain what to do next, what information is needed, and why it is being requested. It should not assume that citizens understand online reporting, document uploads, reference numbers, or administrative terminology.

### 2.4 Ask rather than assume

If a citizen's message could refer to multiple services or concerns, the chatbot should ask a simple clarifying question instead of confidently selecting the wrong workflow.

### 2.5 Provide only verified information

Requirements, fees, eligibility, office hours, processing times, and service procedures must come from an approved knowledge base or other authorized source. If information is unavailable, the chatbot should say so and provide an approved way to inquire further.

### 2.6 Preserve citizen control and dignity

The chatbot should not pressure citizens to disclose unnecessary personal information, make unsupported assumptions about their situation, or imply that a report is invalid because it is incomplete, informal, or written with spelling mistakes.

### 2.7 Keep official decisions under human and system control

AI-generated categories, confidence scores, screening signals, and urgency indicators are advisory. Official records, status changes, routing, notifications, and administrative decisions must follow the approved system workflow.

## 3. Proposed Service-Intent Categories

The following categories describe the citizen's **conversation intent**. They are separate from the final labels used to classify community concerns.

| Intent | Meaning | Example from a citizen | Expected response |
|---|---|---|---|
| Service or document inquiry | The citizen wants to know about a Barangay service or document. | “Ano po requirements para sa barangay clearance?” | Provide verified information or a checklist. |
| Service-process guidance | The citizen wants to know how to complete a transaction. | “Saan po ako magsisimula kung kukuha ako ng residency?” | Explain the approved process and clarify details if needed. |
| Service eligibility or requirements clarification | The citizen wants to know whether a requirement or condition applies to them. | “Kailangan po ba ng valid ID?” | Answer only using verified service rules. |
| Community concern or report | The citizen describes an issue that may need Barangay attention. | “Hindi po nakokolekta ang basura sa amin simula pa noong isang araw.” | Acknowledge the concern, gather necessary details, and follow the approved reporting workflow. |
| Assistance inquiry | The citizen wants information about available assistance. | “Saan po puwedeng magtanong tungkol sa PWD assistance?” | Provide verified information or an approved referral. |
| Assistance request | The citizen appears to be requesting help, not merely asking for information. | “Wala po kaming makain ngayon. May matatakbuhan po ba kami?” | Respond empathetically, identify the kind of help requested, and provide only verified assistance options or approved referrals. |
| Reporting-process inquiry | The citizen asks how to report or complain about an issue. | “Paano po magreklamo tungkol sa maingay na kapitbahay?” | Explain the process; clarify whether they also wish to submit a report when appropriate. |
| Follow-up or status inquiry | The citizen asks about a previously submitted request or report. | “May update na po ba sa report ko?” | Use the approved status-checking process and authentication rules. |
| Ambiguous or mixed intent | The message is unclear or contains multiple possible requests. | “May problema po kami sa kalsada. Puwede po ba magpatulong?” | Ask a focused question to determine the citizen's need. |
| Other or unclassified | The message cannot be reliably assigned to an available intent. | A message that does not match a supported workflow. | Clarify, offer an approved alternative, or refer for human review. |

These categories are proposed for workflow analysis and must be reviewed before implementation.

**Important distinction:** A service intent identifies what the citizen wants to accomplish in the conversation. A concern category identifies the type of issue being reported. The system should not treat these as the same classification task.

## 4. Filipino-Citizen-Friendly Conversation Examples

These examples demonstrate the expected behavior. They are illustrative and do not establish final Barangay policy.

### 4.1 Citizen does not know the official document name

**Citizen:** “Paano po kumuha ng papel na nagpapatunay na taga-rito ako?”

**Chatbot:** “Maaaring Certificate of Residency po ang kailangan ninyo. Tama po ba, o may iba kayong dokumentong kailangan?”

**Expected behavior:** Recognize the likely service from the citizen's description and confirm if needed. Do not require the citizen to know the formal document name.

### 4.2 Citizen asks for requirements

**Citizen:** “Ano po kailangan para makakuha ng barangay clearance?”

**Chatbot:** “Tutulungan ko po kayo. Narito po ang mga requirements na nakalista sa aming opisyal na impormasyon: [approved requirements].”

**Expected behavior:** Retrieve the approved checklist from PB-21. If the requirements have not been verified, explain that confirmation is needed instead of inventing a list.

### 4.3 Citizen asks how to report a concern

**Citizen:** “Paano po mag-report ng tambak na basura sa kanto namin?”

**Chatbot:** “Maaari ko po kayong gabayan sa pag-report nito. Gusto po ba ninyong malaman muna ang proseso, o nais na rin po ninyong isumite ang concern?”

**Expected behavior:** Distinguish a request for instructions from an actual submission, while making the next step easy.

### 4.4 Citizen is already reporting a concern

**Citizen:** “Ang tagal na pong hindi nakokolekta ang basura sa street namin.”

**Chatbot:** “Nauunawaan ko po. Para maitala natin nang tama ang concern, saang lugar po ito nangyayari?”

**Expected behavior:** Treat the message as a potential report, acknowledge the concern, and request only the details required by the approved workflow. The example question should be adjusted if the location has already been provided.

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

## 5. Proposed Intent Routing and Workflow

### 5.1 Service and document inquiries

The chatbot should:

1. Identify the likely service even if the citizen describes it informally.
2. Confirm the intended service if more than one interpretation is plausible.
3. Retrieve the approved information from the PB-21 knowledge base.
4. Explain the requirements and steps in accessible language.
5. Ask for additional details only when necessary to give the correct guidance.
6. Explain how the citizen can obtain confirmation when information is unavailable.

The chatbot should not run the concern classifier merely because a citizen mentions a service or document.

### 5.2 Community concerns and reports

The chatbot should:

1. Recognize that the citizen may be reporting an issue.
2. Acknowledge the concern without deciding whether an allegation is true.
3. Collect required information through the approved workflow.
4. Request a concern-category suggestion or advisory screening output through the agreed interface, where applicable.
5. Follow approved urgency and escalation procedures.
6. Submit the information to Laravel for official validation, persistence, status management, routing, notifications, and audit history.
7. Communicate only the submission and status information that the system confirms.

If classification is uncertain, the chatbot should use the agreed clarification or human-review path rather than forcing a category.

The exact processing sequence must align with the reviewed PB-11 API contract and approved operational workflow.

### 5.3 Assistance inquiries and requests

The chatbot should distinguish among asking about an assistance program, asking how to apply, and actively requesting help.

It should respond empathetically, explain verified options, and refer the citizen through an approved channel when needed. It must not promise financial assistance, eligibility, approval, or availability without confirmation.

For urgent or vulnerable situations, the chatbot should follow approved referral and escalation procedures rather than improvising promises or unsupported advice.

### 5.4 Follow-up and status inquiries

When citizens ask about an existing report or service request, the chatbot should use the approved status-checking workflow.

It should verify identity or authorization as required, disclose only information the citizen is permitted to access, and distinguish between a recorded submission and a confirmed resolution.

### 5.5 Ambiguous or multiple intents

When a message could fit several workflows, the chatbot should:

- Acknowledge the likely meaning.
- Ask one focused clarifying question.
- Avoid repeatedly asking for information already provided.
- Separate multiple requests only when the system supports that behavior.
- Preserve report information already collected if the citizen needs clarification.
- Use the approved fallback if the intent remains uncertain.

The chatbot should not make citizens navigate an unnecessarily complicated menu when a simple conversational question can resolve the ambiguity.

## 6. Filipino, English, Taglish, and Informal Language

The chatbot should support natural citizen communication rather than relying exclusively on formal written Filipino or English.

Proposed requirements:

- Understand common Filipino and English expressions, including Taglish within the evaluated scope.
- Handle common spelling mistakes, informal phrasing, abbreviations, and incomplete sentences where supported by testing.
- Respond in a language the citizen appears comfortable using, where feasible.
- Use respectful, plain language and explain official terms.
- Avoid interpreting informal language, grammar, or spelling as evidence of spam or an invalid report.
- Ask for clarification when a word or expression could change the meaning of the request.
- Evaluate examples written in different language styles before relying on the model for production routing.
- Add support for other Philippine languages only after confirming project scope and evaluating performance.

Language support must be assessed through representative test examples, not assumed from the model's ability to generate a response in that language.

## 7. Uncertainty, Classification, and Human Review

### 7.1 Distinguishing intent from concern category

The orchestrator should identify the citizen's broad conversational intent before selecting the applicable workflow. The concern classifier may then suggest a category when the conversation involves an actual report.

Recognizing that a citizen is submitting a report does not guarantee that the correct concern category is known.

### 7.2 PB-19 evaluation considerations

Marc's reported exploratory evaluation achieved 73.3% accuracy on 45 candidate rows that had not yet received final approval. The evaluation also identified difficulty distinguishing Community Concern from Peace and Order Concern and reported 30% recall for Noise Complaint.

These findings indicate areas that require further validation. They do not establish production readiness or justify rejecting legitimate citizen reports.

The team should confirm category definitions, the meaning and handling of confidence scores, and the conditions for clarification or human review. PB-20 does not define an unapproved numeric confidence threshold.

### 7.3 Unclassified or uncertain messages

When the chatbot cannot confidently determine the citizen's intent, it should ask for clarification or use the agreed human-review fallback.

If the message contains a potentially urgent concern, the approved urgent-case procedure should take precedence over unnecessary clarification.

The system must not silently discard a legitimate report because the classifier cannot assign a category.

## 8. Screening, Urgency, and Escalation

### 8.1 Possible spam or duplicate reports

Repeated messages and similar wording may reflect a legitimate follow-up, an ongoing community issue, or reports from multiple citizens.

Screening output should be treated as a signal for review, not proof of abuse. Any restrictions or handling rules must be aligned with PB-22 and the approved system policy.

### 8.2 Potentially urgent concerns

The chatbot may identify potential urgency signals for the approved escalation workflow. However, urgency criteria, recipients, channels, and after-hours procedures must be confirmed by the team and Barangay.

A proposed policy is to notify the Kapitan account for qualifying urgent reports regardless of the hour. This remains pending confirmation.

The chatbot must not claim that an emergency has been verified, personnel have been dispatched, or an issue has been resolved unless the relevant status is confirmed.

## 9. Privacy, Accessibility, and Trust

The chatbot should:

- Collect only information necessary for the relevant service or reporting workflow.
- Explain why requested information is needed.
- Follow approved consent, privacy, access-control, and retention requirements.
- Never disclose another citizen's personal information or report details without authorization.
- Avoid requiring GPS, document uploads, or advanced device features unless the approved workflow genuinely requires them and offers an appropriate alternative.
- Use clear explanations when information is unavailable or human review is needed.
- Avoid promising outcomes, deadlines, eligibility, or services that have not been confirmed.
- Preserve submissions when AI processing fails.

These requirements should be aligned with the project's privacy policy and applicable Barangay procedures.

## 10. System Responsibilities and PB-11 Dependency

### AI orchestrator

The orchestrator supports conversation-level intent recognition, clarification, workflow guidance, suggested concern classification, and approved advisory screening or urgency signals.

It must not independently own official record persistence, assignment, status changes, notifications, or final administrative decisions.

### Laravel application

Laravel remains the system of record and is responsible for authentication and authorization, request validation, persistence, official status management, assignment and routing, notifications, audit history, and authorized personnel corrections.

The system must preserve citizen submissions when AI classification fails, times out, or returns an invalid result. The agreed retry or pending-review behavior must be confirmed before implementation.

### PB-11 API contract

PB-11 v2.0 and its proposed gap-closure addendum remain subject to review. The canonical contract, concern taxonomy, confidence handling, screening and urgency fields, Unclassified behavior, error handling, payload limits, and deployment/interface decisions must be confirmed before dependent implementation is treated as final.

PB-20 can proceed as a workflow draft while those decisions remain open. PB-23 should explicitly identify provisional assumptions and align implementation with the reviewed contract.

## 11. Open Questions for Team and Barangay Review

1. Which services and documents should the initial release support?
2. Who verifies and maintains official service requirements, fees, hours, eligibility, and processing information?
3. Which languages are in scope for the first release, and how will Filipino and Taglish performance be evaluated?
4. Which concern categories and definitions are approved, especially for Community Concern, Peace and Order Concern, and Noise Complaint?
5. How should the chatbot distinguish service inquiries, reporting-process questions, actual concern reports, assistance inquiries, and assistance requests?
6. How should mixed-intent and Unclassified messages be handled?
7. What screening behavior is permitted for suspected spam and duplicate reports?
8. What qualifies as urgent, who receives notifications, and what happens after hours?
9. What privacy, consent, access, and retention requirements apply?
10. What retry or pending-review behavior applies when AI processing fails?
11. Which reviewed PB-11 contract and document location should PB-23 use?

Each decision should be recorded as approved, pending, or deferred, with an owner where possible. Unresolved questions must not be treated as approved policies.

## 12. Acceptance Criteria

PB-20 is ready for review when:

- Citizen-facing intents and workflow boundaries are clearly documented.
- Service inquiries, process questions, concern reports, assistance requests, and follow-up inquiries are distinguished.
- Examples reflect natural Filipino, English, and Taglish usage.
- The chatbot can clarify informal or ambiguous requests without forcing unsupported assumptions.
- Service guidance depends on verified information.
- Uncertain classifications have an explicit clarification or human-review path.
- AI advisory responsibilities are separated from Laravel's official workflow responsibilities.
- Screening, urgency, privacy, accessibility, and failure-handling requirements are documented.
- PB-11 dependencies and unapproved assumptions are clearly identified.
- Open decisions and review responsibilities are recorded.
- Henry can use the document as an input to PB-23.

## 13. Next Steps

1. Review the proposed citizen intents and conversation examples with Henry.
2. Review category overlap and PB-19 evaluation implications with Marc and Henry.
3. Confirm the service scope and verified information sources for PB-21.
4. Confirm the supported language scope and evaluation approach.
5. Align API-dependent behavior with the reviewed PB-11 contract.
6. Validate service procedures, escalation rules, and privacy requirements with the appropriate Barangay representatives.
7. Update PB-20 with confirmed decisions and record any remaining blockers or deferred items.

**Current status:** Draft for team review. The proposed conversation behaviors and service-intent categories require validation before final approval or implementation.
