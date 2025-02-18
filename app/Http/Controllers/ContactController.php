<?php

namespace App\Http\Controllers;

use App\Title;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Contact;

class ContactController extends HomeController
{
    public function index()
    {
        $fields = [
            'how_it_work', 'international_delivery', 'corporative_logistics', 'services',
            'partners', 'blogs', 'feedback', 'faqs', 'contacts', 'tracking_search'
        ];

        $title = Title::query()
            ->select(array_map(function($field) {
                return DB::raw("{$field}_" . App::getLocale() . " as {$field}");
            }, $fields))
            ->first();

        return view('web.contact.header-contact',compact('title'));
    }

    public function message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'string', 'max:150'],
            'subject' => ['nullable', 'string', 'max:500'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);
        if ($validator->fails()) {
            return response(['case' => 'warning', 'title' => 'Warning!', 'type' => 'validation', 'content' => $validator->errors()->toArray()]);
        }
        try {
            Contact::create($request->all());

            return response(['case' => 'success', 'title' => 'Success!', 'content' => 'Məktubunuz uğurla göndərildi. Təşəkkür edirik!']);
        } catch (\Exception $exception) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }

    public function index_footer()
    {
        return view('web.contact.footer-contact');
    }
}
