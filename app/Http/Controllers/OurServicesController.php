<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Faq;
use App\Menu;
use App\Service;
use App\ServiceText;
use App\Title;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OurServicesController extends Controller
{
    public function index()
    {
        try {
            $faqs = Faq::query()->where('page', 3)->select([
                'id',
                DB::raw("question_" . App::getLocale() . " as name"),
                DB::raw("answer_" . App::getLocale() . " as content")
            ])
                ->get();


            $text = ServiceText::query()
                ->select([
                    DB::raw("name_" . App::getLocale() . " as name"),
                    DB::raw("content_" . App::getLocale() . " as content")
                ])->first();
            $fields = [
                'how_it_work', 'international_delivery', 'corporative_logistics', 'services',
                'partners', 'blogs', 'feedback', 'faqs', 'contacts', 'tracking_search'
            ];

            $title = Title::query()
                ->select(array_map(function ($field) {
                    return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
                }, $fields))
                ->first();

            $services = Service::query()->select([
                'id', 'icon',
                DB::raw("name_" . App::getLocale() . " as name"),
                DB::raw("content_" . App::getLocale() . " as content"),
                DB::raw("slug_" . App::getLocale() . " as slug")
            ])
                ->get();

            $blogs = Blog::query()->orderBy('id', 'desc')->limit(3)
                ->where('page', 1)
                ->select([
                    'id', 'icon',
                    DB::raw("name_" . App::getLocale() . " as name"),
                    DB::raw("content_" . App::getLocale() . " as content"),
                    DB::raw("slug_" . App::getLocale() . " as slug")
                ])
                ->get();

            $breadcrumbs = 1;


            return view("web.services.index", compact("faqs", "text", 'title', 'blogs', 'breadcrumbs', 'services'));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    public function branches()
    {
        try {
            if (App::getLocale() == "az") {
                $branches = DB::table('filial')->where('is_active', 1)->get();
            } else {
                $branches = DB::table('filial')->where('is_active', 1)
                    ->select('filial.name',
                        'filial.address_' . App::getLocale() . ' as address',
                        'filial.phone1',
                        'filial.phone2',
                        'filial.work_hours_' . App::getLocale() . ' as work_hours',
                        'filial.map_location'
                    )
                    ->get();
            }
            $breadcrumbs = 1;
            $fields = [
                'branch'
            ];

            $title = Title::query()
                ->select(array_map(function ($field) {
                    return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
                }, $fields))
                ->first();

            return view("web.services.branches", compact('branches', 'breadcrumbs', 'title'));
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    public function cargomat()
    {
        try {
            return view("web.services.cargomat");
        } catch (\Exception $exception) {
            return view("front.error");
        }
    }

    public function get_services($locale, $id)
    {
        $service = Service::query()->select([
            'id', 'icon', 'internal_images',
            DB::raw("name_" . App::getLocale() . " as name"),
            DB::raw("content_" . App::getLocale() . " as content"),
            DB::raw("ceo_title_" . App::getLocale() . " as ceo_title"),
            DB::raw("seo_description_" . App::getLocale() . " as seo_description"),
        ])
            ->where('id', $id)
            ->first();


        return view("web.services.single", compact('service'));
    }

    public function branchNew()
    {
        $lang = App::getLocale() ?? 'az';

        $query = DB::table('filial');

        $branches = $query->where('is_active', 1)->select(
            'filial.id',
            'filial.name_' . App::getLocale() . ' as name',
            'filial.address_' . App::getLocale() . ' as address',
            'filial.phone1',
            'filial.phone2',
            App::getLocale() != 'az' ? 'filial.work_hours_' . App::getLocale() . ' as work_hours' : 'filial.work_hours',
            'filial.is_pudo',
            'filial.map_location',
            'filial.weekday_start_date',
            'filial.weekday_end_date',
            'filial.weekend_start_date',
            'filial.weekend_end_date'
        )
            ->get();

        $today = Carbon::now()->locale('az')->isoFormat('dd');
        foreach ($branches as $branch) {
            $now = Carbon::now();
            $currentTime = $now->format('H:i');
            $dayOfWeek = $now->dayOfWeek;

            if ($dayOfWeek >= 1 && $dayOfWeek <= 5) {
                if (
                    $currentTime >= $branch->weekday_start_date &&
                    $currentTime <= $branch->weekday_end_date
                ) {
                    $branch->is_open = 1;
                } else {
                    $branch->is_open = 0;
                }
            } elseif ($dayOfWeek == 6) {
                if (
                    $currentTime >= $branch->weekend_start_date &&
                    $currentTime <= $branch->weekend_end_date
                ) {
                    $branch->is_open = 1;
                } else {
                    $branch->is_open = 0;
                }
            } else {
                $branch->is_open = 0;
            }
            $branch->today_abbr = $today;

            $days = [
                'az' => ['be' => 'B.e.', 'ça' => 'Ç.a.', 'ç' => 'Ç.', 'ca' => 'C.a.', 'c' => 'C.', 'ş' => 'Ş.'],
                'en' => ['be' => 'Mon', 'ça' => 'Tue', 'ç' => 'Wed', 'ca' => 'Thu', 'c' => 'Fri', 'ş' => 'Sat'],
                'ru' => ['be' => 'Пн', 'ça' => 'Вт', 'ç' => 'Ср', 'ca' => 'Чт', 'c' => 'Пт', 'ş' => 'Сб'],
            ];
            $locale = App::getLocale();

            $labels = $days[$locale] ?? $days['az'];
            $workHours = [
                $labels['be'] => $branch->weekday_start_date . '-' . $branch->weekday_end_date,
                $labels['ça'] => $branch->weekday_start_date . '-' . $branch->weekday_end_date,
                $labels['ç'] => $branch->weekday_start_date . '-' . $branch->weekday_end_date,
                $labels['ca'] => $branch->weekday_start_date . '-' . $branch->weekday_end_date,
                $labels['c'] => $branch->weekday_start_date . '-' . $branch->weekday_end_date,
                $labels['ş'] => $branch->weekend_start_date . '-' . $branch->weekend_end_date,
            ];

            $branch->work_hours_details = $workHours;
        }

        return view("web.services.branchNew", compact('branches'));
    }
}
