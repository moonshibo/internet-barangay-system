# PB-21 — Knowledge Base and Checklist

**Project:** IntRENEt (Internet Barangay System)
**Task:** PB-21 — Knowledge Base and Checklist
**Status:** Draft — Pending Team Review and Barangay Verification
**Owner:** Starween
**Related Task:** PB-20 — Service Intent and Workflow Analysis
**Sprint:** Sprint 3 (October 19–November 1, 2026)


## 1. Purpose

This document defines the information the IntRENEt chatbot may use when answering citizens' questions about barangay services, requirements, procedures, and reporting processes.

The knowledge base should provide consistent, understandable, and reliable information. It must distinguish verified information from details that still require confirmation.

This document is a planning and requirements artifact. It does not establish official barangay policies or independently approve service requirements.

## 2. Objectives

The knowledge base should:

1. Provide consistent answers to common barangay service inquiries.
2. Help citizens understand requirements, procedures, and the next steps for a service.
3. Support Filipino, English, and Taglish conversations where language handling has been evaluated.
4. Prevent the chatbot from inventing requirements, fees, schedules, processing times, or eligibility rules.
5. Identify information that requires confirmation by authorized barangay personnel.
6. Provide a maintainable checklist for reviewing and updating service information.
7. Support the service-intent and workflow analysis defined in PB-20.

## 3. Scope

### 3.1 Included

- Barangay service descriptions and purposes.
- Official requirements and supporting documents.
- Application procedures and processing steps.
- Fees, office hours, and processing times when officially verified.
- Whether a service requires an in-person transaction.
- Official contact details and referral instructions.
- Frequently asked questions and approved answers.
- Information verification, review, and maintenance procedures.

### 3.2 Excluded

- Inventing or independently approving barangay policies.
- Making final eligibility or administrative decisions.
- Determining the truth of citizen allegations.
- Replacing authorized barangay personnel.
- Exposing confidential citizen records or internal case information.
- Treating unverified information as official guidance.

## 4. Knowledge Base Information Structure

Each service or knowledge-base entry should contain the following fields where applicable.

| Field | Description |
|---|---|
| Entry ID | Unique identifier for the entry |
| Service name | Official or approved name of the service |
| Alternative names | Common names or expressions citizens may use |
| Category | Service inquiry, document request, reporting process, or other approved category |
| Description | Plain-language explanation of the service |
| Requirements | Officially confirmed documents or information needed |
| Procedure | Approved steps citizens should follow |
| Fees | Official fee or a clear statement that the fee is not yet verified |
| Processing time | Confirmed estimate or published service standard, if available |
| Transaction method | Online, in person, or another confirmed method |
| Office or responsible unit | Officially confirmed office or personnel responsible |
| Contact information | Approved contact details, if available |
| Source | Official document, published notice, or authorized confirmation |
| Verification status | Verified, Pending Verification, or Needs Review |
| Verified by | Authorized reviewer or office |
| Date verified | Date the information was last confirmed |
| Review date | Date the information should next be reviewed |
| Version or revision notes | Summary of changes made to the entry |

Not every field will apply to every service. Missing information must be identified rather than guessed.

## 5. Initial Service Inventory

The following is a proposed inventory for collecting information. It is not a claim that every listed service is available in the project barangay.

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

The project team should confirm which services and concern categories are applicable before treating this inventory as final.

## 6. Verification and Approval Rules

### 6.1 Acceptable information sources

Potential sources include:

- Official barangay service guides and forms.
- Officially published notices and service announcements.
- Current documents provided by an authorized barangay office.
- Direct confirmation from authorized personnel, recorded with the confirmation date and responsible office.
- Other official sources approved by the project team.

Search results, social media comments, old screenshots, and informal recollections must not automatically be treated as authoritative sources.

### 6.2 Verification statuses

Use the following statuses consistently.

- **Verified:** An authorized source has been checked and the information is approved for chatbot use.
- **Pending Verification:** The information has been collected or proposed but has not yet been confirmed.
- **Needs Review:** The information may be outdated, conflicting, incomplete, or affected by a reported change.
- **Retired:** The entry should no longer be used because it has been superseded or withdrawn.

Only entries approved for use should be presented as confirmed official guidance. The exact approval process and responsible personnel remain subject to team and barangay confirmation.

### 6.3 Verification checklist

Before an entry is marked Verified, confirm that:

- [ ] The service name and description are accurate.
- [ ] Requirements come from an authorized source.
- [ ] Procedure steps are complete and understandable.
- [ ] Fees and processing times are confirmed, or clearly marked as unavailable.
- [ ] Office hours and contact details are current, if included.
- [ ] The transaction method has been confirmed.
- [ ] The source and verification date are recorded.
- [ ] The responsible reviewer is identified.
- [ ] Conflicting or incomplete information has been resolved.
- [ ] The entry is written in clear, citizen-friendly language.
- [ ] The entry has received the approval required by the project or barangay.

## 7. Citizen-Friendly Answer Guidelines

The chatbot should:

1. Answer the citizen's actual question using relevant, verified entries.
2. Use plain and respectful language rather than unnecessary technical terms.
3. Match the citizen's language preference where supported.
4. Explain requirements and procedures in a clear order.
5. Ask a clarifying question when the requested service is unclear.
6. Separate confirmed information from details that are still pending verification.
7. Avoid promising approval, eligibility, or a specific processing time without an authoritative basis.
8. Provide an approved referral or contact route when the question cannot be answered reliably.
9. Avoid requesting personal information that is unnecessary for the inquiry.
10. Avoid exposing private case information or details that the citizen is not authorized to access.

### 7.1 Missing or unverified information

If the knowledge base does not contain a verified answer, the chatbot must not invent one.

Expected behavior:

- Explain which detail cannot yet be confirmed.
- Provide any relevant information that is verified.
- Direct the citizen to an approved barangay contact or human assistance route, if available.
- Record the missing-information issue for authorized review when supported by the system.
- Avoid presenting a proposed requirement as an official requirement.

**Example response:**

"Pasensya na po, hindi ko pa makumpirma ang kasalukuyang requirements para sa serbisyong ito. Maaari po kayong magtanong sa awtorisadong barangay office upang makuha ang tamang impormasyon."

This is an example response, not an official contact instruction. The team should insert an approved referral route when one is confirmed.

## 8. Privacy and Access Control

- Public service information must be separated from private citizen records.
- The knowledge base must not expose personal information from reports, applications, or case histories.
- A citizen's request for their own application status must follow the system's authentication and authorization rules.
- Internal staff notes and restricted procedures must not be exposed through public chatbot answers.
- Access to create, approve, edit, or retire entries should follow the permissions defined by the project.
- Knowledge-base entries must not be used to bypass Laravel authorization or validation.

## 9. Updates and Maintenance

Every knowledge-base update should follow a controlled process:

1. Identify the entry that needs to be added or changed.
2. Record the reason for the change and the proposed source.
3. Obtain confirmation from the appropriate authorized source.
4. Review the proposed wording for accuracy and clarity.
5. Update the entry and record the revision.
6. Record the reviewer and verification date.
7. Publish the update only after the required approval.
8. Flag conflicting, outdated, or withdrawn information so it is no longer used as confirmed guidance.

The team must determine who owns ongoing maintenance and how frequently entries should be reviewed.

## 10. Relationship to the Chatbot and Laravel

The knowledge base supplies information that the chatbot can use to answer service inquiries. It does not replace the application's business rules or authorization checks.

### Chatbot and orchestrator responsibilities

- Identify the citizen's information need.
- Retrieve relevant approved knowledge-base entries, once retrieval is implemented.
- Present information in understandable language.
- Ask for clarification when needed.
- Explain when information is missing or unverified.
- Refer questions to an approved human assistance route when necessary.

### Laravel and authorized system responsibilities

- Enforce authentication and authorization.
- Validate and persist submissions.
- Manage official application or report status.
- Control access to private records.
- Maintain authorized workflow, audit, and notification behavior.
- Apply approved business rules.

These responsibilities must remain aligned with the agreed API contract and implementation decisions. Any technical integration details that have not been approved remain pending confirmation.

## 11. Open Questions

The project team and authorized barangay representatives need to confirm:

- Which services are officially available in the target barangay?
- Which documents are the authoritative source for each service?
- Who can verify and approve service information?
- What fees, processing times, and office schedules may be published?
- Which services require an in-person transaction?
- What approved contact or referral route should the chatbot provide?
- How frequently should entries be reviewed?
- Who maintains the knowledge base after deployment?
- How should conflicting official sources be resolved?
- What technical format and retrieval method will the chatbot use?
- Which entries, if any, are required for the initial prototype?

Until these questions are resolved, affected information must remain clearly marked as pending confirmation.

## 12. Acceptance Criteria

PB-21 can be considered ready for team review when:

- [ ] The knowledge-base purpose and scope are documented.
- [ ] A reusable structure for service entries is defined.
- [ ] An initial service inventory is available for confirmation.
- [ ] Verification statuses and source requirements are defined.
- [ ] A verification checklist is included.
- [ ] Rules for missing, conflicting, and outdated information are documented.
- [ ] Citizen-friendly response guidelines are included.
- [ ] Privacy and access-control boundaries are described.
- [ ] A maintenance and approval process is proposed.
- [ ] The responsibilities of the chatbot and Laravel are distinguished.
- [ ] Unconfirmed policies and technical decisions are explicitly identified.
- [ ] The document has been reviewed by the project team.

These criteria describe documentation readiness; they do not prove that a working knowledge-base retrieval feature has been implemented.

## 13. Next Steps

1. Review this draft with the project team.
2. Obtain authorized sources for the services in scope.
3. Confirm the service inventory and approval responsibilities.
4. Populate entries only when supporting information is available.
5. Resolve outstanding questions about knowledge-base integration.
6. Revise this document based on feedback.
7. Commit and share the reviewed draft according to the team's Git workflow.

**Document status:** Draft — Pending Team Review and Barangay Verification.
