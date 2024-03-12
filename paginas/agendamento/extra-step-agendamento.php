<?php
include('verifica_login.php');
?>

<?php

// Se n existir algum dado, retorna
if (
    !isset($_POST['nomeAgenda']) || !isset($_POST['atividadeAgenda']) || !isset($_POST['cursoAgenda']) || !isset($_POST['dataAgenda']) ||
    !isset($_POST['bancadaTechAgenda']) || !isset($_POST['bancadaGeralAgenda']) || !isset($_POST['horaAgenda'])
) {
    header('Location: index.php?menuop=agendamento');
    exit();
}

// Adquirindo dados do usuários (NULOS ou do PASSO 2)
$nomeAgenda = $_POST['nomeAgenda'];
$atividadeAgenda = $_POST['atividadeAgenda'];
$cursoAgenda = $_POST['cursoAgenda'];
$dataAgenda = $_POST['dataAgenda'];
$bancadaTechAgenda = $_POST["bancadaTechAgenda"];
$bancadaGeralAgenda = $_POST["bancadaGeralAgenda"];
$horaAgenda = $_POST["horaAgenda"];

?>

<div class="container mb-5">
    <header>
        <div class="mt-3 text-center">
            <img src="img/progress3.png" class="img-fluid" width="1000 px" alt="">
        </div>
    </header>

    <body>
        <div class="mt-5">
            <form action="index.php?menuop=step3-agendamento" method="post">
                <div class="d-flex flex-wrap">
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Computador
                        </div>
                        <img src="img/pcPhoto.png" alt="PC" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Filamento FLA
                        </div>
                        <img src="img/filaVerm.png" alt="Filamento FLA vermelho" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Filamento FLA
                        </div>
                        <img src="img/filaAmar.png" alt="Filamento FLA amarelo" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Blocos de mármore
                        </div>
                        <img src="img/no-img.png" style="opacity: 0.3;" alt="Blocos de mármore" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Multímetro ET-1100
                        </div>
                        <img src="img/et-1100.png" alt="Multímetro ET-1100" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Multímetro MX-901
                        </div>
                        <img src="img/no-img.png" style="opacity: 0.3;" alt="MX-901" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Multímetro ET-3200
                        </div>
                        <img src="img/et-3200.jpg" alt="ET-3200" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Multímetro ET-1002
                        </div>
                        <img src="img/et-1002.png" alt="ET-1002" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Montana 680
                        </div>
                        <img src="img/montana.png" alt="Montana 680" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Ciclo das rochas (caixa)
                        </div>
                        <img src="img/no-img.png" style="opacity: 0.3;" alt="Ciclo das rochas" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Bateria 12V
                        </div>
                        <img src="img/bateria-12v.png" alt="Bateria 12V" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            GeoScope
                        </div>
                        <img src="img/no-img.png" style="opacity: 0.3;" alt="GeoScope" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Micr. p/ solda
                        </div>
                        <img src="img/mic-solda.png" alt="Micr. p/ solda" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Chave hex. Fêmea
                        </div>
                        <img src="img/chave-hex-f.jpg" alt="Chave hex. Fêmea" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10+</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Inversor 12-127 400W
                        </div>
                        <img src="img/inversor.png" alt="Inversor 12-127 400W" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Chave de Fenda
                        </div>
                        <img src="img/chave-fenda.jpg" alt="Chave de Fenda" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Tomada Alta Tensão
                        </div>
                        <img src="img/tomada-alta-tensao.jpg" alt="Tomada Alta Tensão" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Transformadores Pequenos
                        </div>
                        <img src="img/transformador-pequeno.jpg" alt="Transformadores Pequenos" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Caixa branca
                        </div>
                        <img src="img/caixa-branca.jpg" alt="Caixa branca" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center me-5 mb-4">
                        <div class="form-text">
                            Alicate bico
                        </div>
                        <img src="img/alicate-bico.png" alt="Alicate bico" class="reserva-icon">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                </div>

                <?php // Input invisível para enviar o dado idUsuario 
                ?>
                <div class="mt-4 d-flex flex-row-reverse">
                    <input type="hidden" name="nomeAgenda" value="<?= $nomeAgenda ?>">
                    <input type="hidden" name="atividadeAgenda" value="<?= $atividadeAgenda ?>">
                    <input type="hidden" name="cursoAgenda" value="<?= $cursoAgenda ?>">
                    <input type="hidden" name="dataAgenda" value="<?= $dataAgenda ?>">
                    <input type="hidden" name="horaAgenda" value="<?= $horaAgenda ?>">
                    <input type="hidden" name="bancadaTechAgenda" value="<?= $bancadaTechAgenda ?>">
                    <input type="hidden" name="bancadaGeralAgenda" value="<?= $bancadaGeralAgenda ?>">
                    <input class="btn btn-light" type="submit" value="Reservar">

            </form>
            <div class="me-2">
                <form action="index.php?menuop=step2-agendamento" method="post">
                    <input class="btn btn-outline-ceub" type="submit" value="Voltar">
                    <input type="hidden" name="nomeAgenda" value="<?= $nomeAgenda ?>">
                    <input type="hidden" name="atividadeAgenda" value="<?= $atividadeAgenda ?>">
                    <input type="hidden" name="cursoAgenda" value="<?= $cursoAgenda ?>">
                    <input type="hidden" name="dataAgenda" value="<?= $dataAgenda ?>">
                    <input type="hidden" name="horaAgenda" value="<?= $horaAgenda ?>">
                    <input type="hidden" name="bancadaTechAgenda" value="<?= $bancadaTechAgenda ?>">
                    <input type="hidden" name="bancadaGeralAgenda" value="<?= $bancadaGeralAgenda ?>">

                </form>
            </div>
        </div>
</div>

</body>
</div>