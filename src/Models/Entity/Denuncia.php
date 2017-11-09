<?php

namespace App\Models\Entity;


/**
 * @Entity @Table(name="denuncia")
 **/

class Denuncia
{

    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    public $id_denuncia;
    /**
     * @var string
     * @Column(type="string", length=400)
     */
    public $descricao_denuncia;
    /**
     * @var string
     * @Column(type="string", length=200, nullable=true)
     */
    public $dir_foto_denuncia;
    /**
     * @var double
     * @Column(type="float")
     */
    public $latitude_denuncia;
    /**
     * @var double
     * @Column(type="float")
     */
    public $longitude_denuncia;
    /**
     * @var
     * @Column(type="string", length=30)
     */
    public $cidade;
    /**
     * @var
     * @Column(type="string", length=30)
     */
    public $estado;
    /**
     * @Column(type="string", length=40)
     */
    public $data_denuncia;
    /**
     * @var
     * @Column(type="integer", nullable=true)
     */
    public $status_denuncia;
    /**
     * @OneToOne(targetEntity="Solucao", fetch="EAGER")
     * @JoinColumn(name="fk_solucao_denuncia", referencedColumnName="id_solucao")
     */
    public $fk_solucao_denuncia;
    /**
     * @OneToOne(targetEntity="Categoria", fetch="EAGER")
     * @JoinColumn(name="fk_categoria_denuncia", referencedColumnName="id_categoria")
     */
    public $fk_categoria_denuncia;
    /**
     * @ManyToOne(targetEntity="Login", fetch="EAGER")
     * @JoinColumn(name="fk_login_denuncia", referencedColumnName="id_login")
     */
    public $fk_login_denuncia;

    function getId_denuncia()
    {
        return $this->id_denuncia;
    }

    function getDescricao_denuncia()
    {
        return $this->descricao_denuncia;
    }

    function getDir_foto_denuncia()
    {
        if($this->dir_foto_denuncia != ""){
            return $this->dir_foto_denuncia;
        }
        else{
            return 'http://projetocitycare.com.br/Imgs/Painel/foto.jpg';
        }

    }

    function getLatitude_denuncia()
    {
        return $this->latitude_denuncia;
    }

    function getLongitude_denuncia()
    {
        return $this->longitude_denuncia;
    }

    function getData_denuncia()
    {
        return $this->data_denuncia;
    }

    function getStatus_denuncia()
    {
        return $this->status_denuncia;
    }

    function getFk_solucao_denuncia()
    {
        return $this->fk_solucao_denuncia;
    }

    function getFk_categoria_denuncia()
    {
        return $this->fk_categoria_denuncia;
    }

    function getFk_login_denuncia()
    {
        return $this->fk_login_denuncia;
    }

    function getCidade()
    {
        return $this->cidade;
    }

    function getEstado()
    {
        return $this->estado;
    }

    function setId_denuncia($id_denuncia)
    {
        $this->id_denuncia = $id_denuncia;
    }

    function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    function setEstado($estado)
    {
        $this->estado = $estado;
    }


    function setDescricao_denuncia($descricao_denuncia)
    {
        $this->descricao_denuncia = $descricao_denuncia;
    }

    function setDir_foto_denuncia($dir_foto_denuncia)
    {
        $this->dir_foto_denuncia = $dir_foto_denuncia;
    }

    function setLatitude_denuncia($latitude_denuncia)
    {
        $this->latitude_denuncia = $latitude_denuncia;
    }

    function setLongitude_denuncia($longitude_denuncia)
    {
        $this->longitude_denuncia = $longitude_denuncia;
    }

    function setData_denuncia($data_denuncia)
    {
        $this->data_denuncia = $data_denuncia;
    }

    function setStatus_denuncia($status_denuncia)
    {
        $this->status_denuncia = $status_denuncia;
    }

    function setFk_solucao_denuncia(Solucao $fk_solucao_denuncia)
    {
        $this->fk_solucao_denuncia = $fk_solucao_denuncia;
    }

    function setFk_categoria_denuncia(Categoria $fk_categoria_denuncia)
    {
        $this->fk_categoria_denuncia = $fk_categoria_denuncia;
    }

    function setFk_login_denuncia(Login $fk_login_denuncia)
    {
        $this->fk_login_denuncia = $fk_login_denuncia;
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
    }


}