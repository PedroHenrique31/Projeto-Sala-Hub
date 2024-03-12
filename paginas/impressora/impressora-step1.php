<?php
include('verifica_login.php');
?>

<?php

if (!isset($_SESSION['nome']) || !isset($_POST['cursoImpressora']) || !isset($_POST['semestreImpressora']) || !isset($_POST['dataImpressora'])) {
    header('Location: index.php?menuop=impressora');
    exit();
}

// Adquirindo dados do usuários (NULOS ou do PASSO 2)
$nomeImpressora = $_SESSION['nome'];
$cursoImpressora = $_POST['cursoImpressora'];
$semestreImpressora = $_POST['semestreImpressora'];
$dataImpressora = $_POST['dataImpressora'];
// $idUsuario = $_SESSION["usuario_id"];
?>

<div class="container">
    <header>
        <div class="mt-3 text-center">
            <img src="img/progress1.png" class="img-fluid" width="1000 px" alt="">
        </div>
    </header>

    <body>
        <div class="mt-3">
            <form action="index.php?menuop=impressora-step2" method="post">
                <div class="mb-3">
                    <i class="bi bi-person-fill"></i><label class="form-label bi" for="nomeImpressora">Organizador</label>
                    <?php if ($_SESSION['administrador'] != 1) {
                        echo "<input type='text' readonly class='form-control-plaintext readonly' name='nomeImpressora' value='$nomeImpressora'>";
                    } else {
                        echo '<input class="form-control" type="text" name="nomeImpressora" value="' . $nomeImpressora . '" pattern="[A-Za-zÀ-ú \']+" minlength="3" maxlength="30" required>';
                    } ?>
                </div>
                <div class="mb-3 col-4">
                    <label class="form-label" for="cursoImpressora">Curso</label>
                    <select class="form-select" aria-label="select" name="cursoImpressora" required>
                        <?php if ($cursoImpressora == '') { ?><option selected value="">Curso</option><?php } else { ?><option value="">Curso</option><?php } ?>
                        <?php if ($cursoImpressora == 'Administração') { ?><option selected value="Administração">Administração</option><?php } else { ?><option value="Administração">Administração</option><?php } ?>
                        <?php if ($cursoImpressora == 'Análise e Desenvolvimento de Sistemas') { ?><option selected value="Análise e Desenvolvimento de Sistemas">Análise e Desenvolvimento de Sistemas</option><?php } else { ?><option value="Análise e Desenvolvimento de Sistemas">Análise e Desenvolvimento de Sistemas</option><?php } ?>
                        <?php if ($cursoImpressora == 'Arquitetura e Urbanismo') { ?><option selected value="Arquitetura e Urbanismo">Arquitetura e Urbanismo</option><?php } else { ?><option value="Arquitetura e Urbanismo">Arquitetura e Urbanismo</option><?php } ?>
                        <?php if ($cursoImpressora == 'Biomedicina') { ?><option selected value="Biomedicina">Biomedicina</option><?php } else { ?><option value="Biomedicina">Biomedicina</option><?php } ?>
                        <?php if ($cursoImpressora == 'Ciência da Computação') { ?><option selected value="Ciência da Computação">Ciência da Computação</option><?php } else { ?><option value="Ciência da Computação">Ciência da Computação</option><?php } ?>
                        <?php if ($cursoImpressora == 'Ciência de dados e Machine Learning') { ?><option selected value="Ciência de dados e Machine Learning">Ciência de dados e Machine Learning</option><?php } else { ?><option value="Ciência de dados e Machine Learning">Ciência de dados e Machine Learning</option><?php } ?>
                        <?php if ($cursoImpressora == 'Ciências Biológicas') { ?><option selected value="Ciências Biológicas">Ciências Biológicas</option><?php } else { ?><option value="Ciências Biológicas">Ciências Biológicas</option><?php } ?>
                        <?php if ($cursoImpressora == 'Ciências Contábeis') { ?><option selected value="Ciências Contábeis">Ciências Contábeis</option><?php } else { ?><option value="Ciências Contábeis">Ciências Contábeis</option><?php } ?>
                        <?php if ($cursoImpressora == 'Direito') { ?><option selected value="Direito">Direito</option><?php } else { ?><option value="Direito">Direito</option><?php } ?>
                        <?php if ($cursoImpressora == 'Educação Física') { ?><option selected value="Educação Física">Educação Física</option><?php } else { ?><option value="Educação Física">Educação Física</option><?php } ?>
                        <?php if ($cursoImpressora == 'Enfermagem') { ?><option selected value="Enfermagem">Enfermagem</option><?php } else { ?><option value="Enfermagem">Enfermagem</option><?php } ?>
                        <?php if ($cursoImpressora == 'Engenharia Civil') { ?><option selected value="Engenharia Civil">Engenharia Civil</option><?php } else { ?><option value="Engenharia Civil">Engenharia Civil</option><?php } ?>
                        <?php if ($cursoImpressora == 'Engenharia de Computação') { ?><option selected value="Engenharia de Computação">Engenharia de Computação</option><?php } else { ?><option value="Engenharia de Computação">Engenharia de Computação</option><?php } ?>
                        <?php if ($cursoImpressora == 'Engenharia Elétrica') { ?><option selected value="Engenharia Elétrica">Engenharia Elétrica</option><?php } else { ?><option value="Engenharia Elétrica">Engenharia Elétrica</option><?php } ?>
                        <?php if ($cursoImpressora == 'Fisioterapia') { ?><option selected value="Fisioterapia">Fisioterapia</option><?php } else { ?><option value="Fisioterapia">Fisioterapia</option><?php } ?>
                        <?php if ($cursoImpressora == 'Jornalismo') { ?><option selected value="Jornalismo">Jornalismo</option><?php } else { ?><option value="Jornalismo">Jornalismo</option><?php } ?>
                        <?php if ($cursoImpressora == 'Marketing') { ?><option selected value="Marketing">Marketing</option><?php } else { ?><option value="Marketing">Marketing</option><?php } ?>
                        <?php if ($cursoImpressora == 'Medicina') { ?><option selected value="Medicina">Medicina</option><?php } else { ?><option value="Medicina">Medicina</option><?php } ?>
                        <?php if ($cursoImpressora == 'Medicina Veterinária') { ?><option selected value="Medicina Veterinária">Medicina Veterinária</option><?php } else { ?><option value="Medicina Veterinária">Medicina Veterinária</option><?php } ?>
                        <?php if ($cursoImpressora == 'Nutrição') { ?><option selected value="Nutrição">Nutrição</option><?php } else { ?><option value="Nutrição">Nutrição</option><?php } ?>
                        <?php if ($cursoImpressora == 'Psicologia') { ?><option selected value="Psicologia">Psicologia</option><?php } else { ?><option value="Psicologia">Psicologia</option><?php } ?>
                        <?php if ($cursoImpressora == 'Publicidade e Propaganda') { ?><option selected value="Publicidade e Propaganda">Publicidade e Propaganda</option><?php } else { ?><option value="Publicidade e Propaganda">Publicidade e Propaganda</option><?php } ?>
                        <?php if ($cursoImpressora == 'Relações Internacionais') { ?><option selected value="Relações Internacionais">Relações Internacionais</option><?php } else { ?><option value="Relações Internacionais">Relações Internacionais</option><?php } ?>
                    </select>
                </div>
                <div class="row">
                    <div class="mb-3 col-3">
                        <label class="form-label" for="semestreImpressora">Semestre</label>
                        <select class="form-select" aria-label="select" name="semestreImpressora" required>
                            <?php if ($semestreImpressora == '') { ?><option selected value="">Semestre</option><?php } else { ?><option value="">Semestre</option><?php } ?>
                            <?php if ($semestreImpressora == '1') { ?><option selected value="1">1º</option><?php } else { ?><option value="1">1º</option><?php } ?>
                            <?php if ($semestreImpressora == '2') { ?><option selected value="2">2º</option><?php } else { ?><option value="2">2º</option><?php } ?>
                            <?php if ($semestreImpressora == '3') { ?><option selected value="3">3º</option><?php } else { ?><option value="3">3º</option><?php } ?>
                            <?php if ($semestreImpressora == '5') { ?><option selected value="5">5º</option><?php } else { ?><option value="5">5º</option><?php } ?>
                            <?php if ($semestreImpressora == '4') { ?><option selected value="4">4º</option><?php } else { ?><option value="4">4º</option><?php } ?>
                            <?php if ($semestreImpressora == '6') { ?><option selected value="6">6º</option><?php } else { ?><option value="6">6º</option><?php } ?>
                            <?php if ($semestreImpressora == '7') { ?><option selected value="7">7º</option><?php } else { ?><option value="7">7º</option><?php } ?>
                            <?php if ($semestreImpressora == '8') { ?><option selected value="8">8º</option><?php } else { ?><option value="8">8º</option><?php } ?>
                            <?php if ($semestreImpressora == '9') { ?><option selected value="9">9º</option><?php } else { ?><option value="9">9º</option><?php } ?>
                            <?php if ($semestreImpressora == '10') { ?><option selected value="10">10º</option><?php } else { ?><option value="10">10º</option><?php } ?>
                            <?php if ($semestreImpressora == '11') { ?><option selected value="11">11º</option><?php } else { ?><option value="11">11º</option><?php } ?>
                            <?php if ($semestreImpressora == '12') { ?><option selected value="12">12º</option><?php } else { ?><option value="12">12º</option><?php } ?>
                        </select>
                    </div>
                    <div class="mb-3 col-3">
                        <label class="form-label" for="dataImpressora">Data</label>
                        <input class="form-control" type="date" name="dataImpressora" value="<?= $dataImpressora ?>" required>
                    </div>
                    <div class="row g-0">
                        <div class="col-3"></div>
                        <div class="alert col alert-warning alert-dismissible fade show align-items-center d-flex flex-row p-2" role="alert">
                            <i class='bx bxs-error-circle bx-sm me-2'></i>
                            <div>
                                Só serão aceitas reservas com pelo menos <br><strong>1 dia, até 1 mês</strong> de antecedência
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class=" col text-end">
                            <input class="btn btn-light mt-2" type="submit" value="Próximo">
                        </div>
                    </div>

                </div>
                <?php // Input invisível para enviar o dado idUsuario 
                ?>
                <input type="hidden" name="deHoraImpressora" value="">
                <input type="hidden" name="ateHoraImpressora" value="">
            </form>
        </div>

    </body>
</div>