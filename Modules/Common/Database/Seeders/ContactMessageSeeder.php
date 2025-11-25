<?php

namespace Modules\Common\Database\Seeders;

use Faker\Factory as Faker;
use Modules\Core\Models\User;
use Illuminate\Database\Seeder;
use Modules\Common\Models\ContactMessage;

class ContactMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $topics = [
            'helpdesk',
            'technical',
            'billing',
            'feedback',
            'general',
        ];

        // Get the developer user id once
        $developer = User::where('email', 'developer@app.com')->first();

        for ($i = 0; $i < 50; $i++) {
            $seenAt = $faker->optional(0.3)->dateTimeBetween('-1 month', 'now');
            ContactMessage::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'whatsapp_code' => 'id',
                'whatsapp_number' => (string) $faker->numberBetween(81200000000, 81999999999),
                'topic' => $faker->randomElement($topics),
                'subject' => $faker->sentence(6, true),
                'message' => $faker->paragraph(3, true),
                'seen_at' => $seenAt,
                'seen_by' => $seenAt ? ($developer?->id ?? null) : null,
                'created_at' => $faker->dateTimeBetween('-2 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}