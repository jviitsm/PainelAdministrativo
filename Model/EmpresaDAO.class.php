<?php


class EmpresaDAO{

    public function validarAcesso(Empresa $empresa){

        $loga = Conexao::getInstance()->prepare("SELECT * FROM login WHERE email=? AND senha=?");
        $loga->bindValue(1,$empresa->getEmpresa());
        $loga->bindValue(2,$empresa->getSenha());
        $loga->execute();
        if($loga->rowCount()==1){
            return true;
        }else{
            return false;
        }

    }
}