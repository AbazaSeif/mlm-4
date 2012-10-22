<?php

class Base_Controller extends Controller {

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}
	
	public function __construct()
    	{
	    	// Generate a 'moduleURL' variable so we can access which module we are currently i
	    	// (Used primarily in search)
	    	$url = explode('/', URL::current());
	    	$moduleurl = $url[3];
	    	View::share('moduleURL', $moduleurl);
    	}
    
}