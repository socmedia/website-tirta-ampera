# SEO

## Table of Contents

1. [Description](#description)
2. [Main Features](#main-features)
    - [View Listing](#1-view-listing)
    - [Edit SEO](#2-edit-seo)
3. [SEO Form Requirements](#seo-form-requirements)
4. [Notes](#notes)

---

## Description

The **SEO** menu is used to manage SEO (Search Engine Optimization) data on the website.  
SEO data is grouped by **page** and **section** (if any), to configure meta tags, titles, descriptions, and other SEO data per page.

Example:

-   Page: `Home`, `About Us`, `Contact`
-   Section: `Hero`, `Footer` (optional, if SEO per section)

Administrators can search, filter by page/section, change display language, and edit multi-language SEO data.

📍 URL: [/panel/seo](/panel/seo)

---

## Main Features

### 1. View Listing

Displays a list of SEO data based on filters:

-   **Page** → main page (e.g., Home, About, Contact).
-   **Section** → part of the page (if any, e.g., Hero, Footer).
-   **Locale** → filter by active language.

Available columns:

-   **Title** → SEO title (per language).
-   **Created** → creation date.
-   **Actions** → button to edit SEO.

Additional features:

-   **Search** → search by keyword.
-   **Pagination** → SEO list navigation.
-   **Locale Switcher** → change display language.

### 2. Edit SEO

Edit SEO data for a specific page/section in a specific language.  
📍 URL: `/panel/seo/{id}/edit`

Administrators can:

-   Edit the **title** (SEO title) per language.
-   Edit the **description** (meta description) per language.
-   Edit the **keywords** (meta keywords) per language.
-   Save SEO changes directly from the listing.

---

## SEO Form Requirements

-   **page** → required, string, max 255 characters.
-   **section** → optional, string, max 255 characters.
-   **key** → required, string, max 255 characters, unique in the `seo` table.
-   **type** → required, string, max 50 characters (e.g., `meta`, `og`, `twitter`).
-   **meta** → optional (additional metadata).
-   **translations** → array containing multi-language data:
    -   **title** → required, string, max 255 characters.
    -   **description** → optional, string, max 500 characters.
    -   **keywords** → optional, string, max 255 characters.

---

## Notes

-   **SEO** can only be **edited**, not **added** or **deleted** via the panel.
-   Each SEO data supports **multi-language** with the `translations` field.
-   Page and section are obtained from configuration/enum, not added manually.
-   Data listing uses **SeoService** with filters: search, sort, page, section, locale, and pagination.
