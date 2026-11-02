# PB-21 — Knowledge Base and Checklist

**Project:** IntRENEt (Internet Barangay System)
**Task:** PB-21 — Knowledge Base and Checklist
**Status:** Revised requirements document — aligned with PB-20 and PB-11 v2.1; service information subject to authorized Barangay verification
**Owner:** Starween
**Sprint:** Sprint 3 — October 19–November 1, 2026
**Related Tasks:** PB-11 — Laravel–Chatbot/AI Orchestrator Contract; PB-20 — Service Intent and Workflow Analysis; PB-22 — Abuse-Screening Requirements; PB-23 — Chatbot Conversation Design and AI Orchestrator; PB-24 — Data Model; PB-25 — Laravel–AI Orchestrator Implementation

## 1. Purpose

This document defines the information the IntRENEt chatbot may use when answering citizens' questions about barangay services, requirements, procedures, and reporting processes.

The knowledge base is intended to provide consistent, understandable, and reliable information. It must distinguish verified information from details that are incomplete, outdated, conflicting, or still awaiting confirmation.

It also establishes a reusable structure for service information, verification requirements, citizen-friendly response guidelines, privacy boundaries, and maintenance procedures.

This document is a planning and requirements artifact. It does not establish official barangay policies, independently approve service requirements, or confirm that every listed service is available in the target barangay.

## 2. Objectives

The knowledge base should:

1. Provide consistent answers to common barangay service inquiries.
2. Help citizens understand service purposes, requirements, procedures, and next steps.
3. Support Filipino, English, and Taglish conversations where language handling has been evaluated.
4. Prevent the chatbot from inventing requirements, fees, schedules, processing times, or eligibility rules.
5. Identify information that requires confirmation by authorized barangay personnel.
6. Provide a maintainable checklist for reviewing and updating service information.
7. Support the service-intent and workflow analysis defined in PB-20.
8. Separate public service information from private citizen records and internal administrative information.
9. Establish clear rules for handling missing, conflicting, and outdated information.
10. Provide a foundation for future knowledge-base retrieval and chatbot integration.

## 3. Scope

### 3.1 Included

The knowledge base may contain the following information when supported by appropriate sources:

- Barangay service descriptions and purposes.
- Official requirements and supporting documents.
- Application procedures and processing steps.
- Fees and payment instructions, when officially verified.
- Office hours and processing times, when officially verified.
- Whether a service requires an in-person transaction.
- Official contact details and referral instructions.
- Frequently asked questions and approved answers.
- Reporting procedures and information citizens may need to provide.
- Service availability and relevant restrictions, when confirmed.
- Information verification, review, approval, and maintenance procedures.

### 3.2 Excluded

The knowledge base and chatbot must not:

- Invent or independently approve barangay policies.
- Make final eligibility or administrative decisions.
- Determine the truth of citizen allegations.
- Replace authorized barangay personnel.
- Expose confidential citizen records or internal case information.
- Treat unverified information as official guidance.
- Guarantee service approval or processing outcomes.
- Override Laravel validation, authorization, or established business rules.
- Treat AI-generated answers as authoritative sources.

### 3.3 Relationship to PB-20 Service Intent

The knowledge base supports the service-intent workflows defined in PB-20.

The chatbot must distinguish between a citizen asking about a service and a citizen submitting an actual concern or report.

For example:

- Asking about Barangay Clearance requirements is a service inquiry.
- Asking how to report a noise complaint is a reporting-process inquiry.
- Describing an actual ongoing noise disturbance and requesting assistance is a concern-reporting interaction.

A service inquiry must not automatically be treated as a formal complaint or submitted request.

## 4. Knowledge Base Information Structure

Each service or knowledge-base entry should use a consistent structure. Fields may be optional when they do not apply, but missing information must be identified rather than guessed.

| Field | Description |
|---|---|
| Entry ID | Unique identifier for the knowledge-base entry |
| Service name | Official or approved name of the service |
| Alternative names | Common names or expressions citizens may use |
| Category | Service inquiry, document request, reporting process, or another approved category |
| Description | Plain-language explanation of the service |
| Requirements | Officially confirmed documents or information needed |
| Procedure | Approved steps citizens should follow |
| Fees | Official fee or an explicit indication that the fee is unverified or unavailable |
| Processing time | Confirmed estimate or published service standard, if available |
| Transaction method | Online, in person, or another confirmed method |
| Office or responsible unit | Officially confirmed office or personnel responsible |
| Contact information | Approved contact details, if available |
| Source | Official document, published notice, or authorized confirmation |
| Verification status | Verified, Pending Verification, Needs Review, or Retired |
| Verified by | Authorized reviewer or responsible office |
| Date verified | Date the information was last confirmed |
| Review date | Date the information should next be reviewed |
| Version or revision notes | Summary of changes made to the entry |

