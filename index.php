<?php
session_start();
require 'bootstrap.php';
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\Entity\Login;

?>
<?php
if (isset($_POST['btn_logar'])) {
    $email = $_POST["usuario"];
    $senha = base64_encode($_POST["senha"]);


    $loginRepository = $entityManager->getRepository('App\Models\Entity\Login');

    $existeLogin = $loginRepository->findBy(array('login' => $email, 'senha' => $senha));
    $existeEmail = $loginRepository->findBy(array('email' => $email, 'senha' => $senha));

    if ($existeLogin) {
        $_SESSION["usuario"] = $email;
        $_SESSION["array"] = $existeLogin;
        header("Location: view/SubView/dashboard.php ");
    }
    else if($existeEmail){
        $_SESSION["usuario"] = $usuario;
        $_SESSION["array"] = $existeEmail;
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
    $mail->Body =$novaSenha;

    if (!$mail->send()) {
        echo "<p class='alert-danger'>Email Invalido!</p>";
    }
    else
    {
        echo "<p class='alert-danger'>Email Enviado com Sucesso!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>City Care - Login</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login City Care</h3>
                            		<p>Insira o seu e-mail ou login e sua senha para realizar o login!</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="usuario" placeholder="E-mail/Login" class="form-username form-control" id="usuario">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="senha" placeholder="Senha" class="form-password form-control" id="senha">
			                        </div>
			                        <button type="submit" name="btn_logar" class="btn">Realizar Login</button>
			                    </form>
                                <span class="pull-right">
                                     <a data-toggle="modal" href="#myModal"> Esqueceu sua senha?</a>
                                </span>
		                    </div>

                        </div>
                    </div>
                </div>
            </div>
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
                                <p>Insira o seu e-mail para recuperar sua senha!</p>

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
            
        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>