<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class IndexCalculation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oras:index_calc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Oras ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //prepare working files ....
        
    }
}
