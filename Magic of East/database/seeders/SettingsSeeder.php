<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'password','facebook','instagram','phone','mobile'
        ];

        $values = [
            'password','https://www.facebook.com/profile.php?id=100063885351713&mibextid=ZbWKwL','https://www.facebook.com/profile.php?id=100063885351713&mibextid=ZbWKwL','011 566 0010','+963 938 677 759 / +963 998 116 660 / +963 958 694 044'
        ];

        for ($i = 0; $i < 5; $i++) {
            Settings::create([
                'name' => $names[$i],
                'value'=>$values[$i]
            ]);
        }
    }
}
