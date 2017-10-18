<?php
class EmpresaController
{

    public function validarAcesso($empresa,$senha){
        $empresaModel = new Empresa();
        $empresaDAO = new EmpresaDAO();
        $empresaModel->setEmpresa($empresa);
        $empresaModel->setSenha($senha);

        if($empresaDAO->validarAcesso($empresaModel)) {
            if ($empresaModel->getUsuario() == "admin" && $empresaModel->getSenha() == "admin") {
                return $flag = 1;
            } else {
                return $flag = 2;
            }
        }else{
            return false;
        }
    }


}
