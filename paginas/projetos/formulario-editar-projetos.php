<?php
include('verifica_login.php');
?>

<?php

// Checa se "&idProjetos=X" foi apagado da URL
if (!isset($_GET['idProjetos'])) {
    header('Location: index.php?menuop=projetos');
    exit();
}

$idProjetos = $_GET['idProjetos'];

//Pega os dados do projeto com o ID dado
$sql = "SELECT * FROM tbprojetos WHERE idProjetos = {$idProjetos}";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);

// Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
if (mysqli_num_rows($rs) == 0 || $dados['visivelProjetos'] != 0) {
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
    $resumo = $dados['resumoProjetos'];
}

// Consulta sql para pegar as imagens
$sqlImg = "SELECT nomeImagem FROM tbimagens WHERE idSeuProjeto = $idProjetos";
$rsImg = mysqli_query($conexao, $sqlImg) or die("Erro ao executar consulta!" . mysqli_error($conexao));

// Loop para armazenar os dados em um array  (utilizar imgArray[0], imgArray[1]... para mostrar os dados)
$imgArray = array();
while ($dadosImg = mysqli_fetch_assoc($rsImg)) {
    array_push($imgArray, $dadosImg['nomeImagem']);
}


// Consulta sql para pegar as imagens
$sqlIdImg = "SELECT idImagem FROM tbimagens WHERE idSeuProjeto = $idProjetos";
$rsIdImg = mysqli_query($conexao, $sqlIdImg) or die("Erro ao executar consulta!" . mysqli_error($conexao));

// Loop para armazenar os dados em um array  (utilizar imgArray[0], imgArray[1]... para mostrar os dados)
$idImgArray = array();
while ($dadosIdImg = mysqli_fetch_assoc($rsIdImg)) {
    array_push($idImgArray, $dadosIdImg['idImagem']);
}


// Pega os dados do arquivo do projeto
$sqlFile = "SELECT * FROM tbarquivos WHERE idSeuProjeto = $idProjetos";
$rsFile = mysqli_query($conexao, $sqlFile) or die("Erro ao executar consulta!" . mysqli_error($conexao));
$dadosFile = mysqli_fetch_assoc($rsFile);
if ($dadosFile != NULL) {
    $nomeArquivo = $dadosFile['nomeArquivo'];
    $idArquivo = $dadosFile['idArquivo'];
}



?>

