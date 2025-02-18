<?php

namespace App\Http\Controllers;

use App\Item;
use App\Package;
use App\PackageStatus;
use App\Title;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrackingSearchController extends Controller
{
    public function get_tracking_search(){
        $fields = [
            'how_it_work', 'international_delivery', 'corporative_logistics', 'services',
            'partners', 'blogs', 'feedback', 'faqs', 'contacts', 'tracking_search'
        ];

        $title = Title::query()
            ->select(array_map(function($field) {
                return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
            }, $fields))
            ->first();

        return view('web.trackingSearch',compact('title'));
    }
    public function local_tracking_search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'track' => ['required', 'string', 'max:500'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => 'Track not found!']);
        }
        try {
            $track = $request->track;

            $package = Package::whereRaw("(package.number = ? or package.internal_id = ?)", [$track, $track])
                ->orderBy('id', 'desc')
                ->select('id')
                ->first();

            if (!$package) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Package not found!']);
            }

            $package_id = $package->id;

            $events = PackageStatus::leftJoin('lb_status as status', 'package_status.status_id', '=', 'status.id')
                ->where('package_status.package_id', $package_id)
                ->select('status.status_' . App::getLocale() . ' as status', 'package_status.created_at as date')
                ->get();

            if (count($events) == 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Event not found!']);
            }

            return response(['case' => 'success', 'events' => $events]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function tracking_search_in_aser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'track_number' => ['required', 'string', 'max:500'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => 'Track not found!']);
        }

        $packages = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
            ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
            ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
            ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
            ->leftJoin('currency as cur', 'item.currency_id', '=', 'cur.id')
            ->leftJoin('currency as cur_package', 'package.currency_id', '=', 'cur_package.id')
            ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
            ->leftJoin('filial as f', 'package.branch_id', '=', 'f.id')
            ->whereNull('package.deleted_by')
            ->where('package.number',$request->input('track_number'))
            ->select(
            'package.id',
            'package.internal_id',
            'item.invoice_doc',
            'item.invoice_confirmed',
            'item.invoice_status as invoice_status',
            'item.id as item_id',
            'item.price',
            'cur.name as currency',
            'package.number as track',
            'package.seller_id',
            'package.other_seller',
            'seller.title as seller',
            'package.volume_weight',
            'package.gross_weight',
            'package.chargeable_weight',
            'package.unit',
            'package.total_charge_value as amount',
            //'package.amount_usd',
            'package.paid_status',
            'package.paid',
            'package.paid_sum as paid_usd',
            'package.paid_azn',
            'package.last_status_date',
            'package.last_status_id',
            'package.is_warehouse',
            'package.currency_id',
            'cur_package.icon as cur_icon',
            'flight.name as flight',
            's.status_' . App::getLocale() . ' as status',
            's.color as status_color',
            'package.issued_to_courier_date', // has courier (null -> false, not null -> true)
            'package.amount_azn',
            'package.external_w_debt',
            'package.internal_w_debt',
            'f.name as branch_name'
        )
            ->orderBy('package.id', 'desc')
            ->get();
        return view('web.tracking_search_in_aser', compact('packages'));
    }
}
