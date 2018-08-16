<?php

namespace Kolores\Hurdle;

use Kolores\Request;
use Kolores\Response;


interface Wall {
	public function filter(Request $request, Response $Response);	
}