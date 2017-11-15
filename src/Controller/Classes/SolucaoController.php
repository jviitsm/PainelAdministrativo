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
                } catch (Exception $e) {
                    echo "<script type='text/javascript'>alert('Desculpe Ocorreu um Erro!');</script>";
                }

            }


        }
    }

}