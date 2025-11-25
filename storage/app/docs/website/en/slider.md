# Slider

## Table of Contents

1. [Description](#description)
2. [Main Features](#main-features)
    - [View Listing](#1-view-listing)
    - [Create Slider](#2-create-slider)
    - [Edit Slider](#3-edit-slider)
    - [Show Slider](#4-show-slider)
    - [Delete Slider](#5-delete-slider)
    - [Update Order](#6-update-order)
3. [Slider Form Requirements](#slider-form-requirements)
4. [Notes](#notes)

---

## Description

The **Slider** menu is used to manage slider content displayed on the website homepage, such as hero banners, promotions, and testimonials.  
Administrators can add new sliders, edit, view details, delete, and reorder sliders using drag & drop.

📍 URL: [/panel/slider](/panel/slider)

---

## Main Features

### 1. View Listing

Displays a list of sliders with the following columns:

-   **Heading** (multi-language according to active locale)
-   **Link** (meta / button URL)
-   **Status** (active/inactive)
-   **Created** (creation date)
-   **Actions** (show, edit, delete)

Additional features:

-   **Search** → search by heading.
-   **Sorting** → default `sort_order asc`, can be changed.
-   **Filter Tabs** → filter by slider type (`hero`, `featured`, `promotion`, `testimonial`, `milestone`, `stores`).
-   **Pagination** → set the number of items per page.

### 2. Create Slider

To add a new slider.  
📍 URL: [/panel/slider/create](/panel/slider/create)

### 3. Edit Slider

Edit an existing slider.  
📍 URL: `/panel/slider/{id}/edit`

-   All fields are the same as **Create**, but pre-filled with data from the database.
-   Validation remains the same.

### 4. Show Slider

View details of a specific slider.  
📍 URL: `/panel/slider/{id}`

Displayed data:

-   Heading & Sub Heading (per language/locale)
-   Description
-   Button Text + Button URL
-   Status (active/inactive)
-   Slider type
-   Media (desktop/mobile image)

### 5. Delete Slider

-   Delete a slider using the action button.

After successful deletion, a notification **“Slider deleted successfully”** will appear.

### 6. Update Order

Administrators can reorder **sliders** using drag & drop.  
After the order is updated, the system will display a notification **“Slider order updated successfully”**.

---

## Slider Form Requirements

When adding or editing a slider, the data must meet the following requirements:

-   **Status** → boolean (active/inactive).
-   **Type** → required, maximum 50 characters. Common values:  
    `hero`, `featured`, `promotion`, `testimonial`, `milestone`, `stores`.
-   **Media** → required, must upload an image.
-   **Heading** → required, maximum 191 characters.
-   **Sub Heading** → optional, maximum 50 characters.
-   **Description** → optional, maximum 191 characters.
-   **Button Text** → optional, maximum 100 characters.
-   **Button URL** → optional, maximum 191 characters.

---

## Notes

-   Slider supports **multi-language** via the `translations` field.
-   The slider order affects the frontend display.
-   Status determines whether the slider is shown on the website or not.
