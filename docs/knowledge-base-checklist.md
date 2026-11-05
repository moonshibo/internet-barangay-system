# PB-21 — Knowledge Base and Checklist

**Project:** IntRENEt (Internet Barangay System)
**Task:** PB-21 — Knowledge Base and Checklist
**Status:** Finalized requirements document — aligned with PB-11 v2.1, PB-18 approved label-review policy, PB-20 finalized workflow requirements, and PB-22 abuse-screening requirements
**Owner:** Starween
**Sprint:** Sprint 3 — October 19–November 1, 2026
**Related Tasks:** PB-11 — Laravel–Chatbot/AI Orchestrator Contract; PB-18 — Citizen Concern Dataset Review and Label Policy; PB-20 — Service Intent and Workflow Analysis; PB-22 — Abuse-Screening Requirements; PB-23 — Chatbot Conversation Design and AI Orchestrator; PB-24 — Data Model; PB-25 — Laravel–AI Orchestrator Implementation

## 1. Purpose

This document defines the knowledge-base requirements for the IntRENEt chatbot. It establishes how the chatbot may provide citizens with information about barangay services, document requirements, procedures, reporting processes, and other approved public information.

The knowledge base must provide consistent, understandable, and reliable answers while distinguishing verified information from details that are incomplete, outdated, conflicting, or awaiting authorized confirmation.

This document also establishes:

- A standard structure for knowledge-base entries.
- An initial service and information inventory.
- Source verification and approval requirements.
- Citizen-friendly response guidelines.
- Privacy and access-control boundaries.
- Knowledge-base maintenance and revision procedures.
- Responsibilities of the chatbot, AI orchestrator, and Laravel application.

**Finalization boundary:** PB-21 finalizes the project's knowledge-base requirements and handling rules. It does not independently establish barangay policy or certify that every listed service, fee, requirement, schedule, or procedure has been confirmed by an authorized Barangay representative. Individual service information must be supported by an authoritative source before it is presented as confirmed guidance.

## 2. Objectives

The knowledge base must:

1. Provide consistent answers to common barangay service inquiries.
2. Help citizens understand service purposes, requirements, procedures, and next steps.
3. Support Filipino, English, and Taglish responses where language handling has been evaluated.
4. Prevent the chatbot from inventing requirements, fees, schedules, processing times, or eligibility rules.
5. Distinguish verified information from pending, incomplete, conflicting, or outdated information.
6. Provide a reusable structure for service information and frequently asked questions.
7. Support the service-intent and workflow requirements defined in PB-20.
8. Separate public service information from private citizen records and restricted administrative information.
9. Establish consistent rules for missing information, source conflicts, and updates.
10. Provide a requirements foundation for future knowledge-base storage, retrieval, and chatbot integration.
11. Ensure that AI-generated answers do not become substitutes for official barangay decisions.
12. Provide a traceable process for reviewing and maintaining published information.

## 3. Scope

### 3.1 Included

The knowledge base may contain the following information when supported by appropriate sources:

- Barangay service descriptions and purposes.
- Official requirements and supporting documents.
- Application procedures and processing steps.
- Fees and payment instructions, when officially verified.
- Office hours and processing times, when officially verified.
- Confirmed transaction methods, including online or in-person requirements.
- Official contact details and referral instructions.
- Frequently asked questions and approved answers.
- Reporting procedures and information citizens may need to provide.
- Confirmed service availability and applicable restrictions.
- Publicly approved announcements and service information.
- Source verification, approval, review, and maintenance records.

### 3.2 Excluded

The knowledge base and chatbot must not:

- Invent, independently establish, or approve barangay policies.
- Make final eligibility or administrative decisions.
- Determine the truth or legitimacy of citizen allegations.
- Replace authorized barangay personnel.
- Expose confidential citizen records or internal case information.
- Present unverified information as official guidance.
- Guarantee service approval or processing outcomes.
- Override Laravel validation, authorization, or established business rules.
- Treat AI-generated answers as authoritative sources.
- Treat a citizen's inquiry as an automatically submitted application or complaint.
- Use private citizen submissions as verified public knowledge without an authorized review and approval process.

