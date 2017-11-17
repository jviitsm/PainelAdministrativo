<?php


namespace App\Controller\Classes;

use PHPMailer\PHPMailer\PHPMailer;
use App\Models\Entity\Empresa;
use App\Models\Entity\Login;


class UsuarioController
{

    function realizarLogin($entityManager)
    {
        if (isset($_POST['btn_logar'])) {
            $email = $_POST["usuario"];
            $senha = base64_encode($_POST["senha"]);

            $loginRepository = $entityManager->getRepository('App\Models\Entity\Login');

            $existeLogin = $loginRepository->findBy(array('login' => $email, 'senha' => $senha));
            $existeEmail = $loginRepository->findBy(array('email' => $email, 'senha' => $senha));

            if ($existeLogin) {
                $id = $existeLogin[0]->id_login;
                $administrador = $existeLogin[0]->administrador;
                $empresaRepository = $entityManager->getRepository('App\Models\Entity\Empresa');
                $empresa = $empresaRepository->findBy(array('fk_login_empresa' => $id));

                if ($empresa) {
                    if ($administrador == false) {
                        $_SESSION["usuario"] = $email;
                        $_SESSION["array"] = $existeLogin;
                        $_SESSION["administrador"] = false;

                        header("Location: View/SubView/dashboard.php");
                    }
                    if ($administrador == true) {
                        $_SESSION["usuario"] = $email;
                        $_SESSION["array"] = $existeLogin;
                        $_SESSION["administrador"] = true;
                        header("Location: View/SubView/dashboard.php");
                    }
                } else {
                    echo "<p class='alert-danger'>Somente usuário empresa permitido!</p>";
                }
            } else if ($existeEmail) {
                $id = $existeEmail[0]->id_login;
                $empresaRepository = $entityManager->getRepository('App\Models\Entity\Empresa');
                $administrador = $existeEmail[0]->administrador;
                $empresa = $empresaRepository->findBy(array('fk_login_empresa' => $id));

                if ($empresa) {
                    if ($administrador == false) {
                        $_SESSION["usuario"] = $email;
                        $_SESSION["array"] = $existeEmail;
                        $_SESSION["administrador"] = false;
                        header("Location: View/SubView/dashboard.php");

                    } else if ($administrador == true) {
                        $_SESSION["usuario"] = $email;
                        $_SESSION["array"] = $existeEmail;
                        $_SESSION["administrador"] = true;
                        header("Location: View/SubView/dashboard.php");
                    }
                } else {
                    echo "<p class='alert-danger'>Somente empresa permitido!</p>";
                }
            } else {
                echo "<p class='alert-danger'>Usuário ou Senha inválidos!</p>";
            }
        }
    }

    function esqueceuSenha($entityManager){

        if (isset($_POST['btn_esqueceu'])) {


            $email = $_POST["email_esqueceu"];
            if(empty($email)){
                echo "<p class='alert alert-danger'>Digite o Email!</p>";
            }else{


                //Gerar senha randomica
                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                $novaSenha = substr(str_shuffle($chars), 0, 8);



                $loginRepository = $entityManager->getRepository('App\Models\Entity\Login');

                $login = $loginRepository->findBy(array('email' => $email));

                if ($login) {

                    $id = $login[0]->id_login;

                    $loginUser = new Login();
                    $loginUser = $loginRepository->find($id);

                    $loginUser->setSenha($novaSenha);


                    $entityManager->merge($loginUser);
                    $entityManager->flush();


                    $mail = new PHPMailer(true);
                 #   $mail->isSMTP();
                    $mail->SMTPDebug = 0;
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 587;
                    $mail->SMTPSecure = 'tls';
                    $mail->SMTPAuth = true;
                    $mail->Username = "projetocitycare@gmail.com";
                    $mail->Password = "citycare123";
                    $mail->setFrom("projetocitycare@gmail.com", 'City Care');
                    $mail->addAddress($email);
                    $mail->Subject = 'Nova Senha';
                    $mail->Body = $novaSenha;


                    if (!$mail->send()) {
                        echo "<p class='alert alert-danger'>Email Invalido!</p>";
                    } else {
                        echo "<p class='alert alert-success'>Email Enviado com Sucesso!</p>";
                    }
                } else {
                    echo "<p class='alert alert-danger'>Email Invalido!</p>";
                }
            }

        }
    }
    function retornarUsuario(){
       $user = $_SESSION["array"];
        return $user;
    }
    function retornarEmpresa($entityManager, $id){
        $empresaRepository = $entityManager->getRepository('App\Models\Entity\Empresa');
        $empresa = $empresaRepository->findBy(array('fk_login_empresa' => $id));
        return $empresa;
    }

