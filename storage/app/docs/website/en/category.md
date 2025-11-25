# Category

## Table of Contents

1. [Description](#description)
2. [Main Features](#main-features)
    - [View Listing](#1-view-listing)
    - [Filter by Group & Status](#2-filter-by-group--status)
    - [Show Category](#3-show-category)
    - [Update Order](#4-update-order)
    - [Delete Category](#5-delete-category)
3. [Category Form Requirements](#category-form-requirements)
4. [Notes](#notes)

---

## Description

The **Category** menu is used to manage the list of categories for various available **groups**.  
Categories serve as a way to group data, such as: products, posts, investor documents, FAQs, and more.

📍 URL: [/panel/{page}/category](/panel/{page}/category)

Several default category groups are available:

-   **departments**
-   **investor_documents**
-   **faqs**
-   **notifications**
-   **posts**
-   **products**
-   **stores**

---

## Main Features

### 1. View Listing

Displays a list of categories based on the selected filters.  
Available columns:

-   **Name** → category name (multi-language).
-   **Description** → category description.
-   **Status** → active/inactive status.
-   **Featured** → whether the category is marked as featured.
-   **Created** → creation date.
-   **Action** → action buttons (edit, delete, view).

Additional features:

-   **Search** → search by name/description.
-   **Sorting** → sort by columns (name, status, featured, created).
-   **Pagination** → navigate through category data pages.

### 2. Filter by Group & Status

-   **Group** → filter categories by group (e.g., only `products` or `faqs`).
-   **Status** → filter categories by status (`all`, `active`, `inactive`).

The group tab also displays the number of categories in each group.

### 3. Show Category

Displays the details of the selected category, including subcategories if available.  
Details are retrieved from `CategoryService::findByIdWithSubcategories`.

### 4. Update Order

Categories can be reordered using **drag & drop**.  
Order changes are saved to the database via `CategoryService::updateOrder`.

If you are viewing category details, the subcategory order will also be updated automatically.

### 5. Delete Category

Categories can be deleted using the **Delete** button.  
After deletion, the category will be removed from the list.

This action is only available to users with the **delete-category** permission.

---

## Category Form Requirements

-   **group** → required, string.
-   **meta** → optional (additional metadata).
-   **featured** → boolean, default `false`.
-   **translations** → multi-language array:
    -   **name** → required, string, max 255 characters.
    -   **description** → optional, string, max 1000 characters.

---

## Notes

-   **Category** is available for various groups (`departments`, `investor_documents`, `faqs`, `notifications`, `posts`, `products`, `stores`).
-   Supports **multi-language** via the `translations` field.
-   **Category order** can be changed with drag & drop.
-   Sensitive actions (delete) require confirmation.
-   Access is controlled by permissions:
    -   `create-{page}-category`
    -   `update-{page}-category`
    -   `delete-{page}-category`
