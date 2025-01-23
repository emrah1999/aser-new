<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Contact;

class ContactController extends HomeController
{
    public function index()
    {
        return view('web.contact.header-contact');
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
