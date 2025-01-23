<?php

namespace App\Http\Controllers;

use App\TokensForLogin;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function cache_clear(Request $request) {
        try {
            $token = $request->input('token');

            $token_control = TokensForLogin::where('token', $token)
                ->where('created_time', '>', time()-60)
                ->orderBy('id', 'desc')
                ->select('id')
                ->first();

            if (!$token_control) {
                return response([
                    'status' => Response::HTTP_NOT_FOUND,
                    'type' => 'Oops',
                    'message' => 'Token not found...'
                ], Response::HTTP_NOT_FOUND);
            }

            \Artisan::call('cache:clear');

            return response([
                'status' => Response::HTTP_OK,
                'type' => 'Success',
                'message' => 'Successfully...'
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'type' => 'Error',
                'message' => 'Sorry, An error occurred...'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
