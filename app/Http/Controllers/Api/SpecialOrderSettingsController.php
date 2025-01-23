<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SpecialOrder;
use App\SpecialOrderGroups;
use App\SpecialOrdersSettings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SpecialOrderSettingsController extends Controller
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

    public function get_settings()
    {
        $settings = SpecialOrdersSettings::where('active', 1)->select('percent')->first();

        return $settings;
    }

    public function update_special_order(Request $request, $country_id, $order_id)
    {
        $validator = Validator::make($request->all(), [
            'order_id.*' => ['required', 'integer'],
            'order_id' => ['required', 'array'],
            'color.*' => ['nullable', 'string', 'max:100'],
            'color' => ['required', 'array'],
            'size.*' => ['nullable', 'string', 'max:100'],
            'size' => ['required', 'array'],
            'description.*' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'array'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            if (!is_numeric($order_id)) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Wrong order format!']);
            }

            $color = $request->color;
            $size = $request->size;
            $description = $request->description;

            $group = SpecialOrderGroups::where(['id' => $order_id, 'client_id' => $this->userID, 'disable' => 0, 'is_paid' => 0, 'waiting_for_payment' => 0])
                ->select('group_code')
                ->first();

            if (!$group) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Order not found!']);
            }

            for ($i = 0; $i < count($request->order_id); $i++) {

                $spo = SpecialOrder::where(['group_code' => $group->group_code, 'id' => $request->order_id[$i]])
                    ->first();

                if (!$spo){
                    return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Göndərdiyiniz müraciətlərdən hər hansı biri tapılmadı'], Response::HTTP_NOT_FOUND);
                }

                $spo->update([
                    'color' => $color[$i],
                    'size' => $size[$i],
                    'description' => $description[$i]
                ]);
            }

            return response(['case' => 'success', 'title' => 'Uğurlu!', 'content' => 'Sifariş bilgiləri uğurla dəyişdirildi!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }
}
