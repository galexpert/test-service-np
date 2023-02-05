<?php

namespace App\Console\Commands;


use App\Models\Location;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Jobs\addCities;

class ImportLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cities:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Import Cities ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey" => "bbf65ca0211773f3206949d78ad08970",
            "modelName"=> "Address",
            "calledMethod"=> "getCities",
            "methodProperties" => [
                "Language" =>"UA",
                "Limit" => "20"
            ]

        ]);

        $cities = json_decode($response->getBody()->getContents(), true)['data'];

        if (!$cities){
            $this->error('cities not found');
            return FALSE;
        }

        $assoc_array = array();
        $this->output->progressStart(count($cities));
        $os = array('Абрикосовка', 'Агайманы', 'Агрономичное', 'Адамполь');

        foreach($cities as $key => $val) {
            if(!in_array($val['DescriptionRu'], $os)){
                $assoc_array[$val['CityID']]['langs']['uk']['title'] = isset($val['Description']) ? $val['Description'] : '';
                $assoc_array[$val['CityID']]['langs']['ru']['title'] = isset($val['DescriptionRu']) ? $val['DescriptionRu'] : '';
                $assoc_array[$val['CityID']]['langs']['uk']['areadescription'] = isset($val['AreaDescription']) ? $val['AreaDescription'] : '';
                $assoc_array[$val['CityID']]['langs']['ru']['areadescription'] = isset($val['AreaDescriptionRu']) ? $val['AreaDescriptionRu'] : '';
                $assoc_array[$val['CityID']]['ref']= isset($val['Ref']) ? $val['Ref'] : '';
                $assoc_array[$val['CityID']]['cityId']= isset($val['CityID']) ? $val['CityID'] : '';
            } else {
                continue;
            }
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
        $this->info('Вибрано city: '. count($assoc_array));

       if ($assoc_array) {
            foreach ($assoc_array as $city) {
                $result = Location::where('ref', $city['ref'])->first();
               if(!$result) {
                    $modelLocation = Location::updateOrCreate([
                        'parent_id' => 0,
                        'ref' => isset($city['ref']) ? $city['ref'] : null,
                        'cityId' => isset($city['cityId']) ? $city['cityId'] : null,
                    ]);
                    if ($modelLocation) {
                        foreach ($city['langs'] as $key => $lang) {
                            $modelLocation->lang()->updateOrCreate([
                                'title' => $lang['title'],
                                'areadescription' => $lang['areadescription'],
                                'location_id' => $modelLocation->id,
                                'lang' => $key,
                            ]);
                        }
                    }
                }
            }
        }

        $cities = Location::where('parent_id', '0')->get()->toArray();
        if($cities) {
            $users = $this->withProgressBar($cities, function ($city)  {
                    // реализація job черги окремо на кожну вставку
                    $res = addCities::dispatch($city);
            });
        }
    }


}
