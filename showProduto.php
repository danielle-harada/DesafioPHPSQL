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
    <img src="../DesafioPHPSQL/Imagens/<?=$id;?>.jpg" alt="">

<?php foreach ($produtos as $produto) :?>
  <h2><?= $produto['nome'] ?></h2>
  <p>Descrição do produto:<br></p>
  <p><?= $produto['descricao'] ?><br></p>
  <p>Preço:<br></p>
  <p><?= $produto['preco'] ?></p>
<?php endforeach; ?>

<form action="removeProduto.php" method="post">
  <input type="hidden" value="<?= $id ?>" name="id">
  <input type="submit" value="Excluir Produto">

<a href="editProduto.php?id=<?= $id ?>">Editar Produto</a>
</form>
  </body>
 </html>
