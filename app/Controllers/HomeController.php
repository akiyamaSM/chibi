<?php

namespace App\Controllers;

use Chibi\Request;
use Chibi\Response;
use Chibi\Controller\Controller;

class HomeController extends Controller
{

    public function json(Request $request, Response $response)
    {
        $name = $request->only('name');
        return $response->withJson([
                'name' => $name
            ])->withStatus(200);
    }

    public function views()
    {
        $array = [
            'one',
            'two',
            'three'
        ];
        return view('hello', [
            'name' => 'Houssain',
            'age' => 26,
            'array' => $array,
        ]);
    }

    public function testConfig()
    {
        $config = \Chibi\App::getInstance()->getContainer()->config;
        bdump($config);
    }
}
