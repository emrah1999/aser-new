<?php

namespace App\Http\Controllers\Api;

use App\CountryDetails;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CountryDetailsController extends Controller
{

    private $userID;

    public function __construct(Request $request)
    {
        //		$this->middleware(['auth', 'verified']);
        $this->middleware(function ($request, $next) {

            if ($request->get('api')) {
                App::setlocale($request->get('apiLang') ?? 'en');
                $this->userID = $request->get('user_id');

                if (Auth::guest()) {
                    $user = User::find($this->userID);
                    Auth::login($user);
                }
            } else {
                $this->userID = Auth::id();
            }
            return $next($request);
        });
    }

    public function get_country_details(Request $request, $country_id){
        $countries = CountryDetails::where('country_id', $country_id)
            ->select('id', 'country_id', 'title', 'information')
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        $user = User::where('id', $this->userID)
            ->select(\DB::raw("CONCAT(name, ' ', surname) AS name_surname, id AS colibri_id"))
            ->first();

        foreach ($countries as $country) {
            $information = $country->information;

            if (strpos($information, '{name_surname}') !== false) {
                $information = str_replace('{name_surname}', $user->name_surname, $information);
            }

            if (strpos($information, '{colibri_id}') !== false) {
                $information = str_replace('{colibri_id}', $user->colibri_id, $information);
            }

            $country->information = $information;
        }

        return [$countries, $user];
    }

}
