<?php

namespace Database\Seeders;

use App\Models\InvoiceGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InvoiceGroup::factory(30)->create();
    }
}