### 3.3 Relationship to PB-20 Service Intent

PB-21 supports the ten conversation-level intents established in PB-20:

1. Service or document inquiry.
2. Service-process guidance.
3. Eligibility or requirements clarification.
4. Community concern or report.
5. Reporting-process inquiry.
6. Assistance inquiry.
7. Assistance request.
8. Follow-up or status inquiry.
9. Ambiguous or mixed intent.
10. Other or unclassified.

The knowledge base primarily supports informational intents. It may also provide approved reporting instructions and referral information for citizens who need to submit a concern or request.

The chatbot must distinguish between asking about a service and actually submitting a request.

Examples:

- Asking about Barangay Clearance requirements is a service or document inquiry.
- Asking how to report a noise complaint is a reporting-process inquiry.
- Describing an actual noise disturbance and asking the barangay to address it is a concern-reporting interaction.
- Asking what assistance the barangay offers is an assistance inquiry.
- Asking the barangay to provide assistance is an assistance request.

An assistance inquiry may be answered using approved public information. An actual assistance request may enter the request workflow and be classified as Barangay Assistance when appropriate.

A service inquiry must not automatically create a formal request, complaint, or application.

## 4. Knowledge-Base Information Structure

Each knowledge-base entry must follow a consistent structure. Fields may be optional when they do not apply, but missing information must be identified rather than guessed.

| Field | Description |
|---|---|
| Entry ID | Unique identifier for the knowledge-base entry |
| Service name | Official or approved name of the service |
| Alternative names | Common Filipino, English, or Taglish expressions citizens may use |
| Entry type | Service information, document information, reporting guidance, FAQ, or public announcement |
| Category | Approved service or information category |
| Description | Plain-language explanation of the service or topic |
| Requirements | Officially confirmed documents or information needed |
| Procedure | Approved steps citizens should follow |
| Fees | Confirmed official fee or an indication that the information is unavailable or pending verification |
| Processing time | Confirmed estimate or published service standard, if available |
| Transaction method | Confirmed online, in-person, or other transaction method |
| Office or responsible unit | Confirmed office or personnel responsible |
| Contact information | Approved public contact details, if available |
| Source | Official document, published notice, or authorized confirmation |
| Verification status | Verified, Pending Verification, Needs Review, or Retired |
| Verified by | Authorized reviewer or responsible office |
| Date verified | Date the information was last confirmed |
| Review date | Date the information should next be reviewed |
| Version or revision notes | Summary of changes made to the entry |

### 4.1 Entry Identification and Organization

Every entry must have a unique identifier to support retrieval, maintenance, and revision tracking.

Alternative names may include common Filipino expressions, English terms, Taglish phrases, and other wording citizens may use when referring to a service.

Alternative names help the chatbot recognize the intended topic. They do not establish that a service, requirement, fee, or procedure is officially available.

Each entry must also have an identifiable information type so that the retrieval process can distinguish service information from reporting instructions, FAQs, and other public content.

### 4.2 Missing Information

When a field has no confirmed information:

- Leave the value unpopulated or identify it as pending verification.
- Do not generate an assumed value.
- Do not present an unverified value as an official requirement.
- Identify the missing information for authorized review.
- Do not substitute information from another barangay or a similar service without an approved source.

### 4.3 Retrieval Eligibility

The verification status must affect whether an entry can be used in a public chatbot response.

- **Verified:** May be used for public answers within the approved scope of the entry.
- **Pending Verification:** Must not be presented as confirmed official guidance.
- **Needs Review:** Must not be used to provide disputed or potentially outdated information as confirmed guidance.
- **Retired:** Must not be used as active public guidance.

