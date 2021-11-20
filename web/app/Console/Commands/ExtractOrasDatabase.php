<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use File;

use    App\House;
use    App\Apartament;
use    App\Measurement;

use Carbon\Carbon;

class ExtractOrasDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oras:extract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract Oras Database';

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
        $this->error('Works only with ... one House');
        // $orasDb = File::get(storage_path('db.json'));
        // $orasDbJson = json_decode($orasDb);
        // var_dump(count($orasDbJson));   

        // $houses = \JsonMachine\JsonMachine::fromFile(storage_path('db.json'));
        // foreach ($houses as $house) {
        //     dd($house);
        // }
        House::truncate();
        Apartament::truncate();
        Measurement::truncate();

        $files = scandir(storage_path('to_migrate'));

        $house = new House();
        $house->save();

        foreach($files as $file) {
            if (strpos($file, '..') > -1){
                continue;
            }

            if ('.' ==  $file){
                continue;
            }
          
            $fileSplit = explode("-", $file);

            // Apartament

            $apartmentRequest = Apartament::where('number', $fileSplit[0]);

            if ($apartmentRequest->count() > 0){
                $aparmentModel = $apartmentRequest->first();
            } else {
                $aparmentModel = new Apartament();
                $aparmentModel->house_id = $house->id;
                $aparmentModel->number = $fileSplit[0];
                $aparmentModel->save();
            }

            $type = str_replace('house1' , '' , $fileSplit[1]);
            $type = str_replace('.csv' , '' , $type);


            $handle = fopen(storage_path('to_migrate/' . $file), "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    // process the line read.
                    $measurementData = explode(",", $line);

                    /**

                        Column  Type    Comment
                        id  int unsigned Auto Increment  
                        type    varchar(255) NULL    
                        apartment_id    int  
                        consumption int  
                        temp    int  
                        flow_time   int  
                        power_consumption   varchar(255) NULL    
                        created_at  timestamp NULL   
                        updated_at  timestamp NULL   

                        Consumption Temp    FlowTime    Power_Consumption   TimeStamp

                        array(6) {
                          [0]=>
                          string(4) "2950"
                          [1]=>
                          string(8) "5.127357"
                          [2]=>
                          string(9) "29.047428"
                          [3]=>
                          string(8) "72.01072"
                          [4]=>
                          string(10) "0.11394013"
                          [5]=>
                          string(20) "2020-05-09T14:36:18
                        "
                        }
                    **/

                    if ('TimeStamp' == trim($measurementData[5])){
                        continue;
                    }

                    $measurement = new Measurement();
                    $measurement->type = $type;
                    $measurement->apartment_id = $aparmentModel->id;
                    $measurement->consumption = (double) $measurementData[1];
                    $measurement->temp = (double) $measurementData[2];
                    $measurement->flow_time = (double) $measurementData[3];
                    $measurement->power_consumption = (double) $measurementData[4];

                    $date = str_replace('T', " ", trim($measurementData[5]));
                    $measurement->created_at = Carbon::parse($date);

                    // `2020-11-21T21:50:18` vs `2021-11-19 21:44:20`

                    $measurement->save();

                }

                fclose($handle);
            } else {
                // error opening the file.
            } 


        }
    }
}
