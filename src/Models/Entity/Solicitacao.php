<?php

namespace App\Models\Entity;
/**

 * @Entity @Table(name="solicitado")

 **/
class Solicitacao{

    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    public $id_solicitacao;
    /**
     * @var string
     * @Column(type="string", unique=true, length=50)
     */
    public $email;
    /**
     * @var string
     * @Column(type="string", length=30)
     */
    public $nome_fantasia;
    /**
     * @var string
     * @Column(type="string", length=15)
     */
    public $estado;
    /**
     * @var string
     * @Column(type="string", length=30)
     */
    public $cidade;
    /**
     * @var string
     * @Column(type="string", length=30)
     */
    public $telefone;

    /**
     * @return int
     */
    public function getIdSolicitacao()
    {
        return $this->id_solicitacao;
    }
    /**
     * @var
     * @Column(type="integer", nullable=true)
     */
    public $status_solicitacao;
    /**
     * @param int $id_solicitacao
     */
    public function setIdSolicitacao($id_solicitacao)
    {
        $this->id_solicitacao = $id_solicitacao;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getNomeFantasia()
    {
        return $this->nome_fantasia;
    }

    /**
     * @param string $nome_fantasia
     */
    public function setNomeFantasia($nome_fantasia)
    {
        $this->nome_fantasia = $nome_fantasia;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return string
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param string $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    /**
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param string $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @return mixed
     */
    public function getStatusSolicitacao()
    {
        return $this->status_solicitacao;
    }

    /**
     * @param mixed $status_solicitacao
     */
    public function setStatusSolicitacao($status_solicitacao)
    {
        $this->status_solicitacao = $status_solicitacao;
    }


    function montarTabela($solicitações){

        foreach ($solicitações as $index){

            echo "<form id=\"form_denuncia\" method=\"post\">";
            echo "<tr>";
            echo "<td>$index->id_solicitacao</td>";
            echo "<td>$index->email</td>";
            echo "<td>$index->nome_fantasia</td>";
            echo "<td>$index->cidade</td>";
            echo "<td>$index->estado</td>";
            echo "<td>$index->telefone</td>";
            echo "<input type=\"hidden\" name=\"id\" value=\"$index->id_solicitacao\">";
            echo "<td><button type=\"submit\" name=\"btnSolicitado\" class=\"btn btn-info btn-fill pull-center\">Cadastrar</button></td>";
            echo "</form>";





        }

    }










}