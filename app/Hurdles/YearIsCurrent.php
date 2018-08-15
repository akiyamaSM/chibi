<?php

namespace App\Hurdles;

use Chibi\Hurdle\ShouldRedirect;
use Chibi\Hurdle\Wall;
use Chibi\Request;
use Chibi\Response;

class YearIsCurrent implements Wall, ShouldRedirect{

	public function filter(Request $request, Response $response){

		if($request->has('year') && $request->only('year') == 2018){
			return true;
		}

		return false;
	}

    /**
     * Redirect to a page
     *
     * @return mixed
     */
    public function redirectTo()
    {
        return redirect(route('test'));
    }
}