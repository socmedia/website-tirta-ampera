# Page

## Table of Contents

1. [Description](#description)
2. [Main Features](#main-features)
    - [View Listing](#1-view-listing)
    - [Edit Translation](#2-edit-translation)
3. [Page Form Requirements](#page-form-requirements)
4. [Notes](#notes)

---

## Description

The **Page** menu is used to manage **static website content**, such as **Terms & Conditions** and **Privacy Policy**.  
Content is organized by **tab (page)** and **section** within each tab.

Example:

-   Page `About Us` → sections: `Milestone`, `Team`, `Testimonial`.
-   Page `Terms & Conditions` → sections: `General Terms`, `User Obligations`.

Administrators can search, filter by tab/section, switch display language, and edit translation content.

📍 URL: [/panel/page](/panel/page)

---

## Main Features

### 1. View Listing

Displays a list of static content based on filters:

-   **Tab** → main page (e.g., About, Contact, Terms).
-   **Section** → part of the page (e.g., Hero, Milestone, Footer).
-   **Locale** → filter by active language.

Available columns:

-   **Name** → content title/name.
-   **Created** → creation date.
-   **Actions** → button to edit translation.

Additional features:

-   **Search** → search by keyword.
-   **Pagination** → navigate content list.
-   **Locale Switcher** → change display language.

### 2. Edit Translation

Edit the content of a specific section in a specific language.  
📍 URL: `/panel/page/{id}/edit`

---

## Page Form Requirements

-   **page** → required, string, max 255 characters.
-   **section** → required, string, max 255 characters.
-   **key** → required, string, max 255 characters, unique in the `contents` table.
-   **type** → required, string, max 50 characters.
-   **meta** → optional (additional metadata).
-   **translations** → array containing multilingual data:
    -   **name** → required, string, max 255 characters.
    -   **value** → required (content value for each language).

---

## Notes

-   **Page** is static: it can only be **edited**, not added or deleted via the panel.
-   Each content supports **multiple languages** using the `translations` field.
-   Tabs and sections are obtained from configuration/enums, not added manually.
