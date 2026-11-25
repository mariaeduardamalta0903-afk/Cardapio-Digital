<?php

  require "src/conexao-bd.php";
  require "src/modelo/produto.php";
  require "src/repositorio/produtorepositorio.php";

  $produtoRepositorio = new produtorepositorio($pdo);

  if(isset($_POST['editar'])) {
      $produtoAtual = $produtoRepositorio->buscar($_POST['id']);

      $imagem = $produtoAtual->getimagem();

      if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {
          if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
              throw new RuntimeException('Não foi possível enviar a imagem do produto.');
          }

          $imagem = uniqid() . basename($_FILES['imagem']['name']);
          if (!move_uploaded_file($_FILES['imagem']['tmp_name'], 'img/' . $imagem)) {
              throw new RuntimeException('Não foi possível salvar a imagem do produto.');
          }
      }

      $produto = new Produto($_POST['id'], $_POST['tipo'], $_POST['nome'], $_POST['descricao'], $_POST['preco'], $imagem);
      $produtoRepositorio->atualizar($produto);
      header("Location: admin.php");

      if(isset($_FILES['imagem'])){
    $produto->setImagem(uniqid().$_FILES['imagem']['name']);
    move_uploaded_file($_FILES['imagem']['tmp_name'],$produto->getimagemDiretorio());
      }
} else {
    $produto = $produtoRepositorio->buscar($_GET['id']);
}

?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/admin.css">
  <link rel="stylesheet" href="css/form.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="icon" href="img/icone-grao.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
  <title>saboor-cafeteria-Login - Editar Produto</title>
</head>
<body>
<main>
  <section class="container-admin-banner">
    <img src="img/logo-saboor-cafeteria.jpg" class="logo-admin" alt="logo-saboor cafeteria">
    <h1>Editar Produto</h1>
    <img class= "ornaments" src="img/ornaments-coffee.png" alt="ornaments">
  </section>
  <section class="container-form">
    <form method ="post" enctype="multipart/form-data">

      <label for="nome">Nome</label>
      <input type="text" id="nome" name="nome" placeholder="Digite o nome do produto" value="<?= $produto->getnome() ?>" required>

      <div class="container-radio">
        <div>
            <label for="cafe">Café</label>
            <input type="radio" id="cafe" name="tipo" value="Café" required <?= $produto->getTipo() === 'Café' ? 'checked' : '' ?>>
        </div>
        <div>
            <label for="lanches">lanches da manha</label>
            <input type="radio" id="lanches" name="tipo" value="lanchesdamanha" required <?= $produto->getTipo() === 'lanchesdamanha' ? 'checked' : '' ?>>
        </div>
    </div>

      <label for="descricao">Descrição</label>
      <input type="text" id="descricao" name="descricao" value="<?= $produto->getdescricao() ?>" placeholder="Digite uma descrição" required>

      <label for="preco">Preço</label>
      <input type="text" id="preco" name="preco" value="<?= number_format($produto->getpreco(),2) ?>" placeholder="digite o preco">

      <label for="imagem">Envie uma imagem do produto</label>
      <input type="file" name="imagem" accept="image/*" id="imagem" placeholder="Envie uma imagem">
      <input type="hidden" name="id" value="<?= $produto->getId() ?>">
      <input type="submit" name="editar" class="botao-cadastrar"  value="Editar produto"/>
    </form>

  </section>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/index.js"></script>
</body>
</html>