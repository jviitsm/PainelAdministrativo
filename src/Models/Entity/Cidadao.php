<?php 

namespace App\Models\Entity;

use App\Models\Entity\Login as Login;
/**

* @Entity @Table(name="cidadao")

**/

class Cidadao{
     /** 
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
	public $id_cidadao;
     /** 
     * @var string
     * @Column(type="string", length=100)
     */
	public $nome;
     /** 
     * @var string
     * @Column(type="string", nullable=true, length=100)
     */
	public $sobrenome;
    /** 
     * @var string
     * @Column(type="string", length=10)
     */
	public $sexo;
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
     * @Column(type="string", length=200)
     */
	public $dir_foto_usuario;
    /**
    * @OneToOne(targetEntity="Login", fetch="EAGER")
    * @JoinColumn(name="fk_login_cidadao", referencedColumnName="id_login")
	*/
    public $fk_login_cidadao;
        
        function getId_cidadao() {
            return $this->id_cidadao;
        }

        function getSexo() {
            return $this->sexo;
        }

        function getNome() {
            return $this->nome;
        }

        function getSobrenome() {
            return $this->sobrenome;
        }

        function getEstado() {
            return $this->estado;
        }

        function getCidade() {
            return $this->cidade;
        }
        function getDir_foto_usuario() {
            return $this->dir_foto_usuario;
        }

        function getFk_login_cidadao() {
            return $this->fk_login_cidadao;
        }

        function setId_cidadao($id_cidadao) {
            $this->id_cidadao = $id_cidadao;
        }

        function setSexo($sexo) {
            $this->sexo = $sexo;
        }

        function setNome($nome) {
            $this->nome = $nome;
        }

        function setSobrenome($sobrenome) {
            $this->sobrenome = $sobrenome;
        }

        function setEstado($estado) {
            $this->estado = $estado;
        }

        function setCidade($cidade) {
            $this->cidade = $cidade;
        }

        function setDir_foto_usuario($dir_foto_usuario) {
            $this->dir_foto_usuario = $dir_foto_usuario;
        }

        function setFk_login_cidadao(Login $fk_login_cidadao) {
            $this->fk_login_cidadao = $fk_login_cidadao;
        }


        
        
}

?>