<?php

namespace App\Hurdles;

use Chibi\Hurdle\Wall;
use Chibi\Request;
use Chibi\Response;

class YearIsCurrent implements Wall{

	public function filter(Request $request, Response $response){

		if($request->has('year') && $request->only('year') == 2018){
			return true;
		}

		return false;
	}
}