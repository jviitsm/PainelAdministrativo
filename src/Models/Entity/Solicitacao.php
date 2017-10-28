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











}