<?php
include('verifica_login.php');
?>

<?php

if(!isset($_GET['idAgenda'])){
    header('Location: index.php?menuop=agendamento');
    exit();
}

$idAgenda = $_GET["idAgenda"];

$sql = "SELECT * FROM tbagenda WHERE idAgenda = '{$idAgenda}'";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);
if ($dados["idUsuario"] != $_SESSION["usuario_id"] && $_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=agendamento');
    exit();
}
?>

<div class="container">


    <header>
        <h3>
            Editar Agenda
        </h3>
    </header>


    <div>
        <form action="index.php?menuop=atualizar-agendamento" method="post">
            <div class="mb-3">
                <label class="form-label" for="nomeAgenda">Nome</label>
                <input class="form-control" type="text" name="nomeAgenda" value="<?= $dados["nomeAgenda"] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="atividadeAgenda">Atividade</label>
                <input class="form-control" type="text" name="atividadeAgenda" value="<?= $dados["atividadeAgenda"] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="cursoAgenda">Curso</label>
                <input class="form-control" type="text" name="cursoAgenda" value="<?= $dados["cursoAgenda"] ?>" required>
            </div>
            <div class="row">
                <div class="mb-3 col-3">
                    <label class="form-label" for="bancadaTechAgenda">Bancadas Tech</label>
                    <select class="form-control" name="bancadaTechAgenda" id="bancadaTechAgenda" required>
                        <?php
                        if ($dados['bancadaTechAgenda'] == 0) {
                        ?><option selected>Número de Bancadas Tech</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        <?php
                        } else if ($dados['bancadaTechAgenda'] == 1) {
                        ?><option value>Número de Bancadas Tech</option>
                            <option selected="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        <?php
                        } else if ($dados['bancadaTechAgenda'] == 2) {
                        ?>
                            <option value>Número de Bancadas Tech</option>
                            <option value="1">1</option>
                            <option selected="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        <?php
                        } else if ($dados['bancadaTechAgenda'] == 3) {
                        ?>
                            <option value>Número de Bancadas Tech</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option selected="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        <?php
                        } else if ($dados['bancadaTechAgenda'] == 4) {
                        ?>
                            <option value>Número de Bancadas Tech</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option selected="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        <?php
                        } else if ($dados['bancadaTechAgenda'] == 5) {
                        ?>
                            <option value>Número de Bancadas Tech</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option selected="5">5</option>
                            <option value="6">6</option>
                        <?php
                        } else {
                        ?>
                            <option value>Número de Bancadas Tech</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option selected="6">6</option>
                        <?php
                        }


                        ?>
                    </select>
                </div>
                <div class="mb-3 col-3">
                    <label class="form-label" for="dataAgenda">Data e hora</label>
                    <input class="form-control" type="datetime-local" name="dataAgenda" value="<?= $dados["dataAgenda"] ?>" required>
                </div>
                <div class="invisible">
                    <label class="invisible" for="idAgenda">ID</label>
                    <input class="invisible" type="text" name="idAgenda" value="<?= $dados["idAgenda"] ?>" required>
                </div>
            </div>

            <div>
                <input class="btn btn-default" type="submit" value="Atualizar" name="btnAtualizar">
            </div>

        </form>
    </div>
</div>