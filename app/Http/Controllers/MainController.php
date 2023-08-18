<?php

namespace App\Http\Controllers;


use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use App\Services\LocalizationService;
use App\Services\LocationService;
use GuzzleHttp\Client;


class MainController extends Controller
{
    private $localizationService;


    public function __construct(LocalizationService $localizationService)
    {
        $this->localizationService = $localizationService;

    }

    public function index()
    {
        $lang = $this->localizationService->checkLocale();
        $cities = Location::where('parent_id', '=', 0)->with(['lang' => function ($query) use ($lang) {
            $query->where('lang', '=', $lang);
        }])->get()->toArray();

        return view('index', compact('cities'));
    }

    public function getPosts($id)
    {
        $lang = $this->localizationService->checkLocale();
        $cities = Location::where('parent_id', '=', $id)->with(['lang' => function ($query) use ($lang) {
            $query->where('lang', '=', $lang);
        }])->get()->toJson();

        return $cities;

    }


}
