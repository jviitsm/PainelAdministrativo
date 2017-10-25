<?php
session_start();
require 'bootstrap.php';
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\Entity\Login;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>Login</title>

    <!--Core CSS -->
    <link href="../../includes/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../includes/css/bootstrap-reset.css" rel="stylesheet">
    <link href="../../includes/font-awesome/css/font-awesome.css" rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <link href="../../includes/css/style.css" rel="stylesheet">
    <link href="../../includes/css/style-responsive.css" rel="stylesheet"/>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="../../includes/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="includes/https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="includes/https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-body">

<div class="container">

    <form class="form-signin" action="" method="post">
        <?php
        if (isset($_POST['btn_logar'])) {
            $email = $_POST["usuario"];
            $senha = base64_encode($_POST["senha"]);


            $loginRepository = $entityManager->getRepository('App\Models\Entity\Login');

            $existeLogin = $loginRepository->findBy(array('login' => $email, 'senha' => $senha));
            $existeEmail = $loginRepository->findBy(array('email' => $email, 'senha' => $senha));

            if ($existeLogin) {
                $_SESSION["usuario"] = $email;
                header("Location: view/SubView/dashboard.php ");
            }
            else if($existeEmail){
                $_SESSION["usuario"] = $usuario;
                header("Location: view/SubView/dashboard.php");
            }
            else{
                echo "<p class='alert-danger'>Usuário ou Senha inválidos!</p>";
            }
        }


        if (isset($_POST['btn_esqueceu'])) {
            $email = $_POST["email_esqueceu"];

            //Gerar senha randomica
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $novaSenha =  substr(str_shuffle($chars),0,8);



            $loginRepository = $entityManager->getRepository('App\Models\Entity\Login');

            $login = $loginRepository->findBy(array('email' => $email));


            $id = $login[0] -> id_login;

            $loginUser = new Login();
            $loginUser = $loginRepository->find($id);
            $loginUser->setSenha($novaSenha);

            var_dump($novaSenha);

            $entityManager->merge($loginUser);
            $entityManager->flush();
            var_dump($loginUser);

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
            $mail->Body =$novaSenha;

            if (!$mail->send()) {
                echo "<p class='alert-danger'>Email Invalido!</p>";
            }



        }
        ?>


        <h2 class="form-signin-heading">CITYCARE - LOGIN</h2>
        <div class="login-wrap">
            <div class="user-login-info">
                <input type="text" name="usuario" class="form-control" placeholder="Email" autofocus required="required">
                <input type="password" name="senha" class="form-control" placeholder="Senha" required="required">
            </div>
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Lembre-me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Esqueceu sua senha?</a>

                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit" name="btn_logar">Entrar</button>

            <div class="registration">
                Não possui uma conta ainda?
                <a class="" href="registration.html">
                    Criar conta
                </a>
            </div>

        </div>
    </form>
        <!-- Modal -->
    <form id="form_esqueceu" method="post">
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
             class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Esqueceu sua senha ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter your e-mail address below to reset your password.</p>

                        <input type="text" name="email_esqueceu" placeholder="Email" autocomplete="off"
                               class="form-control placeholder-no-fix">

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <button class="btn btn-success" name="btn_esqueceu" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
        <!-- modal -->



</div>


<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script src="../../includes/js/jquery.js"></script>
<script src="../../includes/bs3/js/bootstrap.min.js"></script>

</body>
</html>
