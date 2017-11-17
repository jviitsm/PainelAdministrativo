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
     * @OneToOne(targetEntity="Login", fetch="EAGER")
     * @JoinColumn(name="fk_login_solucao", referencedColumnName="id_login")
     */
    public $fk_login_solucao;
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

    /**
     * @return mixed
     */
    public function getFkLoginSolucao()
    {
        return $this->fk_login_solucao;
    }

    /**
     * @param mixed $fk_login_solucao
     */
    public function setFkLoginSolucao($fk_login_solucao)
    {
        $this->fk_login_solucao = $fk_login_solucao;
    }


}