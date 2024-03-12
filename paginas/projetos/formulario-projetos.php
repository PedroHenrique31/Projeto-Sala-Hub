<?php
include('verifica_login.php');
?>

<?php

$nomeProjeto = '';
$autoresProjeto = '';
$cursoProjeto = '';
$semestreProjeto = '';
$orientadorProjeto = '';
$resumoProjeto = '';

if (isset($_POST['nomeProjeto'])) {
    // if (preg_match("/^[A-Za-zÀ-ÿ \']+$/", $_POST['nomeProjeto'])) {
    $nomeProjeto = $_POST['nomeProjeto'];
    // }
}
if (isset($_POST['autoresProjeto'])) {
    // if (preg_match("/^[A-Za-zÀ-ÿ \']+$/", $_POST['autoresProjeto'])) {
    $autoresProjeto = $_POST['autoresProjeto'];
    // }
}

if (isset($_POST['orientadorProjeto'])) {
    // if (preg_match("/^[A-Za-zÀ-ÿ \']+$/", $_POST['orientadorProjeto'])) {
    $orientadorProjeto = $_POST['orientadorProjeto'];
    // }
}

if (isset($_POST['cursoProjeto'])) {
    $cursoProjeto = $_POST['cursoProjeto'];
}
if (isset($_POST['semestreProjeto'])) {
    $semestreProjeto = $_POST['semestreProjeto'];
}
if (isset($_POST['resumoProjeto'])) {
    $resumoProjeto = $_POST['resumoProjeto'];
}

?>

