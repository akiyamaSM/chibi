<?php

namespace App\Controllers;

use App\Request;
use App\Response;
use App\Models\Customer;

class HomeController extends Controller {

    public function index(Request $request, Response $response)
    {
        $html = '<a href="/">main menu</a> - <a href="/customer/edit">add new</a><hr/>'
            . '<table border="1"><tr>';

        foreach (Customer::getModelFields() as $field) {
            $html.= '<th>'.$field.'</th>';
        }

        $html.= '<th></th></tr>';

        foreach (Customer::all() as $customer) {
            $html.= '<tr>';
            foreach (Customer::getModelFields() as $field) {
                $html.= '<td>'.$customer->{$field}.'</td>';
            }
            $html.= '<td><a href="/customer/edit?id='.$customer->getPrimaryKeyValue().'">edit</a></td></tr>';
        }

        $html.= '</table>';

        return $response->setBody($html);
    }

    public function json(Request $request, Response $response)
    {
        $name = $request->only('name');
        return $response->withJson([
            'name' => $name
        ])->withStatus(200);
    }

    public function views($user, $name)
    {
        var_dump($user, $name);
        return $this->view('hello', [
            'name' => 'Houssain'
        ]);
    }
}