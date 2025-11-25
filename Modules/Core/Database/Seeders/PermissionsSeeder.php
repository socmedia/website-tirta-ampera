<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (array_keys($this->permissions()) as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                [
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ]
            );
        }
    }

    /**
     * Generate permission datas based on route structure
     *
     * @return array
     */
    public function permissions()
    {
        return [
            // Dashboard
            'view-dashboard' => ['Developer', 'Super Admin', 'Admin', 'Finance', 'Human Resource'],

            // Access Control
            'view-acl-dashboard' => ['Developer', 'Super Admin'],
            'view-permission' => ['Developer', 'Super Admin'],
            'create-permission' => ['Developer'],
            'update-permission' => ['Developer'],
            'delete-permission' => ['Developer'],
            'view-role' => ['Developer', 'Super Admin'],
            'create-role' => ['Developer'],
            'update-role' => ['Developer'],
            'delete-role' => ['Developer'],
            'view-session' => ['Developer', 'Super Admin'],
            'view-user' => ['Developer', 'Super Admin', 'Admin'],
            'create-user' => ['Developer', 'Super Admin'],
            'update-user' => ['Developer', 'Super Admin'],
            'delete-user' => ['Developer', 'Super Admin'],

            // Content Management
            // Posts
            'view-post' => ['Developer', 'Super Admin', 'Admin'],
            'create-post' => ['Developer', 'Super Admin', 'Admin'],
            'update-post' => ['Developer', 'Super Admin', 'Admin'],
            'delete-post' => ['Developer', 'Super Admin', 'Admin'],
            // Post Category
            'view-post-category' => ['Developer', 'Super Admin', 'Admin'],
            'create-post-category' => ['Developer', 'Super Admin', 'Admin'],
            'update-post-category' => ['Developer', 'Super Admin', 'Admin'],
            'delete-post-category' => ['Developer', 'Super Admin', 'Admin'],

            // Pages & Content
            // Content
            'view-content' => ['Developer', 'Super Admin', 'Admin'],
            'create-content' => ['Developer'],
            'update-content' => ['Developer', 'Super Admin', 'Admin'],
            'delete-content' => ['Developer'],
            // Page
            'view-page' => ['Developer', 'Super Admin', 'Admin'],
            'create-page' => ['Developer'],
            'update-page' => ['Developer', 'Super Admin', 'Admin'],
            'delete-page' => ['Developer'],

            // Products
            'view-product' => ['Developer', 'Super Admin', 'Admin', 'Product'],
            'create-product' => ['Developer', 'Super Admin', 'Admin', 'Product'],
            'update-product' => ['Developer', 'Super Admin', 'Admin', 'Product'],
            'delete-product' => ['Developer', 'Super Admin', 'Admin', 'Product'],
            // Product Category
            'view-product-category' => ['Developer', 'Super Admin', 'Admin', 'Product'],
            'create-product-category' => ['Developer', 'Super Admin', 'Admin', 'Product'],
            'update-product-category' => ['Developer', 'Super Admin', 'Admin', 'Product'],
            'delete-product-category' => ['Developer', 'Super Admin', 'Admin', 'Product'],

            // Stores
            'view-store' => ['Developer', 'Super Admin', 'Admin'],
            'create-store' => ['Developer', 'Super Admin', 'Admin'],
            'update-store' => ['Developer', 'Super Admin', 'Admin'],
            'delete-store' => ['Developer', 'Super Admin', 'Admin'],
            // Store Category
            'view-store-category' => ['Developer', 'Super Admin', 'Admin'],
            'create-store-category' => ['Developer', 'Super Admin', 'Admin'],
            'update-store-category' => ['Developer', 'Super Admin', 'Admin'],
            'delete-store-category' => ['Developer', 'Super Admin', 'Admin'],

            // Career
            'view-career' => ['Developer', 'Super Admin', 'Admin', 'Human Resource'],
            'create-career' => ['Developer', 'Super Admin', 'Human Resource'],
            'update-career' => ['Developer', 'Super Admin', 'Human Resource'],
            'delete-career' => ['Developer', 'Super Admin', 'Human Resource'],
            // Career Category
            'view-career-category' => ['Developer', 'Super Admin', 'Human Resource'],
            'create-career-category' => ['Developer', 'Super Admin', 'Human Resource'],
            'update-career-category' => ['Developer', 'Super Admin', 'Human Resource'],
            'delete-career-category' => ['Developer', 'Super Admin', 'Human Resource'],
            // Career Applicants
            'view-career-applicants' => ['Developer', 'Super Admin', 'Human Resource'],
            'update-career-applicants' => ['Developer', 'Super Admin', 'Human Resource'],
            'delete-career-applicants' => ['Developer', 'Super Admin', 'Human Resource'],

            // Investor
            'view-investor' => ['Developer', 'Super Admin', 'Admin', 'Finance'],
            'view-investor-documents' => ['Developer', 'Super Admin', 'Admin', 'Finance'],
            'view-investor-faq' => ['Developer', 'Super Admin', 'Admin'],
            // Investor Category
            'view-investor-category' => ['Developer', 'Super Admin', 'Admin', 'Finance'],
            'create-investor-category' => ['Developer', 'Super Admin', 'Admin', 'Finance'],
            'update-investor-category' => ['Developer', 'Super Admin', 'Admin', 'Finance'],
            'delete-investor-category' => ['Developer', 'Super Admin', 'Admin', 'Finance'],

            // Collaboration
            'view-collaboration-request' => ['Developer', 'Super Admin', 'Admin', 'Business Development', 'Marcom'],
            'update-collaboration-request' => ['Developer', 'Super Admin', 'Admin', 'Business Development', 'Marcom'],
            'delete-collaboration-request' => ['Developer', 'Super Admin', 'Admin', 'Business Development', 'Marcom'],

            // Marketing & Engagement
            'view-slider' => ['Developer', 'Super Admin', 'Admin'],
            'create-slider' => ['Developer', 'Super Admin', 'Admin'],
            'update-slider' => ['Developer', 'Super Admin', 'Admin'],
            'delete-slider' => ['Developer', 'Super Admin', 'Admin'],

            // SEO
            'view-seo' => ['Developer', 'Super Admin'],
            'create-seo' => ['Developer'],
            'update-seo' => ['Developer', 'Super Admin'],
            'delete-seo' => ['Developer'],

            // Instagram Content
            'view-instagram' => ['Developer', 'Super Admin', 'Admin'],
            'create-instagram' => ['Developer', 'Super Admin', 'Admin'],
            'update-instagram' => ['Developer', 'Super Admin', 'Admin'],
            'delete-instagram' => ['Developer', 'Super Admin', 'Admin'],

            // Customer Management
            'view-customer' => ['Developer', 'Super Admin', 'Admin'],
            'create-customer' => ['Developer', 'Super Admin', 'Admin'],
            'update-customer' => ['Developer', 'Super Admin', 'Admin'],
            'delete-customer' => ['Developer', 'Super Admin', 'Admin'],

            // Contact Message
            'view-contact-message' => ['Developer', 'Super Admin', 'Admin'],
            'update-contact-message' => ['Developer', 'Super Admin', 'Admin'],
            'delete-contact-message' => ['Developer', 'Super Admin'],

            // FAQ
            'view-faq' => ['Developer', 'Super Admin', 'Admin'],
            'create-faq' => ['Developer', 'Super Admin', 'Admin'],
            'update-faq' => ['Developer', 'Super Admin', 'Admin'],
            'delete-faq' => ['Developer', 'Super Admin', 'Admin'],
            // FAQ Category
            'view-faq-category' => ['Developer', 'Super Admin', 'Admin'],
            'create-faq-category' => ['Developer', 'Super Admin', 'Admin'],
            'update-faq-category' => ['Developer', 'Super Admin', 'Admin'],
            'delete-faq-category' => ['Developer', 'Super Admin', 'Admin'],

            // Settings
            'view-setting' => ['Developer', 'Super Admin', 'Admin'],
            'create-setting' => ['Developer', 'Super Admin'],
            'update-setting' => ['Developer', 'Super Admin'],
            'delete-setting' => ['Developer'],

            // Notification
            'view-notification' => ['Developer', 'Super Admin', 'Admin'],
        ];
    }
}
