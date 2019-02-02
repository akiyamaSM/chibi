<?php

namespace App\Hurdles;

use Chibi\Hurdle\Wall;
use Chibi\Request;
use Chibi\Response;

class AgeGreaterThan implements Wall{

	public function filter(Request $request, Response $response){

		if($request->has('age') && $request->only('age') > 10){
			return true;
		}

		return false;
	}
}