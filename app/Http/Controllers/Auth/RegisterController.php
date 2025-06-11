<?php

namespace App\Http\Controllers\Auth;

use App\Cities;
use App\EmailListContent;
use App\ExchangeRate;
use App\Http\Controllers\Controller;
use App\Notifications\Emails;
use App\Scopes\DeletedScope;
use App\Service\SendOTPCode;
use App\Settings;
use App\User;
use App\OTP;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/account';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');

		$date = Carbon::today();
		$rates = ExchangeRate::leftJoin('currency as from', 'exchange_rate.from_currency_id', '=', 'from.id')
				->leftJoin('currency as to', 'exchange_rate.to_currency_id', '=', 'to.id')
				->whereDate('exchange_rate.from_date', '<=', $date)
				->whereDate('exchange_rate.to_date', '>=', $date)
				->select('exchange_rate.rate', 'from.name as from_currency', 'to.name as to_currency')
				->orderBy('exchange_rate.id', 'desc')
				->get();

		$general_settings = Settings::select('working_hours_en', 'working_hours_az', 'working_hours_ru')->first();

		View::share(['exchange_rates_for_header' => $rates, 'general_settings' => $general_settings]);
	}

	private function convert_to_ascii($value)
	{
		$charsArray = [
				'0' => ['°', '₀', '۰'],
				'1' => ['¹', '₁', '۱'],
				'2' => ['²', '₂', '۲'],
				'3' => ['³', '₃', '۳'],
				'4' => ['⁴', '₄', '۴', '٤'],
				'5' => ['⁵', '₅', '۵', '٥'],
				'6' => ['⁶', '₆', '۶', '٦'],
				'7' => ['⁷', '₇', '۷'],
				'8' => ['⁸', '₈', '۸'],
				'9' => ['⁹', '₉', '۹'],
				'a' => ['à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ā', 'ą', 'å', 'α', 'ά', 'ἀ', 'ἁ', 'ἂ', 'ἃ', 'ἄ', 'ἅ', 'ἆ', 'ἇ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ', 'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ὰ', 'ά', 'ᾰ', 'ᾱ', 'ᾲ', 'ᾳ', 'ᾴ', 'ᾶ', 'ᾷ', 'а', 'أ', 'အ', 'ာ', 'ါ', 'ǻ', 'ǎ', 'ª', 'ა', 'अ', 'ا'],
				'b' => ['б', 'β', 'Ъ', 'Ь', 'ب', 'ဗ', 'ბ'],
				'c' => ['ç', 'ć', 'č', 'ĉ', 'ċ'],
				'd' => ['ď', 'ð', 'đ', 'ƌ', 'ȡ', 'ɖ', 'ɗ', 'ᵭ', 'ᶁ', 'ᶑ', 'д', 'δ', 'د', 'ض', 'ဍ', 'ဒ', 'დ'],
				'e' => ['é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'ë', 'ē', 'ę', 'ě', 'ĕ', 'ė', 'ε', 'έ', 'ἐ', 'ἑ', 'ἒ', 'ἓ', 'ἔ', 'ἕ', 'ὲ', 'έ', 'е', 'ё', 'э', 'є', 'ə', 'ဧ', 'ေ', 'ဲ', 'ე', 'ए', 'إ', 'ئ'],
				'f' => ['ф', 'φ', 'ف', 'ƒ', 'ფ'],
				'g' => ['ĝ', 'ğ', 'ġ', 'ģ', 'г', 'ґ', 'γ', 'ဂ', 'გ', 'گ'],
				'h' => ['ĥ', 'ħ', 'η', 'ή', 'ح', 'ه', 'ဟ', 'ှ', 'ჰ'],
				'i' => ['í', 'ì', 'ỉ', 'ĩ', 'ị', 'î', 'ï', 'ī', 'ĭ', 'į', 'ı', 'ι', 'ί', 'ϊ', 'ΐ', 'ἰ', 'ἱ', 'ἲ', 'ἳ', 'ἴ', 'ἵ', 'ἶ', 'ἷ', 'ὶ', 'ί', 'ῐ', 'ῑ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'і', 'ї', 'и', 'ဣ', 'ိ', 'ီ', 'ည်', 'ǐ', 'ი', 'इ'],
				'j' => ['ĵ', 'ј', 'Ј', 'ჯ', 'ج'],
				'k' => ['ķ', 'ĸ', 'к', 'κ', 'Ķ', 'ق', 'ك', 'က', 'კ', 'ქ', 'ک'],
				'l' => ['ł', 'ľ', 'ĺ', 'ļ', 'ŀ', 'л', 'λ', 'ل', 'လ', 'ლ'],
				'm' => ['м', 'μ', 'م', 'မ', 'მ'],
				'n' => ['ñ', 'ń', 'ň', 'ņ', 'ŉ', 'ŋ', 'ν', 'н', 'ن', 'န', 'ნ'],
				'o' => ['ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ø', 'ō', 'ő', 'ŏ', 'ο', 'ὀ', 'ὁ', 'ὂ', 'ὃ', 'ὄ', 'ὅ', 'ὸ', 'ό', 'о', 'و', 'θ', 'ို', 'ǒ', 'ǿ', 'º', 'ო', 'ओ'],
				'p' => ['п', 'π', 'ပ', 'პ', 'پ'],
				'q' => ['ყ'],
				'r' => ['ŕ', 'ř', 'ŗ', 'р', 'ρ', 'ر', 'რ'],
				's' => ['ś', 'š', 'ş', 'с', 'σ', 'ș', 'ς', 'س', 'ص', 'စ', 'ſ', 'ს'],
				't' => ['ť', 'ţ', 'т', 'τ', 'ț', 'ت', 'ط', 'ဋ', 'တ', 'ŧ', 'თ', 'ტ'],
				'u' => ['ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'û', 'ū', 'ů', 'ű', 'ŭ', 'ų', 'µ', 'у', 'ဉ', 'ု', 'ူ', 'ǔ', 'ǖ', 'ǘ', 'ǚ', 'ǜ', 'უ', 'उ'],
				'v' => ['в', 'ვ', 'ϐ'],
				'w' => ['ŵ', 'ω', 'ώ', 'ဝ', 'ွ'],
				'x' => ['χ', 'ξ'],
				'y' => ['ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'ÿ', 'ŷ', 'й', 'ы', 'υ', 'ϋ', 'ύ', 'ΰ', 'ي', 'ယ'],
				'z' => ['ź', 'ž', 'ż', 'з', 'ζ', 'ز', 'ဇ', 'ზ'],
				'aa' => ['ع', 'आ', 'آ'],
				'ae' => ['ä', 'æ', 'ǽ'],
				'ai' => ['ऐ'],
				'ch' => ['ч', 'ჩ', 'ჭ', 'چ'],
				'dj' => ['ђ', 'đ'],
				'dz' => ['џ', 'ძ'],
				'ei' => ['ऍ'],
				'gh' => ['غ', 'ღ'],
				'ii' => ['ई'],
				'ij' => ['ĳ'],
				'kh' => ['х', 'خ', 'ხ'],
				'lj' => ['љ'],
				'nj' => ['њ'],
				'oe' => ['ö', 'œ', 'ؤ'],
				'oi' => ['ऑ'],
				'oii' => ['ऒ'],
				'ps' => ['ψ'],
				'sh' => ['ш', 'შ', 'ش'],
				'shch' => ['щ'],
				'ss' => ['ß'],
				'sx' => ['ŝ'],
				'th' => ['þ', 'ϑ', 'ث', 'ذ', 'ظ'],
				'ts' => ['ц', 'ც', 'წ'],
				'ue' => ['ü'],
				'uu' => ['ऊ'],
				'ya' => ['я'],
				'yu' => ['ю'],
				'zh' => ['ж', 'ჟ', 'ژ'],
				'(c)' => ['©'],
				'A' => ['Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Å', 'Ā', 'Ą', 'Α', 'Ά', 'Ἀ', 'Ἁ', 'Ἂ', 'Ἃ', 'Ἄ', 'Ἅ', 'Ἆ', 'Ἇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ', 'ᾍ', 'ᾎ', 'ᾏ', 'Ᾰ', 'Ᾱ', 'Ὰ', 'Ά', 'ᾼ', 'А', 'Ǻ', 'Ǎ'],
				'B' => ['Б', 'Β', 'ब'],
				'C' => ['Ç', 'Ć', 'Č', 'Ĉ', 'Ċ'],
				'D' => ['Ď', 'Ð', 'Đ', 'Ɖ', 'Ɗ', 'Ƌ', 'ᴅ', 'ᴆ', 'Д', 'Δ'],
				'E' => ['É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Ë', 'Ē', 'Ę', 'Ě', 'Ĕ', 'Ė', 'Ε', 'Έ', 'Ἐ', 'Ἑ', 'Ἒ', 'Ἓ', 'Ἔ', 'Ἕ', 'Έ', 'Ὲ', 'Е', 'Ё', 'Э', 'Є', 'Ə'],
				'F' => ['Ф', 'Φ'],
				'G' => ['Ğ', 'Ġ', 'Ģ', 'Г', 'Ґ', 'Γ'],
				'H' => ['Η', 'Ή', 'Ħ'],
				'I' => ['Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Î', 'Ï', 'Ī', 'Ĭ', 'Į', 'İ', 'Ι', 'Ί', 'Ϊ', 'Ἰ', 'Ἱ', 'Ἳ', 'Ἴ', 'Ἵ', 'Ἶ', 'Ἷ', 'Ῐ', 'Ῑ', 'Ὶ', 'Ί', 'И', 'І', 'Ї', 'Ǐ', 'ϒ'],
				'K' => ['К', 'Κ'],
				'L' => ['Ĺ', 'Ł', 'Л', 'Λ', 'Ļ', 'Ľ', 'Ŀ', 'ल'],
				'M' => ['М', 'Μ'],
				'N' => ['Ń', 'Ñ', 'Ň', 'Ņ', 'Ŋ', 'Н', 'Ν'],
				'O' => ['Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ø', 'Ō', 'Ő', 'Ŏ', 'Ο', 'Ό', 'Ὀ', 'Ὁ', 'Ὂ', 'Ὃ', 'Ὄ', 'Ὅ', 'Ὸ', 'Ό', 'О', 'Θ', 'Ө', 'Ǒ', 'Ǿ'],
				'P' => ['П', 'Π'],
				'R' => ['Ř', 'Ŕ', 'Р', 'Ρ', 'Ŗ'],
				'S' => ['Ş', 'Ŝ', 'Ș', 'Š', 'Ś', 'С', 'Σ'],
				'T' => ['Ť', 'Ţ', 'Ŧ', 'Ț', 'Т', 'Τ'],
				'U' => ['Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Û', 'Ū', 'Ů', 'Ű', 'Ŭ', 'Ų', 'У', 'Ǔ', 'Ǖ', 'Ǘ', 'Ǚ', 'Ǜ'],
				'V' => ['В'],
				'W' => ['Ω', 'Ώ', 'Ŵ'],
				'X' => ['Χ', 'Ξ'],
				'Y' => ['Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ', 'Ÿ', 'Ῠ', 'Ῡ', 'Ὺ', 'Ύ', 'Ы', 'Й', 'Υ', 'Ϋ', 'Ŷ'],
				'Z' => ['Ź', 'Ž', 'Ż', 'З', 'Ζ'],
				'AE' => ['Ä', 'Æ', 'Ǽ'],
				'CH' => ['Ч'],
				'DJ' => ['Ђ'],
				'DZ' => ['Џ'],
				'GX' => ['Ĝ'],
				'HX' => ['Ĥ'],
				'IJ' => ['Ĳ'],
				'JX' => ['Ĵ'],
				'KH' => ['Х'],
				'LJ' => ['Љ'],
				'NJ' => ['Њ'],
				'OE' => ['Ö', 'Œ'],
				'PS' => ['Ψ'],
				'SH' => ['Ш'],
				'SHCH' => ['Щ'],
				'SS' => ['ẞ'],
				'TH' => ['Þ'],
				'TS' => ['Ц'],
				'UE' => ['Ü'],
				'YA' => ['Я'],
				'YU' => ['Ю'],
				'ZH' => ['Ж'],
				' ' => ["xC2xA0", "xE2x80x80", "xE2x80x81", "xE2x80x82", "xE2x80x83", "xE2x80x84", "xE2x80x85", "xE2x80x86", "xE2x80x87", "xE2x80x88", "xE2x80x89", "xE2x80x8A", "xE2x80xAF", "xE2x81x9F", "xE3x80x80"],
		];

		foreach ($charsArray as $key => $val) {
			$value = str_replace($val, $key, $value);
		}

		return $value;
	}

	public function showRegistrationForm(Request $request)
	{
		try {
			$lang = App::getLocale();
			$cities = Cities::orderBy('name_' . $lang)->select('id', 'name_' . $lang . ' as name')->get();
            $branchs = DB::table('filial')->where('is_active', 1)->get();

			//language array
			$language_arr = array();

			$language_arr['description'] = __('register.description');
			$language_arr['submit_button'] = __('register.description');

			$language_arr['input_name'] = __('register.input_name');
			$language_arr['input_surname'] = __('register.input_surname');
			$language_arr['input_email'] = __('register.input_email');
			$language_arr['input_phone1'] = __('register.input_phone1');
			$language_arr['input_phone2'] = __('register.input_phone2');
			$language_arr['input_birthday'] = __('register.input_birthday');
			$language_arr['input_language'] = __('register.input_language');
			$language_arr['input_language_select_option'] = __('register.input_language_select_option');
			$language_arr['input_city'] = __('register.input_city');
			$language_arr['input_city_select_option'] = __('register.input_city_select_option');
			$language_arr['input_address'] = __('register.input_address');
			$language_arr['input_passport_series'] = __('register.input_passport_series');
			$language_arr['input_passport_series_select_option'] = __('register.input_passport_series_select_option');
			$language_arr['input_passport_no'] = __('register.input_passport_no');
			$language_arr['input_passport_fin'] = __('register.input_passport_fin');
			$language_arr['input_gender'] = __('register.input_gender');
			$language_arr['input_gender_male'] = __('register.input_gender_male');
			$language_arr['input_gender_female'] = __('register.input_gender_female');
			$language_arr['input_password'] = __('register.input_password');
			$language_arr['input_agreement'] = __('register.input_agreement');
			$language_arr['input_referral'] = __('register.input_referral');

			$language_arr['input_name_error_require'] = __('register.input_name_error_require');
			$language_arr['input_surname_error_require'] = __('register.input_surname_error_require');
			$language_arr['input_email_error_require'] = __('register.input_email_error_require');
			$language_arr['input_phone1_error_require'] = __('register.input_phone1_error_require');
			$language_arr['input_birthday_error_require'] = __('register.input_birthday_error_require');
			$language_arr['input_language_error_require'] = __('register.input_language_error_require');
			$language_arr['input_city_error_require'] = __('register.input_city_error_require');
			$language_arr['input_address_error_require'] = __('register.input_address_error_require');
			$language_arr['input_passport_series_error_require'] = __('register.input_passport_series_error_require');
			$language_arr['input_passport_series_not_chosen'] = __('register.input_passport_series_not_chosen');
			$language_arr['input_gender_error_require'] = __('register.input_gender_error_require');
			$language_arr['input_password_error_require'] = __('register.input_password_error_require');
			$language_arr['input_agreement_error_require'] = __('register.input_agreement_error_require');

			$language_arr['input_passport_error_8'] = __('register.input_passport_error_8');
			$language_arr['input_passport_error_7'] = __('register.input_passport_error_7');
			$language_arr['input_passport_error_6'] = __('register.input_passport_error_6');

			$language_arr['input_passport_fin_error_7'] = __('register.input_passport_fin_error_7');
			$language_arr['input_passport_fin_error_6'] = __('register.input_passport_fin_error_6');

			$language_arr['input_passport_modal_button'] = __('register.input_passport_modal_button');
			$language_arr['input_passport_modal_title'] = __('register.input_passport_modal_title');

			$language_arr['input_birthday_min_error'] = __('register.input_birthday_min_error');

			$language_arr['register_referral_info'] = __('register.referral_info');
            $errorType=null;
            if($request->input('type') == 'juridical'){
                return view('web.register.juridical', compact(
                    'lang',
                    'cities',
                    'language_arr',
                    'branchs',
                    'errorType'
                ));
            }else{
                return view('web.register.index', compact(
                    'lang',
                    'cities',
                    'language_arr',
                    'branchs',
                    'errorType'
                ));
            }
			
		} catch (\Exception $exception) {
			return view('front.error');
		}
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(Request $request,$type=0)
	{
        if($type == 1){
            return Validator::make($request->all(), [
                'voen' => ['required', 'string', 'max:255'],
                'company_name' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'surname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone1' => ['required', 'string', 'max:30'],
                'phone2' => ['nullable', 'string', 'max:10'],
                'language' => ['required', 'string', 'max:10'],
                'city' => ['required', 'string', 'max:255'],
                'address1' => ['required', 'string', 'max:255'],
                /*'location_longitude' => ['required', 'string', 'max:255'],
//                'location_latitude' => ['required', 'string', 'max:255'],*/
//                'passport_series' => ['required', 'string', 'max:10'],
//                'passport_number' => ['required', 'string', 'max:20'],
//                'passport_fin' => ['required', 'string', 'max:15'],
                'parent_code' => ['nullable', 'string', 'max:10'],
                'agreement' => ['required'],
                'password' => ['required', 'string', 'min:5'],
                'branch_id' => ['required', 'integer'],
                'is_legality' => ['required', 'integer'],
                'verification'=>['required', 'string',  'min:2'],
            ]);
        }
        if ($request->is_legality ==1){
            return Validator::make($request->all(), [
                'voen' => ['required', 'string', 'max:255'],
                'company_name' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'surname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone1' => ['required', 'string', 'max:30'],
                'phone2' => ['nullable', 'string', 'max:30'],
                'birthday' => ['required'],
                'language' => ['required', 'string', 'max:10'],
                'city' => ['required', 'string', 'max:255'],
                'address1' => ['required', 'string', 'max:255'],
                /*'location_longitude' => ['required', 'string', 'max:255'],
                'location_latitude' => ['required', 'string', 'max:255'],*/
                'passport_series' => ['required', 'string', 'max:10'],
                'passport_number' => ['required', 'string', 'max:20'],
                'passport_fin' => ['required', 'string', 'max:15'],
                'gender' => ['required', 'integer'],
                'parent_code' => ['nullable', 'string', 'max:10'],
                'agreement' => ['required'],
                'password' => ['required', 'string', 'min:5'],
                'branch_id' => ['required', 'integer'],
                'is_legality' => ['required', 'integer'],
                'verification'=>['required', 'string',  'min:2'],
            ]);
        }else{
            return Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'surname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone1' => ['required', 'string', 'max:30'],
                'phone2' => ['nullable', 'string', 'max:10'],
                'birthday' => ['required'],
                'language' => ['required', 'string', 'max:10'],
                'city' => ['required', 'string', 'max:255'],
                'address1' => ['required', 'string', 'max:255'],
                /*'location_longitude' => ['required', 'string', 'max:255'],
                'location_latitude' => ['required', 'string', 'max:255'],*/
                'passport_series' => ['required', 'string', 'max:10'],
                'passport_number' => ['required', 'string', 'max:20'],
                'passport_fin' => ['required', 'string', 'max:15'],
                'gender' => ['required', 'integer'],
                'parent_code' => ['nullable', 'string', 'max:10'],
                'agreement' => ['required'],
                'password' => ['required', 'string', 'min:5'],
                'branch_id' => ['required', 'integer'],
                'is_legality' => ['required', 'integer'],
                'verification'=>['required', 'string',  'min:2'],
            ]);
        }
		
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param Request $request
	 * @return int[]
	 */
	protected function create(Request $request)
	{
		try {
			$agreement = $request->agreement;

			if (!$agreement) {
				return [2]; //agreement
			}

//			if($request->passport_series == 'VOEN'){
//				$is_legality = 1;
//			}else{
//				$is_legality = 0;
//			}
//
//			$request->merge([
//				'is_legality' => $is_legality
//			]);

			$user = User::create([
					'role_id' => 2,
					'voen' => $request->voen ?? null,
					'company_name' => $request->company_name ?? null,
					'name' => $request->name,
					'surname' => $request->surname,
					'username' => $request->email,
					'email' => $request->email,
					'phone1' => $request->phone1,
					'phone2' => $request->phone2,
					'birthday' => $request->birthday,
					'language' => $request->language,
					'city' => $request->city,
					'address1' => $request->address1,
					'location_latitude1' => $request->location_latitude,
					'location_longitude1' => $request->location_longitude,
					'passport_series' => $request->passport_series ? $request->passport_series : 'VOEN' ,
					'passport_number' => $request->passport_number ? $request->passport_number : $request->voen ,
					'passport_fin' => $request->passport_fin,
					'gender' => $request->gender,
					'referral_unconfirm' => $request->parent_code,
					'password' => Hash::make($request->password),
					'is_legality' => $request->is_legality,
					'branch_id' => $request->branch_id,
			]);

			if (strlen($request->parent_code) >= 6) {
				$parent_code = $request->parent_code;

				$parent_user = User::where(['id' => $parent_code, 'role_id' => 2])
						->whereNull('deleted_by')
						->select('id', 'email', 'name', 'surname', 'language')
						->first();

				if ($parent_user) {
					$email = EmailListContent::where(['type' => 'referral_notification'])->first();

					if ($email) {
						$client = $parent_user->name . ' ' . $parent_user->surname;
						$lang = strtolower($parent_user->language);

						$referral_user = $request->name . ' ' . $request->surname;

						$email_title = $email->{'title_' . $lang}; //from
						$email_subject = $email->{'subject_' . $lang};
						$email_bottom = $email->{'content_bottom_' . $lang};
						$email_content = $email->{'content_' . $lang};

                        $link = route("approve_referral_user_account", ['locale' => App::getLocale(), 'id' => $user->id]);

                        $email_content = str_replace(array('{name_surname}', '{inviter_name}', '{referral_link}'), array($client, $referral_user, $link), $email_content);

						$parent_user->notify(new Emails($email_title, $email_subject, $email_content, $email_bottom));
					}
				}
			}

			return [1, $user]; //success
		} catch (\Exception $exception) {
			return [0, $exception]; //catch
		}
	}

//	/**
//	 * Handle a registration request for the application.
//	 *
//	 * @param \Illuminate\Http\Request $request
//	 * @return \Illuminate\Http\Response
//	 */
  

	 public function register(Request $request)
	 {
		 try {
             if($request->is('api/*')){
                 $request->merge([
                     'phone1' => str_replace("-", "", '994'.$request->phone1),
                 ]);
             }else{
                 $request->merge([
                     'phone1' => str_replace("-", "", '994'.$request->prefix.$request->phone_suffix),
                 ]);
             }

//             if($request->is('api/*')){
//                 return $request;
//             }
//             return $request;
			 $request->is_legality = $this->convert_to_ascii($request->is_legality);
			 $request->voen = $this->convert_to_ascii($request->voen);
			 $request->company_name = $this->convert_to_ascii($request->company_name);
			 $request->name = $this->convert_to_ascii($request->name);
			 $request->surname = $this->convert_to_ascii($request->surname);
			 $request->email = $this->convert_to_ascii($request->email);
			 $request->phone1 = $this->convert_to_ascii($request->phone1);
			 $request->phone2 = $this->convert_to_ascii($request->phone2);
			 $request->city = $this->convert_to_ascii($request->city);
			 $request->address1 = $this->convert_to_ascii($request->address1);
			 $request->passport_series = $this->convert_to_ascii($request->passport_series);
			 $request->passport_number = $this->convert_to_ascii($request->passport_number);
			 $request->passport_fin = $this->convert_to_ascii($request->passport_fin);
			 $request->location_longitude1 = $this->convert_to_ascii($request->location_longitude);
			 $request->location_latitude1 = $this->convert_to_ascii($request->location_latitude);
 //            return $request;
 //            return $request->voen;

//             if($request->is_legality==1){
//                 $is_legality = 1;
//                 $request->passport_series="VOEN";
//                 $request->passport_number=$request->voen;
//             }
//
//             return $request;

             if ($request->is_legality==1){
                 $validator = $this->validator($request,1);
             }
             else{
                 $validator = $this->validator($request);
             }

             Log::channel('register_create')->error('Request.', ['message' => $request->all()]);


             if ($validator->fails()) {
                 Log::channel('register_create')->error('Validator.', ['message' => $validator->messages()]);
                 if($request->is('api/*')){
					 $messages = $validator->messages();
					 return response()->json([
						 'case' => 'warning',
						 'title' => __('static.attention') . '!',
						 "content" => $messages
					 ],422);
				 }

				 return redirect()->back()->withErrors($validator)->withInput();
			 }

//             $request->phone1 = preg_replace("/[^0-9,.]/", "",$request->phone1);
//
//             $request->phone1 = preg_replace("/[^0-9]/", "", $request->phone1);


             if($request->is('api/*')){
                 if (strlen($request->phone1) !== 12 ) {
                     $errorType = 'number2';
                     if($request->is('api/*')){
                         return response()->json([
                             'case' => 'warning',
                             'title' => __('static.attention') . '!',
                             'content' => 'Telfon nömrəsini düzgün daxil edin'

                         ],422);
                     }
//                 return $errorType;

                 }

             }else{
                 if (strlen($request->phone1) !== 12 ) {

                     $errorType = 'number2';

                     return redirect()->back()->with([
                         'case' => 'warning',
                         'title' => __('static.attention') . '!',
                         'content' => 'Telfon nömrəsi doğru deyil',
                         'errorType' => $errorType,
                     ])->withInput();
                 }
             }




             if ($request->is_legality==0){
                 if($request->is('api/*')){
                     $request->birthday = \Carbon\Carbon::createFromFormat('d.m.Y', $request->birthday)->format('Y-m-d');
                 }
             }

             $unveryfied_user = User::where('email', $request->email)->whereNull('email_verified_at')->select('id')->first();

             if ($unveryfied_user) {
                 $unveryfied_user->delete();
             }

 
			 if (!$request->voen){
				 $birthday = $request->input('birthday');
				 $birthdayDate = Carbon::parse($birthday);
				 $age = Carbon::now()->diffInYears($birthdayDate);
				 if ($age < 18) {
					 $errorType = 'age';
					//  return $errorType;
					 return redirect()->back()->with([
						 'case' => 'warning',
						 'title' => __('static.attention') . '!',
						 'content' => '18 yaşdan böyük olmalısınız',
						 'errorType' => $errorType,
					 ])->withInput();
				 }
 
			 }

			 // Check for existing user conflicts
			 if (!User::where('email', $request->email)->select('id')->first() && User::withoutGlobalScope(DeletedScope::class)->where('email', $request->email)->select('id')->first()) {
                 $errorType = 'email';
                 if($request->is('api/*')){
					//  return $errorType;
					 return response()->json([
						 'case' => 'warning',
						 'title' => __('static.attention') . '!',
						 'content' => __('register.user_deleted'),
                         'errorType' => $errorType,

					 ],422);
				 }

				 return redirect()->back()->with([
					 'case' => 'warning',
					 'title' => __('static.attention') . '!',
					 'content' => __('register.user_deleted'),
					 'errorType' => $errorType,
				 ])->withInput();
			 }

			 if (User::where('email', $request->email)->select('id')->first()) {
				$errorType = 'email';
				// return $errorType; 
				 if($request->is('api/*')){
			
					 return response()->json([
						 'case' => 'warning',
						 'title' => __('static.attention') . '!',
						 'content' => __('register.email_exists')
 
					 ],422);
				 }
				 return redirect()->back()->with([
					 'case' => 'warning',
					 'title' => __('static.attention') . '!',
					 'content' => __('register.email_exists'),
					 'errorType' => $errorType,
					 
				 ])->withInput();
			 }
 
			 if (!$request->voen){
				 if (User::where('passport_number', $request->passport_number)->select('id')->first()) {
					$errorType = 'passport_number';
					 if($request->is('api/*')){
						 return response()->json([
							 'case' => 'warning',
							 'title' => __('static.attention') . '!',
							 'content' => __('register.passport_number_exists')
 
						 ],422);
					 }
					 return redirect()->back()->with([
						 'case' => 'warning',
						 'title' => __('static.attention') . '!',
						 'content' => __('register.passport_number_exists'),
						 'errorType' => $errorType,
					 ])->withInput();
				 }
			 }
 
 
			 if (!$request->voen){
				 if ($request->passport_series !== 'VOEN' && User::where('passport_fin', $request->passport_fin)->select('id')->first()) {
					$errorType = 'fin';
					 if($request->is('api/*')){
						 return response()->json([
							 'case' => 'warning',
							 'title' => __('static.attention') . '!',
							 'content' => __('register.passport_fin_exists')
 
						 ],422);
					 }
					 return redirect()->back()->with([
						 'case' => 'warning',
						 'title' => __('static.attention') . '!',
						 'content' => __('register.passport_fin_exists'),
						 'errorType' => $errorType,
					 ])->withInput();
				 }
			 }


             $phone1 = $request->phone1;

             $existUser = User::whereNull('deleted_by')->whereRaw('(phone1 = ? or phone2 = ?)', [$phone1, $phone1])->select('id')->first();



             if ($existUser) {
				$errorType = 'number';
				 if($request->is('api/*')){
					 return response()->json([
						 'case' => 'warning',
						 'title' => __('static.attention') . '!',
						 'content' => __('register.phone_exists')
 
					 ],422);
				 }
				 return redirect()->back()->with([
					 'case' => 'warning',
					 'title' => __('static.attention') . '!',
					 'content' => __('register.phone_exists'),
					 'errorType' => $errorType,
				 ])->withInput();
			 }


			 if ($request->phone2 !== null && !empty($request->phone2)) {
				 $phone2 = str_replace(['(', ')', '-'], '', $request->phone2);
				 $phone2 = '994' . substr($phone2, 1);
				 $request->phone2 = $phone2;
 
				 if (User::whereNull('deleted_by')->whereRaw('(phone1 = ? or phone2 = ?)', [$phone2, $phone2])->select('id')->first()) {
					$errorType = 'number';
					 if($request->is('api/*')){
						 return response()->json([
							 'case' => 'warning',
							 'title' => __('static.attention') . '!',
							 'content' => __('register.phone_exists')
 
						 ],422);
					 }
					 return redirect()->back()->with([
						 'case' => 'warning',
						 'title' => __('static.attention') . '!',
						 'content' => __('register.phone_exists'),
						 'errorType' => $errorType,
					 ])->withInput();
				 }
			 }
			 if($request->is('api/*')){
				 $city=Cities::where('id',$request->city)->first();
				 if($city){
					 $request->city=$city->name_en;
				 }else{
					 $request->city="Baki";
				 }
			 }

			 $response = $this->create($request);

             switch ($response[0]) {
				 case 0:
                     Log::channel('register_create')->error('Failed to create0.', ['message' => $response[1]]);
                     if($request->is('api/*')){
						 return response()->json([
							 'case' => 'error',
							 'title' => __('static.error') . '!',
							 'content' => __('static.error_text') . ' (1) - ',
                             'error'=>2

 
						 ],400);
					 }
					 return redirect()->back()->with([
						 'case' => 'error',
						 'title' => __('static.error'),
						 'content' => __('static.error_text') . ' (1) - '
					 ])->withInput();
				 case 2:
                     Log::channel('register_create')->error('Failed to create2.', ['message' => $response[1]]);

					 if($request->is('api/*')){
						 return response()->json([
							 'case' => 'warning',
							 'title' => __('static.error') . '!',
							 'content' => __('register.agreement_not_chosen')
 
						 ],422);
					 }
					 return redirect()->back()->with([
						 'case' => 'warning',
						 'title' => __('static.error'),
						 'content' => __('register.agreement_not_chosen')
					 ])->withInput();
				 case 1:
                     Log::channel('register_create')->error('Success.', ['message' => $response[1]]);

					 try {
						 $user = $response[1];
						 $this->guard()->login($user);
						 /*$resend_email = new VerificationController();
						 $resend_email->resendAjax($request);*/
						 $userId = $user->getAttribute('id');
						 $otp_session = $this->generateRandomCode();
						 if ( $request->verification=='sms'){
							 $sendOtp = new SendOTPCode();
							 $sendOtp->send_sms($userId, $request->phone1, $otp_session);
                             $otpType = 1;
                             $credential = $request->phone1;
						 }
						 elseif ( $request->verification=='email'){
							 $sendOtp = new SendOTPCode();
							 $sendOtp->send_mail($userId, $request->email, $otp_session);
                             $otpType = 2;
                             $credential = $request->email;
						 }
 
						 Auth::logout();

						 if($request->is('api/*')){
							 return response()->json([
								 'case' => 'success',
								 'phone1'=> $request->phone1,
								 'user_id'=>$userId,
                                 'OTP_TYPE'=>$otpType,
                                 'credential'=>$credential,
								 'title' => __('static.success'),
 
							 ],201);
						 }
 
						 return redirect()->route('otp_page', ['locale'=>App::getLocale(),'otp_session' => $otp_session,'otpType' => $otpType])->with([
							 'case' => 'success',
							 'title' => __('static.success'),
							 'content' => __('register.success_message'),
                             'otpType' => $otpType,
                             'credential'=>$credential
						 ]);
						 
					 } catch (\Exception $exception) {
						 Log::channel('register_verification')->error('Failed to send mail.', [
							 'id' => $response[1]->id,
							 'message' => $exception
						 ]);
						 return redirect()->back()->with([
							 'case' => 'error', 
							 'title' => __('static.error'), 
							 'content' => __('register.sent_email_error')
						 ])->withInput();
					 }
				 default:

                     Log::channel('register_create')->error('Failed to create.', ['message' => $response[1]]);

					 return redirect()->back()->with([
						 'case' => 'error', 
						 'title' => __('static.error'), 
						 'content' => __('static.error_text') . ' (2)'
					 ])->withInput();
			 }
		 } catch (\Exception $exception) {
			 if($request->is('api/*')){
				 return response()->json([
					 'case' => 'error',
					 'title' => __('static.error') . '!',
					 'content' => __('register.sent_email_error'),
                     'error'=>1

 
				 ],400);
			 }
             return $exception;
			 return redirect()->back()->with([
				 'case' => 'error',
				 'title' => __('static.error'),
				 'content' => __('register.sent_email_error')
			 ])->withInput();
		 }
	 }
	 public function resendOTP(Request $request){
		 $validatedData = Validator::make($request->all(),[
			 'user_id' => 'required',
			 'phone1' => 'required',
		 ]);
		 if($validatedData->fails()){
			 $messages = $validatedData->messages();
			 return response()->json(['status'=>false,"errors" => $messages]);
		 }
		 $userId=$request['user_id'];
		 $otp_session = $this->generateRandomCode();
		 $sendOtp = new SendOTPCode();
		 $sendOtp->send_sms($userId, $request['phone1'], $otp_session);
		 return response()->json([
			 'status' => true,
			 'message'=> 'OTP code was sent successfully'
		 ],200);
	 }
 
	 public function checkOTP(Request $request){
		 $validatedData = Validator::make($request->all(),[
			 'user_id' => 'required',
			 'otp' => 'required',
		 ]);
		 if($validatedData->fails()){
			 $messages = $validatedData->messages();
			 return response()->json(['status'=>false,"errors" => $messages],422);
		 }
		 $otp = OTP::query()
			 ->where('client_id', $request['user_id'])
			 ->select('otp')
			 ->orderByDesc('id')
			 ->first();
 
		 if (!$otp) {
			 return response()->json([
				 'status' => false,
				 'message' => 'No OTP found for this user'
			 ],400);
		 }
 
 
		 if ($request['otp'] != $otp->otp) {
			 return response()->json([
				 'status' => false,
				 'message' => 'OTP code is wrong'
			 ],400);
		 }
		 User::findOrFail($request->user_id)->update(['email_verified_at' =>  Carbon::now()]);
 
		 return response()->json([
			 'status' => true,
			 'message' => 'OTP code is true'
		 ],200);
 
	 }
    
    
    protected function generateRandomCode($length = 18) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomCode = '';
        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomCode;
    }
	public function testMurad(){
		$user = User::where('email','muradnesrullayev91@gmail.com')->first();
		// if(!$user){
			 $user->delete();
			 return 'aaa';
		// }
		return 'bbb';
	}


    public function register2(Request $request)
    {
        try {


             if($request->is('api/*')){
                 $request->merge([
                     'phone1' => str_replace("-", "", '994'.$request->phone1),
                 ]);
             }else{
                 $request->merge([
                     'phone1' => str_replace("-", "", '994'.$request->prefix.$request->phone_suffix),
                 ]);
             }
//             return $request;
            $request->is_legality = $this->convert_to_ascii($request->is_legality);
            $request->voen = $this->convert_to_ascii($request->voen);
            $request->company_name = $this->convert_to_ascii($request->company_name);
            $request->name = $this->convert_to_ascii($request->name);
            $request->surname = $this->convert_to_ascii($request->surname);
            $request->email = $this->convert_to_ascii($request->email);
            $request->phone1 = $this->convert_to_ascii($request->phone1);
            $request->phone2 = $this->convert_to_ascii($request->phone2);
            $request->city = $this->convert_to_ascii($request->city);
            $request->address1 = $this->convert_to_ascii($request->address1);
            $request->passport_series = $this->convert_to_ascii($request->passport_series);
            $request->passport_number = $this->convert_to_ascii($request->passport_number);
            $request->passport_fin = $this->convert_to_ascii($request->passport_fin);
            $request->location_longitude1 = $this->convert_to_ascii($request->location_longitude);
            $request->location_latitude1 = $this->convert_to_ascii($request->location_latitude);
            //            return $request;
            //            return $request->voen;

//             if($request->is_legality==1){
//                 $is_legality = 1;
//                 $request->passport_series="VOEN";
//                 $request->passport_number=$request->voen;
//             }
//
//             return $request;

            if ($request->is_legality==1){
                $validator = $this->validator($request,1);
            }
            else{
                $validator = $this->validator($request);
            }

            Log::channel('register_create')->error('Request.', ['message' => $request]);
            Log::channel('register_create')->error('Validator.', ['message' => $validator]);


            if ($validator->fails()) {
                if($request->is('api/*')){
                    $messages = $validator->messages();
                    return response()->json([
                        'case' => 'warning',
                        'title' => __('static.attention') . '!',
                        "content" => $messages
                    ],422);
                }

                return redirect()->back()->withErrors($validator)->withInput();
            }

//             $request->phone1 = preg_replace("/[^0-9,.]/", "",$request->phone1);
//
//             $request->phone1 = preg_replace("/[^0-9]/", "", $request->phone1);


            if($request->is('api/*')){
                if (strlen($request->phone1) !== 12 ) {
                    $errorType = 'number2';
                    if($request->is('api/*')){
                        return response()->json([
                            'case' => 'warning',
                            'title' => __('static.attention') . '!',
                            'content' => 'Telfon nömrəsini düzgün daxil edin'

                        ],422);
                    }
//                 return $errorType;

                }

            }else{
                if (strlen($request->phone1) !== 12 ) {

                    $errorType = 'number2';

                    return redirect()->back()->with([
                        'case' => 'warning',
                        'title' => __('static.attention') . '!',
                        'content' => 'Telfon nömrəsi doğru deyil',
                        'errorType' => $errorType,
                    ])->withInput();
                }
            }


            if ($request->is_legality==0){
                if($request->is('api/*')){
                    $request->birthday = \Carbon\Carbon::createFromFormat('d.m.Y', $request->birthday)->format('Y-m-d');
                }
            }



            if (!$request->voen){
                $birthday = $request->input('birthday');
                $birthdayDate = Carbon::parse($birthday);
                $age = Carbon::now()->diffInYears($birthdayDate);
                if ($age < 18) {
                    $errorType = 'age';
                    //  return $errorType;
                    return redirect()->back()->with([
                        'case' => 'warning',
                        'title' => __('static.attention') . '!',
                        'content' => '18 yaşdan böyük olmalısınız',
                        'errorType' => $errorType,
                    ])->withInput();
                }

            }

            // Check for existing user conflicts
            if (!User::where('email', $request->email)->select('id')->first() && User::withoutGlobalScope(DeletedScope::class)->where('email', $request->email)->select('id')->first()) {
                $errorType = 'email';
                if($request->is('api/*')){
                    //  return $errorType;
                    return response()->json([
                        'case' => 'warning',
                        'title' => __('static.attention') . '!',
                        'content' => __('register.user_deleted'),
                        'errorType' => $errorType,

                    ],422);
                }

                return redirect()->back()->with([
                    'case' => 'warning',
                    'title' => __('static.attention') . '!',
                    'content' => __('register.user_deleted'),
                    'errorType' => $errorType,
                ])->withInput();
            }

            if (User::where('email', $request->email)->select('id')->first()) {
                $errorType = 'email';
                // return $errorType;
                if($request->is('api/*')){

                    return response()->json([
                        'case' => 'warning',
                        'title' => __('static.attention') . '!',
                        'content' => __('register.email_exists')

                    ],422);
                }
                return redirect()->back()->with([
                    'case' => 'warning',
                    'title' => __('static.attention') . '!',
                    'content' => __('register.email_exists'),
                    'errorType' => $errorType,

                ])->withInput();
            }

            if (!$request->voen){
                if (User::where('passport_number', $request->passport_number)->select('id')->first()) {
                    $errorType = 'passport_number';
                    if($request->is('api/*')){
                        return response()->json([
                            'case' => 'warning',
                            'title' => __('static.attention') . '!',
                            'content' => __('register.passport_number_exists')

                        ],422);
                    }
                    return redirect()->back()->with([
                        'case' => 'warning',
                        'title' => __('static.attention') . '!',
                        'content' => __('register.passport_number_exists'),
                        'errorType' => $errorType,
                    ])->withInput();
                }
            }


            if (!$request->voen){
                if ($request->passport_series !== 'VOEN' && User::where('passport_fin', $request->passport_fin)->select('id')->first()) {
                    $errorType = 'fin';
                    if($request->is('api/*')){
                        return response()->json([
                            'case' => 'warning',
                            'title' => __('static.attention') . '!',
                            'content' => __('register.passport_fin_exists')

                        ],422);
                    }
                    return redirect()->back()->with([
                        'case' => 'warning',
                        'title' => __('static.attention') . '!',
                        'content' => __('register.passport_fin_exists'),
                        'errorType' => $errorType,
                    ])->withInput();
                }
            }

            $phone1 = $request->phone1;

            $existUser = User::whereNull('deleted_by')->whereRaw('(phone1 = ? or phone2 = ?)', [$phone1, $phone1])->select('id')->first();



            if ($existUser) {
                $errorType = 'number';
                if($request->is('api/*')){
                    return response()->json([
                        'case' => 'warning',
                        'title' => __('static.attention') . '!',
                        'content' => __('register.phone_exists')

                    ],422);
                }
                return redirect()->back()->with([
                    'case' => 'warning',
                    'title' => __('static.attention') . '!',
                    'content' => __('register.phone_exists'),
                    'errorType' => $errorType,
                ])->withInput();
            }


            if ($request->phone2 !== null && !empty($request->phone2)) {
                $phone2 = str_replace(['(', ')', '-'], '', $request->phone2);
                $phone2 = '994' . substr($phone2, 1);
                $request->phone2 = $phone2;

                if (User::whereNull('deleted_by')->whereRaw('(phone1 = ? or phone2 = ?)', [$phone2, $phone2])->select('id')->first()) {
                    $errorType = 'number';
                    if($request->is('api/*')){
                        return response()->json([
                            'case' => 'warning',
                            'title' => __('static.attention') . '!',
                            'content' => __('register.phone_exists')

                        ],422);
                    }
                    return redirect()->back()->with([
                        'case' => 'warning',
                        'title' => __('static.attention') . '!',
                        'content' => __('register.phone_exists'),
                        'errorType' => $errorType,
                    ])->withInput();
                }
            }
            if($request->is('api/*')){
                $city=Cities::where('id',$request->city)->first();
                if($city){
                    $request->city=$city->name_en;
                }else{
                    $request->city="Baki";
                }
            }

            $response = $this->create($request);

            switch ($response[0]) {
                case 0:
                    Log::channel('register_create')->error('Failed to create.', ['message' => $response[1]]);
                    if($request->is('api/*')){
                        return response()->json([
                            'case' => 'error',
                            'title' => __('static.error') . '!',
                            'content' => __('static.error_text') . ' (1) - ',
                            'error'=>2


                        ],400);
                    }
                    return redirect()->back()->with([
                        'case' => 'error',
                        'title' => __('static.error'),
                        'content' => __('static.error_text') . ' (1) - '
                    ])->withInput();
                case 2:
                    Log::channel('register_create')->error('Failed to create.', ['message' => $response[1]]);

                    if($request->is('api/*')){
                        return response()->json([
                            'case' => 'warning',
                            'title' => __('static.error') . '!',
                            'content' => __('register.agreement_not_chosen')

                        ],422);
                    }
                    return redirect()->back()->with([
                        'case' => 'warning',
                        'title' => __('static.error'),
                        'content' => __('register.agreement_not_chosen')
                    ])->withInput();
                case 1:
                    Log::channel('register_create')->error('Failed to create.', ['message' => $response[1]]);

                    try {
                        $user = $response[1];
                        $this->guard()->login($user);
                        /*$resend_email = new VerificationController();
                        $resend_email->resendAjax($request);*/
                        $userId = $user->getAttribute('id');
                        $otp_session = $this->generateRandomCode();
                        if ( $request->verification=='sms'){
                            $sendOtp = new SendOTPCode();
                            $sendOtp->send_sms($userId, $request->phone1, $otp_session);
                            $otpType = 1;
                            $credential = $request->phone1;
                        }
                        elseif ( $request->verification=='email'){
                            $sendOtp = new SendOTPCode();
                            $sendOtp->send_mail($userId, $request->email, $otp_session);
                            $otpType = 2;
                            $credential = $request->email;
                        }

                        Auth::logout();

                        if($request->is('api/*')){
                            return response()->json([
                                'case' => 'success',
                                'phone1'=> $request->phone1,
                                'user_id'=>$userId,
                                'OTP_TYPE'=>$otpType,
                                'credential'=>$credential,
                                'title' => __('static.success'),

                            ],201);
                        }

                        return redirect()->route('otp_page', ['locale'=>App::getLocale(),'otp_session' => $otp_session,'otpType' => $otpType])->with([
                            'case' => 'success',
                            'title' => __('static.success'),
                            'content' => __('register.success_message'),
                            'otpType' => $otpType,
                            'credential'=>$credential
                        ]);

                    } catch (\Exception $exception) {
                        Log::channel('register_verification')->error('Failed to send mail.', [
                            'id' => $response[1]->id,
                            'message' => $exception
                        ]);
                        return redirect()->back()->with([
                            'case' => 'error',
                            'title' => __('static.error'),
                            'content' => __('register.sent_email_error')
                        ])->withInput();
                    }
                default:

                    Log::channel('register_create')->error('Failed to create.', ['message' => $response[1]]);

                    return redirect()->back()->with([
                        'case' => 'error',
                        'title' => __('static.error'),
                        'content' => __('static.error_text') . ' (2)'
                    ])->withInput();
            }
        } catch (\Exception $exception) {
            if($request->is('api/*')){
                return response()->json([
                    'case' => 'error',
                    'title' => __('static.error') . '!',
                    'content' => __('register.sent_email_error'),
                    'error'=>1


                ],400);
            }
            return $exception;
            return redirect()->back()->with([
                'case' => 'error',
                'title' => __('static.error'),
                'content' => __('register.sent_email_error')
            ])->withInput();
        }
    }
}
