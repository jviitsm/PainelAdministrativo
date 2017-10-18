<?php
session_start();
require_once("inc/Config.inc.php");
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
    <link href="includes/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="includes/css/bootstrap-reset.css" rel="stylesheet">
    <link href="includes/font-awesome/css/font-awesome.css" rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <link href="includes/css/style.css" rel="stylesheet">
    <link href="includes/css/style-responsive.css" rel="stylesheet"/>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="includes/js/ie8-responsive-file-warning.js"></script><![endif]-->

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
        $loginController = new LoginController();
        if (isset($_POST['btn_logar'])) {


            $usuario = $_POST["usuario"];
            $senha = $_POST["senha"];

            if ($loginController->validarAcesso($usuario, $senha) == 1) {
                $_SESSION['usuario'] = $usuario;
                header("Location: view/viewMaster/pagina_principal.php");
            } else if ($loginController->validarAcesso($usuario, $senha) == 2) {
                $_SESSION['usuario'] = $usuario;
                header("Location: view/viewSubs/pagina_principal.php");
            } else {
                echo "<p class='alert-danger'>Usuário ou Senha inválidos!</p>";
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

        <!-- Modal -->
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
                        <input type="text" name="email" placeholder="Email" autocomplete="off"
                               class="form-control placeholder-no-fix">

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <button class="btn btn-success" type="button">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

    </form>

</div>


<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script src="includes/js/jquery.js"></script>
<script src="includes/bs3/js/bootstrap.min.js"></script>

</body>
</html>
