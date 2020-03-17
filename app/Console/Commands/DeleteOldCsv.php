<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteOldCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:csv {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old csv';

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
        $date = $this->argument('date');
        if ($date === null)
        {
            $date = Carbon::parse($date)->subDay()->format('Y/m/d');
        }
        else
        {
            $date = Carbon::parse($date)->format('Y/m/d');
        }
        $path = 'csv/'.$date;
        Storage::deleteDirectory($path)
            ? $this->info('Directory delete')
            : $this->info('Directory does not exist');
    }
}
