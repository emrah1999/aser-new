<?php
    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
    
    class RedirectController extends Controller
    {
        public function redirect(Request $request)
        {
            $fullUrl = $request->query('url');
            
            $decodedUrl = urldecode($fullUrl);
            
            $parsedUrl = parse_url($decodedUrl, PHP_URL_QUERY);
            parse_str($parsedUrl, $queryParams);
            $finalUrl = $queryParams['url'] ?? '';
            
            if ($finalUrl && filter_var($finalUrl, FILTER_VALIDATE_URL)) {
                return redirect()->away($finalUrl); // Geçerli ise yönlendirme yap
            }
            
            return abort(404, 'Invalid URL');
        }
    }



