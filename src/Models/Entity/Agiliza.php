<?php
namespace App\Models\Entity;


/**
 *@Entity
 *@Table(name="agiliza")
 **/
class Agiliza{
    /** 
     * @Id
     * @OneToOne(targetEntity="Login", fetch="EAGER")
     * @JoinColumn(name="fk_login_agiliza", referencedColumnName="id_login")
     */
    public $fk_login_agiliza;
    /** 
     * @Id
     * @OneToOne(targetEntity="Denuncia", fetch="EAGER")
     * @JoinColumn(name="fk_denuncia_agiliza", referencedColumnName="id_denuncia")
     *        */
    public $fk_denuncia_agiliza;
    /** 
     * @var bool
     * @Column(type="boolean")
     */
    public $interacao;
    
    function getFk_login_agiliza(){
        return $this->fk_login_agiliza;
    }

    function getFk_denuncia_agiliza(){
        return $this->fk_denuncia_agiliza;
    }

    function getInteracao() {
        return $this->interacao;
    }

    function setFk_login_agiliza(Login $fk_login_agiliza) {
        $this->fk_login_agiliza = $fk_login_agiliza;
    }

    function setFk_denuncia_agiliza(Denuncia $fk_denuncia_agiliza) {
        $this->fk_denuncia_agiliza = $fk_denuncia_agiliza;
    }

    function setInteracao($interacao) {
        $this->interacao = $interacao;
    }


}