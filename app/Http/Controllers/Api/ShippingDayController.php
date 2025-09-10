<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ShippingDay;
use DB;
use Illuminate\Http\Request;

class ShippingDayController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('Language');

            $validator = \Validator::make($request->all(), [
                'country_id' => 'required|exists:shipping_days,country_id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first('country_id')
                ], 422);
            }

            $country_id = $request->input('country_id');

            $shippingDays = ShippingDay::where('shipping_days.is_active', 1)
                ->where('country_id', $country_id)
                ->leftJoin('countries', 'shipping_days.country_id', '=', 'countries.id')
                ->select(
                    'shipping_days.content_' . $lang . ' as content',
                    'countries.name_' . $lang . ' as country_name',
                    'countries.code',
                    DB::raw("CONCAT('" . env('APP_URL') . "', countries.new_flag) as flag"),
                    DB::raw("CONCAT('" . env('APP_URL') . "', countries.image) as image")
                )->first();

            if (!$shippingDays) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'No active shipping days found for the specified country.'
                    ]
                );
            }

            return response()->json(
                [
                    'status' => 'success',
                    'data' => $shippingDays
                ]
            );
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
}
