<?php
require_once("../../bootstrap.php");

use App\Models\Entity\Empresa;
use App\Models\Entity\Login;

session_start();


if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    session_destroy();
}

$empresaRepository = $entityManager->getRepository('App\Models\Entity\Empresa');
$empresa = $empresaRepository->findBy(array("fk_login_empresa" => $_SESSION["array"][0]->id_login));


if (isset($_POST['btnAtualizarPerfil'])) {
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
            copy($nome_temporario, "teste/$nome_real");
            $photoURL = "teste/" . $nome_real;
            $empresaUser->setDir_foto_usuario($photoURL);

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


?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>City Care</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet"/>


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet"/>
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="#DCDCDC" data-image="assets/img/sidebar-5.jpg">

        <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->


        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.projetocitycare.com.br" class="simple-text">
                    City Care
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="dashboard.php">
                        <i class="pe-7s-graph"></i>
                        <p>Painel Administrativo</p>
                    </a>
                </li>
                <li class="active">
                    <a href="user.php">
                        <i class="pe-7s-user"></i>
                        <p>Perfil de Usuário</p>
                    </a>
                </li>
                <li>
                    <a href="table.php">
                        <i class="pe-7s-note2"></i>
                        <p>Denuncias</p>
                    </a>
                </li>
                <li>
                    <a href="maps.php">
                        <i class="pe-7s-map-marker"></i>
                        <p>Mapa</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Usuário</a>
                </div>
                <div class="collapse navbar-collapse">

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="user.php">
                                <p> <?php echo $_SESSION["usuario"]; ?></p>
                            </a>
                        </li>
                        <li>
                            <a href="sair.php">
                                <p>Sair</p>
                            </a>
                        </li>
                        <li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <!-- Conteudo da pagina !-->


        <?php

        $nomeFantasia = $empresa[0]->nome_fantasia;
        $login = $_SESSION["array"][0]->login;
        $email = $_SESSION["array"][0]->email;
        $razaoSocial = $empresa[0]->razao_social;
        $dirFoto = $empresa[0]->dir_foto_usuario;
        $cidade = $empresa[0]->cidade;
        $estado = $empresa[0]->estado;


        ?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Editar Perfil</h4>
                            </div>
                            <div class="content">
                                <form id="atualizarPerfil" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Nome Fantasia</label>
                                                <input type="text" name="nomeFantasia" class="form-control" disabled
                                                       value="<?php echo $nomeFantasia ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Login</label>
                                                <input type="text" name="login" class="form-control" placeholder="Login"
                                                       value="<?php echo $login ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Nova Senha</label>
                                                <input type="text" name="novaSenha" class="form-control"
                                                       placeholder="Senha">
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Razão Social</label>
                                                <input type="text" name="razaoSocial" class="form-control"
                                                       placeholder="Razão Social"
                                                       value="<?php echo $razaoSocial; ?> ">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" name="email" class="form-control"
                                                       placeholder="Email"
                                                       value="<?php echo $email ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cidade</label>
                                                <input type="text" name="cidade" class="form-control"
                                                       placeholder="Cidade"
                                                       value="<?php echo $cidade ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <input type="text" name="estado" class="form-control"
                                                       placeholder="Estado"
                                                       value="<?php echo $estado ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Foto de Perfil</label>
                                                <input type="file" accept="image/*" name="fotoPerfil" id="fotoPerfil"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" name="btnAtualizarPerfil"
                                            class="btn btn-info btn-fill pull-right">Atualizar Perfil
                                    </button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="image">
                                <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400"
                                     alt="..."/>
                            </div>
                            <div class="content">
                                <div class="author">
                                    <br>
                                    <img class="avatar border-gray" src="<?php echo $dirFoto ?>"
                                         alt="Foto de Usuário"/>
                                    <h4 class="title"><?php echo $nomeFantasia ?><br/>
                                        <small><?php echo $login ?></small>
                                    </h4>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
</div>


</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

<!--  Charts Plugin -->
<script src="assets/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="assets/js/light-bootstrap-dashboard.js"></script>

<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>

</html>