The technical retrieval mechanism and enforcement of these rules are implementation responsibilities under the relevant development tasks. The requirements in this section do not claim that retrieval filtering has already been implemented.

## 5. Initial Service and Information Inventory

The following inventory establishes the initial areas for knowledge-base preparation. It does not independently confirm that every service is currently available in the target barangay.

| Service or topic | Information to collect | Initial information status |
|---|---|---|
| Barangay Clearance/Certification | Purpose, requirements, procedure, fees, processing time | Pending Verification |
| Certificate of Residency | Requirements, procedure, fees, processing time | Pending Verification |
| Certificate of Indigency | Eligibility guidance, requirements, procedure, transaction method | Pending Verification |
| Community Concern | Accepted concern types and reporting procedure | Pending Verification |
| Noise Complaint | Reporting process and information citizens may need to provide | Pending Verification |
| Peace and Order Concern | Reporting process and authorized referral procedure | Pending Verification |
| Barangay Assistance | Available assistance types, eligibility guidance, and contact details | Pending Verification |
| General Service Inquiry | Approved office information and service directory | Pending Verification |
| Reporting-Process Inquiry | Approved instructions for submitting a concern or report | Pending Verification |
| Report Follow-up | Authorized status inquiry process and access restrictions | Pending Verification |

### 5.1 Relationship to PB-11 v2.1 Classification Categories

The knowledge base must remain consistent with the eight category names established in the PB-11 v2.1 contract.

**Service and document-related labels handled through service-intent routing:**

1. Barangay Clearance/Certification
2. Certificate of Residency
3. Certificate of Indigency

**Concern categories:**

4. Community Concern
5. Noise Complaint
6. Peace and Order Concern
7. Barangay Assistance

**Fallback category:**

8. Other/Unclassified

The three document-service labels belong to the orchestrator's service-intent routing path. They are not additional concern-classifier labels.

The four concern categories correspond to the concern-classification scope covered by the PB-15 to PB-19 dataset and evaluation work. Other/Unclassified is the fallback when a concern cannot be reliably assigned to a supported category.

The knowledge base provides verified information about services and reporting workflows. It does not determine classifier output, establish the truth of a report, or replace the PB-11 classification contract.

### 5.2 Classification and Knowledge-Base Boundaries

The following rules apply:

- A citizen asking about a document service should receive relevant verified service information.
- A citizen asking how to report a concern should receive approved reporting instructions.
- An actual concern report may enter the classification workflow defined by PB-11.
- A request for barangay assistance may use the Barangay Assistance category when it is an actual assistance request.
- A question about available assistance must not automatically be treated as an assistance request.
- Other/Unclassified must not be used to invent a service or supply unsupported information.

### 5.3 Inventory Confirmation

Before an individual inventory item is published as confirmed service information, its details must be supported by an appropriate source and reviewed through the verification process in Section 6.

The following must be established for each applicable service:

- Whether the service is available or applicable in the target barangay.
- Which official documents or sources describe the service.
- Which information may be published to citizens.
- Which office or authorized personnel can verify the entry.
- Which information requires restricted staff access.
- Which approved contact or referral route may be provided to citizens.

### 5.4 Service-Navigation Dataset Mapping to PB-20 Conversation Intents

The following seven records were identified in the service-navigation portion of the citizen survey dataset. These records represent questions about where to ask for information, which office or personnel to approach, or where to obtain assistance.

They are conversation-level service-navigation examples, not concern-classification training records. They remain excluded from the concern-classification baseline and must not be assigned a concern category solely because the citizen uses the word "concern."

