<?php
namespace App\Models\Entity;


/**

 * @Entity @Table(name="comentario")

 **/
class Comentario{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    public $id_comentario;
    /**
     * @OneToOne(targetEntity="Login", fetch="EAGER")
     * @JoinColumn(name="fk_login_comentario", referencedColumnName="id_login")
     */
    public $fk_login_comentario;
    /**
     * @OneToOne(targetEntity="Denuncia", fetch="EAGER")
     * @JoinColumn(name="fk_denuncia_comentario", referencedColumnName="id_denuncia")
     */
    public $fk_denuncia_comentario;
    /**
     * @var string
     * @Column(type="string", length=400)
     */
    public $descricao_comentario;

    function getId_comentario() {
        return $this->id_comentario;
    }

    function getFk_login_comentario(){
        return $this->fk_login_comentario;
    }

    function getFk_denuncia_comentario(){
        return $this->fk_denuncia_comentario;
    }

    function getDescricao_comentario() {
        return $this->descricao_comentario;
    }

    function setId_comentario($id_comentario) {
        $this->id_comentario = $id_comentario;
    }

    function setFk_login_comentario(Login $fk_login_comentario) {
        $this->fk_login_comentario = $fk_login_comentario;
    }

    function setFk_denuncia_comentario(Denuncia $fk_denuncia_comentario) {
        $this->fk_denuncia_comentario = $fk_denuncia_comentario;
    }

    function setDescricao_comentario($descricao_comentario) {
        $this->descricao_comentario = $descricao_comentario;
    }




}
?>