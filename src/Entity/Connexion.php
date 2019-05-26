<?php

namespace App\Entity;



class Connexion
{
private  $username;
private  $password;
/**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

/**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

/**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

/**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

   
    
}