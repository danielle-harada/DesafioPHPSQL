<?php
  session_start();

  include 'sql.php';

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
  <body>
    <table border="1">
      <tr>
        <td>ID</td>
        <td>Produto</td>
        <td>Descrição</td>
        <td>Preço</td>
        <td>Link</td>
      </tr>
      <?php foreach ($produtos as $produto) : ?>
      <tr>
        <td><?= $produto['ID']?> </td>
        <td><?= $produto['NOME']?> </td>
        <td><?= $produto['DESCRICAO']?> </td>
        <td><?= $produto['PRECO']?> </td>
        <td><a href="showProduto.php?id=<?= $produto['ID']?>">Ver Produto</td>
      </tr>
    <?php endforeach; ?>
  </table>
  </body>
  </html>