| Dataset ID | Citizen's Main Request | PB-20 Conversation Intent | Routing Interpretation |
|---|---|---|---|
| C0063 | Ask which office handles inquiries about Barangay sports events | Service or document inquiry | Direct the citizen to verified sports-event or general service information, or an approved referral. |
| C0067 | Ask which window or counter handles Barangay inquiries | Service or document inquiry | Provide verified office or inquiry-counter information when available. |
| C0068 | Ask whom to approach about a Barangay service | Service or document inquiry | Identify the relevant service and provide verified office or personnel information when available. |
| C0070 | Ask which office or personnel handles a Barangay service concern | Service or document inquiry | Clarify the service involved and provide verified navigation information. |
| C0071 | Ask whom to approach for assistance for a person with a disability (PWD) | Assistance inquiry | Identify available, verified assistance information or an authorized referral. Do not assume eligibility or promise assistance. |
| C0073 | Ask whom to approach about a Barangay service | Service or document inquiry | Same wording as C0068; retain its existing duplicate/near-duplicate review treatment. |
| C0076 | Ask which office or personnel handles a Barangay service concern | Service or document inquiry | Clarify the service involved and provide verified navigation information. |

**Routing and Classification Rules**

1. General questions about which office, window, or personnel handles a Barangay service are routed as **Service or document inquiry** under PB-20.
2. Questions about where to obtain financial, social, disability-related, or other Barangay assistance are routed as **Assistance inquiry** when the citizen is asking for information rather than submitting a request for aid.
3. Questions specifically asking how to file or submit a community concern are routed as **Reporting-process inquiry**.
4. If the citizen proceeds to submit an actual community concern or assistance request, the applicable PB-20 submission workflow applies. Concern classification is invoked only when the applicable request is submitted, following the agreed Laravel save-first process.
5. These navigation records remain outside the concern-classification baseline. They are examples for conversation-intent recognition and service navigation, not additional concern categories.
6. Office assignments, personnel names, contact details, service availability, and referral instructions must only be presented as confirmed when supported by verified Barangay information.

**Terminology Clarification**

"General Service Inquiry" and "Reporting-Process Inquiry" in the PB-21 knowledge-base inventory describe knowledge-base information or inquiry topics. They do not introduce additional PB-20 conversation intents. For routing, general office/service-navigation questions map to **Service or document inquiry**, while questions about how to submit a concern map to **Reporting-process inquiry**.

The seven records retain their existing `service_navigation` designation and `include_in_baseline=N` status.

## 6. Verification and Approval Rules

### 6.1 Acceptable Information Sources

Potential sources include:

- Official barangay service guides and forms.
- Officially published notices and service announcements.
- Current documents provided by an authorized barangay office.
- Direct confirmation from authorized personnel, recorded with the confirmation date and responsible office.
- Other official sources accepted by the project and appropriate barangay representatives.

Search results, social media comments, old screenshots, informal recollections, and unverified third-party information must not automatically be treated as authoritative sources.

When multiple sources provide conflicting information, the affected entry must be marked Needs Review until the conflict is resolved through an authorized review.

### 6.2 Verification Statuses

The following statuses must be used consistently:

- **Verified:** An appropriate authorized source has been checked, and the information has received the approval required for chatbot use.
- **Pending Verification:** Information has been collected or proposed but has not yet received the required confirmation.
- **Needs Review:** Information may be outdated, conflicting, incomplete, or affected by a reported change.
- **Retired:** The entry must no longer be used because it has been superseded, withdrawn, or approved for retirement.

Only entries with Verified status and the required approval may be presented as confirmed public guidance.

Verification must be supported by traceable source information. A project-team review alone does not turn an unverified barangay service fact into an official barangay policy.

### 6.3 Verification Checklist

Before an entry is marked Verified, the responsible reviewer must confirm:

- [ ] The service name and description are accurate.
- [ ] The service is confirmed to be available or applicable.
- [ ] Requirements come from an appropriate authorized source.
- [ ] Procedure steps are complete and understandable.
- [ ] Fees and processing times are confirmed, or clearly identified as unavailable.
- [ ] Office hours and contact details are current, if included.
- [ ] The transaction method has been confirmed.
- [ ] Eligibility information is supported by an authorized source, if applicable.
- [ ] The source and verification date are recorded.
- [ ] The responsible reviewer or office is identified.
- [ ] Conflicting or incomplete information has been resolved.
- [ ] The entry is written in clear, citizen-friendly language.
- [ ] Privacy-sensitive and restricted information has been excluded from public content.
- [ ] The entry has received the approval required for public chatbot use.

