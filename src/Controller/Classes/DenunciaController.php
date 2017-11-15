<?php
namespace App\Controller\Classes;


class DenunciaController{

    function contarDenuncias($entityManager){
        $denunciaRepository = $entityManager->getRepository('App\Models\Entity\Denuncia');
        $denuncias = $denunciaRepository->findBy(array("status_denuncia" => 1));
        $numeroDenuncias = count($denuncias);
        return $numeroDenuncias;
    }

    function buscarDenuncia($entityManager){
        $denunciaRepository = $entityManager->getRepository('App\Models\Entity\Denuncia');
        $denuncia = $denunciaRepository->find($_SESSION['denuncia']);
        return $denuncia;
    }










}