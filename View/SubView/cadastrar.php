<?php
require '../../bootstrap.php';

use App\Models\Entity\Solicitacao;
use App\Models\Entity\Empresa;
use App\Models\Entity\Login;

session_start();


if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    session_destroy();
}
if (!$_SESSION['administrador'] == true) {
    header("Location: dashboard.php");
}


$solicitacaoRepository = $entityManager->getRepository('App\Models\Entity\Solicitacao');

$solicitacao = $solicitacaoRepository->find($_SESSION['cadastrar']);


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


?>

<!doctype html>
<html lang="en">
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
                <li>
                    <a href="user.php">
                        <i class="pe-7s-user"></i>
                        <p>Perfil de Usuário</p>
                    </a>
                </li>
                <li
                ">
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
                <?php
                if ($_SESSION['administrador'] == true) {
                    echo "  <li class=\"active\">
                    <a href=\"solicitacoes.php\">
                        <i class=\"pe-7s-id\"></i>
                        <p>Sol. de Cadastro</p>
                    </a>
                </li>";
                } ?>

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
                    <a class="navbar-brand" href="#">Cadastro de Empresa</a>
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


        <!--  Tabela De Denuncias    -->

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Cadastrar Empresa</h4>
                            </div>
                            <div class="content">
                                <form id="atualizarPerfil" method="post">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Nome Fantasia</label>
                                                <input type="text" name="nomeFantasia" class="form-control"
                                                       placeholder="Nome Fantasia"">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Login</label>
                                                <input type="text" name="login" class="form-control" placeholder="Login"
                                                ">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Senha</label>
                                                <input type="text" name="senha" class="form-control"
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
                                                ">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" name="email" class="form-control"
                                                       placeholder="Email"
                                                ">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cidade</label>
                                                <input type="text" name="cidade" class="form-control"
                                                       placeholder="Cidade"
                                                ">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <input type="text" name="estado" class="form-control"
                                                       placeholder="Estado"
                                                ">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cnpj</label>
                                                <input type="text" name="cnpj" class="form-control"
                                                       placeholder="Cnpj"
                                                ">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="btnCadastrar"
                                            class="btn btn-info btn-fill pull-right">Cadastrar
                                    </button>

                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <p class="text-center">Dados da solicitação</p>
                            </div>
                            <div class="card-separator">
                            </div>
                            <div class="content">
                                <br>
                                <p class="text-center">Email: <?php echo $solicitacao->getEmail(); ?> </p>
                                <p class="text-center">Nome Fantasia: <?php echo $solicitacao->getNomeFantasia(); ?></p>
                                <p class="text-center">Cidade: <?php echo $solicitacao->getCidade(); ?></p>
                                <p class="text-center">Estado: <?php echo $solicitacao->getEstado(); ?></p>
                                <p class="text-center">Telefone: <?php echo $solicitacao->getTelefone(); ?></p>
                            </div>

                        </div>
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