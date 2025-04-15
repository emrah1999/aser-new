<?php

namespace App\Http\Controllers;

use App\ClientsLog;
use App\Contract;
use App\ExchangeRate;
use App\Exports\ClientPackagesExport;
use App\Package;
use App\PackingService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends HomeController
{
    public function show() {
        try {
            $query = User::leftJoin('contract as c', 'users.contract_id', '=', 'c.id')
                 ->leftJoin('filial as br', 'users.branch_id', '=', 'br.id')
                ->where(['users.role_id'=>2])
                ->whereNull('users.deleted_by');

            $search_arr = array(
                'suite' => '',
                'parent' => '',
                'name' => '',
                'surname' => '',
                'passport' => '',
                'address' => '',
                'phone' => '',
                'email' => '',
                'username' => '',
                'contract' => '',
            );

            if (!empty(Input::get('suite')) && Input::get('suite') != ''  && Input::get('suite') != null) {
                $where_suite = Input::get('suite');
                $query->where('users.id', $where_suite);
                $search_arr['suite'] = $where_suite;
            }

            if (!empty(Input::get('parent')) && Input::get('parent') != ''  && Input::get('parent') != null) {
                $where_parent = Input::get('parent');
                $query->where('users.parent_id', $where_parent);
                $search_arr['parent'] = $where_parent;
            }

            if (!empty(Input::get('name')) && Input::get('name') != ''  && Input::get('name') != null) {
                $where_name = Input::get('name');
                $query->where('users.name', 'LIKE', '%'.$where_name.'%');
                $search_arr['name'] = $where_name;
            }

            if (!empty(Input::get('surname')) && Input::get('surname') != ''  && Input::get('surname') != null) {
                $where_surname = Input::get('surname');
                $query->where('users.surname', 'LIKE', '%'.$where_surname.'%');
                $search_arr['surname'] = $where_surname;
            }

            if (!empty(Input::get('passport')) && Input::get('passport') != ''  && Input::get('passport') != null) {
                $where_passport = Input::get('passport');
                $query->where('users.passport_number', 'LIKE', '%'.$where_passport.'%');
                $search_arr['passport'] = $where_passport;
            }

            if (!empty(Input::get('address')) && Input::get('address') != ''  && Input::get('address') != null) {
                $where_address = Input::get('address');
                $query->whereRaw("
                    users.address1 LIKE '%".$where_address."%'
                ");
                $search_arr['address'] = $where_address;
            }

            if (!empty(Input::get('phone')) && Input::get('phone') != ''  && Input::get('phone') != null) {
                $where_phone = Input::get('phone');
                $query->whereRaw("
                    users.phone1 LIKE '%".$where_phone."%' or
                    users.phone2 LIKE '%".$where_phone."%'
                ");
                $search_arr['phone'] = $where_phone;
            }

            if (!empty(Input::get('email')) && Input::get('email') != ''  && Input::get('email') != null) {
                $where_email = Input::get('email');
                $query->where('users.email', 'LIKE', '%'.$where_email.'%');
                $search_arr['email'] = $where_email;
            }

            if (!empty(Input::get('username')) && Input::get('username') != ''  && Input::get('username') != null) {
                $where_username = Input::get('username');
                $query->where('users.username', 'LIKE', '%'.$where_username.'%');
                $search_arr['username'] = $where_username;
            }

            if (!empty(Input::get('contract')) && Input::get('contract') != ''  && Input::get('contract') != null) {
                $where_contract_id = Input::get('contract');
                $query->where('users.contract_id', $where_contract_id);
                $search_arr['contract'] = $where_contract_id;
            }

            //short by start
            $short_by = 'users.id';
            $shortType = 'DESC';
            if (!empty(Input::get('shortBy')) && Input::get('shortBy') != ''  && Input::get('shortBy') != null) {
                $short_by = Input::get('shortBy');
            }
            if (!empty(Input::get('shortType')) && Input::get('shortType') != ''  && Input::get('shortType') != null) {
                $short_type = Input::get('shortType');
                if ($short_type == 2) {
                    $shortType = 'DESC';
                } else {
                    $shortType = 'ASC';
                }
            }
            //short by finish
            if(Auth::user()->role() == 9){
                if($search_arr['parent_id'] != "" ){
                    $clients = $query
                        ->orderBy($short_by, $shortType)
                        ->select(
                            'users.id', //suite
                            'users.parent_id',
                            'users.suite',
                            'users.name',
                            'users.surname',
                            'users.username',
                            'users.first_pass',
                            'users.passport_series',
                            'users.passport_number',
                            'users.passport_fin',
                            'users.birthday',
                            'users.gender',
                            'users.balance',
                            'users.language',
                            'users.contract_id',
                            'c.system as contract',
                            'users.email',
                            'users.phone1',
                            'users.phone2',
                            'users.address1',
                            'users.zip1',
                            'users.created_at',
                            'users.is_legality',
                            'users.is_partner',
                            'users.branch_id',
                            'br.name as branch_name',
                        )
                        ->paginate(50);
                }
                else{
                    $clients = $query
                        ->orderBy($short_by, $shortType)
                        ->select(
                            'users.id', //suite
                            'users.parent_id',
                            'users.suite',
                            'users.name',
                            'users.surname',
                            'users.username',
                            'users.first_pass',
                            'users.passport_series',
                            'users.passport_number',
                            'users.passport_fin',
                            'users.birthday',
                            'users.gender',
                            'users.balance',
                            'users.language',
                            'users.contract_id',
                            'c.system as contract',
                            'users.email',
                            'users.phone1',
                            'users.phone2',
                            'users.address1',
                            'users.zip1',
                            'users.created_at',
                            'users.is_legality',
                            'users.is_partner',
                            'users.branch_id',
                            'br.name as branch_name',
                        )
                        ->paginate(1);
                }
            }else{
                $clients = $query
                ->orderBy($short_by, $shortType)
                    ->select(
                        'users.id', //suite
                        'users.parent_id',
                        'users.suite',
                        'users.name',
                        'users.surname',
                        'users.username',
                        'users.first_pass',
                        'users.passport_series',
                        'users.passport_number',
                        'users.passport_fin',
                        'users.birthday',
                        'users.gender',
                        'users.balance',
                        'users.language',
                        'users.contract_id',
                        'c.system as contract',
                        'users.email',
                        'users.phone1',
                        'users.phone2',
                        'users.address1',
                        'users.zip1',
                        'users.created_at',
                        'users.is_legality',
                        'users.is_partner',
                        'users.branch_id',
                        'br.name as branch_name',
                    )
                    ->paginate(50);
            }

            $contracts = Contract::whereNull('deleted_by')->select('id', 'system as description')->get();
            $packing_services = PackingService::whereNull('deleted_by')->select('id', 'title')->get();
            $branchs = DB::table('filial')->where('is_active', 1)->get();

            $date = Carbon::today();
            $rate = ExchangeRate::whereDate('from_date', '<=', $date)
                ->whereDate('to_date', '>=', $date)
                ->where('from_currency_id', 1)
                ->where('to_currency_id', 3)
                ->select('rate')
                ->orderBy('id', 'desc')
                ->first();

            if (!$rate) {
                // rate note found
                $rate_usd_to_azn = 0;
            } else {
                $rate_usd_to_azn = $rate->rate;
            }

            foreach ($clients as $client) {
                $balance_usd = $client->balance;
                $balance_azn = $balance_usd * $rate_usd_to_azn;
                $balance_azn = sprintf('%0.2f', $balance_azn);
                $client->balance_azn = $balance_azn;
            }

            return view("backend.clients", compact(
                'clients',
                'contracts',
                'packing_services',
                'search_arr',
                'branchs'
            ));
        } catch (\Exception $exception) {
            //dd($exception);
            return view('backend.error');
        }
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'content' => 'Id not found!']);
        }
        try {
            User::where(['id'=>$request->id, 'role_id'=>2])->whereNull('deleted_by')->update(['deleted_by'=>Auth::id(), 'deleted_at'=>Carbon::now()]);

            $request_string = json_encode($request->all());

            ClientsLog::create([
                'type' => 'delete',
                'client_id' => $request->id,
                'request' => $request_string,
                'role_id' => Auth::user()->role(),
                'created_by' => Auth::id()
            ]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successful!', 'id'=>$request->id]);
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'An error occurred!']);
        }
    }

    public function add(Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'parent_id' => ['nullable', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address1' => ['required', 'string', 'max:100'],
            'zip1' => ['nullable', 'string', 'max:30'],
            //'phone1' => ['required', 'string', 'max:30'],
            'phone1' => ['required', 'string', 'regex:/^994[0-9]{9}$/', 'min:12', 'max:15'],
//            'address2' => ['nullable', 'string', 'max:100'],
//            'zip2' => ['nullable', 'string', 'max:30'],
            'phone2' => ['nullable', 'string', 'max:30'],
//            'address3' => ['nullable', 'string', 'max:100'],
//            'zip3' => ['nullable', 'string', 'max:30'],
//            'phone3' => ['nullable', 'string', 'max:30'],
            'birthday' => ['nullable', 'date'],
            'gender' => ['required', 'integer'],
//            'suite' => ['required', 'string', 'max:10'],
            'contract_id' => ['nullable', 'integer'],
            'language' => ['required', 'string', 'max:50'],
//            'console_option' => ['nullable', 'string', 'max:15'],
//            'packing_service_id' => ['required', 'integer'],
//            'console_limit' => ['nullable', 'integer'],
            'is_legality' => ['nullable'],
            'is_partner' => ['nullable'],
            'branch_id' => ['required']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type'=>'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            unset($request['id']);
            $request->merge(['created_by'=>Auth::id(), 'role_id'=>2]);

            $old_password = $request->password;

            $new_password = Hash::make($old_password);
            unset($request['password']);
            $request['password'] = $new_password;

            if (Auth::user()->role() != 2) {
                $request->merge(['first_pass'=>$old_password]);
            }

            if (isset($request->parent_id) && !empty($request->parent_id) && (!isset($request->contract_id) || empty($request->contract_id))) {
                $parent = User::where(['id' =>$request->parent_id, 'role_id' => 2])->select('contract_id')->first();
                if ($parent) {
                    unset($request['contract_id']);
                    $parent_contract_id = $parent->contract_id;
                    $request->merge(['contract_id' => $parent_contract_id]);
                }
            }
            
            
            if($request->is_legality == true){
                $is_legal = 1;
            }else{
                $is_legal = 0;
            }

            if($request->is_partner == true){
                $is_partner = 1;
            }else{
                $is_partner = 0;
            }
           
            $request->merge([
                'is_legality' => $is_legal,
                'is_partner' => $is_partner,
            ]);
            //dd($request->all());
            $add = User::create($request->all());
           
            $request_string = json_encode($request->all());

            ClientsLog::create([
                'type' => 'add',
                'client_id' => $add->id,
                'request' => $request_string,
                'role_id' => Auth::user()->role(),
                'created_by' => Auth::id()
            ]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successful!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function update(Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer'],
            'parent_id' => ['nullable', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$request->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id],
            'address1' => ['required', 'string', 'max:100'],
            'zip1' => ['nullable', 'string', 'max:30'],
            'phone1' => ['required', 'string', 'regex:/^994[0-9]{9}$/', 'min:12', 'max:15'],
//            'address2' => ['nullable', 'string', 'max:100'],
//            'zip2' => ['nullable', 'string', 'max:30'],
            'phone2' => ['nullable', 'string', 'max:30'],
//            'address3' => ['nullable', 'string', 'max:100'],
//            'zip3' => ['nullable', 'string', 'max:30'],
//            'phone3' => ['nullable', 'string', 'max:30'],
            'birthday' => ['nullable', 'date'],
            'gender' => ['required', 'integer'],
//            'suite' => ['required', 'string', 'max:10'],
            'contract_id' => ['nullable', 'integer'],
            'language' => ['required', 'string', 'max:50'],
//            'console_option' => ['nullable', 'string', 'max:15'],
//            'packing_service_id' => ['required', 'integer'],
//            'console_limit' => ['nullable', 'integer'],
            'is_legality' => ['nullable'],
            'is_partner' => ['nullable'],
            'branch_id' => ['required']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type'=>'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {

            if($request['parent_id'] == null && $request['contract_id'] == null){
                unset($request['parent_id']);
                unset($request['contract_id']);
            }
  
            $id = $request->id;
            unset($request['id'], $request['_token']);

            $is_legal = 0;

            if (empty($request->password) || !isset($request->password)) {
                unset($request['password']);
            }
            else {
                if (Auth::user()->role() != 2) {
                    $request->merge(['first_pass'=>$request->password]);
                }

                $new_password = Hash::make($request->password);
                unset($request['password']);
                $request['password'] = $new_password;
            }

            if (isset($request->parent_id) && !empty($request->parent_id) && (!isset($request->contract_id) || empty($request->contract_id))) {
                $parent = User::where(['id' =>$request->parent_id, 'role_id' => 2])->select('contract_id')->first();
                if ($parent) {
                    unset($request['contract_id']);
                    $parent_contract_id = $parent->contract_id;
                    $request->merge(['contract_id' => $parent_contract_id]);
                }
            }

            if($request->is_legality == true){
                $is_legal = 1;
            }else{
                $is_legal = 0;
            }

            if($request->is_partner == true){
                $is_partner = 1;
            }else{
                $is_partner = 0;
            }
           
           
            $request->merge([
                'is_legality' => $is_legal,
                'is_partner' => $is_partner
            ]);
            
            // dd($is_legal);
            $currentUser = User::find($id);
            
            User::where(['id'=>$id, 'role_id'=>2])->update($request->all());
            
            User::where(['parent_id'=>$id, 'role_id'=>2])->update(['contract_id'=>$request->contract_id]);
            

            $request_string = json_encode($request->all());
            $currentString = json_encode($currentUser);

            ClientsLog::create([
                'type' => 'update',
                'client_id' => $id,
                'request' => $request_string,
                'current' => $currentString,
                'role_id' => Auth::user()->role(),
                'created_by' => Auth::id()
            ]);

            if ($currentUser) {
                if ($currentUser->passport_fin != $request->get('passport_fin')) {
                    $update = Package::where('client_id', $id)
                        ->whereIn('carrier_status_id', [0, 4])
                        ->whereNull('deleted_at')
                        ->whereNull('deleted_by')
                        ->whereNull('delivered_at')
                        ->update([
                            'carrier_status_id' => 9
                        ]);
                }
            }

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successful!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function admin_export_packages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => ['required', 'integer'],
            'referral_packages' => ['required', 'string', 'max:3'],
            'delivered_packages' => ['required', 'string', 'max:3']
        ]);
        if ($validator->fails()) {
            Session::flash('message', 'Validation error!');
            Session::flash('class', 'warning');
            Session::flash('display', 'block');
            return redirect()->route("get_declaration_page");
        }
        try {
            return Excel::download(new ClientPackagesExport($request->client_id, $request->delivered_packages, $request->referral_packages), 'client_packages.xlsx');
        } catch (\Exception $e) {
            Session::flash('message', 'Sorry something went wrong!');
            Session::flash('class', 'danger');
            Session::flash('display', 'block');
            return redirect()->route("get_declaration_page");
        }
    }

    public function client_log(Request $request){

        try {
           
            $user = $request->id;

            $clients = ClientsLog::leftJoin('users', 'clients_log.created_by', '=', 'users.id')
            ->where('client_id', $user)
            ->orderBy('created_at', 'desc')
            ->select(
                'clients_log.id',
                'clients_log.client_id',
                'clients_log.type',
                'clients_log.request',
                'clients_log.current',
                'clients_log.created_at',
                'clients_log.created_by',
                'users.name',
                'users.surname'
            )
            ->get();
            // dd($clients);
            $arr = [];

            foreach($clients as $key => $client){

                $request = $client['request'];
                $decode_request = json_decode($request,true);

                $current = $client['current'];
                $decode_current = json_decode($current,true);

                if($decode_current == null){
                    $result_array = $decode_request;
                }else{
                    $result_array = array_diff_assoc($decode_request, $decode_current);
                }



                $createdDate = substr($client['created_at'], 0, 19);

                $createdBy = $client->name. ' ' .$client->surname;

                array_push($arr,[
                    'Changes' => $result_array,
                    'Date' => $createdDate,
                    'User' => $createdBy
                ]);
                
                
            }
                
                // dd($arr);

            return response()->json($arr);

        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }

    }

    public function manager_client_show() {
        try {
            $query = User::leftJoin('contract as c', 'users.contract_id', '=', 'c.id')
                ->leftJoin('filial as br', 'users.branch_id', '=', 'br.id')
                ->where(['users.role_id'=>2])
                ->whereNull('users.deleted_by');

            $search_arr = array(
                'suite' => '',
                'parent' => '',
                'name' => '',
                'surname' => '',
                'passport' => '',
                'address' => '',
                'phone' => '',
                'email' => '',
                'username' => '',
                'contract' => '',
            );

            if (!empty(Input::get('suite')) && Input::get('suite') != ''  && Input::get('suite') != null) {
                $where_suite = Input::get('suite');
                $query->where('users.id', $where_suite);
                $search_arr['suite'] = $where_suite;
            }

            if (!empty(Input::get('parent')) && Input::get('parent') != ''  && Input::get('parent') != null) {
                $where_parent = Input::get('parent');
                $query->where('users.parent_id', $where_parent);
                $search_arr['parent'] = $where_parent;
            }

            if (!empty(Input::get('name')) && Input::get('name') != ''  && Input::get('name') != null) {
                $where_name = Input::get('name');
                $query->where('users.name', 'LIKE', '%'.$where_name.'%');
                $search_arr['name'] = $where_name;
            }

            if (!empty(Input::get('surname')) && Input::get('surname') != ''  && Input::get('surname') != null) {
                $where_surname = Input::get('surname');
                $query->where('users.surname', 'LIKE', '%'.$where_surname.'%');
                $search_arr['surname'] = $where_surname;
            }

            if (!empty(Input::get('passport')) && Input::get('passport') != ''  && Input::get('passport') != null) {
                $where_passport = Input::get('passport');
                $query->where('users.passport_number', 'LIKE', '%'.$where_passport.'%');
                $search_arr['passport'] = $where_passport;
            }

            if (!empty(Input::get('address')) && Input::get('address') != ''  && Input::get('address') != null) {
                $where_address = Input::get('address');
                $query->whereRaw("
                    users.address1 LIKE '%".$where_address."%'
                ");
                $search_arr['address'] = $where_address;
            }

            if (!empty(Input::get('phone')) && Input::get('phone') != ''  && Input::get('phone') != null) {
                $where_phone = Input::get('phone');
                $query->whereRaw("
                    users.phone1 LIKE '%".$where_phone."%' or
                    users.phone2 LIKE '%".$where_phone."%'
                ");
                $search_arr['phone'] = $where_phone;
            }

            if (!empty(Input::get('email')) && Input::get('email') != ''  && Input::get('email') != null) {
                $where_email = Input::get('email');
                $query->where('users.email', 'LIKE', '%'.$where_email.'%');
                $search_arr['email'] = $where_email;
            }

            if (!empty(Input::get('username')) && Input::get('username') != ''  && Input::get('username') != null) {
                $where_username = Input::get('username');
                $query->where('users.username', 'LIKE', '%'.$where_username.'%');
                $search_arr['username'] = $where_username;
            }

            if (!empty(Input::get('contract')) && Input::get('contract') != ''  && Input::get('contract') != null) {
                $where_contract_id = Input::get('contract');
                $query->where('users.contract_id', $where_contract_id);
                $search_arr['contract'] = $where_contract_id;
            }

            //short by start
            $short_by = 'users.id';
            $shortType = 'DESC';
            if (!empty(Input::get('shortBy')) && Input::get('shortBy') != ''  && Input::get('shortBy') != null) {
                $short_by = Input::get('shortBy');
            }
            if (!empty(Input::get('shortType')) && Input::get('shortType') != ''  && Input::get('shortType') != null) {
                $short_type = Input::get('shortType');
                if ($short_type == 2) {
                    $shortType = 'DESC';
                } else {
                    $shortType = 'ASC';
                }
            }
            //short by finish

            if( $search_arr['suite'] != "" ||  $search_arr['parent'] != "" ||  $search_arr['name'] != "" || $search_arr['surname'] != "" || $search_arr['passport'] != "" || $search_arr['phone'] != "" || $search_arr['email'] != "" || $search_arr['email'] != ""){
                $clients = $query
                ->orderBy($short_by, $shortType)
                ->select(
                    'users.id', //suite
                    'users.parent_id',
                    'users.suite',
                    'users.name',
                    'users.surname',
                    'users.username',
                    'users.first_pass',
                    'users.passport_series',
                    'users.passport_number',
                    'users.passport_fin',
                    'users.birthday',
                    'users.gender',
                    'users.balance',
                    'users.language',
                    'users.contract_id',
                    'c.system as contract',
                    'users.email',
                    'users.phone1',
                    'users.phone2',
                    'users.address1',
                    'users.zip1',
                    'users.created_at',
                    'users.is_legality',
                    'users.is_partner',
                    'users.branch_id',
                    'br.name as branch_name',
                )
                ->paginate(30);

            }else{
                $clients = $query
                ->orderBy($short_by, $shortType)
                ->select(
                    'users.id', //suite
                    'users.parent_id',
                    'users.suite',
                    'users.name',
                    'users.surname',
                    'users.username',
                    'users.first_pass',
                    'users.passport_series',
                    'users.passport_number',
                    'users.passport_fin',
                    'users.birthday',
                    'users.gender',
                    'users.balance',
                    'users.language',
                    'users.contract_id',
                    'c.system as contract',
                    'users.email',
                    'users.phone1',
                    'users.phone2',
                    'users.address1',
                    'users.zip1',
                    'users.created_at',
                    'users.is_legality',
                    'users.is_partner',
                    'users.branch_id',
                    'br.name as branch_name',
                );
                //->paginate(1);
            }
            
            $contracts = Contract::whereNull('deleted_by')->select('id', 'system as description')->get();
            $packing_services = PackingService::whereNull('deleted_by')->select('id', 'title')->get();
            $branchs = DB::table('filial')->where('is_active', 1)->get();
    
            $date = Carbon::today();
            $rate = ExchangeRate::whereDate('from_date', '<=', $date)
                ->whereDate('to_date', '>=', $date)
                ->where('from_currency_id', 1)
                ->where('to_currency_id', 3)
                ->select('rate')
                ->orderBy('id', 'desc')
                ->first();

            if (!$rate) {
                // rate note found
                $rate_usd_to_azn = 0;
            } else {
                $rate_usd_to_azn = $rate->rate;
            }

            foreach ($clients as $client) {
                $balance_usd = $client->balance;
                $balance_azn = $balance_usd * $rate_usd_to_azn;
                $balance_azn = sprintf('%0.2f', $balance_azn);
                $client->balance_azn = $balance_azn;
            }

            return view("backend.clients", compact(
                'clients',
                'contracts',
                'packing_services',
                'search_arr',
                'branchs'
            ));
        } catch (\Exception $exception) {
            //dd($exception);
            return view('backend.error');
        }
    }
}
