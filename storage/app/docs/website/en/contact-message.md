# Contact Message

## Table of Contents

1. [Description](#description)
2. [Main Features](#main-features)
    - [View Listing](#1-view-listing)
    - [Show Message](#2-show-message)
    - [Mark as Seen / Unseen](#3-mark-as-seen--unseen)
    - [Delete Message](#4-delete-message)
    - [Export](#5-export)
3. [Notes](#notes)

---

## Description

The **Contact Message** menu is used to manage incoming messages from the **Contact Us** form or other integrated communication sources.

Administrators can:

-   View the list of incoming messages.
-   Open the details of a specific message.
-   Mark messages as **seen** or **unseen**.
-   Delete messages.
-   Export message data (xlsx, csv).

📍 URL: [/panel/public-message](/panel/public-message)

---

## Main Features

### 1. View Listing

Displays a list of messages with filters:

-   **Tab** → `All`, `Seen`, `Unseen`.
-   **Search** → search by name/email/subject.
-   **Pagination / Infinite Scroll** → the list will automatically load more data when scrolling near the end.

Columns available in the listing:

-   **Name/Email** → message sender.
-   **Subject** → message subject (or "No Subject" if empty).
-   **Message (excerpt)** → summary of the message content.
-   **Created At** → time the message was received.

### 2. Show Message

Displays message details when selected from the sidebar. Information shown:

-   **Subject** → message subject.
-   **From** → sender's name and email.
-   **Date** → time the message was sent.
-   **Message** → full message content.

Quick action buttons are also available:

-   **Email** → opens the email application to reply.
-   **WhatsApp** → if a WhatsApp number is available, directly opens a chat with the sender.

### 3. Mark as Seen / Unseen

-   **Mark as Seen** → marks an unread message as read.
-   **Mark as Unseen** → marks a read message as unread.

Messages are automatically marked as **seen** when opened.

### 4. Delete Message

Messages can be deleted using the **Remove** button.

-   After deletion, the message will disappear from the list.
-   This action is only available to users with the **delete-contact-message** permission.

### 5. Export

Message data can be exported in several formats:

-   **.xlsx**
-   **.csv**

Export will use the currently active filters (tab & search).  
The export process uses **Laravel Excel (Maatwebsite/Excel)**.

---

## Notes

-   Messages can only be **viewed**, **marked as seen/unseen**, **deleted**, and **exported**.
-   Messages cannot be created or edited from the panel (they only come from users via the Contact form).
-   Infinite scroll is used to load the next messages, replacing classic pagination.
-   Sensitive actions (delete) require a confirmation modal.
-   Access rights are controlled via **permissions** (`view-contact-message`, `update-contact-message`, `delete-contact-message`).
