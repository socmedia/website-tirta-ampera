# Permissions

## Description

The **Permissions** menu is used to display the list of permissions available in the system.  
These permissions are usually defined in the code or modules, and can then be grouped into **Roles**.

📍 URL: [/panel/access-control/permission](/panel/access-control/permission)

## Main Features

-   **View Listing** → Displays all permissions with columns:
    -   `Name`
    -   `Guard`
    -   `Created`
    -   `Actions`  
        Supports search, guard filter, sorting, and pagination.
-   **Show (optional)** → Permission details can be viewed when used in a Role.
-   **Delete** → Delete permissions (either individually or in bulk).

## Notes

-   Permissions are not added directly from this menu, but are defined in the code/module.
-   This menu mainly functions as a **viewer** to help administrators see the available permissions.
-   Main management is done through **Roles**, where permissions are assigned and then given to users.
