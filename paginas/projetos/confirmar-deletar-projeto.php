<?php
include('verifica_login.php');
?>

<?php

// Checa se apagaram o ID do projeto de alguma forma
if (!isset($_GET['idProjetos']) or $_GET['idProjetos'] == NULL) {
    header('Location: index.php?menuop=projetos');
    exit();
}

$idProjetos = mysqli_real_escape_string($conexao, $_GET["idProjetos"]);

//Pega os dados do projeto com o ID dado
$sql = "SELECT * FROM tbprojetos WHERE idProjetos = {$idProjetos}";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);

// Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
if (mysqli_num_rows($rs) == 0) {
    header("Location: index.php?menuop=projetos");
    exit();
} 

// Se o usuário não for admin e nem autor do projeto
if(($_SESSION['usuario_id'] != $dados['usuarioIdProjetos']) && ($_SESSION['administrador'] != 1)){
    header("Location: index.php?menuop=projetos");
    exit();
}else{
    $titulo = $dados['nomeProjetos'];
    $autor = $dados['autoresProjetos'];
    $curso = $dados['cursoProjetos'];
    $semestre = $dados['semestreProjetos'];
    $orientador = $dados['orientadorProjetos'];
    //$resumo = $dados['resumoProjetos'];
}


$string = $dados['resumoProjetos'];
// strip tags to avoid breaking any html
//$string = strip_tags($string);
if (strlen($string) > 500) {
    // truncate string
    $stringCut = substr($string, 0, 500);
    $endPoint = strrpos($stringCut, ' ');

    //if the string doesn't contain any space then it will cut without word basis.
    $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
    $string = $string . '...';
}

?>

<div class="container">
    <header class="text-center mt-4 fs-3">
        Deseja deletar o projeto abaixo?
    </header>
    <header class="text-center mt-4 fs-4">
        Essa ação não pode ser desfeita.
</header>

    <body>
        <div class="d-flex justify-content-center mt-3">
            <div class="col-7 border border-1 rounded shadow p-3">
                <div class="row" style="min-height: 200px;">
                    <div class="col-6 text-center container-fluid">
                        <div id="mainCarousel" class="carousel slide" data-bs-ride="true">
                            <div class="carousel-indicators">
                                <?php
                                // Consulta sql para pegar as imagens
                                $sqlImg = "SELECT nomeImagem FROM tbimagens WHERE idSeuProjeto = $idProjetos";
                                $rsImg = mysqli_query($conexao, $sqlImg) or die("Erro ao executar consulta!" . mysqli_error($conexao));

                                // Loop para armazenar os dados em um array
                                $rsArray = array();
                                while ($dadosImg = mysqli_fetch_assoc($rsImg)) {
                                    array_push($rsArray, $dadosImg['nomeImagem']);
                                }
                                ?>

                                <?php
                                // Código PHP para apresentar os botões
                                if (count($rsArray)) { ?>
                                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <?php }
                                // Loop para apresentar os botões
                                for ($i = 1; $i < count($rsArray); $i++) { ?>
                                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="<?= $i ?>" aria-label="<?= 'Slide ' . $i ?>"></button>
                                <?php } ?>

                            </div>
                            <div class="carousel-inner">
                                <!-- Primeiro item -->
                                <div class="carousel-item active">
                                    <?php
                                    if (count($rsArray) > 0) { ?>
                                        <img src="<?= 'uploads/img/' . $idProjetos . '/' . $rsArray[0] ?>" class="d-block w-100 img-fluid delete-project-img" alt="imagemProjeto">
                                    <?php } else { ?>
                                        <img src="img/sche.jpg" class="d-block w-100 img-fluid delete-project-img" alt="imagemProjeto">
                                    <?php } ?>
                                </div>
                                <?php
                                // Loop para apresentar as imagens secundárias
                                for ($i = 1; $i <= (count($rsArray) - 1); $i++) { ?>
                                    <div class="carousel-item">
                                        <img src="<?= 'uploads/img/' . $idProjetos . '/' . $rsArray[$i] ?>" class="d-block w-100 img-fluid delete-project-img" alt="imagemProjeto">
                                    </div>
                                <?php }
                                ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-6 d-flex flex-column g-0" style="height: auto;">
                        <div class="fs-4 fw-bold">
                            <?php echo "$titulo" ?>
                        </div>
                        <div class="fs-5"><?php echo "$autor" ?></div>
                        <div class="d-flex align-items-end" style="height: 100%;">
                            <div class="row flex-fill">
                                <div class="fs-6"><?php echo "$curso" ?> - <?php echo "$semestre" ?>º</div>
                                <div class="fs-6">Orientador: <?php echo "$orientador" ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="fw-bold fs-6">Resumo</div>
                    <div class="about">
                        <?php // echo "$resumo" 
                        ?>
                        <?php echo htmlentities($string) ?>
                    </div>
                </div>


            </div>


        </div>

        <div class="d-flex justify-content-end">

            <div class="mt-4 me-5 d-flex flex-row-reverse">
                <!-- Deletar button -->
                <div>
                    <form action="index.php?menuop=deletar-projeto" method="post">
                        <input class="btn btn-light mt-2" type="submit" value="Deletar">
                        <input type="hidden" name="idProjetos" value="<?= $idProjetos ?>">
                    </form>
                </div>
                <!-- Voltar button -->
                <div class="me-2">
                    <form action="index.php?menuop=info-projetos&idProjetos=<?= $idProjetos ?>" method="post">
                        <input class="btn btn-outline-ceub mt-2" type="submit" value="Voltar">
                    </form>
                </div>
            </div>
            <div class="me-2"></div>
            <div class="col-2"></div>
        </div>


    </body>
</div>