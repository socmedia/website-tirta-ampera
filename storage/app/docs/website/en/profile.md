# Profile

## Table of Contents

1. [Description](#description)
2. [Main Features](#main-features)

    - [Account](#1-account)
    - [Preference](#2-preference)
    - [Security / Password](#3-security--password)

3. [Profile Form Requirements](#profile-form-requirements)
4. [Notes](#notes)

---

## Description

The **Profile** menu is used to manage user account information in the application.
It consists of 3 main sections:

-   **Account** → update name, email, and avatar.
-   **Preference** → theme settings (light/dark mode).
-   **Security / Password** → change account password.

📍 URL: [/panel/account](/panel/account)

---

## Main Features

### 1. Account

Manage user account information.

📍 URL: [/panel/account](/panel/account)

Features:

-   Update name and email.
-   Upload / change avatar.
-   Delete account (with password validation).
-   **avatarChanged** event to update the UI after the avatar is updated.

### 2. Preference

Manage application appearance (theme).

📍 URL: [/panel/preference](/panel/preference)

Features:

-   Choose **Light Mode**.
-   Choose **Dark Mode**.
-   Theme is stored in the `$store.ui` state.

### 3. Security / Password

Manage account security by changing the password.

📍 URL: [/panel/security](/panel/security)

Features:

-   Input **Current Password** (required validation).
-   Input **New Password**.
-   Input **Confirm New Password**.
-   Update password button with spinner loader.
-   Toggle **show/hide password** using the `bx-eye` icon.

---

## Profile Form Requirements

### Account

-   **Name** → required, string, maximum 191 characters.
-   **Email** → required, valid and unique email.
-   **Avatar** → optional, image file (if provided, replaces the old avatar).
-   **Current Password** → required when deleting the account.

### Preference

-   **Theme** → required, string, only `light` or `dark`.

### Security / Password

-   **Current Password** → required, string, minimum 8 characters.
-   **Password** → required, string, minimum 8 characters.
-   **Password Confirmation** → required, must match `password`.

---

## Notes

-   The old avatar will be automatically deleted when replaced with a new one.
-   When deleting an account, the system will automatically log out and redirect to the login page.
-   Preferences (theme) are stored on the frontend using Alpine Store (`$store.ui`).
-   Password validation follows Laravel's built-in `current_password:web` rule.
-   All forms use **Livewire** with real-time validation support.