### 4.1 Entry Identification and Organization

Each entry should have a unique identifier to support maintenance, retrieval, and revision tracking.

Alternative names may include common Filipino expressions, English terms, Taglish phrases, and other wording citizens may use when referring to a service.

Alternative names must help the chatbot recognize a citizen's intended service. They must not be treated as evidence that a service or requirement is officially available.

### 4.2 Missing Information

If a field has no confirmed information:

- Leave the value unpopulated or mark it as pending verification.
- Do not generate an assumed value.
- Do not present an unverified value as an official requirement.
- Identify the missing information for authorized review.

## 5. Initial Service Inventory

The following inventory provides an initial structure for collecting and verifying information. It is not a confirmation that every listed service is currently available in the project barangay.

| Service or topic | Information to collect | Initial status |
|---|---|---|
| Barangay Clearance or Certification | Purpose, requirements, procedure, fees, processing time | Pending Verification |
| Certificate of Residency | Requirements, procedure, fees, processing time | Pending Verification |
| Certificate of Indigency | Eligibility guidance, requirements, procedure, transaction method | Pending Verification |
| Community Concern | Accepted concern types and reporting procedure | Pending Verification |
| Noise Complaint | Reporting process, required details, handling procedure | Pending Verification |
| Peace and Order Concern | Reporting process and authorized referral procedure | Pending Verification |
| Barangay Assistance | Available assistance types, eligibility guidance, and contact details | Pending Verification |
| General Service Inquiry | Official office information and service directory | Pending Verification |
| Report Follow-up | Authorized status inquiry process and access restrictions | Pending Verification |

### 5.1 Relationship to PB-11 Concern Categories

The initial inventory must remain consistent with the concern and service classifications established in PB-11 v2.1.

The eight category names locked for the current project scope are:

**Service and document-related labels handled through intent routing:**

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

The four concern categories correspond to the concern-classification scope covered by the PB-15 to PB-19 dataset and evaluation work. Other/Unclassified serves as a fallback when the concern cannot be reliably assigned to a supported category.

The knowledge base supplies verified information for these services and workflows. It does not determine classifier output or replace the classification contract.

### 5.2 Inventory Confirmation

Before entries are treated as final service information, the project team must confirm:

- Which services are officially available in the target barangay.
- Which reporting categories are applicable.
- Which information can be published to citizens.
- Which office or authorized personnel can confirm each entry.
- Which information requires restricted staff access.

## 6. Verification and Approval Rules

### 6.1 Acceptable Information Sources

Potential sources include:

- Official barangay service guides and forms.
- Officially published notices and service announcements.
- Current documents provided by an authorized barangay office.
- Direct confirmation from authorized personnel, recorded with the confirmation date and responsible office.
- Other official sources approved by the project team and appropriate barangay representatives.

Search results, social media comments, old screenshots, informal recollections, and unverified third-party information must not automatically be treated as authoritative sources.

When multiple sources provide conflicting information, the entry must be marked Needs Review until the conflict is resolved by an authorized reviewer.

### 6.2 Verification Statuses

The following statuses must be used consistently:

- **Verified:** An authorized source has been checked and the information has received the approval required for chatbot use.
- **Pending Verification:** Information has been collected or proposed but has not yet been confirmed.
- **Needs Review:** Information may be outdated, conflicting, incomplete, or affected by a reported change.
- **Retired:** The entry must no longer be used because it has been superseded, withdrawn, or otherwise approved for retirement.

Only entries approved for use should be presented as confirmed official guidance.

The exact approval process and responsible personnel remain subject to project-team and barangay confirmation.

### 6.3 Verification Checklist

Before an entry is marked Verified, confirm that:

- [ ] The service name and description are accurate.
- [ ] The service is confirmed to be available or applicable.
- [ ] Requirements come from an authorized source.
- [ ] Procedure steps are complete and understandable.
- [ ] Fees and processing times are confirmed, or clearly identified as unavailable.
- [ ] Office hours and contact details are current, if included.
- [ ] The transaction method has been confirmed.
- [ ] Eligibility information is supported by an authorized source, if applicable.
- [ ] The source and verification date are recorded.
- [ ] The responsible reviewer or office is identified.
- [ ] Conflicting or incomplete information has been resolved.
- [ ] The entry is written in clear, citizen-friendly language.
- [ ] Privacy-sensitive or internal information has been excluded from public content.
- [ ] The entry has received the approval required by the project or barangay.

### 6.4 Source and Approval Traceability

Every verified entry should retain enough information to identify where its contents came from and who confirmed them.

Where practical, the source record should include:

- Document title or source description.
- Issuing office or responsible personnel.
- Date of publication or confirmation, when available.
- Date checked by the project team.
- Name or role of the authorized reviewer.
- Relevant revision or approval notes.

A source reference must be retained so that information can be reviewed when a service requirement or procedure changes.

## 7. Citizen-Friendly Answer Guidelines

The chatbot should:

1. Answer the citizen's actual question using relevant verified entries.
2. Use plain and respectful language rather than unnecessary technical terms.
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

The chatbot should not force every field into an answer. It should provide only the information relevant to the question and supported by verified entries.

### 7.2 Missing or Unverified Information

If the knowledge base does not contain a verified answer, the chatbot must not invent one.

Expected behavior:

- Explain which detail cannot yet be confirmed.
- Provide any relevant information that is already verified.
- Direct the citizen to an approved barangay contact or human assistance route, if available.
- Record the missing-information issue for authorized review when supported by the system.
- Avoid presenting a proposed requirement as an official requirement.
- Avoid making assumptions based on similar services or other barangays.

**Example response:**

"Pasensya na po, hindi ko pa makumpirma ang kasalukuyang requirements para sa serbisyong ito. Maaari po kayong magtanong sa awtorisadong barangay office upang makuha ang tamang impormasyon."

This is an example response, not an official contact instruction. The project team should insert an approved referral route when one has been confirmed.

### 7.3 Conflicting or Outdated Information

When an entry contains conflicting or potentially outdated information:

1. Do not present the disputed detail as confirmed guidance.
2. Identify the affected information as requiring review.
3. Use another verified source only if it has been approved for the same purpose.
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

The chatbot must not translate official requirements in a way that changes their meaning.

## 8. Privacy and Access Control

The knowledge base must distinguish public service information from private citizen records and restricted administrative information.

The following rules apply:

- Public service information must be separated from private citizen records.
- The knowledge base must not expose personal information from reports, applications, or case histories.
- A citizen's request for their own application or report status must follow the system's authentication and authorization rules.
- Internal staff notes and restricted procedures must not be exposed through public chatbot answers.
- Access to create, approve, edit, or retire entries should follow the permissions defined by the project.
- Knowledge-base entries must not be used to bypass Laravel authorization or validation.
- Citizen-provided information must not automatically become verified public knowledge.
- Sensitive information must not be included in public knowledge-base answers simply because it appears in an internal record.

The chatbot must not disclose another citizen's application details, complaint history, contact information, or other protected information.

## 9. Updates and Maintenance

Knowledge-base information must be maintained through a controlled process so that outdated or incorrect guidance does not remain active.

### 9.1 Update Procedure

Every knowledge-base update should follow these steps:

1. Identify the entry that needs to be added, revised, reviewed, or retired.
2. Record the reason for the change and the proposed source.
3. Obtain confirmation from the appropriate authorized source.
4. Review the proposed wording for accuracy, completeness, and clarity.
5. Update the entry and record the revision.
6. Record the reviewer and verification date.
7. Publish the update only after the required approval.
8. Flag conflicting, outdated, or withdrawn information so it is no longer used as confirmed guidance.

### 9.2 Review and Maintenance Responsibilities

The project team must determine:

- Who owns ongoing knowledge-base maintenance.
- Who may propose changes.
- Who is authorized to verify service information.
- Who approves entries for public chatbot use.
- How frequently entries should be reviewed.
- How urgent changes or corrections should be handled.
- How retired entries and previous versions should be retained.

These responsibilities must be confirmed before the knowledge base is treated as an operational source of official service guidance.

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

## 10. Relationship to the Chatbot, AI Orchestrator, and Laravel

The knowledge base supplies information that the chatbot may use to answer service inquiries. It does not replace the application's business rules, official records, or authorization checks.

