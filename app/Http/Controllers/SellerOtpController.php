<?php
    
    namespace App\Http\Controllers;
    
    use App\Seller;
    use App\SellerOtp;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class SellerOtpController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $sellerOtps = SellerOtp::paginate(50);
            return view('front.account.seller_otp', compact('sellerOtps'));
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
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $request->validate([
                'otp_code' => 'required|string|max:255',
                'otp_text' => 'required|string|max:255',
               
            ]);
            
            $request->merge([
                'is_active' => 0,
                'created_by' => Auth::user()->id,
                'seller_id' => 2,
            ]);
            
            SellerOtp::create($request->all());
            return response(['case' => 'success', 'title' => __('static.success'), 'content' => __('static.success')]);
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
