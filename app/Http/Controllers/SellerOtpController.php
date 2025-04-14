<?php
    
    namespace App\Http\Controllers;
    
    use App\Seller;
    use App\SellerOtp;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;


    class SellerOtpController extends Controller
    {
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
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            $sellerOtps = SellerOtp::orderBy('id','desc')->where('created_by',Auth::id())->paginate(15);


            $sellerOtps->getCollection()->transform(function ($item) {
                $item->created_at = \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i');
                return $item;
            });

            if($request->is('api/*')){
                return response()->json([
                    'message'=>'success',
                    'data'=>$sellerOtps
                ]);
            }

            return view('front.account.seller_otp', compact('sellerOtps'));
        }

        public function getTrendyolOtp(){
            $data=[];
            try {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://onaykodu.bionet.az/api/trendyolsms-list?cargo_id=2",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER=>0,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-Api-Key: BisFgRG9lIewerWFPostazeo0Ijcargo2MjMASDDIyS.xvbde'
                    )
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $response = json_decode($response);
                if (is_array($response)) {
                    $data=$response;
                }
                $date=strtotime('-3 minutes');
                $array=[];
                $say=0;
                $threeMinutesAgo = now()->subMinutes(3);
                $filtered = [];
                $say = 0;

                foreach ($response as $item) {
                    $createdAt = \Carbon\Carbon::createFromFormat('d.m.Y H:i:s', $item->created);

                    if ($createdAt >= $threeMinutesAgo) {
                        $filtered[] = [
                            'id' => ++$say,
                            'onay_code' => $item->onaykodu,
                            'date' => $createdAt->format('Y-m-d H:i')
                        ];
                    }
                }
                return  response()->json([
                    'success' => true,
                    'data' => $filtered
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage()
                ]);
            }
        }
        
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $sellers = Seller::get();
            return view('front.account.seller_otp_add', compact('sellers'));
        }
        
        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'otp_code' => 'required|string|max:255',
                'otp_text' => 'required|string|max:255',
            ], [
                'required' => ':attribute mütləq doldurulmalıdır',
                'string' => ':attribute mətn formatında olmalıdır',
                'max' => ':attribute maksimum :max simvol olmalıdır',
            ], [
                'otp_code' => 'Otp kod',
                'otp_text' => 'Track Id',
            ]);
        
            if ($validator->fails()) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'case' => 'error',
                        'errors' => $validator->errors(),
                        'message' => 'Məlumatlar düzgün deyil'
                    ], 422);
                }
        
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validator)
                    ->with(['case' => 'error']);
            }
        
            if ($request->filled('otp_code') && $request->filled('otp_text')) {
                $request->merge([
                    'is_active' => 0,
                    'created_by' => Auth::id(),
                    'seller_id' => 2,
                ]);
        
                SellerOtp::create($request->all());
        
                if ($request->is('api/*')) {
                    return response()->json([
                        'case' => 'success',
                        'title' => __('static.success'),
                        'content' => __('static.success')
                    ]);
                }
        
                return redirect()->route('get_seller_otp', ['locale' => App::getLocale()])
                    ->with([
                        'case' => 'success',
                        'title' => __('static.success'),
                        'content' => __('static.success')
                    ]);
            }
        
            // Bu hissəyə düşərsə, valid input yoxdur
            if ($request->is('api/*')) {
                return response()->json([
                    'case' => 'error',
                    'content' => 'Məlumatları düzgün daxil edin'
                ], 422);
            }
        
            return redirect()->back()->with([
                'case' => 'error',
                'content' => 'Məlumatları düzgün daxil edin'
            ]);
        }
        
        /**
         * Display the specified resource.
         *
         * @param  \App\Models\SellerOtp  $sellerOtp
         * @return \Illuminate\Http\Response
         */
        public function show(SellerOtp $sellerOtp)
        {
            return view('seller_otps.show', compact('sellerOtp'));
        }
        
        /**
         * Show the form for editing the specified resource.
         *
         * @param  \App\Models\SellerOtp  $sellerOtp
         * @return \Illuminate\Http\Response
         */
        public function edit(SellerOtp $sellerOtp)
        {
            return view('seller_otps.edit', compact('sellerOtp'));
        }
        
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\Models\SellerOtp  $sellerOtp
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, SellerOtp $sellerOtp)
        {
            $request->validate([
                'otp_code' => 'required|string|max:255',
                'otp_text' => 'required|string|max:255',
            ]);
            
            $sellerOtp->update($request->all());
            
            return redirect()->route('get_seller_otp')
                ->with('success', 'Seller OTP updated successfully.');
        }
        
        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Models\SellerOtp  $sellerOtp
         * @return \Illuminate\Http\Response
         */
        public function destroy(SellerOtp $sellerOtp)
        {
            $sellerOtp->delete();
            
            return redirect()->route('seller-otps.index')
                ->with('success', 'Seller OTP deleted successfully.');
        }
    }
