<?php


class LoginDAO{

    public function validarAcesso(Login $login){

        $loga = BdConnection::getInstance()->prepare("SELECT * FROM login WHERE email=? AND senha=?");
        $loga->bindValue(1,$login->getEmail());
        $loga->bindValue(2,$login->getSenha());
        $loga->execute();
        if($loga->rowCount()==1){
            return true;
        }else{
            return false;
        }

    }

}