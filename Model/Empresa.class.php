<?php

class Empresa
{

    private $idEmpresa;
    private $cnpj;
    private $razao_social;
    private $nome_fantasia;
    private $estado;
    private $cidade;
    private $dir_foto_usuario;
    private $empresa;
    private $fk_login_empresa;

    /**
     * @return mixed
     */
    public function getFkLoginEmpresa()
    {
        return $this->fk_login_empresa;
    }

    /**
     * @param mixed $fk_login_empresa
     */
    public function setFkLoginEmpresa($fk_login_empresa)
    {
        $this->fk_login_empresa = $fk_login_empresa;
    }

    /**
 *
 * @return mixed
 */
public function getIdEmpresa()
{
    return $this->idEmpresa;
}/**
 * @param mixed $idEmpresa
 */
public function setIdEmpresa($idEmpresa)
{
    $this->idEmpresa = $idEmpresa;
}/**
 * @return mixed
 */
public function getCnpj()
{
    return $this->cnpj;
}/**
 * @param mixed $cnpj
 */
public function setCnpj($cnpj)
{
    $this->cnpj = $cnpj;
}/**
 * @return mixed
 */
public function getRazaoSocial()
{
    return $this->razao_social;
}/**
 * @param mixed $razao_social
 */
public function setRazaoSocial($razao_social)
{
    $this->razao_social = $razao_social;
}/**
 * @return mixed
 */
public function getNomeFantasia()
{
    return $this->nome_fantasia;
}/**
 * @param mixed $nome_fantasia
 */
public function setNomeFantasia($nome_fantasia)
{
    $this->nome_fantasia = $nome_fantasia;
}/**
 * @return mixed
 */
public function getEstado()
{
    return $this->estado;
}/**
 * @param mixed $estado
 */
public function setEstado($estado)
{
    $this->estado = $estado;
}/**
 * @return mixed
 */
public function getCidade()
{
    return $this->cidade;
}/**
 * @param mixed $cidade
 */
public function setCidade($cidade)
{
    $this->cidade = $cidade;
}/**
 * @return mixed
 */
public function getDirFotoUsuario()
{
    return $this->dir_foto_usuario;
}/**
 * @param mixed $dir_foto_usuario
 */
public function setDirFotoUsuario($dir_foto_usuario)
{
    $this->dir_foto_usuario = $dir_foto_usuario;
}/**
 * @return mixed
 */
public function getEmpresa()
{
    return $this->empresa;
}/**
 * @param mixed $empresa
 */
public function setEmpresa($empresa)
{
    $this->empresa = $empresa;
}







}