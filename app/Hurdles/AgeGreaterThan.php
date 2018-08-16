<?php

namespace App\Hurdles;

use Kolores\Hurdle\Wall;
use Kolores\Request;
use Kolores\Response;

class AgeGreaterThan implements Wall{

	public function filter(Request $request, Response $response){

		if($request->has('age') && $request->only('age') > 10){
			return true;
		}

		return false;
	}
}