<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class Language {
    public static $locales = ['vn' => 'Vietnamese','en' => 'English','ru'=>'Russian'];
    public static $skip_locales = ['public','action'];
    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Make sure current locale exists.
        $locale = $request->segment(1);
        $manage = $request->segment(2);
        session()->put('manage',$manage);
        session()->put('locale',$locale);
        if(in_array($locale,Language::$skip_locales)) {
                   return $next($request);
                }
        if ( ! array_key_exists($locale, Language::$locales)) {
		            $segments = $request->segments();
		            $segmen = $request->segments();
		            $say = 0;
		            	foreach($segments as $segment){
							$segmen[$say+1] = $segments[$say];
							$say++;
						}
		            $segmen[0] = $this->app->config->get('app.fallback_locale');
		            return $this->redirector->to(implode('/', $segmen));
       	}

        $this->app->setLocale($locale);

        return $next($request);
    }

}