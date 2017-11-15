<?php

namespace App\Controller\Classes;

class CidadaoController{

    function contarCidadaos($entityManager){
        $cidadaoRepository = $entityManager->getRepository('App\Models\Entity\Cidadao');
        $cidadadaos = $cidadaoRepository->findAll();
        $numeroCidadaos = count($cidadadaos);
        return $numeroCidadaos;
    }








}