**Checklist interpretation:** These checkboxes track verification work. They are not instructions that the chatbot executes. A box should be marked only when the corresponding review or approval has actually been completed.

### 6.4 Source and Approval Traceability

Every verified entry must retain enough information to identify where its contents came from and who confirmed them.

Where practical, the source record should include:

- Document title or source description.
- Issuing office or responsible personnel.
- Date of publication or confirmation, when available.
- Date checked by the project team.
- Name or role of the authorized reviewer.
- Relevant revision or approval notes.

A source reference must be retained so that information can be reviewed when a service requirement or procedure changes.

### 6.5 Conflicting Sources

When two or more sources provide different information:

1. Identify the affected field or statement.
2. Record the conflicting sources.
3. Mark the affected entry Needs Review.
4. Avoid presenting the disputed detail as confirmed guidance.
5. Request clarification from the appropriate authorized source.
6. Update the entry only after the conflict has been resolved and the required approval has been recorded.

The chatbot must not independently choose between conflicting official requirements.

## 7. Citizen-Friendly Answer Guidelines

The chatbot must:

1. Answer the citizen's actual question using relevant verified entries.
2. Use plain, respectful, and understandable language.
3. Match the citizen's language preference where supported.
4. Explain requirements and procedures in a clear, logical order.
5. Ask a clarifying question when the requested service or concern is unclear.
6. Separate confirmed information from details that are still pending verification.
7. Avoid promising approval, eligibility, or a specific processing time without an authoritative basis.
8. Provide an approved referral or contact route when the question cannot be answered reliably.
9. Avoid requesting personal information that is unnecessary for the inquiry.
10. Avoid exposing private case information or details that the citizen is not authorized to access.
11. Avoid presenting a generated explanation as an official barangay decision.
12. Avoid implying that a citizen has submitted a formal request when the interaction is only an inquiry.
13. Avoid treating a general service question as a concern-classification request.
14. Avoid treating knowledge-base content as evidence that a citizen's allegation is true.

### 7.1 Answer Organization

When relevant verified information is available, the chatbot should organize its answer around the citizen's immediate need.

For service inquiries, an answer may include:

- Service purpose.
- Confirmed requirements.
- Approved procedure.
- Confirmed fees, if applicable.
- Confirmed processing time, if available.
- Confirmed transaction method.
- Approved contact or referral information.

The chatbot must not force every field into an answer. It should provide only the information relevant to the question and supported by verified entries.

### 7.2 Missing or Unverified Information

If the knowledge base does not contain a verified answer, the chatbot must not invent one.

Expected behavior:

- Explain which detail cannot yet be confirmed.
- Provide relevant information that is already verified.
- Direct the citizen to an approved barangay contact or human assistance route, if available.
- Record the missing-information issue for authorized review when supported by the system.
- Avoid presenting a proposed requirement as an official requirement.
- Avoid making assumptions based on similar services or other barangays.

**Example response:**

"Pasensya na po, hindi ko pa makumpirma ang kasalukuyang requirements para sa serbisyong ito. Maaari po kayong magtanong sa awtorisadong barangay office upang makuha ang tamang impormasyon."

This is an example response, not an official contact instruction. An approved referral route must be supplied before it is presented as a specific contact instruction.

### 7.3 Conflicting or Outdated Information

When an entry contains conflicting or potentially outdated information:

1. Do not present the disputed detail as confirmed guidance.
2. Identify the affected information as requiring review.
3. Use another verified source only if it is approved for the same purpose.
4. Provide an approved human referral route when necessary.
5. Flag the entry for authorized review and revision.

A previously verified entry must not remain in active use as confirmed guidance when a credible change or conflict has been identified.

