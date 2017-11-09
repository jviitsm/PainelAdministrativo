<?php 

namespace App\Models\Entity;

/**

* @Entity @Table(name="solucao")

**/

class Solucao{
     /** 
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    public $id_solucao;
    /** 
     * @var string
     * @Column(type="string")
     */ 
    public $descricao_solucao;
    /** 
     * @var string
     * @Column(type="string")
     */ 
    public $dir_foto_solucao;
    /** 
     * @var string
     * @Column(type="string")
     */ 
    public $data_solucao;

    /**
     * @return int
     */
    public function getIdSolucao()
    {
        return $this->id_solucao;
    }

    /**
     * @param int $id_solucao
     */
    public function setIdSolucao($id_solucao)
    {
        $this->id_solucao = $id_solucao;
    }

    /**
     * @return string
     */
    public function getDescricaoSolucao()
    {
        return $this->descricao_solucao;
    }

    /**
     * @param string $descricao_solucao
     */
    public function setDescricaoSolucao($descricao_solucao)
    {
        $this->descricao_solucao = $descricao_solucao;
    }

    /**
     * @return string
     */
    public function getDirFotoSolucao()
    {
        return $this->dir_foto_solucao;
    }

    /**
     * @param string $dir_foto_solucao
     */
    public function setDirFotoSolucao($dir_foto_solucao)
    {
        $this->dir_foto_solucao = $dir_foto_solucao;
    }

    /**
     * @return string
     */
    public function getDataSolucao()
    {
        return $this->data_solucao;
    }

    /**
     * @param string $data_solucao
     */
    public function setDataSolucao($data_solucao)
    {
        $this->data_solucao = $data_solucao;
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
    }


}