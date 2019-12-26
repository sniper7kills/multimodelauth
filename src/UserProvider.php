<?php
namespace Sniper7Kills\MultiModelAuth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class UserProvider extends EloquentUserProvider
{
    /**
     * The array of models we want to be able to authenticate against
     *
     * @var array
     */
    protected $models;

    /**
     * Create a new database user provider.
     *
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @return void
     */
    public function __construct(HasherContract $hasher, array $models)
    {
        $this->models = $models;
        $this->hasher = $hasher;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $split = explode(config('MultiModelAuth.separator'),$identifier);
        $this->model = $split[0];

        return parent::retrieveById($identifier);
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $split = explode(config('MultiModelAuth.separator'),$identifier);
        $this->model = $split[0];

        return parent::retrieveByToken($identifier, $token);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        foreach($this->models as $model)
        {
            $this->model = $model;

            $user = parent::retrieveByCredentials($credentials);

            if($user != null)
                return $user;
        }
        return null;
    }

    /**
     * Get a user based on credentials passed in by passport
     *
     * @param mixed $credential
     * @return mixed
     */
    public function findForPassport($credential)
    {
        foreach($this->models as $model)
        {
            $this->model = $model;

            if(method_exists($this->model, 'findForPassport'))
                $user = (new $this->model)->findForPassport($credential);
            else
                $user = (new $this->model)->where('email',$credential)->first();

            if($user != null)
                return $user;
        }
        return null;
    }
}
