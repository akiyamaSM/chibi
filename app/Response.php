<?php

namespace App;

class Response {

    protected $body;

    protected $statusCode = 200;

    protected $headers = [];

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

    /**
     * Get the body
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set status Code
     *
     * @param $statusCode
     * @return $this
     */
    public function withStatus($statusCode)
    {
        $this->statusCode = $statusCode;

        header(sprintf(
            'HTTP/%s %s %s',
            '1.1',
            $this->statusCode,
            ''
        ));
        return $this;
    }

    /**
     * Get status Code
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Return a Json version
     *
     * @param $body
     * @return $this
     */
    public function withJson($body)
    {
        $this->withHeader('Content-Type', 'application/json');
        $this->body = json_encode($body);
        return $this;
    }

    /**
     * Set Header
     *
     * @param $name
     * @param $content
     * @return $this
     */
    public function withHeader($name, $content)
    {
        $this->headers[] = [
            'name' => $name,
            'content' => $content
        ];
        return $this;
    }

    /**
     * Get list of Headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Apply Register Headers
     *
     */
    public function applyHeaders()
    {
        array_walk($this->headers, function($header){
            header(
                sprintf('%s: %s', $header['name'], $header['content'])
            );
        });
    }
}