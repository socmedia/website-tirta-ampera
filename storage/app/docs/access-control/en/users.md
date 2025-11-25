# Users

## Description

The **Users** menu is used to manage user accounts that have access to the system.  
Administrators can create, update, delete, and assign roles to each user as needed.

📍 URL: [/panel/access-control/user](/panel/access-control/user)

## Main Features

-   **View Listing** → Displays all users with columns: `Name`, `Email`, `Roles`, `Created`, and `Actions`.  
    Supports search, guard filter, sorting, and pagination.
-   **Create** → Add a new user with the following data:
    -   Full name
    -   Email (unique)
    -   Password & password confirmation
    -   Role (can be more than one)
-   **Edit** → Update existing user information, including password reset and role update.
-   **Show (optional)** → View complete user details along with their roles.
-   **Delete** → Delete users individually or in bulk (bulk delete).

## Form Validation

-   **Name** → Required, minimum 3 characters
-   **Email** → Required, valid email format, must be unique
-   **Password** → Required, minimum 8 characters, must be confirmed
-   **Roles** → Optional, can be more than one, must match existing roles

## Notes

-   Passwords can be configured to be stricter (combination of uppercase, numbers, symbols).
-   It is recommended that each user has at least **one role**.
-   Use the bulk delete feature with caution, as deleted data cannot be recovered.
