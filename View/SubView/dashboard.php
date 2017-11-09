<?php
require_once("../../bootstrap.php");
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    session_destroy();
}

$denunciaRepository = $entityManager->getRepository('App\Models\Entity\Denuncia');
$denuncias = $denunciaRepository->findBy(array("status_denuncia" => 1));
$numeroDenuncias = count($denuncias);

$cidadaoRepository = $entityManager->getRepository('App\Models\Entity\Cidadao');
$cidadadaos = $cidadaoRepository->findAll();
$numeroCidadaos = count($cidadadaos);

$agilizaRepository = $entityManager->getRepository('App\Models\Entity\Agiliza');
$comentarioRepository = $entityManager->getRepository('App\Models\Entity\Comentario');

$agilizas = $agilizaRepository->findBy(array("interacao" => 1));
$comentario = $comentarioRepository->findAll();
$numeroInteracoes = count($agilizas) + count($comentario);

$solucaoRepository = $entityManager->getRepository('App\Models\Entity\Solucao');
$solucoes = $solucaoRepository->findAll();

$numeroSolucoes = count($solucoes);


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

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script  type="text/javascript">
        google.load("visualization","1",{'packages':['corechart']});
        google.setOnLoadCallback(desenhaGrafico);

        function desenhaGrafico() {
            var data = new google.visualization.DataTable();
            data.addColumn('string','Mês');
            data.addColumn('number','Despesas em R$');

            data.addRows(2);

            data.setValue(0,0,'JAN');
            data.setValue(0,1,3450.0);

            data.setValue(1,0,'FEV');
            data.setValue(1,1,5420.0);

            var options = {
                title: 'Despesas por mês',
                width: 400, height : 300,
                colors: ['#335070'],
                legend: {position: 'bottom'}
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

            chart.draw(data,options);


        }
    </script>

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

        <!--

            Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
            Tip 2: you can also add an image using data-image tag

        -->

        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.projetocitycare.com.br" class="simple-text">
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
                    <a class="navbar-brand">Painel</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">

                    </ul>

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
                                <div class="huge"><?php echo $numeroDenuncias ?></div>
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
                                <div class="huge"><?php echo $numeroSolucoes ?></div>
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
                                <div class="huge"><?php echo $numeroCidadaos ?></div>
                                <div>Usuários <br>Cadastrados!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left"></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
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


<script src="assets/js/sb-admin-2.js"></script>


</html>
