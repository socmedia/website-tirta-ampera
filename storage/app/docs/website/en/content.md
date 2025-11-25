# Content

## Table of Contents

1. [Description](#description)
2. [Main Features](#main-features)
    - [View Listing](#1-view-listing)
    - [Edit Translation](#2-edit-translation)
3. [Content Form Requirements](#content-form-requirements)
4. [Notes](#notes)

---

## Description

The **Content** menu is used to manage static content on the website.  
Content is grouped by **tab (page)** and **section** within each page.

Example:

-   Page: `About Us`
-   Section: `Milestone`, `Team`, `Testimonial`

Administrators can search, filter by tab/section, switch display language, and edit content translations.

📍 URL: [/panel/content](/panel/content)

---

## Main Features

### 1. View Listing

Displays a list of static content based on filters:

-   **Tab** → main page (e.g., About, Contact, Home).
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
📍 URL: `/panel/content/{id}/edit`

Administrators can:

-   Edit the **name** (content title) for each language.
-   Edit the **value** (content body) for each language.
-   Save translation changes directly from the listing.

---

## Content Form Requirements

-   **page** → required, string, max 255 characters.
-   **section** → required, string, max 255 characters.
-   **key** → required, string, max 255 characters, unique in the `contents` table.
-   **type** → required, string, max 50 characters.
-   **meta** → optional (additional metadata).
-   **translations** → array containing multilingual data:
    -   **name** → required, string, max 255 characters.
    -   **value** → required (content in the respective language).

---

## Notes

-   **Content** is static → can only be **edited**, not **added** or **deleted** via the panel.
-   Each content supports **multiple languages** with the `translations` field.
-   Tabs and sections are obtained from configuration/enums, not added manually.
-   Data listing uses **ContentService** with filters: search, sort, tab, section, locale, and pagination.
