<?php

namespace Chibi\Auth;


use App\User;
use Chibi\Session\Session;

class Auth
{
    protected static $instance = null;

    protected $guard = null;

    protected $connectedId = null;

    /**
     * Auth constructor.
     *
     * @param $name
     */
    private function __construct($name)
    {
        $this->guard = $name;
    }

    /**
     * Login with the id
     *
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public static function loginWith($id)
    {
        $auth = static::getInstance();

        $instance = self::getRecordById($id);

        if(is_null($instance))
        {
            throw new \Exception("User not found");
        }

        Session::put('auth',
            $auth->connectWithId($id)
        );

        return $instance;
    }

    /**
     * Generate the auth instance
     *
     * @param string $name
     * @return Auth|null
     */
    public static function getInstance($name = 'user')
    {
        if($auth = Session::get('auth')){
            if(!is_null($auth->getConnectedId()) && $auth->getGuardName() === $name){
                return $auth;
            }
        }

        if(!is_null(static::$instance)){
            return static::$instance;
        }

        static::$instance = new Auth($name);

        return static::$instance;
    }

    /**
     * Set the connected ID
     *
     * @param $id
     * @return $this
     */
    public function connectWithId($id)
    {
        $this->connectedId = $id;

        return $this;
    }

    /**
     * Get the record by id
     *
     * @param $id
     * @return mixed
     */
    protected static function getRecordById($id)
    {
        $auth = static::getInstance();

        $instance = call_user_func_array([$auth->havingGuard(), 'find'], [$id]);

        return $instance;
    }

    /**
     * Check if the user can login
     *
     * @param $username
     * @param $password
     * @param null $extra
     * @return bool
     */
    public static function canLogin($username, $password, $extra = null)
    {
        $instance = static::getInstance()->havingGuard();

        // look for the username first(which should be unique)

        $user = call_user_func_array([$instance, 'where'], [
            [
                'email' => $username,
            ]
        ]);

        if(is_null($user) === 0){
            return false;
        }

        // compare with the password
        $hashedPassword = call_user_func_array([$instance, 'hash'], [$password]);

        if(!static::IsSamePassword($user->getPassword(), $hashedPassword)){
            return false;
        }
        if(!is_null($extra) && is_callable($extra)){
            return $extra($user);
        }

        return true;
    }

    /**
     * @param $one
     * @param $two
     * @return bool
     */
    public static function IsSamePassword($one, $two)
    {
        return $one === $two;
    }

    /**
     * Get the authenticated user
     *
     * @return array
     */
    public function user()
    {
        $auth = static::getInstance($this->guard);

        return static::getRecordById(
            $auth->connectedId
        );
    }



    /**
     * Get the connected Id
     *
     * @return null
     */
    public function getConnectedId()
    {
        return $this->connectedId;
    }

    /**
     * Get the guard name
     *
     * @return null
     */
    public function getGuardName(){
        return $this->guard;
    }


    /**
     * Get the related Katana
     *
     * @return string
     */
    protected function havingGuard()
    {
        return User::class;
    }

    /**
     * Pickup the guard
     *
     * @param $name
     * @return Auth|null
     */
    public static function against($name)
    {
        return static::getInstance($name);
    }

    /**
     * Logout the connected user
     *
     */
    public static function logOut()
    {
        Session::forget('auth');
    }
}