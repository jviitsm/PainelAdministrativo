<?php

namespace App\Controller\Classes;

use App\Models\Entity\Solucao;

class SolucaoController{

    function contarSolucao($entityManager){
        $solucaoRepository = $entityManager->getRepository('App\Models\Entity\Solucao');
        $solucoes = $solucaoRepository->findAll();
        $numeroSolucoes = count($solucoes);
        return $numeroSolucoes;
    }
    function contarSolucaoNaCidade($entityManager){
        $solucaoRepository = $entityManager->getRepository('App\Models\Entity\Solucao');
        $solucoes = $solucaoRepository->findAll();
        $numeroSolucoes = count($solucoes);
        return $numeroSolucoes;
    }


    function cadastrarSolucao($entityManager,$denuncia)
    {

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
                        copy($nome_temporario, "/home/citycare/public_html/Imgs/Solucao/$nome_real"); #"/home/citycare//public_html/Imgs/Solucao/$nome_real
                        ##../../assets/img/$nome_real
                        $photoURL = "https://projetocitycare.com.br/Imgs/Solucao/$nome_real"; #http://projetocitycare.com.br/Imgs/Solucao/$nome_real
                    } else {
                        echo "<script type='text/javascript'>alert('Tipo de arquivo invalido');</script>";
                        $controle = false;
                    }
                }
            } else {
                echo "<script type='text/javascript'>alert('Insira a foto da solução');</script>";
                $controle = false;
            }

            if ($controle) {

                try {

                    $solucao = new Solucao();

                    $loginRepository = $entityManager->getRepository('App\Models\Entity\Login');
                    $login = $loginRepository->find($_SESSION['array'][0] -> id_login);

                    $solucao->setDescricaoSolucao($descricao);
                    $solucao->setDirFotoSolucao($photoURL);


                    date_default_timezone_set('America/Bahia');
                    $date = date("Y-n-j");
                    $date .= "T";
                    $date .= date("G:i:s.000P");

                    $solucao->setDataSolucao($date);
                    $solucao->setFkLoginSolucao($login);

                    $entityManager->persist($solucao);
                    $entityManager->flush();

                    $denuncia->setStatus_denuncia(0);
                    $denuncia->setFk_solucao_denuncia($solucao);

                    $entityManager->merge($denuncia);
                    $entityManager->flush();

                    $_SESSION['denuncia'] = "";
                    header("Location: table.php ");
                } catch (Exception $e) {
                    echo "<script type='text/javascript'>alert('Desculpe Ocorreu um Erro!');</script>";
                }

            }

        }
    }
    function redirecionar(){
        if (isset($_POST['btn_solucao'])) {
            $id = $_POST['id'];

            $_SESSION["denuncia"] = $id;
            header("Location: solucao.php");

        }
    }
    function montarTabela($denuncias)
    {
        foreach ($denuncias as $lista) {

            $endereco = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lista->latitude_denuncia . ',' . $lista->longitude_denuncia . '&key=AIzaSyC_smlZV61EJc1y0ZqgG6CqjzfT1ApoHrQ');
            $output = json_decode($endereco, true);

            $endereco = $output['results'][0]['formatted_address'];
            list($year, $month, $day) = explode('-', $lista->data_denuncia);
            list($dia) = explode('T', $day);
            $data = "$dia"."/$month"."/$year";


            echo "<form id=\"form_denuncia\" method=\"post\">";
            echo "<tr>";
            echo "<td>$lista->id_denuncia</td>";
            echo "<td>$lista->descricao_denuncia</td>";
            echo "<td>{$lista->fk_categoria_denuncia->descricao_categoria}</td>";
            echo "<td>$endereco</td>";
            echo "<td>$data</td>";
            echo "<td><button type=\"submit\" name=\"btn_solucao\" class=\"btn btn-info btn-fill pull-center\">Checar</button></td>";
            echo "<input type=\"hidden\" name=\"id\" value=\"$lista->id_denuncia\">";
            echo "</form>";
        }
        if(!$denuncias){
            echo "<h2  class='label-danger' style='text-align: center'>Nenhuma Denuncia Solucionada</h2>";
        }
    }

}