<?php

namespace App\Jobs;


use App\Models\Location;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;


class addCities implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $city;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($city)
    {
        //
        $this->city = $city;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey" => "bbf65ca0211773f3206949d78ad08970",
            "modelName"=> "Address",
            "calledMethod"=> "getWarehouses",
            "methodProperties" => [
                "CityRef" => $this->city['ref']
            ]
        ]);


        if($this->city){
            // реализація job черги
            $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
                "apiKey" => "bbf65ca0211773f3206949d78ad08970",
                "modelName"=> "Address",
                "calledMethod"=> "getWarehouses",
                "methodProperties" => [
                    "CityRef" => $this->city['ref']
                ]
            ]);

           $posts = json_decode($response->getBody()->getContents(), true)['data'];

            if (!$posts){
                //$this->error('$posts not found');
                return FALSE;
            }

            $assoc_array = array();

            foreach($posts as $key => $val) {
                    $assoc_array[$key]['langs']['uk']['title'] = isset($val['Description']) ? $val['Description'] : '';
                    $assoc_array[$key]['langs']['ru']['title'] = isset($val['DescriptionRu']) ? $val['DescriptionRu'] : '';
                    $assoc_array[$key]['langs']['uk']['areadescription'] = isset($val['ShortAddress']) ? $val['ShortAddress'] : '';
                    $assoc_array[$key]['langs']['ru']['areadescription'] = isset($val['ShortAddressRu']) ? $val['ShortAddressRu'] : '';
                    $assoc_array[$key]['ref']= isset($val['Ref']) ? $val['Ref'] : '';
                    $assoc_array[$key]['cityId']= isset($this->city['cityId']) ? $this->city['cityId'] : '';
                    $assoc_array[$key]['parent_id']= isset($this->city['id']) ? $this->city['id'] : '';
            }


            if ($assoc_array) {
                foreach ($assoc_array as $key => $city) {
                    $result = Location::where('ref', $city['ref'])->first();
                    if(!$result) {
                        $modelLocation = Location::updateOrCreate([
                            'parent_id' => isset($city['parent_id']) ? $city['parent_id'] : 0,
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

        }

    }

    public function getResponse()
    {
        return $this->response;
    }
}
