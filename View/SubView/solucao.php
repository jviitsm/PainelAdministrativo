<?php
require_once("../../bootstrap.php");

use App\Controller\Classes\DenunciaController;
Use App\Controller\Classes\ComentarioController;
use App\Controller\Classes\AgilizaController;
use App\Controller\Classes\SolicitacaoCadastroController;

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    session_destroy();
}

$solicitacaoController = new SolicitacaoCadastroController();
$denunciaController = new DenunciaController();
$comentarioController = new ComentarioController();
$agilizaController = new AgilizaController();

$denuncia = $denunciaController->buscarDenuncia($entityManager,$_SESSION['denuncia']);
$agilizas = $agilizaController->buscarAgilizas($entityManager,$denuncia);
$categoria = $denunciaController->retornarCategoria($denuncia);
$comentarios = $comentarioController->buscarComentario($entityManager,$denuncia);
$solucao = $denunciaController->retornarSolucao($denuncia);

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


    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>

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
                <li class="active">
                    <a href="table.php">
                        <i class="pe-7s-note2"></i>
                        <p>Denuncias</p>
                    </a>
                </li>
                <li>
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
                    <a class="navbar-brand">Solução</a>
                </div>
                <div class="collapse navbar-collapse">
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
        <div class="col-sm-5">
            <br>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="text-center">Dados da Denuncia</h5>
                </div>
                <div class="panel-thumbnail">
                    <img src="<?php echo $denuncia->getDir_foto_denuncia() ?>" class="img-thumbnail">
                </div>
                <div class="panel-body">
                    <p class="huge text-center">
                        <?php echo $denuncia->getDescricao_denuncia() ?>
                    </p>
                    <p class="text-center  "><?php echo $categoria ?></p>
                    <p class="huge text-center"><?php echo $_SESSION['endereco'] ?></p>
                    <p class="huge text-center"><?php echo $_SESSION['dataDenuncia'] ?></p>
                    <p class="text-center"><?php echo count($agilizas) ?> Agiliza(s)</p>
                    <center><a class="modal-footer" href="<?php echo $denuncia->getDir_foto_denuncia() ?>">Ver
                            Imagem</a></center>
                </div>
            </div>

        </div>


        <!-- main col right -->
        <div class="col-sm-7">
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading text-center"><h5>Comentários</h5></div>
                <div class="panel-body">
                    <div class="container" style="overflow-y: scroll; max-height: 400px; max-width: 580px">
                        <?php
                        $comentarioController->montarComentarios($comentarios);
                        ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading text-center"><h5>Solução</h5></div>
                <div class="panel-body">


                    <div class="row">
                        <div class="panel-thumbnail">
                            <center>
                                <img src="<?php echo $solucao->getDirFotoSolucao()?>" class="img-thumbnail img-responsive"></center>
                        </div>
                        <div class="panel-body">
                            <label class="text-center">Descrição</label>
                            <p class="text-center"><?php echo $solucao->getDescricaoSolucao()?></p>

                        </div>

                    </div>
                </div>

            </div><!-- /col-9 -->
        </div><!-- /padding -->


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



