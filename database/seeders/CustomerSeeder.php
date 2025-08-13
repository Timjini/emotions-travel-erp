<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        // Get a user to set as created_by
        $user = User::first() ?? User::factory()->create();

        $countries = ['United States', 'United Kingdom', 'Germany', 'France', 'Italy', 'Spain', 'Netherlands', 'Belgium'];
        $customerTypes = ['client', 'supplier', 'client_and_supplier', 'accommodation'];
        $categories = ['guide', 'hotel', 'agency', 'corporate', 'individual'];
        $statuses = ['active', 'inactive', 'pending', 'suspended'];
        $languages = ['en', 'fr', 'de', 'es', 'it', 'nl'];
        $sources = ['website', 'referral', 'trade show', 'social media', 'cold call'];

        $customers = [];

        for ($i = 1; $i <= 20; $i++) {
            $isCompany = rand(0, 1);
            $name = $isCompany
                ? fake()->company()
                : fake()->name();

            $invoicingEntity = $isCompany
                ? $name
                : fake()->company();

            $customers[] = [
                'id' => Str::uuid(),
                'name' => $name,
                'invoicing_entity' => $invoicingEntity,
                'email' => $isCompany ? fake()->companyEmail() : fake()->safeEmail(),
                'contact_person' => $isCompany ? fake()->name() : null,
                'website' => $isCompany ? 'https://'.fake()->domainName() : null,
                'address' => fake()->streetAddress(),
                'post_code' => fake()->postcode(),
                'city' => fake()->city(),
                'district' => rand(0, 1) ? fake()->state() : null,
                'country' => fake()->randomElement($countries),
                'phone_1' => fake()->phoneNumber(),
                'phone_2' => rand(0, 1) ? fake()->phoneNumber() : null,
                'vat_number' => $isCompany ? 'GB'.fake()->randomNumber(9, true) : null,
                'type' => $isCompany ? fake()->randomElement($customerTypes) : 'individual',
                'category' => $isCompany ? fake()->randomElement($categories) : null,
                'iban' => $isCompany ? fake()->iban() : null,
                'swift_code' => $isCompany ? fake()->swiftBicNumber() : null,
                'status' => fake()->randomElement($statuses),
                'preferred_language' => fake()->randomElement($languages),
                'notes' => rand(0, 1) ? fake()->paragraph() : null,
                'source' => fake()->randomElement($sources),
                'created_by' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('customers')->insert($customers);
    }
}
