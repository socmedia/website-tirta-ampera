# Post

## Table of Contents

1. [Description](#description)
2. [Main Features](#main-features)
    - [View Listing](#1-view-listing)
    - [Create Post](#2-create-post)
    - [Edit Post](#3-edit-post)
    - [Show Post](#4-show-post)
    - [Delete Post](#5-delete-post)
3. [Post Form Requirements](#post-form-requirements)
4. [Notes](#notes)

---

## Description

The **Post** menu is used to manage article content on the website.  
Content types can be:

-   `news`
-   `article`

Administrators can add new posts, edit, view details, delete, as well as perform search, filter, sorting, and pagination.

📍 URL: [/panel/post](/panel/post)

---

## Main Features

### 1. View Listing

Displays a list of posts with the following columns:

-   **Title** (multi-language according to active locale)
-   **Author**
-   **Published By**
-   **Status**
-   **Created** (creation date)
-   **Actions** (show, edit, delete)

Additional features:

-   **Search** → search by title.
-   **Sorting** → default `created_at desc`.
-   **Filter Tabs** → by post type (`news`, `article`).
-   **Pagination** → set number of items per page.
-   **Locale Switcher** → change the display language of the listing.

### 2. Create Post

Add a new post.  
📍 URL: [/panel/post/create](/panel/post/create)

### 3. Edit Post

Edit an existing post.  
📍 URL: `/panel/post/{id}/edit`

### 4. Show Post

View details of a specific post.  
📍 URL: `/panel/post/{id}`

### 5. Delete Post

Delete a post using the action button.  
📍 URL: `/panel/post/{id}/delete`

---

## Post Form Requirements

-   **Category** → required, integer, must exist in the `categories` table.
-   **Type** → required, string, maximum 50 characters.
-   **Thumbnail** → required (main image of the post).
-   **Content** → optional, string type.
-   **Tags** → optional, string, maximum 255 characters.
-   **Translations** → must be an array.
    -   **locale** → required, string, maximum 10 characters.
    -   **title** → required, string, maximum 191 characters.
    -   **slug** → required, string, maximum 191 characters.
    -   **subject** → required, string, maximum 191 characters.
    -   **content** → required, string.

---

## Notes

-   Posts support **multi-language** through the `translations` field.
-   Post type (`news`, `article`) affects content grouping.
-   Default sorting → `created_at desc`.
-   Post status determines whether the content can be displayed on the frontend.
