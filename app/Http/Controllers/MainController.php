<?php

namespace App\Http\Controllers;



use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

//use App\Http\Requests\ProductsFilterRequest;
//use App\Http\Requests\SubscriptionRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use App\Services\LocalizationService;
use App\Services\LocationService;
use LisDev\Delivery\NovaPoshtaApi2;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;




class MainController extends Controller
{
    private $localizationService;
    private $LocationService;
    public function __construct(LocalizationService $localizationService, LocationService $locationService)
    {
        $this->localizationService = $localizationService;
        $this->LocationService = $locationService;

    }


    public function index()
    {

        $lang = $this->localizationService->checkLocale();


        $cities = Location::where('parent_id','=', 0)->with(['lang' => function ($query)  use ($lang) {
            $query->where('lang', '=', $lang);
        }])->get()->toArray();


        return view('index', compact('cities' /*'currencySymbol', 'currencies', 'mainCurrency', 'categoriesTree', 'categoryAll', 'itemsJson'*/));
    }

    public function getPosts($id)
    {

        $lang = $this->localizationService->checkLocale();

        $cities = Location::where('parent_id','=', $id)->with(['lang' => function ($query)  use ($lang) {
            $query->where('lang', '=', $lang);
        }])->get()->toJson();

        return $cities;
      /*  return view('index', compact('cities', 'currencySymbol', 'currencies', 'mainCurrency', 'categoriesTree', 'categoryAll', 'itemsJson'));*/
    }

    public function Poshta () {

        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey" => "bbf65ca0211773f3206949d78ad08970",
            "modelName"=> "Address",
            "calledMethod"=> "getCities",
            "methodProperties" => [
                "Language" =>"UA",
            "Limit" => "4"
   ]

        ]);

        $cities = json_decode($response->getBody()->getContents(), true)['data'];
        foreach ($cities as $city){
            $city['parent_id'] = 0;

           /* if($city){
                $city['post_offices'] = json_decode($city->getBody()->getContents(), true)['data'];
            }*/
        }
        dump('0000', $cities);
      /*  $client = new Client();
        $promise1 = Http::async()->post('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey" => "bbf65ca0211773f3206949d78ad08970",
            "modelName"=> "Address",
            "calledMethod"=> "getWarehouses",
            "methodProperties" => [
                "CityRef" => 'fc5f1e3c-928e-11e9-898c-005056b24375'
            ]
        ]);*/



       /* $responses = Http::pool(function (Pool $pool) use ($url, $nbPages) {
            return collect()
                ->range(1, $nbPages)
                ->map(fn ($page) => $pool->post($url . "?page={$page}"));
        });*/
        //$responses = Utils::unwrap($promise1);

       /* $promise1 = $client->postAsync('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey" => "1b009444-4e4a-11ed-a361-48df37b92096",
            "modelName"=> "Address",
            "calledMethod"=> "getWarehouses",
            "methodProperties" => [
                "CityRef" => 'fc5f1e3c-928e-11e9-898c-005056b24375'
            ]
        ]);*/
      /*  $promise2 = $client->postAsync('https://api.novaposhta.ua/v2.0/json/', [
            "apiKey" => "1b009444-4e4a-11ed-a361-48df37b92096",
            "modelName"=> "Address",
            "calledMethod"=> "getWarehouses",
            "methodProperties" => [
                "CityRef" => '1b009444-4e4a-11ed-a361-48df37b92096'
            ]
        ]);*/

     //   $promises = [$promise1, $promise2];

     /*   $results =  Promise\settle($promises)->wait();
        $posts = [];
        foreach ($results as $result){
            $posts[] = json_decode($result['value']->getBody()->getContents(), true);
           // $posts[] = $result['value']->getBody();
        }
        dump('2222', $posts);*/

    }

    public static function getRates()
    {
        //$baseCurrency = CurrencyConversion::getBaseCurrency();
     /*   $currencyAll = CurrencyConversion::getCurrencies();

        $currencySymbolsArr = [];
        foreach ($currencyAll as $currency) {
            if ($currency->is_main) {
                $baseCurrencyCode = $currency->code;
            } else {
                $currencySymbolsArr[] = $currency->code;
            }
        }*/



        $url_api = 'https://api.novaposhta.ua/v2.0';
        $url = config('realty.api_url') . '?base=' . $baseCurrencyCode;
        //  'api_url' => https://api.exchangerate.host/latest?base=UAH   Работает!!!!

        $client = new Client();

        $headers = [
            //'User-Agent' => 'testing/1.0',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        //$response = $client->request('GET', $url, ['headers'=>$headers]);

        try {
            $response = $client->request('GET', $url);
        } catch (Exception $e) {
            //  report($e);
            return response()->json(['result' => 'There is a problem with currency rate service', 'error' => '404']);
            //  return false;
        }


        if ($response->getStatusCode() !== 200) {
            // throw new Exception('There is a problem with currency rate service');
            return response()->json(['result' => 'There is a problem with currency rate service', 'error' => '404']);
        }


        $rates = json_decode($response->getBody()->getContents(), true)['rates'];
        foreach ($currencyAll as $currency) {
            if (!$currency->isMain()) {
                if (!isset($rates[$currency->code])) {
                    throw new Exception('There is a problem with currency ' . $currency->code);
                } else {
                    $currency->update(['xrate' => $rates[$currency->code]]);
                    $currency->touch();
                }
            } else {
                // обновляем поле updated_at главной валюты для избежание повторного запроса данных API сервиса
                // dump($currency->code);
                $currency->touch();
            }
        }
    }

    public function show($slug)
    {

        $lang = $this->localizationService->checkLocale();
        $this->menuService->loadContainerMenu($lang);
        $categoryAll = $this->menuService::$menuContainer;
        $categoriesTree = $this->menuService->categoriesTree($categoryAll);
        list($id, $alias) = explode("-", $slug,2);

       /* $product = Item::with(['files', 'files.thumbnails', 'lang' => function ($query ) use ($slug) {
            $query->where('lang', '*')->where('alias', $slug)->firstOrFail();
        }])->findOrFail($id);*/

        $product = Item::with('files', 'files.thumbnails')->findOrFail($id);

        $product = $this->itemService->addItemWebPLink([$product]);
        list($product) = $product;

        $product->lang = $product->lang()->where('lang', $lang)->where('alias', $slug)->firstOrFail();

        $currencySymbol = CurrencyConversion::getCurrencySymbol();
        $currencies = CurrencyConversion::getCurrencies();

        $mainCurrency = CurrencyConversion::getBaseCurrency();
        //dd($article);

//обращаемся к scope
        //$articles = Article::lastLimit(7);
        // $articles = Article::ArticlesPaginate(3);
        return view('realty::layouts.card', compact('product', 'currencySymbol', 'currencies', 'mainCurrency', 'categoryAll', 'categoriesTree'));
       // return view('realty::front.product.show', compact('product', 'currencySymbol', 'currencies', 'mainCurrency'));
    }

    public function categories()
    {
        return view('categories');
    }

    public function category($code)
    {
        $category = Category::where('code', $code)->first();
        return view('category', compact('category'));
    }





    public function changeLocale($locale)
    {
        $availableLocales = ['ru', 'en'];
        if (!in_array($locale, $availableLocales)) {
            $locale = config('app.locale');
        }
        session(['locale' => $locale]);
        App::setLocale($locale);
        return redirect()->back();
    }

    public function changeCurrency($currencyCode)
    {
        $currency = Currency::byCode($currencyCode)->firstOrFail();
        //dd($currency);
        session(['currency' => $currency->code]);
        return redirect()->back();
    }



}
