<?php
session_start();
if (!$_SESSION['acesso']){
  header ('Location: http://localhost/projetos/DesafioPHPSQL/login.php');
}

include 'sql.php';
include 'header.php';

$extensoesValidas = ['image/jpeg','image/png', 'image/jpg'];
$salvo;
$msg="";

if ($_POST){
  if ($_FILES) {
    if ($_FILES['foto']['error'] == 0) {
      if (array_search($_FILES['foto']['type'], $extensoesValidas) == false) {
        $msg="Extensão do arquivo inválida!<br>";
      }
      else {
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
            echo "Produto salvo com sucesso";
            move_uploaded_file($_FILES['foto']['tmp_name'],'../DesafioPHPSQL/Imagens/'.$idInserido.'.jpg');
          }
        }
        else {
          $msg="Erro no envio!<br>";
        }
      }
    }

    if(isset($salvo)){
      header ('Location: http://localhost/projetos/DesafioPHPSQL/indexProdutos.php');
    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Criar Novo Produto</title>
</head>
<body>
  <div class="container"><br>
    <div class="row justify-content-center">
      <div class="col-3"></div>
      <div class="col-6 border border-success rounded">
        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
            <h5><label class="font-weight-bold" for="nomeProduto">Nome do Produto</label></h5>
            <input class="form-control" type="text" name="nomeProduto" value="" required>
          </div>

          <div class="form-group">
            <h5><label class="font-weight-bold" for="descricao">Descrição</label></h5>
            <input class="form-control" type="text" name="descricao" value="">
          </div>

          <div class="form-group">
            <h5><label class="font-weight-bold" for="preco">Preço</label></h5>
            <input class="form-control" type="number" name="preco" min="0" step=".01" required>
          </div>

          <h5><label class="font-weight-bold" for="foto">Foto</label></h5>
          <input class="form-control-file" type="file" accept="image/jpeg, image/png, image/jpg" name="foto" required>
          <?php echo $msg;?>
          <button class="btn btn-outline-success btn-lg float-right mb-2" type="submit" name="foto">Criar Produto</button>
        </form>
      </div>
      <div class="col-3"></div>
    </div>
  </div>
</body>
</html>
