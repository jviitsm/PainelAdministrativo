<?php


namespace App\Controller\Classes;


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
                    $mail->isSMTP();
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

}
