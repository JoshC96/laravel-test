<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Lead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lead::factory()
        //     ->count(15)
        //     ->state(new Sequence(
        //         fn ($sequence) => ['id' => rand(0, 1299)],
        //     ))
        //     ->create()
        //     ->each(function ($lead) {
        //         $address = Address::factory()->create();
        //     });

        // Initial approach before discovering factory methods
        $first_lead = Lead::create([
            'first_name' => 'John Doe',
            'last_name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '041034567',
            'electric_bill' => 600,
        ]);

        $second_lead = Lead::create([
            'first_name' => 'Josh',
            'last_name' => 'Campbell',
            'email' => 'josh.c@example.com',
            'phone' => '+64 2134 1235',
            'electric_bill' => 100
        ]);

        $third_lead = Lead::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'j.smith@example.com',
            'phone' => '+61 8377 8500',
            'electric_bill' => 350
        ]);

        $first_address = Address::create([
            'street' => 'Penny Place',
            'city' => 'Adelaide',
            'state' => 'SA',
            'zip' => '5000',
            'lead_id' => $first_lead->id
        ]);

        $second_address = Address::create([
            'street' => 'Fake Street',
            'city' => 'Madagascar',
            'state' => 'MG',
            'zip' => '58791',
            'lead_id' => $second_lead->id
        ]);

        $third_address = Address::create([
            'street' => 'Pirie Street',
            'city' => 'Los Angeles',
            'state' => 'CA',
            'zip' => '90005',
            'lead_id' => $third_lead->id
        ]);

    }
}
