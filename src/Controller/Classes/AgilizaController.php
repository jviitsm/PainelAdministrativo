<?php

namespace App\Controller\Classes;

class AgilizaController{

    function contarAgiliza($entityManager){

        $agilizaRepository = $entityManager->getRepository('App\Models\Entity\Agiliza');
        $agilizas = $agilizaRepository->findBy(array("interacao" => 1));
        return $agilizas;
    }
    function buscarAgilizas($entityManager, $denuncia){
        $agilizaRepository = $entityManager->getRepository('App\Models\Entity\Agiliza');
        $agilizas = $agilizaRepository->findBy(array("fk_denuncia_agiliza" => $denuncia->getId_denuncia()));
        return $agilizas;
    }



}