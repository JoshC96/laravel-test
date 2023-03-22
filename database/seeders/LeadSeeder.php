<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

/**
 * @package Database\Seeders
 */
class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lead::factory()
            ->count(15)
            ->state(new Sequence(
                fn ($sequence) => ['id' => substr(uniqid(),0,4)],
            ))
            ->create()
            ->each(function ($lead) {
                $address = Address::factory()->create();
            });
    }
}
