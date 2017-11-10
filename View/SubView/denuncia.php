<?php
require_once("../../bootstrap.php");

use App\Models\Entity\Denuncia;
use App\Models\Entity\Comentario;
use App\Models\Entity\Solucao;

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    session_destroy();
}


##Buscando denuncia que foi clicada pelo usuario
$denunciaRepository = $entityManager->getRepository('App\Models\Entity\Denuncia');

$denuncia = $denunciaRepository->find($_SESSION['denuncia']);

$agilizaRepository = $entityManager->getRepository('App\Models\Entity\Agiliza');
$agilizas = $agilizaRepository->findBy(array("fk_denuncia_agiliza" => $denuncia->getId_denuncia()));

$comentarioInstance = new Comentario();

$categoria = $denuncia->getFk_categoria_denuncia()->getDescricao_categoria();


$comentarioRepository = $entityManager->getRepository('App\Models\Entity\Comentario');
$comentarios = $comentarioRepository->findBy(array("fk_denuncia_comentario" => $denuncia->getId_denuncia()));


##Cadastrar Solução


if (isset($_POST['btnSolucionar'])) {
    $controle = true;
    if ($_POST['descricaoSolucao'] != '') {
        $descricao = $_POST['descricaoSolucao'];
    } else {
        echo "<script type='text/javascript'>alert('Preencha a descrição');</script>";
        $controle = false;
    }


    if (!($_FILES['fotoSolucao']['error'] == 4)) {
        $imagem = $_FILES["fotoSolucao"];
        if ($imagem["error"] == 0) {
            $nome_temporario = $_FILES["fotoSolucao"]["tmp_name"];
            $nome_real = uniqid('img-' . date('d-m-y') . '-');
            $extensao = pathinfo($_FILES["fotoSolucao"]["name"], PATHINFO_EXTENSION);
            $nome_real .= $_FILES["fotoSolucao"]["name"] . "";
            if (strstr('.jpg;.jpeg;.gif;.png', $extensao)) {
                copy($nome_temporario, "teste/$nome_real"); #"/home/citycare//public_html/Imgs/Solucao/$nome_real
                $photoURL = "teste/" . $nome_real; #http://projetocitycare.com.br/Imgs/Solucao/$nome_real
            } else {
                echo "<script type='text/javascript'>alert('Tipo de arquivo invalido');</script>";
                $controle = false;
            }
        }
    } else {
        echo "<script type='text/javascript'>alert('Insira a foto da solução');</script>";
        $controle = false;
    }

    if($controle){

    try{
    $solucao = new Solucao();

    $solucao->setDescricaoSolucao($descricao);
    $solucao->setDirFotoSolucao($photoURL);
    $solucao->setDataSolucao(date('d/m/y'));

    $entityManager->persist($solucao);
    $entityManager->flush();

    $denuncia->setStatus_denuncia(0);
    $denuncia->setFk_solucao_denuncia($solucao);

    $entityManager->merge($denuncia);
    $entityManager->flush();

    $_SESSION['denuncia'] = "";
    header("Location: table.php ");
    }catch (Exception $e){
        echo "<script type='text/javascript'>alert('Desculpe Ocorreu um Erro!');</script>";
    }

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
                <li class="active">
                    <a href="table.php">
                        <i class="pe-7s-note2"></i>
                        <p>Denuncias</p>
                    </a>
                </li>
                <li>
                </li>
                <li>
                    <a href="maps.php">
                        <i class="pe-7s-map-marker"></i>
                        <p>Mapa</p>
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
                    <a class="navbar-brand">Denuncia</a>
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


        <!-- INSERIR BODY AQUI -->

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
                    <div class="list-group">
                        <?php

                        $comentarioInstance->montarComentarios($comentarios);
                        ?>
                    </div>
                </div>
            </div>


            <div class="panel panel-primary">
                <div class="panel-heading text-center"><h5>Solucionar Denuncia</h5></div>
                <div class="panel-body">

                    <p class="text-center">Insira os Dados Para a Solução</p>
                    <div class="row">
                        <form name="formSolucao" id="formSolucao" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                                <p class="text">Descrição</p>
                                <input type="text" name="descricaoSolucao" class="form-control btn-round "
                                       placeholder="Solução">
                            </div>
                            <p>Foto</p>
                            <input type="file" accept="image/*" name="fotoSolucao" id="fotoSolucao"
                                   class="form-control btn-round">
                    </div>
                    <br>
                    <center>
                        <button type="submit" name="btnSolucionar"
                                class="btn btn-primary">Solucionar
                        </button>
                    </center>
                    </form>


                </div>
            </div>


        </div>
    </div><!--/row-->


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

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="assets/js/light-bootstrap-dashboard.js"></script>

<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>


</html>
