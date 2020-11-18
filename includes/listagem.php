<?php

    $mensagem = '';
  if(isset($_GET['status'])){
    switch ($_GET['status']) {
      case 'success':
        $mensagem = '<div class="alert alert-success">Ação executada com sucesso!</div>';
        break;

      case 'error':
        $mensagem = '<div class="alert alert-danger">Ação não executada!</div>';
        break;
    }
  }

    $resultado = '';
    foreach($categorias as $categoria){
        $resultado .= '<tr>
                        <td>'.$categoria->id.'</td>
                        <td>'.$categoria->descricao.'</td>
                        <td>'. ($categoria->ativo == 's' ? 'Ativo' : 'Inativo') . '</td>
                        <td>
                            <a href="editar.php?id='. $categoria->id . '">
                                <button type = "button" class= "btn btn-primary">Editar</button>
                            </a>
                            <a href="excluir.php?id='. $categoria->id . '">
                                <button type = "button" class= "btn btn-danger">Excluir</button>
                            </a>
                        </td>
                       </tr>';
    }

    $resultado = strlen($resultado) ? $resultado : '<tr>
                                                        <td colspan = "3" class = "text-center"> 
                                                            Nenhuma Categoria encontrada! 
                                                        </td>
                                                    </tr>';

    

?>

<main>

    <?=$mensagem?>

    <section>
        <a href = "cadastrar.php">
            <button class = "btn btn-success">Cadastrar</button>
        </a>
    </section>

    <section>
        <form method="get">
        <div class="row my-4">
            <div class="col">
                <label>Buscar por descrição</label>
                <input type="text" name="busca" class="form-control" value="<?=$busca?>">
            </div>
            <div class="col">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="">Ativo/Inativo</option>
                    <option value="s">Ativo</option>
                    <option value="n">Inativo</option>
                </select>
            </div>
            <div class="col d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>

        </div>
        </form>
    </section>

    <section>
        <table class="table bg-light mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?=$resultado?>
            </tbody>
        </table>
    </section>

</main>