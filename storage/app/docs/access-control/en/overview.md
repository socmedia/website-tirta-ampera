# Access Control – Overview

## Description

The **Access Control** module is used to manage who can access the application and its features.  
With this module, administrators can flexibly manage **users, roles, and permissions** to ensure security and proper access restrictions.

## Purpose

-   Provide a clear authentication and authorization mechanism.
-   Ensure each user can only access features according to their assigned roles and permissions.
-   Simplify access rights management on a large scale.

## Key Concepts

-   **Users** → Individuals who have an account to log into the system.
-   **Roles** → Groups of access rights (e.g., _Admin, Editor, Viewer_).
-   **Permissions** → Specific actions that can be performed (e.g., _create post, edit user, delete file_).
-   **Sessions** → User login history, useful for auditing and security.

## Basic Flow

1. The administrator creates **roles** according to the organization's needs.
2. Each role is assigned one or more **permissions**.
3. Users are assigned to one or more **roles**.
4. When a user logs in, the system determines their permissions based on their roles & permissions.

## Notes

-   Use roles to group users with similar responsibilities.
-   Avoid granting permissions directly to individual users (preferably assign via roles).
-   Always check the **sessions** history to monitor login activities.
