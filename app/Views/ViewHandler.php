<?php
namespace App\Views;

use App\Exceptions\ViewNotFoundException;

class ViewHandler {

    /**
     * View Parser
     *
     * @param $view
     * @param array $variables
     * @throws ViewNotFoundException
     */
    final public function view($view, $variables = [])
    {
        if(! file_exists("app/views/{$view}.chibi.php")){
            throw new ViewNotFoundException("The {$view} view is not found");
        }
        extract($variables);
        require_once("app/views/{$view}.chibi.php");
    }

}