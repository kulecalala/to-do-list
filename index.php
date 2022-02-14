<?php

  require __DIR__.'/vendor/autoload.php';

  use \App\Entity\Tarefas;

  $obTarefas = new Tarefas();

  //
  $editarTarefa = '';

  if ( isset( $_GET['id'] ) ) {

    $tarefa = $obTarefas->getTarefa( $_GET['id'] );

    $editarTarefa = '<div id="editar-detalhes">
                      <form name="" method="post" action"">
                        <div id="editar-tarefa">
                          <fieldset> <legend> Editar Tarefa </legend>
                            <input type="text" name="id" value="'. $tarefa->id .'" hidden/>

                            <input type="text" name="titulo" placeHolder="Title" value="'. $tarefa->titulo .'" id="titulo"/>

                            <textarea name="descricao" placeHolder="Description" id="descricao">'. $tarefa->descricao .'</textarea>

                            <input type="text" name="data" value="'. $tarefa->data .'" hidden/>

                            <input type="text" name="feito" value="'. $tarefa->feito .'" hidden/>

                            <input type="text" name="estado" value="'. $tarefa->estado .'" hidden/>

                            <div id="datas">
                              Criação em: '. $tarefa->data .'
                              | Executado em: '. $tarefa->feito .'
                            </div>

                            <div>
                              <input type="submit" name="btnFeito" class="btn-form1" id="btn-form11" value="Update" title="Actualizar e sair"/>

                              <input type="submit" name="apagar-t" class="btn-form2" id="btn-form1" value="Delete" title="Apagar"/>

                              <input type="reset" name="" class="btn-form2" id="btn-form1" value="Reset" title="Restaurar"/>
                            </div>
                          </fieldset>
                        </div>
                       </form>
                      </div>';
  }

  // Apagar itens da lista
  if ( isset( $_POST['apagar-t'] ) ) {

    $obTarefas->id = $_POST['id'];

    if ( $obTarefas->excluir() ) {
      header('location: index.php?tarefaApagadaComSucesso');
    } else {
      header('location: ?erroAoApagar');
    }

  }

  // Marcar como realizada
  if ( isset( $_POST['btnFeito'] ) ) {
    $obTarefas->id        =  $_POST['id'];
    $obTarefas->titulo    = $_POST['titulo'];
    $obTarefas->descricao = $_POST['descricao'];
    $obTarefas->data      = $_POST['data'];
    $obTarefas->feito     = date('Y-m-d H:i:s');
    $obTarefas->estado    = 'f';

    if ( $obTarefas->actualizar()  ) {
      header('location: index.php?TarefaRealizadaComSucesso');
    } else {
      header('location: ?erroAoMarcarComoFeita');
    }

  }

  // Adicionar nova tarefa
  if ( isset( $_POST['addTarefa'] ) ) {

    if ( $_POST['titulo'] != '' && $_POST['descricao'] != '' ) {
      $obTarefas->titulo    = $_POST['titulo'];
      $obTarefas->descricao = $_POST['descricao'];
      $obTarefas->data  = date('Y-m-d');
      $obTarefas->feito = date('Y-m-d H:i:s');
      $obTarefas->estado = 'p';

      if ( $obTarefas->cadastrar() ) {
        header('location: ?success');
      } else {
        header('location: ?error');
      }

    }

  } // Fim tarefas

  // get lista de tarefas
  $getTarefas = Tarefas::getTarefas();
  $toDoList = ''; // Lista de tarefas

  foreach ($getTarefas as $tarefas ) {

    $estado = $tarefas->estado == 'p'? 'Fazer': 'Feita';

    $descricao = '';

    if ( strlen($tarefas->descricao) > 109 ) {
      $descricao = substr($tarefas->descricao, 0, 109) .'...';
    } else {
      $descricao = $tarefas->descricao;
    }

    $toDoList .= '<div class="tarefas">
                    <div class="t-conteudo">
                      <strong>'. substr($tarefas->titulo, 0, 25) .'</strong> |
                      <small> Em: '. $tarefas->data .' | Estado: '. $estado .' </small> <br/>
                      '. $descricao .'
                    </div>

                    <div class="t-controle">
                      <form name="" method="post" action="">
                        <input type="text" name="id" value="'. $tarefas->id .'" hidden/>
                        <input type="text" name="titulo" value="'. $tarefas->titulo .'" hidden/>
                        <input type="text" name="descricao" value="'. $tarefas->descricao .'" hidden/>
                        <input type="text" name="data" value="'. $tarefas->data .'" hidden/>

                        <input type="submit" name="btnFeito" value="F" title="Feita" class="t-btns"/>
                      </form>

                      <a href="?id='. $tarefas->id .'">
                      <button class="t-btns" id="t-btns" title="Detalhes">E</button>
                      </a>
                    </div>
                  </div>';
  }



  if ( $toDoList == '' ) {
    $toDoList = '<div id="lista-to-do-vazia">
                   Não a tarefas por fazer!<br/>
                   Adicione uma!
                 </div>';
  }

  include __DIR__.'/includes/header.php';
  include __DIR__.'/includes/home.php';
  include __DIR__.'/includes/footer.php';