    function atualizarPerfil($entityManager,$empresa){
        if (isset($_POST['btnAtualizarPerfil'])) {
            $empresaRepository = $entityManager->getRepository('App\Models\Entity\Empresa');

            $id = $_SESSION["array"][0]->id_login;

            $loginUser = new Login();
            $empresaUser = new Empresa();

            $loginRepository = $entityManager->getRepository('App\Models\Entity\Login');

            $loginUser = $loginRepository->find($id);

            $loginUser->setId_login($id);
            if ($_POST['novaSenha']) {
                $loginUser->setSenha($_POST['novaSenha']);
            }
            if($_SESSION['array'][0] -> login != $_POST['login']){
                if ($_POST['login'] != ""){
                    if($loginRepository->findBy(array("login" => $_POST['login']))){
                        echo "<script type='text/javascript'>alert('Login Já Existe!');</script>";
                    }
                    else{
                        $loginUser->setLogin($_POST['login']);
                    }
                }
            }
            if($_SESSION['array'][0] -> email != $_POST['email']){
                if($_POST['email'] != ""){
                    if($loginRepository->findBy(array("email" => $_POST['email']))){
                        echo "<script type='text/javascript'>alert('Email Já Existe!');</script>";
                    }
                    else{
                        $loginUser->setEmail($_POST['email']);
                    }
                }
            }



            $entityManager->merge($loginUser);
            $entityManager->flush();


            $loginNovoUser = $loginRepository->find($id);

            $empresaUser = $empresaRepository->find($empresa[0]->id_empresa);

            $empresaUser->setId_empresa($empresa[0]->id_empresa);
            $empresaUser->setRazao_social($_POST['razaoSocial']);
            $empresaUser->setFk_login_empresa($loginNovoUser);
            $empresaUser->setCidade($_POST['cidade']);
            $empresaUser->setEstado($_POST['estado']);

            $imagem = $_FILES["fotoPerfil"];


            if ($imagem["error"] == 0) {
                $nome_temporario = $_FILES["fotoPerfil"]["tmp_name"];
                $nome_real = uniqid('img-' . date('d-m-y') . '-');
                $extensao = pathinfo($_FILES["fotoPerfil"]["name"], PATHINFO_EXTENSION);
                $nome_real .= $_FILES["fotoPerfil"]["name"] . "";
                if (strstr('.jpg;.jpeg;.gif;.png', $extensao)) {
                    copy($nome_temporario, "/home/citycare//public_html/Imgs/User/$nome_real");
                    $photoURL = "https://projetocitycare.com.br/Imgs/User/$nome_real";  #/home/citycare//public_html/Imgs/User/$nome_real
                    $empresaUser->setDir_foto_usuario($photoURL); #http://projetocitycare.com.br/Imgs/User/$nome_real"

                } else {
                    echo "<script type='text/javascript'>alert('Tipo de arquivo invalido');</script>";
                }


            }
            $loginNovaSession = $loginRepository->findBy(array('email' => $loginUser->getEmail()));

            $_SESSION["array"] = $loginNovaSession;
            $_SESSION["usuario"] = $loginUser->getEmail();

            $entityManager->merge($empresaUser);
            $entityManager->flush();


        }

    }


}