<div class="container mb-3">
    <form action="index.php?menuop=criar-projetos" method="post" enctype="multipart/form-data">
        <div class="row mt-3" style="min-height: 400px;">
            <div class="col-6 text-center container-fluid">
                <img src="img/img-place-holder.png" class="img-fluid form-project-img p-4" alt="imagem">
                <div class="fs-5 mt-1">
                    <input class="form-control" type="file" name="imagens[]" multiple>
                </div>
                <div class="alert alert-primary alert-dismissible fade show d-flex align-items-center mt-2" role="alert">
                    <div>
                        <i class='bx bxs-error-circle bx-xs'></i> Envie até <strong>5 imagens</strong> de <strong>4MB</strong> do seu projeto aqui!
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <div class="col-6 d-flex flex-column" style="height: auto;">
                <div>
                    <?php echo '<input class="form-control" type="text" name="nomeProjeto" value="'.$nomeProjeto. '" pattern="[A-Za-z0-9À-ú \']+" minlength="3" maxlength="30" placeholder="Título" required>' ?>
                </div>
                <div class="fs-5 mt-1">
                    <?php echo '<input class="form-control" type="text" name="autoresProjeto" value="'.$autoresProjeto.'" pattern="[A-Za-zÀ-ú \']+" placeholder="Autor" minlength="3" maxlength="500" required>' ?>
                </div>

                <div class="d-flex align-items-end" style="height: 100%;">
                    <div class="row flex-fill">
                        <div class="fs-5 mt-1">
                            <select class="form-select" aria-label="select" name="cursoProjeto" required>
                                <?php if ($cursoProjeto == '') { ?><option selected value="">Curso</option><?php } else { ?><option value="">Curso</option><?php } ?>
                                <?php if ($cursoProjeto == 'Administração') { ?><option selected value="Administração">Administração</option><?php } else { ?><option value="Administração">Administração</option><?php } ?>
                                <?php if ($cursoProjeto == 'Análise e Desenvolvimento de Sistemas') { ?><option selected value="Análise e Desenvolvimento de Sistemas">Análise e Desenvolvimento de Sistemas</option><?php } else { ?><option value="Análise e Desenvolvimento de Sistemas">Análise e Desenvolvimento de Sistemas</option><?php } ?>
                                <?php if ($cursoProjeto == 'Arquitetura e Urbanismo') { ?><option selected value="Arquitetura e Urbanismo">Arquitetura e Urbanismo</option><?php } else { ?><option value="Arquitetura e Urbanismo">Arquitetura e Urbanismo</option><?php } ?>
                                <?php if ($cursoProjeto == 'Biomedicina') { ?><option selected value="Biomedicina">Biomedicina</option><?php } else { ?><option value="Biomedicina">Biomedicina</option><?php } ?>
                                <?php if ($cursoProjeto == 'Ciência da Computação') { ?><option selected value="Ciência da Computação">Ciência da Computação</option><?php } else { ?><option value="Ciência da Computação">Ciência da Computação</option><?php } ?>
                                <?php if ($cursoProjeto == 'Ciência de dados e Machine Learning') { ?><option selected value="Ciência de dados e Machine Learning">Ciência de dados e Machine Learning</option><?php } else { ?><option value="Ciência de dados e Machine Learning">Ciência de dados e Machine Learning</option><?php } ?>
                                <?php if ($cursoProjeto == 'Ciências Biológicas') { ?><option selected value="Ciências Biológicas">Ciências Biológicas</option><?php } else { ?><option value="Ciências Biológicas">Ciências Biológicas</option><?php } ?>
                                <?php if ($cursoProjeto == 'Ciências Contábeis') { ?><option selected value="Ciências Contábeis">Ciências Contábeis</option><?php } else { ?><option value="Ciências Contábeis">Ciências Contábeis</option><?php } ?>
                                <?php if ($cursoProjeto == 'Direito') { ?><option selected value="Direito">Direito</option><?php } else { ?><option value="Direito">Direito</option><?php } ?>
                                <?php if ($cursoProjeto == 'Educação Física') { ?><option selected value="Educação Física">Educação Física</option><?php } else { ?><option value="Educação Física">Educação Física</option><?php } ?>
                                <?php if ($cursoProjeto == 'Enfermagem') { ?><option selected value="Enfermagem">Enfermagem</option><?php } else { ?><option value="Enfermagem">Enfermagem</option><?php } ?>
                                <?php if ($cursoProjeto == 'Engenharia Civil') { ?><option selected value="Engenharia Civil">Engenharia Civil</option><?php } else { ?><option value="Engenharia Civil">Engenharia Civil</option><?php } ?>
                                <?php if ($cursoProjeto == 'Engenharia de Computação') { ?><option selected value="Engenharia de Computação">Engenharia de Computação</option><?php } else { ?><option value="Engenharia de Computação">Engenharia de Computação</option><?php } ?>
                                <?php if ($cursoProjeto == 'Engenharia Elétrica') { ?><option selected value="Engenharia Elétrica">Engenharia Elétrica</option><?php } else { ?><option value="Engenharia Elétrica">Engenharia Elétrica</option><?php } ?>
                                <?php if ($cursoProjeto == 'Fisioterapia') { ?><option selected value="Fisioterapia">Fisioterapia</option><?php } else { ?><option value="Fisioterapia">Fisioterapia</option><?php } ?>
                                <?php if ($cursoProjeto == 'Jornalismo') { ?><option selected value="Jornalismo">Jornalismo</option><?php } else { ?><option value="Jornalismo">Jornalismo</option><?php } ?>
                                <?php if ($cursoProjeto == 'Marketing') { ?><option selected value="Marketing">Marketing</option><?php } else { ?><option value="Marketing">Marketing</option><?php } ?>
                                <?php if ($cursoProjeto == 'Medicina') { ?><option selected value="Medicina">Medicina</option><?php } else { ?><option value="Medicina">Medicina</option><?php } ?>
                                <?php if ($cursoProjeto == 'Medicina Veterinária') { ?><option selected value="Medicina Veterinária">Medicina Veterinária</option><?php } else { ?><option value="Medicina Veterinária">Medicina Veterinária</option><?php } ?>
                                <?php if ($cursoProjeto == 'Nutrição') { ?><option selected value="Nutrição">Nutrição</option><?php } else { ?><option value="Nutrição">Nutrição</option><?php } ?>
                                <?php if ($cursoProjeto == 'Psicologia') { ?><option selected value="Psicologia">Psicologia</option><?php } else { ?><option value="Psicologia">Psicologia</option><?php } ?>
                                <?php if ($cursoProjeto == 'Publicidade e Propaganda') { ?><option selected value="Publicidade e Propaganda">Publicidade e Propaganda</option><?php } else { ?><option value="Publicidade e Propaganda">Publicidade e Propaganda</option><?php } ?>
                                <?php if ($cursoProjeto == 'Relações Internacionais') { ?><option selected value="Relações Internacionais">Relações Internacionais</option><?php } else { ?><option value="Relações Internacionais">Relações Internacionais</option><?php } ?>
                            </select>
                        </div>
                        <div class="fs-5 mt-1">
                            <select class="form-select" aria-label="select" name="semestreProjeto" required>
                                <?php if ($semestreProjeto == '') { ?><option selected value="">Semestre</option><?php } else { ?><option value="">Semestre</option><?php } ?>
                                <?php if ($semestreProjeto == '1') { ?><option selected value="1">1º</option><?php } else { ?><option value="1">1º</option><?php } ?>
                                <?php if ($semestreProjeto == '2') { ?><option selected value="2">2º</option><?php } else { ?><option value="2">2º</option><?php } ?>
                                <?php if ($semestreProjeto == '3') { ?><option selected value="3">3º</option><?php } else { ?><option value="3">3º</option><?php } ?>
                                <?php if ($semestreProjeto == '5') { ?><option selected value="5">5º</option><?php } else { ?><option value="5">5º</option><?php } ?>
                                <?php if ($semestreProjeto == '4') { ?><option selected value="4">4º</option><?php } else { ?><option value="4">4º</option><?php } ?>
                                <?php if ($semestreProjeto == '6') { ?><option selected value="6">6º</option><?php } else { ?><option value="6">6º</option><?php } ?>
                                <?php if ($semestreProjeto == '7') { ?><option selected value="7">7º</option><?php } else { ?><option value="7">7º</option><?php } ?>
                                <?php if ($semestreProjeto == '8') { ?><option selected value="8">8º</option><?php } else { ?><option value="8">8º</option><?php } ?>
                                <?php if ($semestreProjeto == '9') { ?><option selected value="9">9º</option><?php } else { ?><option value="9">9º</option><?php } ?>
                                <?php if ($semestreProjeto == '10') { ?><option selected value="10">10º</option><?php } else { ?><option value="10">10º</option><?php } ?>
                                <?php if ($semestreProjeto == '11') { ?><option selected value="11">11º</option><?php } else { ?><option value="11">11º</option><?php } ?>
                                <?php if ($semestreProjeto == '12') { ?><option selected value="12">12º</option><?php } else { ?><option value="12">12º</option><?php } ?>
                            </select>
                        </div>
                        <div class="fs-5 mt-1">
                            <?php echo '<input class="form-control" type="text" name="orientadorProjeto" value="'.$orientadorProjeto.'" pattern="[A-Za-zÀ-ú \']+" placeholder="Orientador" minlength="3" maxlength="50" required>' ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-3">
            <div class="mt-1 form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" name="resumoProjeto" id="floatingTextarea2" style="height: 200px" minlength="3" maxlength="2500" required><?= $resumoProjeto ?></textarea>
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
            <div>
                Arquivo PDF
            </div>


        </div>

        <div class="text-end">
            <input class="btn btn-light mt-2" type="submit" value="Enviar">
        </div>
    </form>
</div>