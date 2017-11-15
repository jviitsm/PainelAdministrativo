<?php


namespace App\Controller\Classes;

use App\Models\Entity\Solicitacao;


class SolicitacaoCadastroController{


    function solicitarCadastro($entityManager){
        if (isset($_POST['btn_solicitar'])) {
            $email = $_POST['email_solicitar'];
            $telefone = $_POST['telefone_solicitar'];
            $nomeFantasia = $_POST['nome_fantasia'];
            $estado = $_POST['select_estado'];
            $cidade = $_POST['select_cidade'];

            try {

                $solicitacao = new Solicitacao();

                $solicitacao->setEmail($email);
                $solicitacao->setTelefone($telefone);
                $solicitacao->setNomeFantasia($nomeFantasia);
                $solicitacao->setEstado($estado);
                $solicitacao->setCidade($cidade);
                $solicitacao->setStatusSolicitacao(1);

                $entityManager->persist($solicitacao);
                $entityManager->flush();
                echo "<p class='alert alert-success'>Solicitação enviada com sucesso. Entraremos em contato em breve! </p>";
            } catch (Exception $e) {
                echo "<p class='alert alert-success'>Não foi possivel enviar a solicitação </p>";
            }
        }
    }

    function contarSolicitacao($entityManager){

        $solicitacaoRepository = $entityManager->getRepository('App\Models\Entity\Solicitacao');
        $solicitacoes = $solicitacaoRepository->findBy(array("status_solicitacao" => 1));
        $numeroSolicitacoes = count($solicitacoes);

        return $numeroSolicitacoes;
    }
    function buscarSolicitacoes($entityManager){
        $solicitacaoRepository = $entityManager->getRepository('App\Models\Entity\Solicitacao');
        $solicitacoes = $solicitacaoRepository->findBy(array("status_solicitacao" => 1));
        return $solicitacoes;
    }

    function buscarSolicitacao($entityManager,$id){
        $solicitacaoRepository = $entityManager->getRepository('App\Models\Entity\Solicitacao');
        $solicitacao = $solicitacaoRepository->find($id);
        return $solicitacao;

    }

    function montarTask($solicitacoes,$sessao)
    {
        if($sessao == true){
            foreach ($solicitacoes as $index) {
                if($solicitacoes){
                    echo "<li><a href=\"solicitacoes.php\">Empresa: $index->nome_fantasia</a></li>";
                }
                else{
                    echo "<li><a href=\"solicitacoes.php\">Nenhuma Solicitação</a></li>";
                }
            }
        }
    }

    function montarTabela($solicitacoes)
    {

        foreach ($solicitacoes as $index) {

            echo "<form id=\"form_denuncia\" method=\"post\">";
            echo "<tr>";
            echo "<td>$index->id_solicitacao</td>";
            echo "<td>$index->email</td>";
            echo "<td>$index->nome_fantasia</td>";
            echo "<td>$index->cidade</td>";
            echo "<td>$index->estado</td>";
            echo "<td>$index->telefone</td>";
            echo "<input type=\"hidden\" name=\"id\" value=\"$index->id_solicitacao\">";
            echo "<td><button type=\"submit\" name=\"btnSolicitado\" class=\"btn btn-info btn-fill pull\">Cadastrar</button></td>";
            echo "<td><button type=\"submit\" name=\"btnExcluir\" class=\"btn btn-info btn-fill pull\">Excluir</button></td>";
            echo "</form>";


        }

    }

    function montarTaskSolicitacoes($entityManager,$numeroSolicitacoes,$solicitacoes,$sessao){
        if ($_SESSION['administrador'] == true) {
            echo " <ul class=\"nav navbar-nav navbar-left\">
                        <li class=\"dropdown\">
                            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                                <i class=\"fa fa-globe\"></i>
                                <b class=\"caret hidden-sm hidden-xs\"></b>
                                <span class=\"notification hidden-sm hidden-xs\">$numeroSolicitacoes</span>
                                <p class=\"hidden-lg hidden-md\">
                                    $numeroSolicitacoes Notificações
                                    <b class=\"caret\"></b>
                                </p>
                            </a>
                            <ul class=\"dropdown-menu\">" ?>
            <?php
            $this->montarTask($solicitacoes,$sessao) ?>
            <?php echo "
                            </ul>
                        </li>
                    </ul>
                            ";
        }
    }
    function excluirSolicitacao($entityManager){

        if(isset($_POST['btnExcluir'])){
            $solicitacaoRepository = $entityManager->getRepository('App\Models\Entity\Solicitacao');

            try{
                $solicitacaoARemover = $solicitacaoRepository->find($_POST['id']);

                $entityManager->remove($solicitacaoARemover);
                $entityManager->flush();

            }catch (Exception $e){
                echo "<script type='text/javascript'>alert('Não foi possivel excluir!, ocorreu algum erro.');</script>";
            }
        }
    }




}