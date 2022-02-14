<main>
  <div id="topo"> To Do App - by Manuel Benedito </div>

  <section id="add-todo">
    <form class="" action="" method="post">
      <fieldset> <legend> Add To Do</legend>
        <input type="text" name="titulo" placeHolder="Title" value="" id="titulo"/>
        <textarea name="descricao" placeHolder="Description" id="descricao"></textarea>

        <div>
          <input type="submit" name="addTarefa" class="btn-form1" value="Add"/>
          <input type="reset" name="" class="btn-form2" value="Reset"/>
        </div>
      </fieldset>
    </form>
  </section>

  <section id="lista-toDo">
    <?=$toDoList;?>
  </section>
</main>
