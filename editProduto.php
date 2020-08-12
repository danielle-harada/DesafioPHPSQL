<?php
session_start();

include 'sql.php';

$id = $_GET['id'];
$extensoesValidas = ['image/jpeg','image/png', 'image/jpg'];
$salvo;
$msg="";


$query = $db->prepare ("SELECT *
                        FROM produtos
                        WHERE id=:id;");
$query->execute([':id' => $id]);

$produtos=$query->fetchAll(PDO::FETCH_ASSOC);

if ($_FILES) { //verifica se tem files
  if ($_FILES['foto']['error'] == 0) { //verifica se não tem erro
    if (array_search($_FILES['foto']['type'], $extensoesValidas) == false) { //valida as extensoes
      $msg="Extensão do arquivo inválida!<br>"; //se não é valida, imprime msg
    } else {
      move_uploaded_file($_FILES['foto']['tmp_name'],'../DesafioPHPSQL/Imagens/'.$id.'.jpg');//se válida, move para a pasta Imagens
      $query = $db-> prepare("UPDATE produtos SET foto =:foto
                                              WHERE id = :id;");
      $salvo=$query->execute([':id' => $id,
                              ':foto'=>$_FILES['foto']['name']]);}}}


if ($_POST){
        $query = $db-> prepare("UPDATE produtos SET nome = :nome,
                                                    descricao = :descricao,
                                                    preco = :preco,
                                                WHERE id = :id;");
        $salvo=$query->execute([':id' => $id,
                                ':nome'=>$_POST['nomeProduto'],
                                ':descricao'=>$_POST['descricao'],
                                ':preco'=>$_POST['preco']]);}


if(isset($salvo)){
  header ('Location: http://localhost/projetos/DesafioPHPSQL/indexProdutos.php'); }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Editar Produto</title>
  </head>
  <body>
    <?php foreach ($produtos as $produto): ?>
    <form class="" method="post" enctype="multipart/form-data">
      <label for="nomeProduto">Nome do Produto</label><br>
       <input type="text" name="nomeProduto" value="<?= $produto['NOME']?>" required><br>
       <label for="descricao">Descrição</label><br>
       <input type="text" name="descricao" value="<?= $produto['DESCRICAO']?>"><br>
      <label for="preco">Preço</label><br>
       <input type="number" name="preco" min="0" step=".01" value="<?= $produto['PRECO']?>"><br>
      <label for="">Foto</label><br>
      <img src="../DesafioPHPSQL/Imagens/<?=$id;?>.jpg" alt="">
       <input type="file" name="foto"><br>
       <?php echo $msg;?>
       <input type="hidden" name="id" value="<?= $id ?>">
       <input type="submit" name="button" value="Atualizar Produto">
    </form>
    <?php endforeach; ?>
  </body>
</html>
