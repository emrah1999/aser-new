<?php

namespace App\Http\Controllers\Api;

use App\ContractDetail;
use App\Country;
use App\Http\Controllers\Controller;
use App\Instruction;
use App\Seller;
use App\TariffType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class CalculateController extends Controller
{
    public function index(Request $request)
    {
        try {
            $header = $request->header('Language');
            $countries = Country::where('is_active', 1)->select('name_' . $header.' as title', 'id')->orderBy('name_' . App::getLocale())->get();
            $types = TariffType::select('id', 'name_'. $header.' as title')->get();

            return with([
                'countries' => $countries,
                'types' => $types
            ]);
        } catch (\Exception $exception) {
            return response([
                'errorKey' => 'error.http.500'
            ]);
        }
    }

    public function calculate_amount(Request $request) {

        $validator = Validator::make($request->all(), [
            'country' => ['required', 'integer'],
            'type' => ['required', 'integer'],
            'unit' => ['required', 'string', 'max:3'],
            'weight' => ['required'],
            'width' => ['nullable'],
            'height' => ['nullable'],
            'length' => ['nullable'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $country_id = $request->country;
            $type = $request->type;
            $unit = $request->unit;
            $weight = $request->weight;
            $width = $request->width;
            $height = $request->height;
            $length = $request->length;
            $volume_weight = ($width * $length * $height) / 6000;

            if ($unit == 'gm') {
                $weight = $weight / 1000;
            }

            $date = Carbon::today();
            $tariffs = ContractDetail::leftJoin('contract as c', 'contract_detail.contract_id', '=', 'c.id')
                ->leftJoin('currency', 'contract_detail.currency_id', '=', 'currency.id')
                ->where(['contract_detail.country_id'=>$country_id, 'c.default_option'=>1, 'c.is_active'=>1, 'contract_detail.is_active'=>1, 'contract_detail.type_id'=>$type])
                ->whereDate('c.start_date', '<=', $date)->whereDate('c.end_date', '>=', $date)
                ->whereDate('contract_detail.start_date', '<=', $date)->whereDate('contract_detail.end_date', '>=', $date)
                ->select('contract_detail.from_weight', 'contract_detail.to_weight', 'contract_detail.weight_control as volume_control', 'contract_detail.rate', 'contract_detail.charge', 'currency.icon')
                ->get();

            $chargeable_weight = $weight;
            foreach ($tariffs as $tariff) {
                if ($tariff->volume_control == 1) {
                    if ($length > 0 && $width > 0 && $height > 0) {
                        if ($volume_weight > $weight) {
                            $chargeable_weight = $volume_weight;
                        } else {
                            $chargeable_weight = $weight;
                        }
                    } else {
                        $chargeable_weight = $weight;
                    }
                } else {
                    $chargeable_weight = $weight;
                }
                if (($chargeable_weight >= $tariff->from_weight) && ($chargeable_weight <= $tariff->to_weight)) {
                    $amount = $tariff->charge + ($chargeable_weight * $tariff->rate);
                    $amount = sprintf('%0.2f', $amount);
                    $currency_icon = $tariff->icon;
                    return response(['case' => 'success', 'amount' => $currency_icon . $amount]);
                }
            }

            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Uyğun tarif tapılmadı!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }
}
