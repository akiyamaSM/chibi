<?php

namespace Chibi\Hurdle;

use Chibi\Request;
use Chibi\Response;


interface Wall {
	public function filter(Request $request, Response $Response);	
}