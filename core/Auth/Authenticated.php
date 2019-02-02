<?php

namespace Chibi\Auth;


use Chibi\Model\Katana;

abstract class Authenticated extends Katana
{

    abstract function guard(): string ;
    /**
     * Force the login for some user
     *
     * @return  Authenticated
     */
    public function forceLogging()
    {
        Auth::against($this->guard())->connectWithId(
            $this->getIdValue()
        );

        return $this;
    }

    /**
     * Force the logout for some user
     *
     * @return  Authenticated
     */
    public function logout()
    {
        Auth::against($this->guard())->logOut();

        return $this;
    }

    /**
     * Check if the user is connected
     *
     * @return bool
     */
    public function check()
    {
        return  Auth::against($this->guard())->getConnectedId() === $this->getIdValue();
    }
}