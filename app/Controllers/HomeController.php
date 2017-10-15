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
        $name = $request->only('name');
        return $response->withJson([
            'name' => $name
        ])->withStatus(200);
    }
}