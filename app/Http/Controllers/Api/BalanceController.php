<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\PaymentTask;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
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
    public function get_balance(Request $request)
    {
        $get_lang = $request->header('Accept-Language');

        /*$language = DB::table('language_lines')
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->whereIn('group', ['static', 'inputs', 'buttons'])
                        ->whereIn('key', ['balance', 'balance_text', 'amount','add_balance_save', 'balance_log', 'add_balance']);
                });
            })
            ->get();*/

        $language = DB::table('language_lines')
            ->whereIn('group', ['static', 'inputs', 'buttons'])
            ->whereIn('key', ['balance', 'balance_text', 'amount', 'add_balance_save', 'balance_log', 'add_balance'])
            ->get();

        $translations = [];

        $charReplacements = [
            '&ccedil;' => 'ç',
            '&ouml;' => 'ö',
            '&nbsp;' => ' ',
        ];

        foreach ($language as $langLine) {
            $translation = json_decode($langLine->text, true);

            if (isset($translation[$get_lang])) {
                $cleanTranslation = strip_tags($translation[$get_lang]);

                $cleanTranslation = strtr($cleanTranslation, $charReplacements);

                $translations[$langLine->key] = $cleanTranslation;
            }
        }

        return with([ "balance" => Auth::user()->balance(), "get_page" => $translations]);
    }

    public function get_check_callback(Request $request){
        $trans_id = $request->input('trans_id');

        if (!isset($trans_id) || empty($trans_id) && !is_string($trans_id)) return;

        $payment_task = PaymentTask::where(['payment_key' => $trans_id, 'type' => 'pasha'])
            ->orderBy('id', 'desc')
            ->select('id', 'payment_type', 'response_rc', 'order_id', 'packages', 'amount', 'created_by', 'is_api')
            ->first();

        $status = '';
        if($payment_task->response_rc == '000'){
            $status = "success";
        }else{
            $status = "failed";
        }

        return response([
            'status' => $status,
            'payment_type' => $payment_task->payment_type
        ]);
        //dd($payment_task);
    }

}
