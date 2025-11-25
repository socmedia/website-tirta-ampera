## **Roles and Permissions**

This documentation provides a detailed overview of the **roles** and their corresponding **permissions** for the ARAHCoffee website. The Role-Based Access Control (RBAC) ensures users only have access to the functionalities they are authorized for, improving security and efficiency for an IPO-ready company.

---

### **1. User and Access Control**
Access Control governs who can **view, create, update, and delete** users, roles, and permissions within the system.

| **Action** | **Permission Key** | **Roles Allowed** |
| :--- | :--- | :--- |
| View ACL Dashboard | `view-acl-dashboard` | Developer, Super Admin |
| View Permissions | `view-permission` | Developer, Super Admin |
| Manage Permissions | `create-permission, update-permission, delete-permission` | Developer |
| View Roles | `view-role` | Developer, Super Admin |
| Manage Roles | `create-role, update-role, delete-role` | Developer |
| View Users | `view-user` | Developer, Super Admin, Admin |
| Manage Users | `create-user, update-user, delete-user` | Developer, Super Admin |
| View Sessions | `view-session` | Developer, Super Admin |

**Developers** and **Super Admins** have a strict hierarchy of control over the system's security settings.

---

### **2. Content Management**
Content Management permissions allow users to handle website content like posts, pages, and general content blocks.

| **Action** | **Permission Key** | **Roles Allowed** |
| :--- | :--- | :--- |
| View Posts | `view-post` | Developer, Super Admin, Admin |
| Manage Posts | `create-post, update-post, delete-post` | Developer, Super Admin, Admin |
| Manage Post Categories | `create-post-category, update-post-category, delete-post-category` | Developer, Super Admin, Admin |
| View Pages | `view-page` | Developer, Super Admin, Admin |
| Manage Pages | `create-page, update-page, delete-page` | Developer, Super Admin, Admin |
| View Content | `view-content` | Developer, Super Admin, Admin |
| Manage Content | `create-content, update-content, delete-content` | Developer, Super Admin, Admin |

**Admins** and **Super Admins** manage the website's content, while **Developers** can handle structural changes.

---

### **3. Product and Store Management**
These permissions allow for the management of product catalogs and physical store locations.

| **Action** | **Permission Key** | **Roles Allowed** |
| :--- | :--- | :--- |
| Manage Products | `view-product, create-product, update-product, delete-product` | Developer, Super Admin, Admin |
| Manage Product Categories | `view-product-category, create-product-category, update-product-category, delete-product-category` | Developer, Super Admin, Admin |
| Manage Stores | `view-store, create-store, update-store, delete-store` | Developer, Super Admin, Admin |
| Manage Store Categories | `view-store-category, create-store-category, update-store-category, delete-store-category` | Developer, Super Admin, Admin |

**Admins** and **Super Admins** are responsible for keeping product and store information up-to-date.

---

### **4. Human Resources & Careers**
Permissions in this section are specifically for handling job postings and applicant data.

| **Action** | **Permission Key** | **Roles Allowed** |
| :--- | :--- | :--- |
| Manage Careers | `view-career, create-career, update-career, delete-career` | Developer, Super Admin, Human Resource |
| Manage Career Categories | `view-career-category, create-career-category, update-career-category, delete-career-category` | Developer, Super Admin, Human Resource |
| Manage Applicants | `view-career-applicants, update-career-applicants, delete-career-applicants` | Developer, Super Admin, Human Resource |

The **Human Resources** role has dedicated access to the career section to handle all recruitment needs.

---

### **5. Investor Relations**
This is a critical section for an IPO-ready company, with permissions for managing public and financial documents.

| **Action** | **Permission Key** | **Roles Allowed** |
| :--- | :--- | :--- |
| View Investor Content | `view-investor` | Developer, Super Admin, Admin, Finance |
| View Investor Documents | `view-investor-documents` | Developer, Super Admin, Admin, Finance |
| Manage Investor Categories | `create-investor-category, update-investor-category, delete-investor-category` | Developer, Super Admin, Admin, Finance |

The **Finance** team can securely manage sensitive investor-related content.

---

### **6. Marketing and Customer Engagement**
These permissions control marketing materials, customer data, and communication channels.

| **Action** | **Permission Key** | **Roles Allowed** |
| :--- | :--- | :--- |
| Manage Sliders | `view-slider, create-slider, update-slider, delete-slider` | Developer, Super Admin, Admin |
| Manage Instagram Content | `view-instagram, create-instagram, update-instagram, delete-instagram` | Developer, Super Admin, Admin |
| Manage Collaboration Requests | `view-collaboration-request, update-collaboration-request, delete-collaboration-request` | Developer, Super Admin, Admin |
| Manage Customers | `view-customer, create-customer, update-customer, delete-customer` | Developer, Super Admin, Admin |
| Manage Contact Messages | `view-contact-message, update-contact-message, delete-contact-message` | Developer, Super Admin, Admin |
| Manage SEO | `view-seo, create-seo, update-seo, delete-seo` | Developer, Super Admin |

**Admins** and **Super Admins** are the primary roles for managing marketing and customer-facing content.

---

### **7. System & Dashboard Access**
These permissions control access to the system dashboard and core settings.

| **Action** | **Permission Key** | **Roles Allowed** |
| :--- | :--- | :--- |
| View Dashboard | `view-dashboard` | Developer, Super Admin, Admin, Finance, Human Resource |
| Manage FAQs | `view-faq, create-faq, update-faq, delete-faq` | Developer, Super Admin, Admin |
| Manage Settings | `view-setting, create-setting, update-setting, delete-setting` | Developer, Super Admin, Admin |
| View Notifications | `view-notification` | Developer, Super Admin, Admin |

All key personnel have access to the dashboard to monitor their respective areas.

---

### **Summary of Role Permissions**

| **Role** | **Permissions** |
| :--- | :--- |
| **Developer** | Full control over the entire system, including core permissions and security settings. |
| **Super Admin** | Full access to most modules, including user management and content, but no control over core permissions. |
| **Admin** | Manages content, products, stores, marketing, and customer communication. |
| **Finance** | Specialized access to the Investor Relations section and dashboard. |
| **Human Resource** | Dedicated access to manage career postings and applicants. |

This clear breakdown ensures each department can manage their responsibilities efficiently and securely.
