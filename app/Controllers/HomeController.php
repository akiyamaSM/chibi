<?php

namespace App\Controllers;

use App\Response;

class HomeController {

    public function index(Response $response)
    {
        return $response->setBody("HomeController");
    }
}