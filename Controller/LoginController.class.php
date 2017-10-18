<?php


class LoginController{

    public function validarAcesso($email,$senha){
        $loginModel = new Login();
        $loginDAO = new LoginDAO();
        $loginModel->setEmail($email);
        $loginModel->setSenha($senha);

        if($loginDAO->validarAcesso($loginModel)) {
            if ($loginModel->getEmail() == "admin" && $loginModel->getSenha() == "admin") {
                return $flag = 1;
            } else {
                return $flag = 2;
            }
        }else{
            return false;
        }
    }



}