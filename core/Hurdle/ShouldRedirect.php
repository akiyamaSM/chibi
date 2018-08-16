<?php
namespace Kolores\Hurdle;

interface ShouldRedirect{
    /**
     * Redirect to a page
     *
     * @return mixed
     */
    public function redirectTo();
}