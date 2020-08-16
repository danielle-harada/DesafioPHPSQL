<?php
session_start();
if (!$_SESSION['acesso']){
  header ('Location: http://localhost/projetos/DesafioPHPSQL/login.php');
}

include 'sql.php';
include 'header.php';

$id = $_GET['id'];

$query = $db->prepare ("SELECT nome, descricao, preco, foto
  FROM produtos
  WHERE id=:id;");
  $query->execute([':id' => $id]);

  $produtos=$query->fetchAll(PDO::FETCH_ASSOC);
  ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Página do produtos</title>
</head>
<body>
  <div class="container position-relative">
    <?php foreach ($produtos as $produto) :?>
      <div class="row justify-content-center">
        <h1 class="text-right text-uppercase"><?= $produto['nome'] ?></h1>
      </div>
      <div class="row">
        <div class="col-6">
          <img src="../DesafioPHPSQL/Imagens/<?=$id;?>.jpg" alt="<?=$produto['nome'];?>" class="rounded mx-auto d-block" width="100%">
        </div>
        <div class="col-6">
          <br>
          <h4 class="font-weight-bold">Descrição do produto:</h4><br>
          <h5><?= $produto['descricao'] ?><br></h5>
          <br>
          <h4 class="font-weight-bold float-left pr-2">Preço:</h4>
          <h4 class="d-block">R$ <?= $produto['preco'] ?></h4>

          <form class="fixed-bottom position-absolute" action="removeProduto.php" method="post">
            <button type="submit" value="<?= $id ?>" name="id" class="btn btn-outline-danger float-right">Excluir Produto</button>
            <a class="btn btn-outline-info" role="button" href="editProduto.php?id=<?= $id ?>">Editar Produto</a>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</body>
</html>