### 7.4 Language and Terminology

The chatbot should use clear and familiar wording while preserving the meaning of official service names and requirements.

Expected language considerations include:

- Filipino.
- English.
- Taglish.
- Common informal expressions and alternative service names.

Language handling must be evaluated before being treated as a supported capability. Other Philippine languages may be considered in a later scope after appropriate language data, review, and evaluation are available.

The chatbot must not translate or simplify official requirements in a way that changes their meaning.

## 8. Privacy and Access Control

The knowledge base must distinguish public service information from private citizen records and restricted administrative information.

The following rules apply:

- Public service information must be separated from private citizen records.
- The knowledge base must not expose personal information from reports, applications, or case histories.
- A citizen's request for their own application or report status must follow the system's authentication and authorization rules.
- Internal staff notes and restricted procedures must not be exposed through public chatbot answers.
- Access to create, approve, edit, or retire entries must follow the permissions defined by the project.
- Knowledge-base entries must not be used to bypass Laravel authorization or validation.
- Citizen-provided information must not automatically become verified public knowledge.
- Sensitive information must not be included in public knowledge-base answers simply because it appears in an internal record.
- The chatbot must not disclose another citizen's application details, complaint history, contact information, or other protected information.

Knowledge-base retrieval must not provide an alternate route around application authentication or authorization.

## 9. Updates and Maintenance

Knowledge-base information must be maintained through a controlled process so that outdated or incorrect guidance does not remain active.

### 9.1 Update Procedure

Every knowledge-base update should follow these steps:

1. Identify the entry that needs to be added, revised, reviewed, or retired.
2. Record the reason for the change and the proposed source.
3. Obtain confirmation from the appropriate authorized source when the change affects official service information.
4. Review the proposed wording for accuracy, completeness, privacy, and clarity.
5. Update the entry and record the revision.
6. Record the reviewer and verification date.
7. Publish the update only after the required approval.
8. Mark conflicting, outdated, or withdrawn information so it is no longer used as confirmed guidance.

### 9.2 Review and Maintenance Responsibilities

The project must establish the following responsibilities:

- Who owns ongoing knowledge-base maintenance.
- Who may propose changes.
- Who is authorized to verify service information.
- Who approves entries for public chatbot use.
- How frequently entries should be reviewed.
- How urgent changes or corrections should be handled.
- How retired entries and previous versions should be retained.

The technical implementation must enforce the approved permissions and workflow. The exact personnel assignments and maintenance schedule must be recorded when confirmed by the appropriate project and Barangay representatives.

### 9.3 Revision Tracking

Every approved update should retain a revision history where supported by the implementation.

The revision record should identify:

- The entry that changed.
- The previous and updated information, where practical.
- The reason for the change.
- The source used for verification.
- The reviewer or approving office.
- The date of approval or revision.

This supports accountability and makes it easier to identify why a particular answer was provided at a given time.

### 9.4 Retiring an Entry

An entry must be retired when it has been withdrawn, superseded, or approved for removal from active public use.

Retired entries must not be retrieved as current guidance. Historical records may be retained for traceability according to the project's data-retention rules.

## 10. Relationship to the Chatbot, AI Orchestrator, and Laravel

The knowledge base supplies information that the chatbot may use to answer service inquiries. It does not replace application business rules, official records, or authorization checks.

### 10.1 Chatbot and Orchestrator Responsibilities

The chatbot and orchestrator are responsible for:

- Identifying the citizen's information need.
- Recognizing the conversation-level intent defined in PB-20.
- Distinguishing service inquiries from actual concern-reporting interactions.
- Identifying the appropriate service or workflow.
- Retrieving relevant approved knowledge-base entries when retrieval is implemented.
- Presenting information in understandable language.
- Asking for clarification when needed.
- Explaining when information is missing or unverified.
- Referring questions to an approved human assistance route when necessary.