<div class="container mb-3">
    <form action="index.php?menuop=editar-projetos" method="post" enctype="multipart/form-data">
        <div class="row mt-3" style="min-height: 400px;">
            <div class="col-6 d-flex flex-column" style="height: auto;">
                <?php
                if ($imgArray != NULL) { ?>
                    <div class="alert alert-warning align-items-center d-flex flex-row" role="alert">
                        <i class='bx bxs-error-circle bx-sm me-2'></i>
                        <div>
                            Selecione abaixo as imagens que deseja <strong>excluir</strong>.<br>
                            Você ainda pode inserir até <strong>5 imagens</strong> de <strong>4MB</strong> cada.
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-primary alert-dismissible fade show d-flex align-items-center mt-2" role="alert">
                        <div>
                            <i class='bx bxs-error-circle bx-xs'></i> Você pode adicionar até <strong>5 imagens</strong> de <strong>4MB</strong> do seu projeto aqui!
                        </div>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <div class="d-flex flex-column justify-content-center" style="height: 100%;">
                    <?php
                    if ($imgArray == NULL) { ?>
                        <img src="img/img-place-holder.png" class="img-fluid form-project-img" alt="imagem">
                        <?php } else {

                        for ($i = 0; $i < count($imgArray); $i++) {
                            $nome = $imgArray[$i];
                            $id = $idImgArray[$i];
                            // echo "| Imagem: $nome | ID: $id ";
                        ?>
                            <div class="p-1 d-flex flex-row align-items-center">
                                <img src="<?= 'uploads/img/' . $idProjetos . '/' . $imgArray[$i] ?>" class="edit-project-img border shadow-sm" alt="">
                                <div class="form-check form-check-inline ms-3">
                                    <input class="form-check-input" type="checkbox" id="<?= 'imgCheck' . ($i + 1) ?>" name="imgCheck[]" value="<?= $nome ?>">
                                    <label class="form-check-label" for="<?= 'imgCheck' . ($i + 1) ?>">Excluir</label>
                                </div>
                            </div>
                    <?php }
                    } ?>
                    <div class="d-flex align-items-start">
                        <div class="mt-3 d-flex flex-row align-items-center">
                            <div>
                                <input class="form-control" type="file" name="imagens[]" multiple>
                            </div>
                            <div>
                                <i class='bx bxs-file-image bx-md'></i>
                            </div>
                            <div class="small">
                                Imagens
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="col-6 d-flex flex-column " style="height: auto;">
                <div>
                    <label class="form-label">Título</label>
                    <?php echo '<input class="form-control" type="text" name="nomeProjeto" placeholder="Título" value="'.$titulo.'" pattern="[A-Za-z0-9À-ú \']+" minlength="3" maxlength="50" required>'?>
                </div>
                <div class="mt-1">
                    <label class="form-label">Autores</label>
                    <?php echo '<input class="form-control" type="text" name="autoresProjeto" placeholder="Autor" value="'.$autor.'" pattern="[A-Za-zÀ-ú \']+" minlength="3" maxlength="500" required>'?>
                </div>

                <div class="d-flex align-items-end" style="height: 100%;">
                    <div class="row flex-fill">
                        <div class="mt-1 col-12">
                            <label class="form-label">Curso</label>
                            <select class="form-select" aria-label="select" name="cursoProjeto" required>
                                <?php if ($curso == '') { ?><option selected value="">Curso</option><?php } else { ?><option value="">Curso</option><?php } ?>
                                <?php if ($curso == 'Administração') { ?><option selected value="Administração">Administração</option><?php } else { ?><option value="Administração">Administração</option><?php } ?>
                                <?php if ($curso == 'Análise e Desenvolvimento de Sistemas') { ?><option selected value="Análise e Desenvolvimento de Sistemas">Análise e Desenvolvimento de Sistemas</option><?php } else { ?><option value="Análise e Desenvolvimento de Sistemas">Análise e Desenvolvimento de Sistemas</option><?php } ?>
                                <?php if ($curso == 'Arquitetura e Urbanismo') { ?><option selected value="Arquitetura e Urbanismo">Arquitetura e Urbanismo</option><?php } else { ?><option value="Arquitetura e Urbanismo">Arquitetura e Urbanismo</option><?php } ?>
                                <?php if ($curso == 'Biomedicina') { ?><option selected value="Biomedicina">Biomedicina</option><?php } else { ?><option value="Biomedicina">Biomedicina</option><?php } ?>
                                <?php if ($curso == 'Ciência da Computação') { ?><option selected value="Ciência da Computação">Ciência da Computação</option><?php } else { ?><option value="Ciência da Computação">Ciência da Computação</option><?php } ?>
                                <?php if ($curso == 'Ciência de dados e Machine Learning') { ?><option selected value="Ciência de dados e Machine Learning">Ciência de dados e Machine Learning</option><?php } else { ?><option value="Ciência de dados e Machine Learning">Ciência de dados e Machine Learning</option><?php } ?>
                                <?php if ($curso == 'Ciências Biológicas') { ?><option selected value="Ciências Biológicas">Ciências Biológicas</option><?php } else { ?><option value="Ciências Biológicas">Ciências Biológicas</option><?php } ?>
                                <?php if ($curso == 'Ciências Contábeis') { ?><option selected value="Ciências Contábeis">Ciências Contábeis</option><?php } else { ?><option value="Ciências Contábeis">Ciências Contábeis</option><?php } ?>
                                <?php if ($curso == 'Direito') { ?><option selected value="Direito">Direito</option><?php } else { ?><option value="Direito">Direito</option><?php } ?>
                                <?php if ($curso == 'Educação Física') { ?><option selected value="Educação Física">Educação Física</option><?php } else { ?><option value="Educação Física">Educação Física</option><?php } ?>
                                <?php if ($curso == 'Enfermagem') { ?><option selected value="Enfermagem">Enfermagem</option><?php } else { ?><option value="Enfermagem">Enfermagem</option><?php } ?>
                                <?php if ($curso == 'Engenharia Civil') { ?><option selected value="Engenharia Civil">Engenharia Civil</option><?php } else { ?><option value="Engenharia Civil">Engenharia Civil</option><?php } ?>
                                <?php if ($curso == 'Engenharia de Computação') { ?><option selected value="Engenharia de Computação">Engenharia de Computação</option><?php } else { ?><option value="Engenharia de Computação">Engenharia de Computação</option><?php } ?>
                                <?php if ($curso == 'Engenharia Elétrica') { ?><option selected value="Engenharia Elétrica">Engenharia Elétrica</option><?php } else { ?><option value="Engenharia Elétrica">Engenharia Elétrica</option><?php } ?>
                                <?php if ($curso == 'Fisioterapia') { ?><option selected value="Fisioterapia">Fisioterapia</option><?php } else { ?><option value="Fisioterapia">Fisioterapia</option><?php } ?>
                                <?php if ($curso == 'Jornalismo') { ?><option selected value="Jornalismo">Jornalismo</option><?php } else { ?><option value="Jornalismo">Jornalismo</option><?php } ?>
                                <?php if ($curso == 'Marketing') { ?><option selected value="Marketing">Marketing</option><?php } else { ?><option value="Marketing">Marketing</option><?php } ?>
                                <?php if ($curso == 'Medicina') { ?><option selected value="Medicina">Medicina</option><?php } else { ?><option value="Medicina">Medicina</option><?php } ?>
                                <?php if ($curso == 'Medicina Veterinária') { ?><option selected value="Medicina Veterinária">Medicina Veterinária</option><?php } else { ?><option value="Medicina Veterinária">Medicina Veterinária</option><?php } ?>
                                <?php if ($curso == 'Nutrição') { ?><option selected value="Nutrição">Nutrição</option><?php } else { ?><option value="Nutrição">Nutrição</option><?php } ?>
                                <?php if ($curso == 'Psicologia') { ?><option selected value="Psicologia">Psicologia</option><?php } else { ?><option value="Psicologia">Psicologia</option><?php } ?>
                                <?php if ($curso == 'Publicidade e Propaganda') { ?><option selected value="Publicidade e Propaganda">Publicidade e Propaganda</option><?php } else { ?><option value="Publicidade e Propaganda">Publicidade e Propaganda</option><?php } ?>
                                <?php if ($curso == 'Relações Internacionais') { ?><option selected value="Relações Internacionais">Relações Internacionais</option><?php } else { ?><option value="Relações Internacionais">Relações Internacionais</option><?php } ?>
                            </select>
                        </div>
                        <div class="mt-1 col-12">
                            <label class="form-label">Semestre</label>
                            <select class="form-select" aria-label="select" name="semestreProjeto" required>
                                <?php if ($semestre == 1) { ?><option selected value="1">1º</option><?php } else { ?><option value="1">1º</option><?php } ?>
                                <?php if ($semestre == 2) { ?><option selected value="2">2º</option><?php } else { ?><option value="2">2º</option><?php } ?>
                                <?php if ($semestre == 3) { ?><option selected value="3">3º</option><?php } else { ?><option value="3">3º</option><?php } ?>
                                <?php if ($semestre == 4) { ?><option selected value="4">4º</option><?php } else { ?><option value="4">4º</option><?php } ?>
                                <?php if ($semestre == 5) { ?><option selected value="5">5º</option><?php } else { ?><option value="5">5º</option><?php } ?>
                                <?php if ($semestre == 6) { ?><option selected value="6">6º</option><?php } else { ?><option value="6">6º</option><?php } ?>
                                <?php if ($semestre == 7) { ?><option selected value="7">7º</option><?php } else { ?><option value="7">7º</option><?php } ?>
                                <?php if ($semestre == 8) { ?><option selected value="8">8º</option><?php } else { ?><option value="8">8º</option><?php } ?>
                                <?php if ($semestre == 9) { ?><option selected value="9">9º</option><?php } else { ?><option value="9">9º</option><?php } ?>
                                <?php if ($semestre == 10) { ?><option selected value="10">10º</option><?php } else { ?><option value="10">10º</option><?php } ?>
                                <?php if ($semestre == 11) { ?><option selected value="11">11º</option><?php } else { ?><option value="11">11º</option><?php } ?>
                                <?php if ($semestre == 12) { ?><option selected value="12">12º</option><?php } else { ?><option value="12">12º</option><?php } ?>
                            </select>
                        </div>
                        <div class="mt-1 col-12">
                            <label class="form-label">Orientador</label>
                            <?php echo '<input class="form-control" type="text" name="orientadorProjeto" placeholder="Orientador" value="'.$orientador.'" pattern="[A-Za-zÀ-ú \']+" minlength="3" maxlength="50" required>'?>
                        </div>
                    </div>

                </div>

            </div>
        </div>



        <div class="mt-4">
            <div class="mt-1 form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" name="resumoProjeto" id="floatingTextarea2" style="height: 200px" minlength="3" maxlength="2500" required><?= $resumo ?></textarea>
                <label for="floatingTextarea2">Resumo</label>
            </div>
        </div>
        <div class="mt-3 d-flex flex-row align-items-center">
            <div>
                <input class="form-control" type="file" id="formFile" name="arquivo">
            </div>
            <div>
                <i class='bx bxs-file-pdf bx-md'></i>
            </div>
            <div class="small">
                Arquivo PDF
            </div>

            <?php if ($dadosFile != NULL) { ?>
                <div class="ms-4">
                    <strong>Excluir PDF atual?</strong>
                    <div class="form-check form-check-inline ms-1 ">
                        <input class="form-check-input" type="checkbox" id="fileCheck" name="fileCheck" value="<?= $nomeArquivo ?>">
                        <label class="form-check-label" for="fileCheck">Sim</label>
                    </div>
                </div>
            <?php } ?>



        </div>


        <?php

        if ($dadosFile != NULL) { ?>
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center mt-2" style="width: 53%;" role="alert">
                <div>
                    <i class='bx bxs-error bx-xs'></i><strong> O arquivo já existe!</strong> O envio de um novo arquivo irá automaticamente substituí-lo.
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>


        <?php } ?>

        <input class="form-control" type="text" name="idProjetos" value="<?= $idProjetos ?>" hidden>

        <div class="text-end">
            <input class="btn btn-light mt-2" type="submit" value="Atualizar">
        </div>
    </form>
</div>