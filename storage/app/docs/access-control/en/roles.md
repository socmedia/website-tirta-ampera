# Roles

## Description

The **Roles** menu is used to group access rights (permissions) that can be assigned to users.  
With roles, administrators can more easily manage authorization without having to assign permissions to users one by one.

📍 URL: [/panel/access-control/role](/panel/access-control/role)

## Main Features

-   **View Listing** → Displays all roles with columns:
    -   `Name`
    -   `Total Permission`
    -   `Guard`
    -   `Created`
    -   `Actions`  
        Supports search, guard filter, sorting, and pagination.
-   **Edit** → Update role information, including adding or removing related permissions.
-   **Show (optional)** → View complete role details along with the attached permissions.

## Form Validation

-   **Name** → Required, minimum 3 characters, unique per guard.
-   **Guard Name** → Required, must match one of the available guards.

## Notes

-   Roles are the most efficient way to manage a large number of permissions.
-   A user can have more than one role.
-   Delete roles carefully, especially if they are already assigned to many users.
