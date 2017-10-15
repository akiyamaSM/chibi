<?php

namespace App\Controllers;

use App\Request;
use App\Response;

class HomeController {

    public function index(Request $request, Response $response)
    {
        return $response->setBody("HomeController");
    }

    public function json(Request $request, Response $response)
    {
        return $response->withJson([
            'name' => 'Houssain'
        ])->withStatus(200);
    }
}