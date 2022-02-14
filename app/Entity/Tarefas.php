<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Tarefas {
    public $id;
    public $titulo;
    public $descricao;
    public $data;
    public $feito;
    public $estado;

    public function cadastrar() {
      $data = date('Y-m-d');

      $this->data = $data;
      $this->feito = null;
      $this->estado = 'p';

      $obDataBase = new DataBase('listaTarefas');

      $this->id = $obDataBase->insert(
        [
          'titulo'    => $this->titulo,
          'descricao' => $this->descricao,
          'data'      => $this->data,
          'feito'     => $this->feito,
          'estado'    => $this->estado
        ]
      );

      return true;
    }

    public function actualizar( ) {
      return (new DataBase('listaTarefas'))->update(
        'id = '. $this->id,
        [
          'titulo'    => $this->titulo,
          'descricao' => $this->descricao,
          'data'      => $this->data,
          'feito'     => $this->feito,
          'estado'    => $this->estado
        ]
      );
    }

    public function excluir() {
      return (new DataBase('listaTarefas'))->delete('id = '. $this->id );
    }

    public static function getTarefas( $where = null, $order = null, $limit = null ) {
      return (new DataBase('listaTarefas'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getTarefa( $id ) {
      return (new DataBase('listaTarefas'))->select('id='. $id)->fetchObject(self::class);
    }

  }