### 10.1 Chatbot and Orchestrator Responsibilities

The chatbot and orchestrator are responsible for:

- Identifying the citizen's information need.
- Distinguishing service inquiries from actual concern-reporting interactions.
- Identifying the appropriate service or workflow.
- Retrieving relevant approved knowledge-base entries once retrieval is implemented.
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
- Service inquiries should use verified service information rather than automatically invoking concern classification.
- Concern classification applies to actual concern-reporting interactions within the agreed scope.
- Laravel remains responsible for saving citizen requests and managing official records.
- AI classification outputs are advisory and do not replace administrative decisions.
- The knowledge base must not treat routine screening or urgency signals as proof that a citizen's report is valid or invalid.

PB-11 v2.1 is an approved interface design contract, not proof of an implemented or operational integration. Knowledge-base retrieval and related technical implementation must be treated according to the actual implementation status.

### 10.4 Relationship to PB-22 and Other Requirements

PB-22 defines separate abuse-screening requirements. Routine duplicate or spam screening described in PB-11 must not be treated as a complete abuse-screening mechanism.

Likewise, knowledge-base information must not be used to determine the legitimacy or truth of citizen allegations.

Any future integration requirements affecting knowledge-base retrieval, access control, or data handling must be reviewed against the relevant project documents and approved interface decisions.

## 11. Open Questions and Pending Decisions

The project team and authorized barangay representatives need to confirm the following:

### 11.1 Service Information

- Which services are officially available in the target barangay?
- Which documents are the authoritative source for each service?
- What requirements, fees, processing times, and office schedules may be published?
- Which services require an in-person transaction?
- Which service details may be made publicly accessible?
- Which approved contact or referral route should the chatbot provide?

### 11.2 Verification and Maintenance

- Who can verify and approve service information?
- Who maintains the knowledge base after deployment?
- How frequently should entries be reviewed?
- How should conflicting official sources be resolved?
- How should urgent service-information changes be communicated?
- What revision history and approval evidence must be retained?

### 11.3 Technical Integration

- What technical format will be used to store knowledge-base entries?
- What retrieval method will the chatbot use?
- Which entries are required for the initial prototype?
- How will verification status affect whether an entry can be retrieved for public answers?
- How will updates be reflected in the chatbot's available information?
- What access restrictions are required for internal or restricted entries?

Until these questions are resolved, affected information and decisions must remain clearly identified as pending confirmation.

## 12. Acceptance Criteria

PB-21 documentation can be considered ready for team review when:

- [ ] The knowledge-base purpose and scope are documented.
- [ ] A reusable structure for service entries is defined.
- [ ] An initial service inventory is available for confirmation.
- [ ] The inventory is consistent with PB-11 concern and service classifications.
- [ ] Verification statuses and source requirements are defined.
- [ ] A verification checklist is included.
- [ ] Rules for missing, conflicting, and outdated information are documented.
- [ ] Citizen-friendly response guidelines are included.
- [ ] Language and terminology expectations are described.
- [ ] Privacy and access-control boundaries are documented.
- [ ] A maintenance and approval process is proposed.
- [ ] The responsibilities of the chatbot, orchestrator, and Laravel are distinguished.
- [ ] The relationship to PB-11 v2.1 and PB-22 is documented.
- [ ] Unconfirmed barangay policies and technical decisions are explicitly identified.
- [ ] The document has been reviewed by the project team.

These criteria describe documentation readiness. They do not prove that all service information has been verified by the barangay or that a working knowledge-base retrieval feature has been implemented.

## 13. Next Steps

1. Review this revised document against the approved PB-20 and PB-11 v2.1.
2. Obtain authorized sources for the services included in the project scope.
3. Confirm the service inventory and approval responsibilities with the appropriate barangay representatives.
4. Populate knowledge-base entries only when supporting information is available.
5. Mark unverified, incomplete, or conflicting information appropriately.
6. Resolve outstanding questions about knowledge-base storage, retrieval, and integration.
7. Revise the document based on authorized feedback and confirmed implementation decisions.
8. Commit and share the reviewed document according to the team's Git workflow.

**Document status:** Revised PB-21 requirements document — aligned with PB-20 and PB-11 v2.1; service information remains subject to authorized Barangay verification.

**Document note:** This document defines the knowledge-base requirements and verification process. It does not independently establish official barangay policy, confirm the availability of listed services, or certify that knowledge-base retrieval has been implemented.