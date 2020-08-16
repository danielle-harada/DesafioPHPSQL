<?php
  session_start();
  if (!$_SESSION['acesso']){
    header ('Location: http://localhost/projetos/DesafioPHPSQL/login.php');
  }

  include 'sql.php';
  include 'header.php';

  $query = $db->prepare("SELECT * FROM produtos;");
  $query -> execute();
  $produtos = $query->fetchAll(PDO::FETCH_ASSOC);

// var_dump($produtos);

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body class="text-center">
    <br><br>
    <div class="container">
      <table class="table table-striped table-dark">
        <tr class="font-weight-bold">
          <td><h3>ID</h3></td>
          <td><h3>PRODUTO</h3></td>
          <td><h3>DESCRIÇÃO</h3></td>
          <td><h3>PREÇO</h3></td>
          <td></td>
        </tr>
        <?php foreach ($produtos as $produto) : ?>
        <tr>
          <td class="font-weight-bold"><?= $produto['ID']?> </td>
          <td class="text-uppercase"><?= $produto['NOME']?> </td>
          <td><?= $produto['DESCRICAO']?> </td>
          <td>R$ <?= $produto['PRECO']?> </td>
          <td><a class="text-white font-weight-bold" href="showProduto.php?id=<?= $produto['ID']?>">Ver Produto</td>
        </tr>
      <?php endforeach; ?>
    </table>
    </div>

  </body>
  </html>
