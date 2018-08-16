<?php

namespace App\Hurdles;

use Kolores\Hurdle\ShouldRedirect;
use Kolores\Hurdle\Wall;
use Kolores\Request;
use Kolores\Response;

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