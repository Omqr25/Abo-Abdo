<?php

namespace Database\Seeders;

use App\Models\Classification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classifications = [
            'غرف نوم',
            'طقوم مغلف',
            'مجالس عربي خليجي',
            'بواب عربي',
            'مطابخ',
            'ديكورات',
            'طاولات سفرة',
            'مكتبيات',
            'فرشات',
            'مفردات'
        ];
        for ($i = 0; $i < 10; $i++) {
            Classification::create([
                'name' => $classifications[$i]
            ]);
        }
    }
}
