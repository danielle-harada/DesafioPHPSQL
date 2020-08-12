<?php
session_start();

include 'sql.php';

$extensoesValidas = ['image/jpeg','image/png', 'image/jpg'];
$salvo;
$msg="";

if ($_POST){
if ($_FILES) {
  if ($_FILES['foto']['error'] == 0) {
    if (array_search($_FILES['foto']['type'], $extensoesValidas) == false) {
      $msg="Extensão do arquivo inválida!<br>";
    } else {
        $query = $db->prepare("INSERT INTO produtos (nome,
                                               descricao,
                                               preco,
                                               foto)
                                VALUES (:nome,
                                        :descricao,
                                        :preco,
                                        :foto);");
        $salvo=$query->execute([':nome'=>$_POST['nomeProduto'],
                   ':descricao'=>$_POST['descricao'],
                   ':preco'=>$_POST['preco'],
                   ':foto'=>$_FILES['foto']['name']]);
        $idInserido = $db->lastInsertId();
        move_uploaded_file($_FILES['foto']['tmp_name'],'../DesafioPHPSQL/Imagens/'.$idInserido.'.jpg');}
          } else {
            $msg="Erro no envio!<br>";
}}}

if(isset($salvo)){
  header ('Location: http://localhost/projetos/DesafioPHPSQL/createProduto.php'); }


?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Criar Novo Produto</title>
   </head>
   <body>
     <form class="" method="post" enctype="multipart/form-data">
       <label for="nomeProduto">Nome do Produto</label><br>
        <input type="text" name="nomeProduto" value="" required><br>
        <label for="descricao">Descrição</label><br>
        <input type="text" name="descricao" value=""><br>
       <label for="preco">Preço</label><br>
        <input type="number" name="preco" min="0" step=".01" required><br>
       <label for="">Foto</label><br>
        <input type="file" name="foto" required><br>
        <?php echo $msg;?>
       <button type="submit" name="button">Enviar</button>
     </form>
   </body>
 </html>
