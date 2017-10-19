<?php

class Login{

    private $id_login;
    private $email;
    private $login;
    private $senha;
    private $status_login;
    private $administrador;

    /**
     * @return mixed
     */
    public function getIdLogin()
    {
        return $this->id_login;
    }

    /**
     * @param mixed $id_login
     */
    public function setIdLogin($id_login)
    {
        $this->id_login = $id_login;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    /**
     * @return mixed
     */
    public function getStatusLogin()
    {
        return $this->status_login;
    }

    /**
     * @param mixed $status_login
     */
    public function setStatusLogin($status_login)
    {
        $this->status_login = $status_login;
    }

    /**
     * @return mixed
     */
    public function getAdministrador()
    {
        return $this->administrador;
    }

    /**
     * @param mixed $administrador
     */
    public function setAdministrador($administrador)
    {
        $this->administrador = $administrador;
    }





}