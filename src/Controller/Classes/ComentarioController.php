<?php

namespace App\Controller\Classes;

class ComentarioController{

    function contarComentarios($entityManager){
        $comentarioRepository = $entityManager->getRepository('App\Models\Entity\Comentario');
        $comentario = $comentarioRepository->findAll();

        return $comentario;
    }
    function buscarComentario($entityManager,$denuncia){
        $comentarioRepository = $entityManager->getRepository('App\Models\Entity\Comentario');
        $comentarios = $comentarioRepository->findBy(array("fk_denuncia_comentario" => $denuncia->getId_denuncia()));
        return $comentarios;
    }

    function montarComentarios($comentarios){
        foreach ($comentarios as $lista) {


            echo "<textarea class='textarea'style='border: none;resize: none; width: 530px' readonly>$lista->descricao_comentario</textarea>";
            echo "<hr>";
        }
        if(!$comentarios){
            echo "<hr>";
            echo "<br>";
            echo "<textarea class='textarea'style='border: none;resize: none' readonly>Nenhum comentario</textarea>";
            echo "<hr>";
        }
    }

}