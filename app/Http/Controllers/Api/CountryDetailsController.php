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
        $user = User::where('id', $this->userID)
            ->select(\DB::raw("CONCAT(name, ' ', surname) AS name_surname, id AS colibri_id"))
            ->first();
        if ($country_id == 'special') {
            $staticCountries = [
                [
                    [
                        "id" => 12,
                        "country_id" => 'special',
                        "title" => "Full Name",
                        "information" => $user->name_surname,
                    ],
                    [
                        "id" => 12,
                        "country_id" => 'special',
                        "title" => "Address Line1:",
                        "information" => "1923 McDonald Ave Brooklyn, NY11223"
                    ],
                    [
                        "id" => 13,
                        "country_id" => 'special',
                        "title" => "Address Line2:",
                        "information" => 'AS'.$user->colibri_id . ", Aser Cargo Express"
                    ],
                    [
                        "id" => 14,
                        "country_id" => 'special',
                        "title" => "City:",
                        "information" => "New York"
                    ],
                    [
                        "id" => 15,
                        "country_id" => 'special',
                        "title" => "State:",
                        "information" => "NY (New York)"
                    ],
                    [
                        "id" => 16,
                        "country_id" => 'special',
                        "title" => "Country:",
                        "information" => "USA"
                    ],
                    [
                        "id" => 17,
                        "country_id" => 'special',
                        "title" => "ZIP postal code:",
                        "information" => 11223
                    ],
                    [
                        "id" => 16,
                        "country_id" => 'special',
                        "title" => "Phone Number:",
                        "information" => "+1 (718) 872-7577"
                    ],

                ],
                [
                    "name_surname" => $user->name_surname,
                    "colibri_id" => $user->colibri_id,

                ],
                [
                    'text'=>' Diqqət!!! Bu ünvan yalnız Amerikada yaşayan həmyerlilərimiz tərəfindən şəxsi göndərişlər üçün nəzərdə tutulmuşdur. Nyu York vergi ştatı olduğu üçün onlayn sifarişlərinizə vergi hesablanacaqdır. Bu səbəbdən onlayn sifarişləriniz üçün mütləq Delaware ştatındakı anbar ünvanımızı istifadə edin.', ]
            ];

            return $staticCountries;
        }
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

            if (strpos($information, '{aser_id}') !== false) {
                $information = str_replace('{aser_id}', $user->colibri_id, $information);
            }

            $country->information = $information;
        }

        return [
            $countries,
            $user,
            $country_id == 9 ? ['text' => __('static.germany_info')] :($country_id == 4 ? ['text' => __('static.spain_info')] : ""),

        ];

    }

}
