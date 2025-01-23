<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function get_categories(Request $request)
    {
        try {
            $header = $request->header('Accept-Language');
            $categories = Category::whereNull('deleted_by')->select('id', 'name_' . $header)->get();
            return compact('categories');
        } catch (\Exception $e) {
            return response(['case' => 'error', 'title' => 'Error!', 'content' => 'Sorry, something went wrong!']);
        }
    }
}
