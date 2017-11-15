<?php

namespace App\Controller\Classes;

use App\Models\Entity\Login;
use App\Models\Entity\Empresa;

class CadastrarEmpresaController{


    function cadastrar($entityManager,$solicitacao){

        if(isset($_POST['btnCadastrar'])) {
            if($_POST['nomeFantasia'] && $_POST['email'] && $_POST['login'] && $_POST['senha'] && $_POST['razaoSocial'] &&
                $_POST['cidade'] && $_POST['estado']){

                $novoLogin = new Login();

                $novoLogin->setEmail($_POST['email']);
                $novoLogin->setLogin($_POST['login']);
                $novoLogin->setSenha($_POST['senha']);
                $novoLogin->setAsAdministrador(0);
                $novoLogin->setStatus_login(1);

                $entityManager->persist($novoLogin);

                $empresa = new Empresa();

                $empresa->setDir_foto_usuario("http://projetocitycare.com.br/Imgs/User/Masculino.jpg");
                $empresa->setEstado($_POST['estado']);
                $empresa->setCidade($_POST['cidade']);
                $empresa->setFk_login_empresa($novoLogin);
                $empresa->setCnpj($_POST['cnpj']);
                $empresa->setRazao_social($_POST['razaoSocial']);
                $empresa->setNome_fantasia($_POST['nomeFantasia']);

                $entityManager->persist($empresa);


                $entityManager->remove($solicitacao);
                $entityManager->flush();

                header("Location: solicitacoes.php");
            }

            else
            {
                echo "<script type='text/javascript'>alert('Preencha Todos os Campos');</script>";
            }
        }

    }


}
