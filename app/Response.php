<?php

namespace App;

class Response {

    protected $body;

    /**
     * Set the body
     *
     * @param $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }
}