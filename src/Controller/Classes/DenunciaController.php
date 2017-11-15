<?php
namespace App\Controller\Classes;


class DenunciaController{

    function contarDenuncias($entityManager){
        $denunciaRepository = $entityManager->getRepository('App\Models\Entity\Denuncia');
        $denuncias = $denunciaRepository->findBy(array("status_denuncia" => 1));
        $numeroDenuncias = count($denuncias);
        return $numeroDenuncias;
    }

    function buscarDenuncia($entityManager,$id){
        $denunciaRepository = $entityManager->getRepository('App\Models\Entity\Denuncia');
        $denuncia = $denunciaRepository->find($id);
        return $denuncia;
    }
    function buscarSolucionadas($entityManager,$cidade){
        $denunciaRepository = $entityManager->getRepository('App\Models\Entity\Denuncia');
        $denuncia = $denunciaRepository->findBy(array("cidade"=> $cidade, "status_denuncia" => 0));

        return $denuncia;
    }
    function redirecionar(){
        if (isset($_POST['btn_denuncia'])) {
            $id = $_POST['id'];
            $endereco = $_POST['endereco'];

            $_SESSION["denuncia"] = $id;
            $_SESSION['endereco'] = $endereco;
            $_SESSION['dataDenuncia'] = $_POST['dataDenuncia'];
            header("Location: denuncia.php");
        }
    }

    function buscarNaCidade($entityManager){
        $user = $_SESSION["array"];
        $id = $user[0] -> id_login;
        $denunciaRepository = $entityManager->getRepository('App\Models\Entity\Denuncia');
        $empresaRepository = $entityManager->getRepository('App\Models\Entity\Empresa');
        $empresa = $empresaRepository->findBy(array('fk_login_empresa' => $id));
        //Recuperando a cidade do user que esta logado
        $cidade = $empresa[0] -> cidade;
        //BUscando denuncias  da cidade do user logado

        return $denuncias = $denunciaRepository->findBy(array('cidade' => $cidade, 'status_denuncia' =>1 ));

    }

    function retornarCategoria($denuncia){
        $categoria = $denuncia->getFk_categoria_denuncia()->getDescricao_categoria();
        return $categoria;
    }

    function retornarSolucao($denuncia){
        $solucao = $denuncia->getFk_solucao_denuncia();
        return $solucao;
    }

    function montarTabela($denuncias)
    {


        foreach ($denuncias as $lista) {

            $endereco = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lista->latitude_denuncia . ',' . $lista->longitude_denuncia . '&key=AIzaSyC_smlZV61EJc1y0ZqgG6CqjzfT1ApoHrQ');

            $output = json_decode($endereco, true);

            #Executar um explode na data para tratar a mesma
            list($year, $month, $day) = explode('-', $lista->data_denuncia);
            list($dia) = explode('T', $day);


            $endereco = $output['results'][0]['formatted_address'];

            $data = "$dia"."/$month"."/$year";

            echo "<form id=\"form_denuncia\" method=\"post\">";
            echo "<tr>";
            echo "<td>$lista->id_denuncia</td>";
            echo "<td>$lista->descricao_denuncia</td>";
            echo "<td>{$lista->fk_categoria_denuncia->descricao_categoria}</td>";
            echo "<td>$endereco</td>";
            echo "<td>$data</td>";
            echo "<td><button type=\"submit\" name=\"btn_denuncia\" class=\"btn btn-info btn-fill pull-center\">Checar</button></td>";
            echo "<input type=\"hidden\" name=\"id\" value=\"$lista->id_denuncia\">";
            echo "<input type=\"hidden\" name=\"endereco\" value=\"$endereco\">";
            echo "<input type=\"hidden\" name=\"dataDenuncia\" value=\"$data\">";
            echo "</form>";


        }
        if(!$denuncias){
            echo "<td>Nenhuma Denuncia</td>";
        }
    }









}