The orchestrator's conversation-level intent recognition must not be confused with the permanent storage of a service request or an administrative decision.

A citizen asking about a document or service does not automatically require the concern-classification endpoint described in PB-11.

### 10.2 Laravel and Authorized System Responsibilities

Laravel and the authorized application components remain responsible for:

- Enforcing authentication and authorization.
- Validating and persisting submissions.
- Managing official application and report records.
- Managing official application or report status.
- Controlling access to private records.
- Maintaining authorized workflow, audit, and notification behavior.
- Applying approved business rules.
- Ensuring that restricted information is not exposed to unauthorized users.

The chatbot must not independently change official request status, approve an application, determine eligibility, or override Laravel-controlled processes.

### 10.3 Alignment with PB-11 v2.1

PB-21 must remain consistent with the approved PB-11 v2.1 interface design.

Relevant boundaries include:

- The orchestrator identifies conversation intent and supports appropriate workflow selection.
- Service inquiries use verified service information rather than automatically invoking concern classification.
- Concern classification applies to actual concern-reporting interactions within the agreed scope.
- Laravel remains responsible for saving citizen requests and managing official records.
- AI classification outputs are advisory and do not replace administrative decisions.
- The routine `screening_flag` is limited to the agreed routine screening cases: a near-duplicate from the same respondent within a short time window or empty/placeholder-only content.
- The routine screening flag is not a general abuse detector and does not establish whether a report is legitimate.
- Urgency is an advisory signal and must not be treated as proof that a report is valid or as an independent administrative decision.

PB-11 v2.1 is an approved interface design contract. It is not proof of an implemented or operational integration. Knowledge-base retrieval and related technical implementation must be described according to their actual implementation status.

### 10.4 Alignment with PB-18 Label-Review Policy

The knowledge base and chatbot must respect the approved PB-18 label-review policy when discussing or routing concern reports.

Relevant rules include:

- Each concern report receives one primary category.
- Categorization is based on the main reported concern and its impact.
- The chatbot must not assume that an unverified cause or allegation is established fact.
- Multi-issue reports may be flagged for personnel review while retaining one primary category.
- Urgency and potential hazard remain separate from the primary category.
- Obstruction caused by accumulated garbage remains Community Concern; obstruction caused primarily by disorderly conduct may warrant Peace and Order review.
- A model-suggested category is not a verification of the report or an administrative finding.

Knowledge-base information must not override these approved classification boundaries.

### 10.5 Alignment with PB-22 Abuse-Screening Requirements

PB-22 defines separate abuse-screening requirements.

The following distinctions must be maintained:

- Routine duplicate or placeholder screening under PB-11 is not a complete abuse-screening mechanism.
- Abuse-screening requirements must not be silently merged into the knowledge-base retrieval process.
- The knowledge base must not determine whether a citizen is abusive or whether an incident is legitimate.
- Screening signals must not automatically cause a citizen's request to be rejected.
- Any future integration affecting classification, screening, privacy, or data handling must follow the relevant approved project requirements.

### 10.6 Implementation Boundary

The PB-11 interface design, PB-20 workflow requirements, PB-21 knowledge-base requirements, and PB-22 screening requirements provide the basis for dependent development tasks.

They do not prove that:

- Knowledge-base entries have all been collected or verified.
- A knowledge-base database or retrieval mechanism has been completed.
- The chatbot can already retrieve and filter entries by verification status.
- The Laravel and Python orchestrator integration is operational.
- All proposed notification, screening, or classification behavior has been implemented.

Implementation and testing evidence must be recorded under the appropriate development tasks.

## 11. Finalized Requirements and Remaining Operational Work

The following project requirements are finalized for use by dependent tasks:

