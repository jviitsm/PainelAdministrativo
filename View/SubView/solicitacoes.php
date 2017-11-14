<?php
require '../../bootstrap.php';

use App\Models\Entity\Solicitacao;

session_start();


if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    session_destroy();
}

$solicitacaoInstance = new Solicitacao();
$solicitacaoRepository = $entityManager->getRepository('App\Models\Entity\Solicitacao');
$solicitacoes = $solicitacaoRepository->findBy(array("status_solicitacao" => 1));
$numeroSolicitacoes = count($solicitacoes);

if (!$_SESSION['administrador'] == true) {
    header("Location: dashboard.php");
}
if(isset($_POST['btnSolicitado'])){
    $_SESSION['cadastrar'] = $_POST['id'];
    header("Location: cadastrar.php");
}
if(isset($_POST['btnExcluir'])){
    $solicitacaoRepository = $entityManager->getRepository('App\Models\Entity\Solicitacao');

    try{
        $solicitacaoARemover = $solicitacaoRepository->find($_POST['id']);

        $entityManager->remove($solicitacaoARemover);
        $entityManager->flush();

    }catch (Exception $e){
        echo "<script type='text/javascript'>alert('Não foi possivel excluir!, ocorreu algum erro.');</script>";
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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet"/>
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="#DCDCDC" data-image="assets/img/sidebar-5.png">

        <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->


        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="https://www.projetocitycare.com.br" class="simple-text">
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
                    <a class="navbar-brand" href="#">Solicitações de Cadastro</a>
                </div>
                <div class="collapse navbar-collapse">
                    <!-- Mostrar noficiações de solicitações de cadastro -->
                    <?php
                    #verificar se é admin
                    if ($_SESSION['administrador'] == true) {
                        echo " <ul class=\"nav navbar-nav navbar-left\">
                        <li class=\"dropdown\">
                            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                                <i class=\"fa fa-globe\"></i>
                                <b class=\"caret hidden-sm hidden-xs\"></b>
                                <span class=\"notification hidden-sm hidden-xs\">$numeroSolicitacoes</span>
                                <p class=\"hidden-lg hidden-md\">
                                    $numeroSolicitacoes Notificações
                                    <b class=\"caret\"></b>
                                </p>
                            </a>
                            <ul class=\"dropdown-menu\">" ?>
                        <?php
                        $solicitacaoInstance->montarTask($solicitacoes, $_SESSION['administrador']); ?>
                        <?php echo "
                            </ul>
                        </li>
                    </ul>
                            ";
                    }
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


        <!--  Tabela De Denuncias    -->

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Solicitações de Cadastro
                    </header>
                    <div class="panel-body">
                        <section id="unseen">
                            <div style="overflow-x:auto;">
                                <table class="table table-bordered table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Email</th>
                                        <th>Nome Fantasia</th>
                                        <th>Cidade</th>
                                        <th>Estado</th>
                                        <th>Telefone</th>
                                        <th>Cadastrar</th>
                                        <th>Excluir</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <div>
                                        <?php

                                        $solicitacaoInstance = new Solicitacao();

                                        $solicitacaoRepository = $entityManager->getRepository('App\Models\Entity\Solicitacao');

                                        $solicitacoes = $solicitacaoRepository->findBy(array("status_solicitacao" => 1));


                                        $solicitacaoInstance->montarTabela($solicitacoes);

                                        ?>
                                    </div>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </section>
            </div>
        </div>

        </section>
        </section>


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

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="assets/js/light-bootstrap-dashboard.js"></script>



</html>