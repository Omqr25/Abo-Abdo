<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CalculateMonthlyExpenses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expenses:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and save monthly expenses for the previous month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
