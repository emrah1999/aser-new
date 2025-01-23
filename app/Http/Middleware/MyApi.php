<?php

namespace App\Http\Middleware;

use App\TokensForLogin;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Str;

class MyApi
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		try {
			$current_time = time();
			$header = Request::header('Authorization');
			$lang = Request::header('Language');
			$token = '';
			if (Str::startsWith($header, 'Bearer ')) {
				$token = Str::substr($header, 7);
			}

			$user = TokensForLogin::leftJoin('users as user', 'tokens_for_login.client_id', '=', 'user.id')
					->where(['tokens_for_login.token' => $token])
					->where('tokens_for_login.created_at', '>', $current_time - 2 * 30 * 24 * 60 * 60)
					->whereNull('user.deleted_by')
					->select('user.id', 'user.language')
					->orderBy('id', 'desc')
					->first();

			if (!$user) {
				return response([
						'status' => Response::HTTP_FORBIDDEN,
						'message' => 'Because, you have been inactive for more than 2 month, your token have timed out. Please, request a new token.',
				], Response::HTTP_FORBIDDEN);
			}

			$user_id = $user->id;
			$user_lang = $user->language;
			$request->attributes->add(['user_id' => $user_id]);
			$request->attributes->add(['api' => true]);
			session(['userId' => $user_id]);
			if ($lang) {
				$request->attributes->add(['apiLang' => $lang]);
				session('apiLang', $lang);

			} else {
				$request->attributes->add(['apiLang' => $user_lang]);
				session('apiLang', $user_lang);

			}
			return $next($request);
		} catch (\Exception $e) {
			return response([
					'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
					'type' => 'Error',
					'message' => 'Sorry, An error occurred...'
			], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}
}
