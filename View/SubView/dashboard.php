<?php
require_once("../../bootstrap.php");


use App\Controller\Classes\DenunciaController;
use App\Controller\Classes\CidadaoController;
use App\Controller\Classes\AgilizaController;
use App\Controller\Classes\ComentarioController;
use App\Controller\Classes\SolucaoController;
use App\Controller\Classes\SolicitacaoCadastroController;
use App\Controller\Classes\GerarPDF;

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    session_destroy();
}

date_default_timezone_set('America/Bahia');
$hora = date('H:i', time());

$denunciaController = new DenunciaController();
$cidadaoController = new CidadaoController();
$agilizaController = new AgilizaController();
$comentarioController = new ComentarioController();
$solucaoController = new SolucaoController();
$solicitacaoController = new SolicitacaoCadastroController();




if(isset($_POST['btnPDF'])){

    $pdf = new GerarPDF("../../assets/css/estilo.css","Relatorio");
    $pdf->BuildPDF($entityManager);
    $pdf->Exibir("Relatório de Clientes");

}

$numeroInteracoes = count($agilizaController->contarAgiliza($entityManager)) + count($comentarioController->contarComentarios($entityManager));

if (isset($_POST['btnChecar'])) {
    header("Location: solicitacoes.php");
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

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7qWWDPjYAoxV2m_o_E2NnDLSy4EPn52o"></script>

    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="assets/css/estilo.css">

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet"/>


</head>
<body>
<!--   Core JS Files   -->
<script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="assets/js/jquery.min.js"></script>
<!-- Caixa de informação -->
<script src="assets/js/infobox.js"></script>
<!-- Agrupamento dos marcadores -->
<script src="assets/js/markerclusterer.js"></script>


<div class="wrapper">
    <div class="sidebar" data-color="#DCDCDC" data-image="assets/img/sidebar-5.png">

        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="https://www.projetocitycare.com.br" class="simple-text">
                    City Care
                </a>
            </div>

            <ul class="nav">
                <li class="active">
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
                <li>
                    <a href="table.php">
                        <i class="pe-7s-note2"></i>
                        <p>Denuncias</p>
                    </a>
                </li>
                <?php
                if ($_SESSION['administrador'] == true) {
                    echo " <li>
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
                    <a class="navbar-brand">Painel</a>
                </div>

                <div class="collapse navbar-collapse">
                    <!-- Mostrar noficiações de solicitações de cadastro -->
                    <?php
                    #verificar se é admin e montar task
                    $solicitacaoController->montarTaskSolicitacoes($entityManager,$solicitacaoController->contarSolicitacao($entityManager),
                        $solicitacaoController->buscarSolicitacoes($entityManager),$_SESSION['administrador']);
                    ?>
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
        <br>
        <div class="col-md-16">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-map-marker fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo count($denunciaController->buscarNaCidade($entityManager)); ?></div>
                                <div>Denuncias <br> Ativas!</div>
                            </div>
                        </div>
                    </div>
                    <a href="table.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalhes</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-check-square fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $solucaoController->contarSolucao($entityManager)?></div>
                                <div>Denuncias Solucionadas!</div>
                            </div>
                        </div>
                    </div>
                    <a href="solucionadas.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalhes</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $cidadaoController->contarCidadaos($entityManager); ?></div>
                                <div>Usuários <br>Cadastrados!</div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <span class="pull-left"></span>
                        <div class="clearfix"></div>
                    </div>

                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-thumbs-o-up fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $numeroInteracoes ?></div>
                                <div>Interações com <br> Postagens!</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="clearfix"></div>
                    </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="panel-title text-center">Mapa</h4>
                    <p class="category">Denuncias ativas e solucionadas</p>
                </div>
                <div style="overflow-x : auto; overflow-y: auto">
                <div class="content">


                    <div id="mapa" class="container-fluid" style="height: 500px; width: 1000px">

                    </div>
                    </div>
                    <div class="footer">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-history" style="margin-left: 5px"></i> Atualizado as: <?php echo $hora ?>
                        </div>
                            <a>
                                <form method="post">
                                    <center><input type="submit" class="btn btn-primary btn-fill" name="btnPDF" style="margin-bottom: 20px" value="Gerar Relatório"></center>
                                </form>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Arquivo de inicialização do mapa -->
    <script src="assets/js/mapa.js"></script>


</body>

<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

<!--  Charts Plugin -->
<script src="assets/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="assets/js/light-bootstrap-dashboard.js"></script>


</html>
