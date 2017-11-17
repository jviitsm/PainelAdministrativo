<?php

namespace App\Controller\Classes;

use Mpdf\Mpdf;




require '../../bootstrap.php';


class GerarPDF extends Mpdf
{
    private $css = null;
    private $titulo = "Relatório City Care";


    ##Construtor
    public function __construct($css, $titulo)
    {
        $this->titulo = $titulo;
        $this->setarCSS($css);
    }

    ##Definir CSS
    public function setarCSS($file)
    {
        if (file_exists($file)):
            $this->css = file_get_contents($file);
        else:
            echo 'Arquivo inexistente!';
        endif;
    }

    function random_color()
    {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $index = rand(0, 15);
            $color .= $letters[$index];
        }
        return $color;
    }

    private function gerarBairrosAtivos($entityManager){

        $arrayBairro = array();
        $denunciaRepository = $entityManager->getRepository('App\Models\Entity\Denuncia');
        $denuncias = $denunciaRepository->findBy(array("status_denuncia" => 1));

        foreach ($denuncias as $denuncia){
            $endereco = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $denuncia->latitude_denuncia . ',' . $denuncia->longitude_denuncia . '&key=AIzaSyC_smlZV61EJc1y0ZqgG6CqjzfT1ApoHrQ');
            $output = json_decode($endereco, true);
            $endereco = $output['results'][0]['formatted_address'];

            $arrayBairro[] = ["Bairro" => $output['results'][0]["address_components"][2]["long_name"],
                "Denuncia" => $denuncia,
                "Endereco" => $endereco];


        }
        return $arrayBairro;
    }
    private function gerarBairrosSolucionados($entityManager){

        $arrayBairro = array();
        $denunciaRepository = $entityManager->getRepository('App\Models\Entity\Denuncia');
        $denuncias = $denunciaRepository->findBy(array("status_denuncia" => 0));

        foreach ($denuncias as $denuncia){
            $endereco = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $denuncia->latitude_denuncia . ',' . $denuncia->longitude_denuncia . '&key=AIzaSyC_smlZV61EJc1y0ZqgG6CqjzfT1ApoHrQ');
            $output = json_decode($endereco, true);
            $endereco = $output['results'][0]['formatted_address'];

            $arrayBairro[] = ["Bairro" => $output['results'][0]["address_components"][2]["long_name"],
                "Denuncia" => $denuncia,
                "Endereco" => $endereco];


        }
        return $arrayBairro;
    }

    private function gerarCategoria($entityManager)
    {

        $denunciaRepository = $entityManager->getRepository('App\Models\Entity\Denuncia');
        $denuncias = $denunciaRepository->findBy(array("status_denuncia" => 1));
        $categoriaRepository = $entityManager->getRepository('App\Models\Entity\Categoria');
        $retorno = "";

        if ($denuncias) {
            $totalDenuncias = count($denuncias);

            $arrayCategorias = array();
            $arrayFinal = array();

            ##Percorrer as categorias das denuncias
            foreach ($denuncias as $denuncia) {
                $arrayCategorias[] = $denuncia->fk_categoria_denuncia->id_categoria;
            }
            $total = count($arrayCategorias);

            ##Montar array de quantas vezes a categoria foi citada
            $contagem = array_count_values($arrayCategorias);
            foreach ($contagem AS $numero => $vezes) {
                $array[] = ["Número" => $numero, "Vezes" => $vezes];
            }

            ##Calcular porcentagem
            foreach ($array as $categoria) {
                $objeto = $categoriaRepository->find($categoria['Número']);
                $nome = $objeto->descricao_categoria;
                $vezes = $categoria['Vezes'];

                $porcentagem = ($vezes / $total) * 100;

                $arrayFinal[] = ["nome" => $nome, "porcentagem" => round($porcentagem)];
            }

            $totalCategorias = count($arrayFinal);


            function mostrarPorcentagem($arrayFinal){
                $retorno = "";
                foreach($arrayFinal as $categoria){

                    $retorno .= " Categoria de nome: ";
                    $retorno .= $categoria['nome'];
                    $retorno .= ", representando ";
                    $retorno .= $categoria['porcentagem'];
                    if($categoria == end($arrayFinal)){
                        $retorno .= "% dos cadastros.";
                    }
                    else{
                        $retorno .= "% dos cadastros,";
                    }
                    return $retorno;
                }

            }
            $retorno .= "<h6 style=' text-indent: 1.5em;'>Há um total de $totalDenuncias Denuncia(s) ativa(s) no sistema, cadastradas em $totalCategorias categorias distintas. Sendo elas: ";
            $retorno .= mostrarPorcentagem($arrayFinal);
            $retorno .= "</h6>";

        }
        return $retorno;
    }


    private function getDenunciasAtivas($entityManager)
    {

        $bairros = $this->gerarBairrosAtivos($entityManager);

        $retorno = "";

        $retorno .= "<h2 style=\"text-align:center\">Denuncias Ativas(Não Solucionadas)</h2>";
        foreach ($bairros as $bairro){

            $retorno .= "<h2>Bairro: ";
            $retorno .= $bairro['Bairro'];
            $retorno .= "</h2>";

            $denuncia = $bairro['Denuncia'];
            $retorno .= "<h2 style='text-align: center' ><img style='width: 300px;height: 200px;  padding:1px;
   border:1px solid #021a40;' src=";
            $retorno .= $denuncia->dir_foto_denuncia;
            $retorno .= "></h2>";
            $retorno .= "<div class=\"content table-responsive table-full-width\">
                                            <table id=\"customers\">
                                               <tr>
                                                <th>Descrição</th>
                                                <th>Categoria</th>
                                                <th>Endereço</th>
                                                <th>Data</th>
                                                </tr>
                                                <tbody>";

            ##Data da Denuncia
            list($ano, $mes, $dia) = explode('-', $denuncia->data_denuncia);
            list($diaDenuncia) = explode('T', $dia);
            $dataDenuncia = "$diaDenuncia" . "/$mes" . "/$ano";


            $retorno .= "<tr>";
            $retorno .= "<td class='text-center'>{$denuncia -> descricao_denuncia}</td>";
            $retorno .= "<td class='text-center'>{$denuncia->fk_categoria_denuncia->descricao_categoria}</td>";
            $retorno .= "<td class='text-center'>{$bairro['Endereco']}</td>";
            $retorno .= "<td class='text-center'>{$dataDenuncia}</td>";
            $retorno .= "<tr>";



            $retorno .= "   </tbody>
                                            </table>

                                        </div>";
        }
        return $retorno;

    }

    function getDenunciasSolucionadas($entityManager)
    {

        $bairros = $this->gerarBairrosSolucionados($entityManager);

        $retorno = "";

        $retorno .= "<h2 style=\"text-align:center\">Denuncias Solucionadas</h2>";
        foreach ($bairros as $bairro){

            $retorno .= "<h2>Bairro: ";
            $retorno .= $bairro['Bairro'];
            $retorno .= "</h2>";
            $denuncia = $bairro['Denuncia'];
            $retorno .= "<h2 style='text-align: center' ><img style='width: 300px;height: 200px;  padding:1px;
   border:1px solid #021a40;' src=";
            $retorno .= $denuncia->dir_foto_denuncia;
            $retorno .= "></h2>";
            $retorno .= "<div class=\"content table-responsive table-full-width\">
                                            <table id=\"customers\">
                                               <tr>
                                                <th>Descrição</th>
                                                <th>Categoria</th>
                                                <th>Endereço</th>
                                                <th>Data Denuncia</th>
                                                <th>Data Solução</th>
                                                </tr>
                                                <tbody>";

            ##Data da Denuncia
            list($ano, $mes, $dia) = explode('-', $denuncia->data_denuncia);
            list($diaDenuncia) = explode('T', $dia);
            $dataDenuncia = "$diaDenuncia" . "/$mes" . "/$ano";


            $solucao = $denuncia->fk_solucao_denuncia;

            list($year, $month, $day) = explode('-', $solucao->data_solucao);
            list($diaSolucao) = explode('T', $day);
            $dataSolucao = "$diaSolucao" . "/$month" . "/$year";

            $retorno .= "<tr>";
            $retorno .= "<td>{$denuncia -> descricao_denuncia}</td>";
            $retorno .= "<td>{$denuncia->fk_categoria_denuncia->descricao_categoria}</td>";
            $retorno .= "<td>{$bairro['Endereco']}</td>";
            $retorno .= "<td>{$dataDenuncia}</td>";
            $retorno .= "<td>{$dataSolucao}</td>";
            $retorno .= "<tr>";



            $retorno .= "   </tbody>
                                            </table>

                                        </div>";
        }
        return $retorno;
    }


    /*
      * Método para montar o Cabeçalho do relatório em PDF
      */
    protected function getHeader()
    {
        $data = date('j/m/Y');
        $retorno = "<table class=\"tbl_header\" width=\"1000\">  
               <tr>  
                 <td align=\"left\">City Care</td>  
                 <td align=\"right\">Gerado em: $data</td>  
               </tr>  
             </table>";
        return $retorno;
    }


    protected function getFooter()
    {
        $retorno = "<table class=\"tbl_footer\" width=\"1000\">  
               <tr>  
                 <td align=\"left\"><a href=''>www.projetocitycare.com.br/painel</a></td>  
                 <td align=\"right\">Página: {PAGENO}</td>  
               </tr>  
             </table>";
        return $retorno;
    }

    /*
        * Método para construir o arquivo PDF
        */
    public function BuildPDF($entityManager)
    {
        $this->pdf = new mPDF(array('utf-8', 'A4-L'));
        $this->pdf->WriteHTML($this->css, 1);
        $this->pdf->SetHTMLHeader($this->getHeader());
        $this->pdf->SetHTMLFooter($this->getFooter());
        $this->pdf->WriteHtml($this->gerarCategoria($entityManager));
        $this->pdf->WriteHTML($this->getDenunciasAtivas($entityManager));
        $this->pdf->WriteHTML($this->getDenunciasSolucionadas($entityManager));
    }

    /*
   * Método para exibir o arquivo PDF
   * @param $name - Nome do arquivo se necessário grava-lo
   */
    public function Exibir($name = "Relatório City Care")
    {
        $this->pdf->Output($name, 'I');
    }


}