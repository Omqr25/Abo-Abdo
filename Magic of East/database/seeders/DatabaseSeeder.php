<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([UserSeeder::class]);
        $this->call([ClassificationSeeder::class]);
        $this->call([WorkshopSeeder::class]);
        $this->call([GroupSeeder::class]);
        $this->call([ItemSeeder::class]);
        $this->call([CustomerSeeder::class]);
        $this->call([InvoiceSeeder::class]);
        $this->call([InvoiceGroupSeeder::class]);
        $this->call([EmployeeSeeder::class]);
        // $this->call([ExpenseSeeder::class]);
    }
}
