<?php


namespace Sniper7Kills\MultiModelAuth;


trait MultiModelAuthTrait
{
    public function getAuthIdentifierName()
    {
        return config('MultiModelAuth.column_name');
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function createAuthIdentifier()
    {
        return get_class($this).config('MultiModelAuth.separator').$this->{$this->getKeyName()};
    }


    public function save(array $options = [])
    {
        if(is_null($this->{$this->getAuthIdentifierName()})) {
            parent::save($options);
            $this->{$this->getAuthIdentifierName()} = $this->createAuthIdentifier();
        }
        parent::save($options);
    }
}