1. Knowledge-base entries must use a consistent and traceable structure.
2. Public chatbot guidance must be based on appropriately verified information.
3. Unverified, conflicting, incomplete, or retired information must not be presented as confirmed guidance.
4. The initial service inventory must remain consistent with PB-11 v2.1 classification boundaries.
5. The chatbot must distinguish informational inquiries from actual requests and concern reports.
6. The ten PB-20 conversation-level intents must guide the chatbot's informational and workflow behavior.
7. Public information must remain separate from private citizen records and restricted administrative information.
8. Laravel remains responsible for authentication, authorization, validation, persistence, and official records.
9. AI-generated answers and classification results remain advisory.
10. Knowledge-base updates must follow a controlled verification, approval, and revision process.
11. PB-18 classification policy and PB-22 screening boundaries must be respected.
12. The knowledge base must not independently establish service availability, official fees, eligibility, or barangay policy.

The following are operational or implementation activities, not reasons to leave the PB-21 requirements document in draft status:

- Collecting authoritative sources for individual services.
- Obtaining and recording service-specific confirmation.
- Populating and reviewing individual knowledge-base entries.
- Confirming the assigned personnel for ongoing maintenance and approval.
- Selecting and implementing the storage and retrieval mechanism.
- Implementing retrieval restrictions based on verification status.
- Testing chatbot answers against verified and unverified entries.
- Integrating retrieval with the chatbot and Laravel application.

These activities must be completed and evidenced under the appropriate project tasks. Their completion must not be assumed merely because PB-21 has been finalized.

## 12. Acceptance Criteria

PB-21 documentation is considered finalized when the following requirements are documented:

- [x] The knowledge-base purpose and scope are defined.
- [x] A reusable structure for knowledge-base entries is defined.
- [x] An initial service and information inventory is documented.
- [x] The inventory is aligned with PB-11 v2.1 service and concern categories.
- [x] The relationship to the ten PB-20 conversation-level intents is defined.
- [x] Verification statuses and source requirements are defined.
- [x] A verification checklist is included.
- [x] Rules for missing, conflicting, and outdated information are documented.
- [x] Citizen-friendly response guidelines are included.
- [x] Language and terminology expectations are described.
- [x] Privacy and access-control boundaries are documented.
- [x] Knowledge-base update and maintenance requirements are defined.
- [x] The responsibilities of the chatbot, orchestrator, and Laravel are distinguished.
- [x] The relationship to PB-11 v2.1, PB-18, and PB-22 is documented.
- [x] Unconfirmed service facts and implementation work are distinguished from finalized requirements.
- [x] The document is ready for dependent project tasks and implementation planning.

**Important:** These checkboxes indicate that the PB-21 documentation requirements have been addressed in this document. They do not indicate that individual Barangay service entries have been verified, that the Barangay has confirmed every listed service detail, or that knowledge-base retrieval has been implemented and tested.

## 13. Next Steps

With the PB-21 requirements document finalized, dependent work may proceed using the following responsibilities:

1. **PB-23:** Align chatbot conversation design and orchestrator behavior with the approved knowledge-base rules and PB-20 intents.
2. **PB-24:** Determine the data model for knowledge-base entries, verification status, source traceability, and any required relationships.
3. **PB-25:** Implement and test the relevant Laravel–AI orchestrator integration according to the approved interface contract.
4. **Knowledge-base preparation:** Collect authoritative service information and populate entries only when appropriate sources are available.
5. **Verification and approval:** Obtain and record the required confirmation for individual service entries before public use.
6. **Testing:** Evaluate answers for accuracy, missing information, conflicting sources, privacy, and appropriate referral behavior.
7. **Maintenance:** Assign and document the ongoing review and approval responsibilities.


**Document status:** Finalized PB-21 requirements document — aligned with PB-11 v2.1, PB-18 approved label-review policy, PB-20 finalized workflow requirements, and PB-22 abuse-screening requirements.

**Document note:** PB-21 finalizes the knowledge-base requirements, verification rules, and chatbot information-handling boundaries. It does not independently establish official Barangay policy, certify that all listed services and service details have received Barangay confirmation, or claim that knowledge-base retrieval and chatbot integration are operational.