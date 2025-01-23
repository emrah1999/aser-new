<?php

namespace App\Http\Controllers;

use App\Country;
use App\ProhibitedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ProhibitedItemsController extends HomeController
{
    public function index()
    {
        try {
            $items = DB::table('prohibited_items')
                ->leftJoin('countries', 'countries.id', '=', 'prohibited_items.country_id')
                ->select(
                    'countries.id as country_id',
                    'countries.name_' . App::getLocale() . ' as name',
                    DB::raw("REPLACE(REPLACE(prohibited_items.item_" . App::getLocale() . ", '&middot;', ''), '&nbsp;', '') as item")
                )
                ->get();

            $countries = Country::where('url_permission', 1)
                ->select('id', 'name_' . App::getLocale() . ' as name', 'flag')
                ->orderBy('sort', 'desc')
                ->orderBy('id')
                ->get();

            return view('web.prohibited.index', compact('items', 'countries'));
        } catch (\Exception $exception) {
            dd($exception);
            return view("front.error");
        }
    }

}
