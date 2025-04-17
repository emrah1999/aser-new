<?php

namespace App\Http\Controllers;

use App\ChangeAccountLog;
use App\ClientsLog;
use App\DebtsLog;
use App\EmailListContent;
use App\Http\Controllers\Classes\SMS;
use App\InvoiceLog;
use App\Item;
use App\Jobs\CollectorInWarehouseJob;
use App\Location;
use App\Package;
use App\PackageStatus;
use App\Seller;
use App\SmsTask;
use App\SpecialOrderGroups;
use App\SpecialOrderPayments;
use App\SpecialOrders;
use App\SpecialOrdersSettings;
use App\SpecialOrderStatus;
use App\Status;
use App\TokensForLogin;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OperatorUserController extends HomeController
{

    public function __construct(NotificationController $notification)
    {
        parent::__construct();
        $this->notification = $notification;
    }


    public function index()
    {
        return view('backend.operator.index');
    }

    // operator
    public function get_operator_page()
    {
        return view('backend.operator.operator');
    }

    public function get_client(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'suite' => ['nullable', 'integer'],
            'name' => ['nullable', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'passport' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            //id (suite), name, surname, phone, email
            $suite = $request->suite;
            $name = $request->name;
            $surname = $request->surname;
            $passport = $request->passport;
            $fin = $request->fin;
            $phone = $request->phone;
            $email = $request->email;
            $client_query = User::leftJoin('filial', 'users.branch_id', '=', 'filial.id')->whereNull('users.deleted_by')->where('users.role_id', 2); //only clients
            $has_key = false;
            if (isset($suite) && !empty($suite) && $suite != null && $suite != 'null') {
                $suite = (int)$suite;
                $client_query->where('users.id', $suite);
                $has_key = true;
            }
            if (isset($name) && !empty($name) && $name != null && $name != 'null') {
                $client_query->where('users.name', 'LIKE', '%' . $name . '%');
                $has_key = true;
            }
            if (isset($surname) && !empty($surname) && $surname != null && $surname != 'null') {
                $client_query->where('users.surname', 'LIKE', '%' . $surname . '%');
                $has_key = true;
            }
            if (isset($passport) && !empty($passport) && $passport != null && $passport != 'null') {
                $client_query->where('users.passport_number', 'LIKE', '%' . $passport . '%');
                $has_key = true;
            }
            if (isset($fin) && !empty($fin) && $fin != null && $fin != 'null') {
                $client_query->where('users.passport_fin', 'LIKE', '%' . $fin . '%');
                $has_key = true;
            }
            if (isset($phone) && !empty($phone) && $phone != null && $phone != 'null') {
                $client_query->whereRaw("
                    (users.phone1 LIKE '%" . $phone . "%' or
                    users.phone2 LIKE '%" . $phone . "%' or
                    users.phone3 LIKE '%" . $phone . "%')
                ");
                $has_key = true;
            }
            if (isset($email) && !empty($email) && $email != null && $email != 'null') {
                $client_query->where('users.email', 'LIKE', '%' . $email . '%');
                $has_key = true;
            }
            if (!$has_key) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Please enter at least one key!']);
            }
            $clients = $client_query->orderBy('name')
                ->select(
                    'users.id',
                    'users.suite',
                    'users.name',
                    'users.surname',
                    'users.passport_number',
                    'users.passport_fin',
                    'users.email',
                    'users.address1',
                    'users.address2',
                    'users.address3',
                    'users.phone1',
                    'users.phone2',
                    'users.phone3',
                    'users.birthday',
                    'users.branch_id',
                    'users.language',
                    'users.balance',
                    'users.cargo_debt',
                    'users.common_debt',
                    'users.email_verified_at',
                    'filial.name as branch'
                )
                ->get();
            if (count($clients) == 0) {
                return response(['case' => 'warning', 'title' => 'Not found!', 'content' => 'Client not found!']);
            }

            return response(['case' => 'success', 'title' => 'Success!', 'clients' => $clients]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function get_packages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client' => ['required', 'integer'],
            'delivered' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $client = $request->client;
            $delivered_control = $request->delivered;

            $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
                ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
                ->leftJoin('currency as item_cur', 'item.currency_id', '=', 'item_cur.id')
                ->leftJoin('position as p', 'package.position_id', '=', 'p.id')
                ->leftJoin('locations as l', 'p.location_id', '=', 'l.id')
                ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
                ->leftJoin('locations as dep', 'package.departure_id', '=', 'dep.id')
                ->leftJoin('locations as des', 'package.destination_id', '=', 'des.id')
                ->leftJoin('currency as cur', 'package.currency_id', '=', 'cur.id')
                ->leftJoin('seller as sel', 'package.seller_id', '=', 'sel.id')
                ->leftJoin('filial', 'package.branch_id', '=', 'filial.id')
                ->where('package.client_id', $client)
                ->whereNull('package.deleted_by');

            if ($delivered_control == 1) {
                // delivered packages
                $query->whereNotNull('package.delivered_by');
            } else if ($delivered_control == 2) {
                // not delivered packages
                $query->whereNull('package.delivered_by');
            } // else all packages

            $packages = $query->select(
                'package.id',
                'flight.name as flight',
                'package.last_status_date as status_date',
                'package.number',
                'package.internal_id',
                'package.length',
                'package.width',
                'package.height',
                'package.volume_weight',
                'package.gross_weight',
                'package.chargeable_weight', //1 - gross; 2- volume
                'package.total_charge_value as amount',
                'package.paid',
                'package.paid_status',
                'cur.name as currency',
                'package.payment_receipt',
                'package.payment_receipt_date',
                'sel.name as seller',
                'dep.name as departure',
                'des.name as destination',
                's.status_en as status',
                'p.name as position',
                'l.name as location',
                'item.price as invoice',
                'item_cur.name as invoice_currency',
                'item.invoice_doc',                
                'filial.name as branch'
            )
                ->orderBy('package.id', 'desc')
                ->get();

            if (count($packages) == 0) {
                return response(['case' => 'warning', 'title' => 'Not found!', 'content' => 'Package not found!']);
            }

            $has_referral = false;
            if (User::where(['parent_id' => $client, 'role_id' => 2])->select('id')->first()) {
                $has_referral = true;
            }

            return response(['case' => 'success', 'title' => 'Success!', 'packages' => $packages, 'has_referral' => $has_referral]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function show_package_events(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $package_id = $request->package_id;

            $events = PackageStatus::leftJoin('lb_status as status', 'package_status.status_id', '=', 'status.id')
                ->leftJoin('users', 'package_status.created_by', '=', 'users.id')
                ->where('package_status.package_id', $package_id)
                ->select('status.status_en as status', 'package_status.created_at as date', 'users.name as user_name', 'users.surname as user_surname')
                ->get();

            if (count($events) == 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Event not found!']);
            }

            $no = 0;
            foreach ($events as $event) {
                $no++;
                $event->no = $no;
            }

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successfully!', 'events' => $events]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function show_package_invoice_events(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $package_id = $request->package_id;

            $events = InvoiceLog::leftJoin('lb_status as status', 'invoice_log.status_id', '=', 'status.id')
                ->leftJoin('users', 'invoice_log.created_by', '=', 'users.id')
                ->where('invoice_log.package_id', $package_id)
                ->select('status.status_en as inv_status', 'invoice_log.created_at as date', 'users.name as user_name', 'users.surname as user_surname')
                ->get();

            if (count($events) == 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Event not found!']);
            }

            $no = 0;
            foreach ($events as $event) {
                $no++;
                $event->no = $no;
            }

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successfully!', 'events' => $events]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function package_delete_invoice_file(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $package_id = $request->package_id;

            $pack = Package::where('id', $package_id)->first();

            if($pack->last_status_id != 40)
            {
                Item::where('package_id', $package_id)->update([
                    'price' => null,
                    'price_usd' => null,
                    'currency_id' => null,
                    'invoice_doc' => null,
                    'invoice_confirmed' => 0,
                    'invoice_status' => 1
                ]);
    
                $package = Package::whereNull('deleted_at')
                            ->where('id', $package_id)
                            ->select(
                                'last_status_id'
                            )
                            ->first();
    
    
                PackageStatus::create([
                    'package_id' => $package_id,
                    'status_id' => $package->last_status_id, 
                    'created_by' => Auth::id()
                ]);
    
    
                InvoiceLog::create([
                    'package_id' => $package_id,
                    'client_id' => Auth::id(),
                    'invoice_doc' => 'deleted',
                    'created_by' => Auth::id(),
                    'status_id' => 6
                ]);
    
                return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successfully!']);
            }
            return response(['case' => 'Oops', 'title' => 'Error!', 'content' => 'Baglama müştəri tərəfindən bəyan edilib. Xahiş edirik əməliyyatın icrasını dəqiqləşdirin']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function verify_client_account(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $client_id = $request->client;

            if (User::where('id', $client_id)->whereNotNull('email_verified_at')->count() > 0) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Client not found or this account already verified!']);
            }

            User::where('id', $client_id)->update(['email_verified_at'=>Carbon::now()]);

            $request_string = json_encode($request->all());

            ClientsLog::create([
                'type' => 'verify',
                'client_id' => $client_id,
                'request' => $request_string,
                'role_id' => Auth::user()->role(),
                'created_by' => Auth::id()
            ]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successfully!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function login_client_account($client_id)
    {
        try {
            if (!is_numeric($client_id)) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Wrong client format!']);
            }

            $get_token = $this->get_token_for_login_api($client_id);

            if (!$get_token[0]) {
                return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, an error has occurred!']);
            }

            $token = $get_token[1];

            $url = "https://asercargo.az/login-client-account/" . $token;

            return response(['case' => 'success', 'url' => $url]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function get_token_for_login_api($client_id)
    {
        try {
            $token = Str::random(255);

            TokensForLogin::create([
                'token' => $token,
                'client_id' => $client_id,
                'created_time' => time(),
                'created_by' => Auth::id()
            ]);

            return [true, $token];
        } catch (\Exception $exception) {
            return [false];
        }
    }

    // referrals and their packages for operator
    public function get_sub_accounts_and_their_packages($client_id)
    {
        try {
            $sub_accounts = User::where('parent_id', $client_id)
                ->select(
                    'id',
                    'suite',
                    'name',
                    'surname',
                    'passport_number as passport',
                    'email',
                    'address1',
                    'phone1',
                    'phone2',
                    'birthday',
                    'language'
                )
                ->get();
            $sub_accounts_arr = array();
            $i = 0;
            foreach ($sub_accounts as $account) {
                array_push($sub_accounts_arr, $account->id);
                $amount = Item::leftJoin('package as p', 'item.package_id', '=', 'p.id')
                    ->whereNull('p.deleted_by')
                    ->where('p.client_id', $account->id)
                    ->where('p.paid_status', 0)
                    ->where('p.amount_usd', '>', 0)
                    ->sum('p.amount_usd');
                $account->debt = $amount;
                $i++;
            }
            // packages
            $packages = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->leftJoin('container', 'package.last_container_id', '=', 'container.id')
                ->leftJoin('flight', 'container.flight_id', '=', 'flight.id')
                ->leftJoin('currency as item_cur', 'item.currency_id', '=', 'item_cur.id')
                ->leftJoin('position as p', 'package.position_id', '=', 'p.id')
                ->leftJoin('locations as l', 'p.location_id', '=', 'l.id')
                ->leftJoin('lb_status as s', 'package.last_status_id', '=', 's.id')
                ->leftJoin('locations as dep', 'package.departure_id', '=', 'dep.id')
                ->leftJoin('locations as des', 'package.destination_id', '=', 'des.id')
                ->leftJoin('currency as cur', 'package.currency_id', '=', 'cur.id')
                ->leftJoin('seller as sel', 'package.seller_id', '=', 'sel.id')
                ->leftJoin('users as client', 'package.client_id', '=', 'client.id')
                ->whereIn('package.client_id', $sub_accounts_arr)
                ->whereNull('package.deleted_by')
                ->whereNull('package.delivered_by')
                ->select(
                    'package.id',
                    'package.number',
                    'package.internal_id',
                    'flight.name as flight',
                    'package.last_status_date as status_date',
                    'package.volume_weight',
                    'package.gross_weight',
                    'package.chargeable_weight', //1 - gross; 2- volume
                    'package.total_charge_value as amount',
                    'package.paid',
                    'package.paid_status',
                    'cur.name as currency',
                    'package.payment_receipt',
                    'package.payment_receipt_date',
                    'sel.name as seller',
                    'dep.name as departure',
                    'des.name as destination',
                    's.status_en as status',
                    'p.name as position',
                    'l.name as location',
                    'item.price as invoice',
                    'item_cur.name as invoice_currency',
                    'item.invoice_doc',
                    'package.client_id as suite',
                    'client.name as client_name',
                    'client.surname as client_surname'
                )
                ->orderBy('package.id', 'desc')
                ->get();

            return view('backend.operator.sub_accounts', compact(
                'sub_accounts',
                'packages'
            ));
        } catch (\Exception $exception) {
            return view('backend.error');
        }
    }

    // special orders
    public function get_make_orders_page()
    {
        try {
            $counts = array();
            // all
            $counts['all'] = SpecialOrderGroups::whereNull('deleted_by')
                ->where('special_order_groups.is_paid', 1)
                ->count();
            // paid
            $counts['paid'] = SpecialOrderGroups::whereNull('deleted_by')
                ->where('special_order_groups.is_paid', 1)
                ->whereDate('paid_at', '>=', '2020-04-01')
                ->whereNull('special_order_groups.placed_by')
                ->whereNull('special_order_groups.canceled_by')
                ->count();
            // placed
            $counts['ordered'] = SpecialOrderGroups::whereNull('deleted_by')
                ->where('special_order_groups.is_paid', 1)
                ->whereNotNull('special_order_groups.placed_by')
                ->count();
            // canceled
            $counts['declined'] = SpecialOrderGroups::whereNull('deleted_by')
                ->where('special_order_groups.is_paid', 1)
                ->whereNotNull('special_order_groups.canceled_by')
                ->count();
            $counts['old'] = SpecialOrderGroups::whereNull('deleted_by')
                ->where('special_order_groups.is_paid', 1)
//                ->whereNotNull('special_order_groups.placed_by')
//                ->whereNotNull('special_order_groups.canceled_by')
                ->whereRaw("(paid_at < '2020-04-01' or paid_at is null)")
                ->count();

            return view('backend.operator.makeOrder', compact('counts'));
        } catch (\Exception $exception) {
            return view('backend.error');
        }
    }

    public function show_make_orders(Request $request)
    {
        try {
            $query = SpecialOrderPayments::leftJoin('special_order_groups', 'special_order_payments.order_id', '=', 'special_order_groups.id')
                ->leftJoin('users as client', 'special_order_groups.client_id', '=', 'client.id')
                ->leftJoin('countries as c', 'special_order_groups.country_id', '=', 'c.id')
                ->leftJoin('lb_status as s', 'special_order_groups.last_status_id', '=', 's.id')
                ->leftJoin('users as operator', 'special_order_groups.operator_id', '=', 'operator.id')
                ->leftJoin('currency as cur', 'special_order_groups.currency_id', '=', 'cur.id')
                ->where('special_order_payments.paid', 1)
                ->where('special_order_groups.is_paid', 1)
                ->whereNull('special_order_groups.deleted_by')
                ->whereNull('client.deleted_by');

            $order_id = $request->input("order");
            if (isset($order_id) && !empty($order_id) && $order_id != null && $order_id != "null") {
                $query->where('special_order_groups.id', $order_id);
            }
            $payment_id = $request->input("code");
            if (isset($payment_id) && !empty($payment_id) && $payment_id != null && $payment_id != "null") {
                $query->where('special_order_groups.pay_id', $payment_id);
            }
            $suite = $request->input("suite");
            if (isset($suite) && !empty($suite) && $suite != null && $suite != "null") {
                $query->where('special_order_groups.client_id', $suite);
            }
            $name = $request->input("name");
            if (isset($name) && !empty($name) && $name != null && $name != "null") {
                $query->where('client.name', 'like', '%' . $name . '%');
            }
            $surname = $request->input("surname");
            if (isset($surname) && !empty($surname) && $surname != null && $surname != "null") {
                $query->where('client.surname', 'like', '%' . $surname . '%');
            }
            $status = $request->input("status");
            if (isset($status) && !empty($status) && $status != null && $status != "null") {
                switch ($status) {
                    case 1:
                        {
                            // paid
                            $query->whereDate('special_order_groups.paid_at', '>=', '2020-04-01');
                            $query->whereNull('special_order_groups.placed_by');
                            $query->whereNull('special_order_groups.canceled_by');
                        }
                        break;
                    case 2:
                        {
                            // placed
                            $query->whereNotNull('special_order_groups.placed_by');
                        }
                        break;
                    case 3:
                        {
                            // canceled
                            $query->whereNotNull('special_order_groups.canceled_by');
                        }
                        break;
                    case 4:
                        {
                            // old
//                            $query->whereNotNull('special_order_groups.placed_by');
//                            $query->whereNotNull('special_order_groups.canceled_by');
                            $query->whereRaw("(special_order_groups.paid_at < '2020-04-01' or special_order_groups.paid_at is null)");
                        }
                        break;
                }
            }
            $orders = $query->orderBy('special_order_groups.paid_at', 'desc')
                ->orderBy('special_order_groups.id', 'desc')
                ->select(
                    'special_order_groups.id',
                    'special_order_groups.group_code',
                    'special_order_payments.payment_key',
                    'client.id as suite',
                    'client.name',
                    'client.surname',
                    'c.name_en as country',
                    's.status_en as status',
                    'operator.name as operator_name',
                    'operator.surname as operator_surname',
                    'special_order_groups.is_paid',
                    'special_order_groups.price',
                    'special_order_groups.common_debt',
                    'special_order_groups.cargo_debt',
                    'cur.name as currency',
                    'special_order_groups.created_at',
                    'special_order_groups.paid_at'
                )
                ->paginate(30);

            $i = 0;
            foreach ($orders as $order) {
                $i++;
                $order->no = $i;
            }

            return response(['case' => 'success', 'orders' => $orders]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function get_statuses()
    {
        try {
            $statuses = Status::where('for_special_order', 1)->whereNull('deleted_by')->select('id', 'status_en as status')->orderBy('status_en')->get();
            if (count($statuses) > 0) {
                return response(['case' => 'success', 'statuses' => $statuses]);
            }

            return response(['case' => 'warning', 'title' => 'Not found!', 'content' => 'Statuses not found!']);
        } catch (\Exception $exception) {
            return response(['case' => 'warning', 'title' => 'Not found!', 'content' => 'Order not found!']);
        }
    }

    public function get_update_make_order($group_code)
    {
        try {
            $groups = SpecialOrderGroups::leftJoin('users as client', 'special_order_groups.client_id', '=', 'client.id')
                ->leftJoin('countries as c', 'special_order_groups.country_id', '=', 'c.id')
                //->leftJoin('currency as cur', 'special_order_groups.currency_id', '=', 'cur.id')
                ->where('special_order_groups.group_code', $group_code)
                ->whereNull('special_order_groups.deleted_by')
                ->select(
                    'special_order_groups.id as order_id',
                    'special_order_groups.client_id',
                    'special_order_groups.pay_id',
                    'client.id as suite',
                    'client.phone1 as phone',
                    'client.email',
                    'client.language',
                    'client.name',
                    'client.surname',
                    'c.name_en as country',
                    'special_order_groups.disable',
                    'special_order_groups.single_price',
                    'special_order_groups.price',
                    'special_order_groups.common_debt',
                    'special_order_groups.cargo_debt',
                    'special_order_groups.last_status_id',
                    'special_order_groups.placed_by',
                    'special_order_groups.canceled_by'
                )
                ->first();

            if (!$groups) {
                return response(['case' => 'warning', 'title' => 'Not found!', 'content' => 'Orders not found!']);
            }

            $statuses = Status::where('for_special_order', 1)->whereNull('deleted_by')->select('id')->get();
            $status_arr = array();
            foreach ($statuses as $status) {
                array_push($status_arr, $status->id);
            }

            $orders = SpecialOrders::where('special_orders.group_code', $group_code)
                ->whereNull('special_orders.deleted_by')
                ->select(
                    'special_orders.id',
                    'special_orders.url',
                    //'special_orders.title',
                    'special_orders.quantity',
                    'special_orders.single_price',
                    'special_orders.color',
                    'special_orders.size',
                    'special_orders.description',
                    'special_orders.last_status_id',
                    'special_orders.placed_by',
                    'special_orders.canceled_by',
                    'special_orders.placed_by',
                    'special_orders.canceled_by',
                    'special_orders.group_code',
                    'special_orders.order_number'
                )
                ->get();
            if (count($orders) == 0) {
                return response(['case' => 'warning', 'title' => 'Not found!', 'content' => 'Orders not found!']);
            }

            $i = 0;
            foreach ($orders as $order) {
//                if (!in_array($order->last_status_id, $status_arr)) {
//                    $order->last_status_id = 13;
//                }
                $order['base_url'] = $order->url;
//                if (Auth::id() != 124167) {
                    $order->url = $this->connecting_to_bon_az($order->url, $order->group_code);
//                }
                $order->status_changed = false;
                $order->no = $i;
                $i++;
                $order->num = $i;
            }

            return response(['case' => 'success', 'orders' => $orders, 'details' => $groups]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Something went wrong']);
        }
    }

    public function post_update_make_order(Request $request, $group_code)
    {
        $validator = Validator::make($request->all(), [
            // special_orders
            'orders.*.id' => ['required', 'integer'],
            'orders.*.last_status_id' => ['required', 'integer'],
            'orders.*.quantity' => ['required', 'integer'],
            'orders.*.order_number' => ['nullable', 'string', 'max:500'],
            // special_order_groups
            'details.order_id' => ['required', 'integer'],
            'details.common_debt' => ['nullable'],
            'details.cargo_debt' => ['nullable'],
            'details.last_status_id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $details = $request->details;
            $orders = $request->orders;

            $settings = SpecialOrdersSettings::where('id', 1)->select('percent')->first();

            if (!$settings) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Settings not found!']);
            }

//            $percent = $settings->percent;
	    $percent = 0;

            $group_status_id = $details['last_status_id'];
            $client_id = $details['client_id'];
            if (isset($details['sms_status'])) {
                $sms_status = $details['sms_status'];
            } else {
                $sms_status = false;
            }

            $client = User::where('id', $client_id)
                ->where('role_id', 2)
                ->whereNull('deleted_by')
                ->select('cargo_debt', 'common_debt', 'language', 'email', 'name', 'surname', 'phone1 as phone', 'fcm_token')
                ->first();

            if (!$client) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Client not found!']);
            }

            $phone_number = $client->phone;

            $group_id = $details['order_id'];

            $old_group = SpecialOrderGroups::where('id', $group_id)
                ->whereNull('deleted_by')
                ->select('group_code', 'last_status_id', 'common_debt', 'cargo_debt')
                ->first();

            if (!$old_group) {
                return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Order not found!']);
            }

            $group_code = $old_group->group_code;
            $order_old_common_debt = $old_group->common_debt;
            $order_old_cargo_debt = $old_group->cargo_debt;

            $date = Carbon::now();
            $status_arr = [12, 13, 21, 22, 23, 24, 25];

            $placed_urls = '';
            $placed_cargo_urls = '';
            $placed_common_urls = '';
            $canceled_urls = '';
            $canceled_store_urls = '';
            $canceled_size_urls = '';
            $canceled_incorrect_link_urls = '';

            foreach ($orders as $order) {
                $order_id = $order['id'];

                $old_order = SpecialOrders::where('id', $order_id)
                    ->where('group_code', $group_code)
                    ->whereNull('deleted_by')
                    ->select('id', 'last_status_id')
                    ->first();

                if (!$old_order) {
                    continue;
                }

                $old_status_id = $old_order->last_status_id;
                if (in_array($old_status_id, $status_arr)) {
                    continue;
                }

                $quantity = $order['quantity'];
                $status_id = $order['last_status_id'];

                $order_arr = array();
                $order_arr['quantity'] = $quantity;
                $order_arr['last_status_id'] = $status_id;

                if (in_array($status_id, [13, 21, 22])) {
                    // placed
                    $order_arr['placed_by'] = Auth::id();
                    $order_arr['placed_at'] = $date;
                    $order_arr['order_number'] = $order['order_number'];

                    switch ($status_id) {
                        case 21: {
                            // placed with cargo debt
                            $placed_cargo_urls .= '<p><a href="' . $order['base_url'] . '">' . $order['base_url'] . '</a></p>';
                        } break;
                        case 22: {
                            // placed with common debt
                            $placed_common_urls .= '<p><a href="' . $order['base_url'] . '">' . $order['base_url'] . '</a></p>';
                        } break;
                        default: {
                            // placed
                            $placed_urls .= '<p><a href="' . $order['base_url'] . '">' . $order['base_url'] . '</a></p>';
                        }
                    }
                } else if (in_array($status_id, [12, 23, 24, 25])) {
                    // canceled
                    $order_arr['canceled_by'] = Auth::id();
                    $order_arr['canceled_at'] = $date;
                    if ($status_id == 12) {
                        //special_orders_stoke
                        $canceled_urls .= '<p><a href="' . $order['base_url'] . '">' . $order['base_url'] . '</a></p>';
                    } else if ($status_id == 24) {
                        //special_orders_canceled_store
                        $canceled_store_urls .= '<p><a href="' . $order['base_url'] . '">' . $order['base_url'] . '</a></p>';
                    } else if ($status_id == 23) {
                        //special_orders_canceled_size
                        $canceled_size_urls .= '<p><a href="' . $order['base_url'] . '">' . $order['base_url'] . '</a></p>';
                    } else if ($status_id == 25) {
                        //sp_ord_canceled_incorrect_link
                        $canceled_incorrect_link_urls .= '<p>' . $order['base_url'] . '</p>';
                    }
                }

                SpecialOrders::where('id', $order_id)->update($order_arr);
            }

            $group_arr = array();

            $common_debt = $details['common_debt'];
            if ($common_debt != null && $common_debt > 0) {
                $common_debt = $common_debt + ($common_debt * $percent) / 100;
                $common_debt = sprintf('%0.2f', $common_debt);
                $group_arr['common_debt'] = $common_debt;
            }

            $cargo_debt = $details['cargo_debt'];
            if ($cargo_debt != null && $cargo_debt > 0) {
                $cargo_debt = $cargo_debt + ($cargo_debt * $percent) / 100;
                $cargo_debt = sprintf('%0.2f', $cargo_debt);
                $group_arr['cargo_debt'] = $cargo_debt;
            }

            if (in_array($group_status_id, [13, 21, 22])) {
                // placed
                $group_arr['placed_by'] = Auth::id();
                $group_arr['placed_at'] = $date;
            } else if (in_array($group_status_id, [12, 23, 24, 25])) {
                // canceled
                $group_arr['canceled_by'] = Auth::id();
                $group_arr['canceled_at'] = $date;
            }

            $group_arr['operator_id'] = Auth::id();
            SpecialOrderGroups::where('id', $group_id)->update($group_arr);

            if ($old_group->last_status_id != $group_status_id) {
                SpecialOrderStatus::create([
                    'order_id' => $group_id,
                    'status_id' => $group_status_id,
                    'created_by' => Auth::id()
                ]);
            }

            $has_debt = false;
            if ($cargo_debt > 0 || $common_debt > 0) {
                $has_debt = true;
                $client_old_cargo_debt = $client->cargo_debt;
                $client_new_cargo_debt = $client_old_cargo_debt + $cargo_debt;
                $client_new_cargo_debt = sprintf('%0.2f', $client_new_cargo_debt);
                $client_old_common_debt = $client->common_debt;
                $client_new_common_debt = $client_old_common_debt + $common_debt;
                $client_new_common_debt = sprintf('%0.2f', $client_new_common_debt);
                if ($order_old_cargo_debt > 0) {
                    $client_new_cargo_debt = $client_new_cargo_debt - $order_old_cargo_debt;
                }
                if ($order_old_common_debt > 0) {
                    $client_new_common_debt = $client_new_common_debt - $order_old_common_debt;
                }
                if ($client_new_cargo_debt < 0) {
                    $client_new_cargo_debt = 0;
                }
                if ($client_new_common_debt < 0) {
                    $client_new_common_debt = 0;
                }
                User::where('id', $client_id)->update([
                    'cargo_debt' => $client_new_cargo_debt,
                    'common_debt' => $client_new_common_debt
                ]);
                DebtsLog::create([
                    'type' => 'in',
                    'client_id' => $client_id,
                    'order_id' => $group_id,
                    'cargo' => $cargo_debt,
                    'common' => $common_debt,
                    'operator_id' => Auth::id(),
                    'created_by' => Auth::id()
                ]);
            }

            $lang = $client->language;
            $lang = strtolower($lang);
            $country = SpecialOrderGroups::leftJoin('countries as country', 'special_order_groups.country_id', '=', 'country.id')
                ->where('special_order_groups.id', $group_id)
                ->select('country.name_' . $lang . ' as name')
                ->first();
            if ($country) {
                $country_name = $country->name;
            } else {
                $country_name = '';
            }

            if (strlen($placed_urls) > 0) {
                //placed
                $emails = EmailListContent::where(['type' => 'special_order_url_notification'])->first();

                if ($emails && $client && $client_id != 0 && $client_id != null && $client->email != null) {
                    $client_full_name = $client->name . ' ' . $client->surname;

                    $email_to = $client->email;
                    $email_title = $emails->{'title_' . $lang}; //from
                    $email_subject = $emails->{'subject_' . $lang};
                    $email_bottom = $emails->{'content_bottom_' . $lang};
                    $email_content = $emails->{'content_' . $lang};
                    $email_button = $emails->{'button_name_' . $lang};

                    $email_push_content = $emails->{'push_content_' . $lang};
                    // $email_push_content = str_replace('{order_id}', $group_id, $email_push_content);

                    $email_subject = str_replace('{country_name}', $country_name, $email_subject);

                    $email_content = str_replace('{name_surname}', $client_full_name, $email_content);
                    $email_content = str_replace('{link_list}', $placed_urls, $email_content);

                    $this->notification->sendNotification($email_title, $email_subject, $email_content, $client_id);

                    $job = (new CollectorInWarehouseJob($email_to, $email_title, $email_subject, $email_content, $email_bottom, $email_button))
                        ->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }
            }

            if (strlen($placed_cargo_urls) > 0) {
                //placed with cargo debt
                $total_debt = $cargo_debt;
                $total_debt .= ' TRY';

                $emails = EmailListContent::where(['type' => 'sp_placed_cargo_debt'])->first();

                if ($sms_status) {
                    $text = $emails->{'sms_' . $lang};

                    if (strlen($text) > 0) {
                        $text = str_replace('{amount}', $total_debt, $text);

                        $control_id = time() . $lang;
                        $phone_arr = array();
                        array_push($phone_arr, $phone_number);
                        $sms = new SMS();
                        $send_bulk_sms = $sms->sendBulkSms($text, $phone_arr, $control_id);

                        if ($send_bulk_sms[0] == true) {
                            $response = simplexml_load_string($send_bulk_sms[1], 'SimpleXMLElement', LIBXML_NOCDATA);
                            $json = json_decode(json_encode((array)$response), TRUE);

                            if (isset($json['head']['responsecode'])) {
                                $response_code = $json['head']['responsecode'];
                            } else {
                                $response_code = 'error';
                            }

                            if (isset($json['body']['taskid'])) {
                                $task_id = $json['body']['taskid'];
                            } else {
                                $task_id = 'error';
                            }

                            if ($response_code == '000') {
                                //success
                                $sms_status = 1;
                            } else {
                                //failed
                                $sms_status = 0;
                            }

                            SmsTask::create([
                                'type' => 'special_orders_placed_cargo_debt',
                                'code' => $response_code,
                                'task_id' => $task_id,
                                'control_id' => $control_id,
                                'package_id' => $group_id, // group_id
                                'client_id' => $client_id,
                                'number' => $phone_number,
                                'message' => $text,
                                'created_by' => Auth::id()
                            ]);

                            SpecialOrderGroups::where('id', $group_id)->update(['debt_sms'=>$sms_status]);
                        }
                    }
                }

                if ($emails && $client && $client_id != 0 && $client_id != null && $client->email != null) {
                    $client_full_name = $client->name . ' ' . $client->surname;

                    $email_to = $client->email;
                    $email_title = $emails->{'title_' . $lang}; //from
                    $email_subject = $emails->{'subject_' . $lang};
                    $email_bottom = $emails->{'content_bottom_' . $lang};
                    $email_content = $emails->{'content_' . $lang};
                    $email_button = $emails->{'button_name_' . $lang};

                    $email_push_content = $emails->{'push_content_' . $lang};
                    // $email_push_content = str_replace('{order_id}', $group_id, $email_push_content);

                    $email_subject = str_replace('{order_id}', $group_id, $email_subject);

                    $email_content = str_replace('{name_surname}', $client_full_name, $email_content);
                    $email_content = str_replace('{link_list}', $placed_cargo_urls, $email_content);
                    $email_content = str_replace('{amount}', $total_debt, $email_content);

                    $this->notification->sendNotification($email_title, $email_subject, $email_content, $client_id);

                    $job = (new CollectorInWarehouseJob($email_to, $email_title, $email_subject, $email_content, $email_bottom, $email_button))
                        ->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }
            }

            if (strlen($placed_common_urls) > 0) {
                //placed with common debt
                $total_debt = $common_debt;
                $total_debt .= ' TRY';

                $emails = EmailListContent::where(['type' => 'sp_placed_common_debt'])->first();

                if ($sms_status) {
                    $text = $emails->{'sms_' . $lang};

                    if (strlen($text) > 0) {
                        $text = str_replace('{amount}', $total_debt, $text);

                        $control_id = time() . $lang;
                        $phone_arr = array();
                        array_push($phone_arr, $phone_number);
                        $sms = new SMS();
                        $send_bulk_sms = $sms->sendBulkSms($text, $phone_arr, $control_id);

                        if ($send_bulk_sms[0] == true) {
                            $response = simplexml_load_string($send_bulk_sms[1], 'SimpleXMLElement', LIBXML_NOCDATA);
                            $json = json_decode(json_encode((array)$response), TRUE);

                            if (isset($json['head']['responsecode'])) {
                                $response_code = $json['head']['responsecode'];
                            } else {
                                $response_code = 'error';
                            }

                            if (isset($json['body']['taskid'])) {
                                $task_id = $json['body']['taskid'];
                            } else {
                                $task_id = 'error';
                            }

                            if ($response_code == '000') {
                                //success
                                $sms_status = 1;
                            } else {
                                //failed
                                $sms_status = 0;
                            }

                            SmsTask::create([
                                'type' => 'special_orders_placed_common_debt',
                                'code' => $response_code,
                                'task_id' => $task_id,
                                'control_id' => $control_id,
                                'package_id' => $group_id, // group_id
                                'client_id' => $client_id,
                                'number' => $phone_number,
                                'message' => $text,
                                'created_by' => Auth::id()
                            ]);

                            SpecialOrderGroups::where('id', $group_id)->update(['debt_sms'=>$sms_status]);
                        }
                    }
                }

                if ($emails && $client && $client_id != 0 && $client_id != null && $client->email != null) {
                    $client_full_name = $client->name . ' ' . $client->surname;

                    $email_to = $client->email;
                    $email_title = $emails->{'title_' . $lang}; //from
                    $email_subject = $emails->{'subject_' . $lang};
                    $email_bottom = $emails->{'content_bottom_' . $lang};
                    $email_content = $emails->{'content_' . $lang};
                    $email_button = $emails->{'button_name_' . $lang};

                    $email_push_content = $emails->{'push_content_' . $lang};
                    // $email_push_content = str_replace('{order_id}', $group_id, $email_push_content);

                    $email_subject = str_replace('{order_id}', $group_id, $email_subject);

                    $email_content = str_replace('{name_surname}', $client_full_name, $email_content);
                    $email_content = str_replace('{link_list}', $placed_common_urls, $email_content);
                    $email_content = str_replace('{amount}', $total_debt, $email_content);

                    $this->notification->sendNotification($email_title, $email_subject, $email_content, $client_id);

                    $job = (new CollectorInWarehouseJob($email_to, $email_title, $email_subject, $email_content, $email_bottom, $email_button))
                        ->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }
            }

            if (strlen($canceled_urls) > 0) {
                //canceled
                $emails = EmailListContent::where(['type' => 'special_orders_stoke'])->first();

                if ($emails && $client && $client_id != 0 && $client_id != null && $client->email != null) {
                    $client_full_name = $client->name . ' ' . $client->surname;

                    $email_to = $client->email;
                    $email_title = $emails->{'title_' . $lang}; //from
                    $email_subject = $emails->{'subject_' . $lang};
                    $email_bottom = $emails->{'content_bottom_' . $lang};
                    $email_content = $emails->{'content_' . $lang};
                    $email_button = $emails->{'button_name_' . $lang};

                    $email_push_content = $emails->{'push_content_' . $lang};
                    // $email_push_content = str_replace('{order_id}', $group_id, $email_push_content);

                    $email_subject = str_replace('{order_id}', $group_id, $email_subject);

                    $email_content = str_replace('{name_surname}', $client_full_name, $email_content);
                    $email_content = str_replace('{link_list}', $canceled_urls, $email_content);

                    $this->notification->sendNotification($email_title, $email_subject, $email_content, $client_id);

                    $job = (new CollectorInWarehouseJob($email_to, $email_title, $email_subject, $email_content, $email_bottom, $email_button))
                        ->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }
            }

            
            if (strlen($canceled_incorrect_link_urls) > 0) {
                //canceled (incorrect link)
                $emails = EmailListContent::where(['type' => 'sp_ord_canceled_incorrect_link'])->first();

                if ($emails && $client && $client_id != 0 && $client_id != null && $client->email != null) {
                    $client_full_name = $client->name . ' ' . $client->surname;

                    $email_to = $client->email;
                    $email_title = $emails->{'title_' . $lang}; //from
                    $email_subject = $emails->{'subject_' . $lang};
                    $email_bottom = $emails->{'content_bottom_' . $lang};
                    $email_content = $emails->{'content_' . $lang};
                    $email_button = $emails->{'button_name_' . $lang};

                    $email_push_content = $emails->{'push_content_' . $lang};
                    // $email_push_content = str_replace('{order_id}', $group_id, $email_push_content);

                    $email_subject = str_replace('{order_id}', $group_id, $email_subject);

                    $email_content = str_replace('{name_surname}', $client_full_name, $email_content);
                    $email_content = str_replace('{link_list}', $canceled_incorrect_link_urls, $email_content);

                    $this->notification->sendNotification($email_title, $email_subject, $email_content, $client_id);

                    $job = (new CollectorInWarehouseJob($email_to, $email_title, $email_subject, $email_content, $email_bottom, $email_button))
                        ->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }
            }

            if (strlen($canceled_store_urls) > 0) {
                //canceled
                $emails = EmailListContent::where(['type' => 'special_orders_canceled_store'])->first();

                if ($emails && $client && $client_id != 0 && $client_id != null && $client->email != null) {
                    $client_full_name = $client->name . ' ' . $client->surname;

                    $email_to = $client->email;
                    $email_title = $emails->{'title_' . $lang}; //from
                    $email_subject = $emails->{'subject_' . $lang};
                    $email_bottom = $emails->{'content_bottom_' . $lang};
                    $email_content = $emails->{'content_' . $lang};
                    $email_button = $emails->{'button_name_' . $lang};

                    $email_push_content = $emails->{'push_content_' . $lang};
                    // $email_push_content = str_replace('{order_id}', $group_id, $email_push_content);
                    
                    $email_subject = str_replace('{order_id}', $group_id, $email_subject);

                    $email_content = str_replace('{name_surname}', $client_full_name, $email_content);
                    $email_content = str_replace('{link_list}', $canceled_store_urls, $email_content);

                    $this->notification->sendNotification($email_title, $email_subject, $email_content, $client_id);

                    $job = (new CollectorInWarehouseJob($email_to, $email_title, $email_subject, $email_content, $email_bottom, $email_button))
                        ->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }
            }

            if (strlen($canceled_size_urls) > 0) {
                //canceled
                $emails = EmailListContent::where(['type' => 'special_orders_canceled_size'])->first();

                if ($emails && $client && $client_id != 0 && $client_id != null && $client->email != null) {
                    $client_full_name = $client->name . ' ' . $client->surname;

                    $email_to = $client->email;
                    $email_title = $emails->{'title_' . $lang}; //from
                    $email_subject = $emails->{'subject_' . $lang};
                    $email_bottom = $emails->{'content_bottom_' . $lang};
                    $email_content = $emails->{'content_' . $lang};
                    $email_button = $emails->{'button_name_' . $lang};

                    $email_push_content = $emails->{'push_content_' . $lang};
                    // $email_push_content = str_replace('{order_id}', $group_id, $email_push_content);

                    $email_subject = str_replace('{order_id}', $group_id, $email_subject);

                    $email_content = str_replace('{name_surname}', $client_full_name, $email_content);
                    $email_content = str_replace('{link_list}', $canceled_size_urls, $email_content);

                    $this->notification->sendNotification($email_title, $email_subject, $email_content, $client_id);

                    $job = (new CollectorInWarehouseJob($email_to, $email_title, $email_subject, $email_content, $email_bottom, $email_button))
                        ->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }
            }

            if ($group_status_id == 18) {
                //debt
                $total_debt = $cargo_debt + $common_debt;
                $total_debt .= ' TRY';

                $emails = EmailListContent::where(['type' => 'special_order_debt'])->first();

                if ($sms_status) {
                    $text = $emails->{'sms_' . $lang};

                    $text = str_replace('{amount}', $total_debt, $text);

                    $control_id = time() . $lang;
                    $phone_arr = array();
                    array_push($phone_arr, $phone_number);
                    $sms = new SMS();
                    $send_bulk_sms = $sms->sendBulkSms($text, $phone_arr, $control_id);

                    if ($send_bulk_sms[0] == true) {
                        $response = simplexml_load_string($send_bulk_sms[1], 'SimpleXMLElement', LIBXML_NOCDATA);
                        $json = json_decode(json_encode((array)$response), TRUE);

                        if (isset($json['head']['responsecode'])) {
                            $response_code = $json['head']['responsecode'];
                        } else {
                            $response_code = 'error';
                        }

                        if (isset($json['body']['taskid'])) {
                            $task_id = $json['body']['taskid'];
                        } else {
                            $task_id = 'error';
                        }

                        if ($response_code == '000') {
                            //success
                            $sms_status = 1;
                        } else {
                            //failed
                            $sms_status = 0;
                        }

                        SmsTask::create([
                            'type' => 'special_orders_debt',
                            'code' => $response_code,
                            'task_id' => $task_id,
                            'control_id' => $control_id,
                            'package_id' => $group_id, // group_id
                            'client_id' => $client_id,
                            'number' => $phone_number,
                            'message' => $text,
                            'created_by' => Auth::id()
                        ]);

                        SpecialOrderGroups::where('id', $group_id)->update(['debt_sms'=>$sms_status]);
                    }
                }

                if ($emails && $client && $client_id != 0 && $client_id != null && $client->email != null) {
                    $client_full_name = $client->name . ' ' . $client->surname;

                    $email_to = $client->email;
                    $email_title = $emails->{'title_' . $lang}; //from
                    $email_subject = $emails->{'subject_' . $lang};
                    $email_bottom = $emails->{'content_bottom_' . $lang};
                    $email_content = $emails->{'content_' . $lang};
                    $email_button = $emails->{'button_name_' . $lang};

                    $email_push_content = $emails->{'push_content_' . $lang};
                    // $email_push_content = str_replace('{order_id}', $group_id, $email_push_content);

                    $email_subject = str_replace('{order_id}', $group_id, $email_subject);

                    $email_content = str_replace('{name_surname}', $client_full_name, $email_content);
                    $email_content = str_replace('{amount}', $total_debt, $email_content);

                    $this->notification->sendNotification($email_title, $email_subject, $email_content, $client_id);

                    $job = (new CollectorInWarehouseJob($email_to, $email_title, $email_subject, $email_content, $email_bottom, $email_button))
                        ->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }
            }

            if ($group_status_id == 26) {
                //common debt
                $total_debt = $common_debt;
                $total_debt .= ' TRY';

                $emails = EmailListContent::where(['type' => 'special_order_common_debt'])->first();

                if ($sms_status) {
                    $text = $emails->{'sms_' . $lang};

                    $text = str_replace('{amount}', $total_debt, $text);

                    $control_id = time() . $lang;
                    $phone_arr = array();
                    array_push($phone_arr, $phone_number);
                    $sms = new SMS();
                    $send_bulk_sms = $sms->sendBulkSms($text, $phone_arr, $control_id);

                    if ($send_bulk_sms[0] == true) {
                        $response = simplexml_load_string($send_bulk_sms[1], 'SimpleXMLElement', LIBXML_NOCDATA);
                        $json = json_decode(json_encode((array)$response), TRUE);

                        if (isset($json['head']['responsecode'])) {
                            $response_code = $json['head']['responsecode'];
                        } else {
                            $response_code = 'error';
                        }

                        if (isset($json['body']['taskid'])) {
                            $task_id = $json['body']['taskid'];
                        } else {
                            $task_id = 'error';
                        }

                        if ($response_code == '000') {
                            //success
                            $sms_status = 1;
                        } else {
                            //failed
                            $sms_status = 0;
                        }

                        SmsTask::create([
                            'type' => 'special_orders_debt',
                            'code' => $response_code,
                            'task_id' => $task_id,
                            'control_id' => $control_id,
                            'package_id' => $group_id, // group_id
                            'client_id' => $client_id,
                            'number' => $phone_number,
                            'message' => $text,
                            'created_by' => Auth::id()
                        ]);

                        SpecialOrderGroups::where('id', $group_id)->update(['debt_sms'=>$sms_status]);
                    }
                }

                if ($emails && $client && $client_id != 0 && $client_id != null && $client->email != null) {
                    $client_full_name = $client->name . ' ' . $client->surname;

                    $email_to = $client->email;
                    $email_title = $emails->{'title_' . $lang}; //from
                    $email_subject = $emails->{'subject_' . $lang};
                    $email_bottom = $emails->{'content_bottom_' . $lang};
                    $email_content = $emails->{'content_' . $lang};
                    $email_button = $emails->{'button_name_' . $lang};

                    $email_push_content = $emails->{'push_content_' . $lang};
                    // $email_push_content = str_replace('{order_id}', $group_id, $email_push_content);

                    $email_subject = str_replace('{order_id}', $group_id, $email_subject);

                    $email_content = str_replace('{name_surname}', $client_full_name, $email_content);
                    $email_content = str_replace('{amount}', $total_debt, $email_content);

                    $this->notification->sendNotification($email_title, $email_subject, $email_content, $client_id);

                    $job = (new CollectorInWarehouseJob($email_to, $email_title, $email_subject, $email_content, $email_bottom, $email_button))
                        ->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }
            }

            if ($group_status_id == 27) {
                //debt
                $total_debt = $cargo_debt;
                $total_debt .= ' TRY';

                $emails = EmailListContent::where(['type' => 'special_order_cargo_debt'])->first();

                if ($sms_status) {
                    $text = $emails->{'sms_' . $lang};

                    $text = str_replace('{amount}', $total_debt, $text);

                    $control_id = time() . $lang;
                    $phone_arr = array();
                    array_push($phone_arr, $phone_number);
                    $sms = new SMS();
                    $send_bulk_sms = $sms->sendBulkSms($text, $phone_arr, $control_id);

                    if ($send_bulk_sms[0] == true) {
                        $response = simplexml_load_string($send_bulk_sms[1], 'SimpleXMLElement', LIBXML_NOCDATA);
                        $json = json_decode(json_encode((array)$response), TRUE);

                        if (isset($json['head']['responsecode'])) {
                            $response_code = $json['head']['responsecode'];
                        } else {
                            $response_code = 'error';
                        }

                        if (isset($json['body']['taskid'])) {
                            $task_id = $json['body']['taskid'];
                        } else {
                            $task_id = 'error';
                        }

                        if ($response_code == '000') {
                            //success
                            $sms_status = 1;
                        } else {
                            //failed
                            $sms_status = 0;
                        }

                        SmsTask::create([
                            'type' => 'special_orders_debt',
                            'code' => $response_code,
                            'task_id' => $task_id,
                            'control_id' => $control_id,
                            'package_id' => $group_id, // group_id
                            'client_id' => $client_id,
                            'number' => $phone_number,
                            'message' => $text,
                            'created_by' => Auth::id()
                        ]);

                        SpecialOrderGroups::where('id', $group_id)->update(['debt_sms'=>$sms_status]);
                    }
                }

                if ($emails && $client && $client_id != 0 && $client_id != null && $client->email != null) {
                    $client_full_name = $client->name . ' ' . $client->surname;

                    $email_to = $client->email;
                    $email_title = $emails->{'title_' . $lang}; //from
                    $email_subject = $emails->{'subject_' . $lang};
                    $email_bottom = $emails->{'content_bottom_' . $lang};
                    $email_content = $emails->{'content_' . $lang};
                    $email_button = $emails->{'button_name_' . $lang};

                    $email_push_content = $emails->{'push_content_' . $lang};
                    // $email_push_content = str_replace('{order_id}', $group_id, $email_push_content);

                    $email_subject = str_replace('{order_id}', $group_id, $email_subject);

                    $email_content = str_replace('{name_surname}', $client_full_name, $email_content);
                    $email_content = str_replace('{amount}', $total_debt, $email_content);

                    $this->notification->sendNotification($email_title, $email_subject, $email_content, $client_id);

                    $job = (new CollectorInWarehouseJob($email_to, $email_title, $email_subject, $email_content, $email_bottom, $email_button))
                        ->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }
            }

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Success!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function disable_or_enable_make_order_for_client(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer'],
            'type' => ['required', 'integer']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $type = $request->type; // 0 - enable, 1 - disbale
            SpecialOrderGroups::where('id', $request->id)->update(['disable' => $type]);
            if ($type == 1) {
                $status_id = 20;
            } else {
                $status_id = 1;
            }
            SpecialOrderStatus::create([
                'order_id' => $request->id,
                'status_id' => $status_id,
                'created_by' => Auth::id()
            ]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successful!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

//    private function send_mail_for_special_order($order_id, $client_id, $message)
//    {
//        try {
//            $client = User::where('id', $client_id)->select('phone1', 'email', 'name', 'surname')->first();
//            if ($client) {
//                $job = (new SpecialOrderEmailJob($client->email, $order_id, $client->name . " " . $client->surname, $message))
//                    ->delay(Carbon::now()->addSeconds(10));
//                dispatch($job);
//
//                return true;
//            }
//
//            return false;
//        } catch (\Exception $exception) {
//            return false;
//        }
//    }

    private function connecting_to_bon_az($url, $order_group_code)
    {
        $bon_id = 785;
        $new_url = "https://bon.az/r?id=";
        $new_url .= $bon_id . "&order_id=" . $order_group_code . "&url=" . $url;

        return $new_url;
    }

    // anonymous page
    public function get_anonymous_page()
    {
        return view('backend.operator.anonymous');
    }

    public function show_anonymous_orders(Request $request)
    {
        try {
            $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->leftJoin('currency as p_cur', 'package.currency_id', '=', 'p_cur.id')
                ->leftJoin('currency as i_cur', 'item.currency_id', '=', 'i_cur.id')
                ->leftJoin('seller', 'package.seller_id', '=', 'seller.id')
                ->leftJoin('category', 'item.category_id', '=', 'category.id')
                ->leftJoin('lb_status as status', 'package.last_status_id', '=', 'status.id')
                ->where('package.client_id', 0)
                ->whereNull('package.deleted_by');

            if (Auth::user()->role() == 3) {
                // collector
                $query->where('package.departure_id', Auth::user()->location());

                if(Auth::user()->id == 137297){
                    $query->where('package.departure_id', Auth::user()->location());
                    $query->whereDate('package.created_at', '>', date('2021-08-27'));
                }
            }

            $track = $request->input("code");
            if (isset($track) && !empty($track) && $track != null && $track != "null") {
                $query->where('package.number', 'like', '%' . $track . '%');
            }
            $internal_id = $request->input("internal_id");
            if (isset($internal_id) && !empty($internal_id) && $internal_id != null && $internal_id != "null") {
                $query->where('package.internal_id', 'like', '%' . $internal_id . '%');
            }
            $client = $request->input("client");
            if (isset($client) && !empty($client) && $client != null && $client != "null") {
                $query->where('package.client_name_surname', 'like', '%' . $client . '%');
            }
            $orders = $query->select(
                'package.id',
                'package.number',
                'package.internal_id',
                'package.client_name_surname',
                'package.gross_weight',
                'package.total_charge_value as amount',
                'p_cur.name as amount_currency',
                'item.invoice_doc',
                'item.price as invoice',
                'i_cur.name as invoice_currency',
                'seller.name as seller',
                'category.name_en as category',
                'status.status_en as status',
                'package.created_at'
            )
                ->orderBy('id', 'desc')
                ->paginate(30);

            return response(['case' => 'success', 'orders' => $orders]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function client_control(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => ['required', 'integer']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'content' => 'Client id not found!']);
        }
        try {
            $client = User::where('id', $request->client_id)->select('name', 'surname')->first();
            if ($client) {
                return response(['case' => 'success', 'client' => $client->name . ' ' . $client->surname]);
            }

            return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Client not found!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function merge_client_and_package(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => ['required', 'integer'],
            'package_id' => ['required', 'integer']
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            $package_id = $request->package_id;
            $client_id = $request->client_id;

            $status_id = 37;
            $customer_type_id = 1;

            $client = User::where('id', $client_id)->first();
            $branch = $client->branch_id;
            if($client->is_legality == 1){
                $status_id = 41;
                $customer_type_id = 2;
            }
            if (Auth::user()->role() == 3) {
                // collector
                if (Package::where(['id' => $package_id, 'client_id' => 0])->where('departure_id', Auth::user()->location())->count() == 0) {
                    return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Package not found!']);
                }

                Package::where('id', $package_id)
                    ->where('departure_id', Auth::user()->location())
                    ->update(['client_id' => $client_id, 'anonymous_merge_operator_id' => Auth::id(), 'last_status_id' => $status_id, 'customer_type_id' => $customer_type_id, 'branch_id' => $branch]);
            } else {
                // other users
                if (Package::where(['id' => $package_id, 'client_id' => 0])->count() == 0) {
                    return response(['case' => 'warning', 'title' => 'Oops!', 'content' => 'Package not found!']);
                }

                Package::where('id', $package_id)->update(['client_id' => $client_id, 'anonymous_merge_operator_id' => Auth::id(), 'last_status_id' => $status_id, 'customer_type_id' => $customer_type_id, 'branch_id' => $branch]);
            }

            PackageStatus::create([
                'package_id' => $package_id,
                'status_id' => $status_id, // no invoice
                'created_by' => Auth::id()
            ]);

            ChangeAccountLog::create([
                'old_client_id' => 0,
                'new_client_id' => $client_id,
                'package_id' => $package_id,
                'created_by' => Auth::id()
            ]);

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Successful!']);
        } catch (\Exception $exception) {
            dd($exception);
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    // all packages
    public function get_packages_page()
    {
        try {
            $sellers = Seller::whereNull('deleted_by')->orderBy('name')->select('id', 'name')->get();
            $statuses = Status::whereNull('deleted_by')->select('id', 'status_en as status')->get();
            $locations = Location::whereNull('deleted_by')->orderBy('name')->select('id', 'name')->get();

            return view('backend.operator.packages', compact(
                'sellers',
                'statuses',
                'locations'
            ));
        } catch (\Exception $exception) {
            return view('backend.error');
        }
    }

    public function show_packages(Request $request)
    {
        try {
            $query = Item::leftJoin('package', 'item.package_id', '=', 'package.id')
                ->leftJoin('currency as item_currency', 'item.currency_id', '=', 'item_currency.id')
                ->leftJoin('currency as cur', 'package.currency_id', '=', 'cur.id')
                ->leftJoin('seller as s', 'package.seller_id', '=', 's.id')
                ->leftJoin('users as c', 'package.client_id', '=', 'c.id')
                ->leftJoin('lb_status as st', 'package.last_status_id', '=', 'st.id')
                ->leftJoin('position as p', 'package.position_id', '=', 'p.id')
                ->leftJoin('locations as l', 'p.location_id', '=', 'l.id')
                ->leftJoin('locations as dep', 'package.departure_id', '=', 'dep.id')
                ->leftJoin('locations as des', 'package.destination_id', '=', 'des.id')
                ->whereNull('package.deleted_by');
            if (!empty(Input::get('no')) && Input::get('no') != '' && Input::get('no') != null && Input::get('no') != 'null') {
                $where_no = Input::get('no');
                $query->where('package.id', $where_no);
            }
            if (!empty(Input::get('number')) && Input::get('number') != '' && Input::get('number') != null && Input::get('number') != 'null') {
                $where_number = Input::get('number');
                $query->whereRaw('(package.number LIKE "%' . $where_number . '%" or package.internal_id LIKE "%' . $where_number . '%")');
            }
            if (!empty(Input::get('suite')) && Input::get('suite') != '' && Input::get('suite') != null && Input::get('suite') != 'null') {
                $where_client = Input::get('suite');
                $query->where('package.client_id', $where_client);
            }
            if (!empty(Input::get('name')) && Input::get('name') != '' && Input::get('name') != null && Input::get('name') != 'null') {
                $where_client_name = Input::get('name');
                $query->where('c.name', 'like', '%' . $where_client_name . '%');
            }
            if (!empty(Input::get('surname')) && Input::get('surname') != '' && Input::get('surname') != null && Input::get('surname') != 'null') {
                $where_client_surname = Input::get('surname');
                $query->where('c.surname', 'like', '%' . $where_client_surname . '%');
            }
            if (!empty(Input::get('seller')) && Input::get('seller') != '' && Input::get('seller') != null && Input::get('seller') != 'null') {
                $where_seller = Input::get('seller');
                $query->where('package.seller_id', $where_seller);
            }
            if (!empty(Input::get('status')) && Input::get('status') != '' && Input::get('status') != null && Input::get('status') != 'null') {
                $where_status = Input::get('status');
                $query->where('package.last_status_id', $where_status);
            }
            if (!empty(Input::get('location')) && Input::get('location') != '' && Input::get('location') != null && Input::get('location') != 'null') {
                $where_location = Input::get('location');
                if ($where_location == 'container') {
                    $query->whereNotNull('package.container_id');
                } else {
                    $query->where('p.location_id', $where_location);
                }
            }
            if (!empty(Input::get('departure')) && Input::get('departure') != '' && Input::get('departure') != null && Input::get('departure') != 'null') {
                $where_departure = Input::get('departure');
                $query->where('package.departure_id', $where_departure);
            }
            if (!empty(Input::get('destination')) && Input::get('destination') != '' && Input::get('destination') != null && Input::get('destination') != 'null') {
                $where_destination = Input::get('destination');
                $query->where('package.destination_id', $where_destination);
            }
            if (!empty(Input::get('invoice_status')) && Input::get('invoice_status') != '' && Input::get('invoice_status') != null && Input::get('invoice_status') != 'null') {
                $where_invoice_status = Input::get('invoice_status');
                switch ($where_invoice_status) {
                    case 'no_invoice':
                        {
                            $query->whereNull('item.invoice_doc');
                        }
                        break;
                    case 'not_confirmed':
                        {
                            $query->where('item.invoice_confirmed', 0);
                        }
                        break;
                    case 'confirmed':
                        {
                            $query->where('item.invoice_confirmed', 1);
                        }
                        break;
                }
            }
            $packages = $query->orderBy('id', 'desc')
                ->select(
                    'package.id',
                    'package.last_status_id',
                    'package.number',
                    'package.height',
                    'package.width',
                    'package.length',
                    'package.gross_weight',
                    'package.unit',
                    'package.total_charge_value',
                    'cur.name as currency',
                    's.name as seller',
                    'package.client_id as suite',
                    'c.name as client_name',
                    'c.surname as client_surname',
                    'package.client_id',
                    'package.created_at',
                    'st.status_en as status',
                    'st.color as status_color',
                    'p.name as position',
                    'l.name as location',
                    'package.container_id as container',
                    'dep.name as departure',
                    'des.name as destination',
                    'item.price',
                    'item_currency.name as invoice_currency',
                    'item.invoice_doc',
                    'package.package_img'
                )
                ->paginate(50);

            return response(['case' => 'success', 'packages' => $packages]);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

}
