<?php

namespace App\Console\Commands;

use App\Voter;
use Illuminate\Console\Command;
use League\Csv\Reader;

class UpdateVoterLatLongCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voters:update-lat-long';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        foreach ($this->getFileList() as $file) {
            $reader = $this->readCsv($file);
    
            foreach ($reader as $index => $row) {
                $this->updateVoterInfo($row);
            }
            
            $this->info("Completed {$file}");
        }
    }
    
    /**
     * Returns array containing the files we will be parsing.
     *
     * @return array
     */
    protected function getFileList()
    {
        return [
            'address_list_1.csv',
            'address_list_2.csv',
            'address_list_3.csv',
            'address_list_4.csv',
            'address_list_5.csv',
            'address_list_6.csv',
        ];
    }
    
    /**
     * Reads the CSV file.
     *
     * @return \League\Csv\Reader
     */
    protected function readCsv($file)
    {
        $file = storage_path("data/{$file}");
        
        return Reader::createFromPath($file, 'r');
    }
    
    /**
     * Updates the voter's info.
     *
     * @param $row
     */
    protected function updateVoterInfo($row)
    {
        if ($row[2] == 'Match') {
            list($long, $lat) = explode(',', $row[5]);
            
            Voter::find($row[0])
                ->update([
                    'latitude' => $lat,
                    'longitude' => $long
                ]);
        }
    }
}
