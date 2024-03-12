<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<div class="container">

    <header class="text-center mt-3 mb-4 me-4">
        <div class="rounded shadow" style="background-image: url('./img/strip.jpg'); background-size:cover;">
            <span class="fs-1" style="color:white;">Projetos</span>
        </div>
    </header>

    <?php if (isset($_SESSION['usuario_id'])) { ?>
        <div class="d-flex flex-row-reverse mb-3">
            <div class="me-4">
                <a href="index.php?menuop=formulario-projetos"><button class="btn btn-light me-3" type="submit">Novo Projeto</button></a>
            </div>
        </div>
    <?php } else { ?>
        <div class="p-1"></div>
    <?php } ?>


    <!-- cards -->
    <div class="d-flex flex-wrap">

        <?php
        // Método SQL para mostrar os Cards
        $sql = "SELECT idProjetos, nomeProjetos, resumoProjetos FROM tbprojetos WHERE visivelProjetos = 0";

        // Variável para executar a consulta
        $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));

        // Loop para mostrar os cards
        while ($dados = mysqli_fetch_assoc($rs)) {
            $id = $dados['idProjetos'];

            // Lógica para cortar o resumo para caber no card
            $string = $dados['resumoProjetos'];
            // strip tags to avoid breaking any html
            //$string = strip_tags($string);
            if (strlen($string) > 150) {
                // truncate string
                $stringCut = substr($string, 0, 150);
                $endPoint = strrpos($stringCut, ' ');

                //if the string doesn't contain any space then it will cut without word basis.
                $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                $string = $string . '...';
            }

        ?>

            <div class="card ms-2 me-4 mb-4" style="width: 18rem; min-height: 411px;">
                <div class="rounded zoom-img">
                    <?php
                    $sqlImg = "SELECT * FROM tbimagens WHERE idSeuProjeto = '$id' LIMIT 1";
                    $rsImg = mysqli_query($conexao, $sqlImg) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                    if ($dadosImg = mysqli_fetch_assoc($rsImg)) {
                        $firstImage = $dadosImg['nomeImagem']; ?>
                        <a href="index.php?menuop=info-projetos&idProjetos=<?= $dados["idProjetos"] ?>"><img src="<?= 'uploads/img/' . $id . '/' . $firstImage ?>" alt=""></a>
                    <?php } else { ?>
                        <a href="index.php?menuop=info-projetos&idProjetos=<?= $dados["idProjetos"] ?>"><img src="img/woman.jpg" alt="imagemDoProjeto"></a>
                    <?php } ?>
                </div>
                <div class="card-body d-flex flex-column" style="height: auto;">
                    <div class="">
                        <h5 class="card-title"><?php echo $dados["nomeProjetos"] ?></h5>
                    </div>
                    <div class="mt-1">
                        <p class="card-text about"><?php echo htmlentities($string); ?></p>
                    </div>
                    <div class="mt-2 d-flex align-items-end" style="height: 100%;">
                        <a href="index.php?menuop=info-projetos&idProjetos=<?= $dados["idProjetos"] ?>" class="btn btn-light">Ver projeto</a>
                    </div>




                </div>
            </div>

        <?php } ?>

    </div>
    <?php if (isset($_SESSION['administrador'])) {
        if ($_SESSION['administrador'] == 1) { ?>
            <div>
                <div class="">
                    <a href="index.php?menuop=escolher-restaurar-projetos" class="text-decoration-none">Restaurar projeto</a>
                </div>
            </div>
    <?php }
    } ?>
</div>