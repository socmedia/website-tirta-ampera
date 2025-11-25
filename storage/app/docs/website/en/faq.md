# FAQ (Investor)

## Table of Contents

1. [Description](#description)
2. [Main Features](#main-features)
    - [View Listing](#1-view-listing)
    - [Create](#2-create)
    - [Edit](#3-edit)
    - [Show](#4-show-optional)
    - [Delete](#5-delete)
    - [Reorder](#6-reorder)
3. [FAQ Form Requirements](#faq-form-requirements)
4. [Notes](#notes)

---

## Description

The **FAQ (Investor)** menu is used to manage a list of frequently asked questions from the public and investors.  
Admins can add questions & answers in multiple languages, set the status (active/inactive), and mark certain FAQs as **Featured**.

📍 URL: [/panel/investor/faq](/panel/investor/faq)

---

## Main Features

### 1. View Listing

Displays a list of FAQs with filters for status and language.

Available columns:

-   **Question** → main question (multi-language).
-   **Status** → active/inactive.
-   **Featured** → marked as featured or not.
-   **Created** → creation date.
-   **Actions** → edit, show, or delete.

Additional features:

-   **Search** → search by question keyword.
-   **Pagination** → navigate the FAQ list.
-   **Locale Switcher** → change display language.
-   **Tabs** → filter by FAQ status.

### 2. Create

Add a new question to the FAQ list.  
📍 URL: `/panel/investor/faq/create`

### 3. Edit

Edit existing FAQ data.  
📍 URL: `/panel/investor/faq/{id}/edit`

### 4. Show (Optional)

Display FAQ details including all translations.  
📍 URL: `/panel/investor/faq/{id}`

### 5. Delete

Delete a specific FAQ.

### 6. Reorder

Reorder FAQs using **drag & drop** as needed.

---

## FAQ Form Requirements

-   **status** → boolean (true/false), determines if the FAQ is displayed on the website.
-   **featured** → boolean, mark if the FAQ should be shown in a special section.
-   **category** → required, options:
    -   `General`
    -   `Investor & Finance`
    -   `Investor Information`
-   **translations** → multi-language array containing:
    -   **question** → required, string, max 255 characters.
    -   **answer** → required, string, max 2000 characters.

---

## Notes

-   FAQs support **multiple languages**.
-   FAQs can only be **added, edited, viewed, deleted, and reordered**.
-   There is no **bulk delete** feature.
-   Use categories to make FAQs more structured and easier to find.
