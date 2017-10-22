<?php 

namespace App\Models\Entity;

/**

* @Entity @Table(name="categoria")

**/

class Categoria{
      /** 
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    public $id_categoria;
    /** 
     * @var string
     * @Column(type="string", unique=true, length=30)
     */
    public $descricao_categoria;
    
    function getId_categoria() {
        return $this->id_categoria;
    }

    function getDescricao_categoria() {
        return $this->descricao_categoria;
    }

    function setId_categoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    function setDescricao_categoria($descricao_categoria) {
        $this->descricao_categoria = $descricao_categoria;
    }


}