<?php
include("./db/conexao.php");
date_default_timezone_set('America/Sao_Paulo');

// include('verifica_login.php');
if (!isset($_SESSION)) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5.2.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- BoxIcons 2.1.2 -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <!-- arquivo .css -->
    <link rel="stylesheet" href="css/estilo-padrao.css">

    <!-- arquivo .js -->
    <script src="js/script.js"></script>

    <title>Sistema Agendador 1.2</title>


</head>


<body>
    <header class="bg-light">

        <!-- Navbar Principal --->
        <nav class="navbar navbar-light bg-light">
            <div class="d-flex container-fluid p-2 text-light">
                <div class="text-black col-4">
                    <span class="mb-0 text-light"><a href="index.php?menuop=home"><img src="img/logo.png" class="img-fluid" alt="Logo" width="160"></a></span>
                </div>
                <div class="bd-highlight col-4 text-center">
                    <span class="text-black">
                        <h2><strong>Sistema Sala HUB</strong></h2>
                    </span>
                </div>
                <div class="text-black col-4 text-end">
                    <a href="logout.php"><i class='bx bx-log-out-circle bx-lg' style="color:#390d4a;"></i></a>
                </div>
            </div>
        </nav>

        <!-- Separador horizontal -->
        <div class="bg-ceub" style="height: 4px;"></div>

        <!-- Navbar debaixo -->
        <nav class="navbar navbar-expand-sm navbar-light bg-light shadow-sm">
            <!-- Container central -->
            <div class="container">
                <!-- Home Icon -->
                <a href="index.php?menuop=home" class="text-reset">
                    <h5><i class='bx bx-cube-alt d-inline-block align-bottom'></i></h5>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#toggleMobileMenu" aria-controls="toggleMobileMenu" aria-expanded="false" aria-lable="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Links principais -->
                <div class="collapse navbar-collapse" id="toggleMobileMenu">
                    <ul class="navbar-nav">
                        <li class="nav-item active"><a href="index.php?menuop=home" class="nav-link active">
                                <h5>Home&nbsp</h5>
                            </a></li>
                        <li class="nav-item "><a href="index.php?menuop=usuario" class="nav-link">
                                <h5>Usuários&nbsp</h5>
                            </a></li>
                        <li class="nav-item "><a href="index.php?menuop=agendamento" class="nav-link">
                                <h5>Agendamento&nbsp</h5>
                            </a></li>
                        <li class="nav-item"><a href="index.php?menuop=projetos" class="nav-link">
                                <h5>Projetos&nbsp</h5>
                            </a></li>
                    </ul>
                </div>
            </div>
        </nav>

    </header>
    <main>
        <div class="container-fluid g-0">

            <?php
            $menuop = (isset($_GET["menuop"])) ? $_GET["menuop"] : "home";

            // Casos para acessar os links
            switch ($menuop) {
                case 'home':
                    include("paginas/home/home.php");
                    break;

                case 'agendamento':
                    include("paginas/agendamento/agendamento.php");
                    break;

                case 'cad-agendamento':
                    include("paginas/agendamento/cad-agendamento.php");
                    break;

                case 'step1-agendamento':
                    include("paginas/agendamento/step1-agendamento.php");
                    break;

                case 'step2-agendamento':
                    include("paginas/agendamento/step2-agendamento.php");
                    break;

                case 'step3-agendamento':
                    include("paginas/agendamento/step3-agendamento.php");
                    break;

                case 'edit-step1-agendamento':
                    include("paginas/agendamento/edit-step1-agendamento.php");
                    break;

                case 'edit-step2-agendamento':
                    include("paginas/agendamento/edit-step2-agendamento.php");
                    break;

                case 'edit-step3-agendamento':
                    include("paginas/agendamento/edit-step3-agendamento.php");
                    break;

                case 'inserir-reserva':
                    include("paginas/agendamento/inserir-reserva.php");
                    break;

                case 'editar-agendamento':
                    include("paginas/agendamento/editar-agendamento.php");
                    break;

                case 'confirmar-excluir-agendamento':
                    include("paginas/agendamento/confirmar-excluir-agendamento.php");
                    break;

                case 'excluir-agendamento':
                    include("paginas/agendamento/excluir-agendamento.php");
                    break;

                case 'atualizar-agendamento':
                    include("paginas/agendamento/atualizar-agendamento.php");
                    break;

                case 'extra-step-agendamento':
                    include("paginas/agendamento/extra-step-agendamento.php");
                    break;

                case 'extra-edit-agendamento':
                    include("paginas/agendamento/extra-edit-agendamento.php");
                    break;

                case 'usuario':
                    include("paginas/usuario/usuario.php");
                    break;

                case 'cad-usuario':
                    include("paginas/usuario/cad-usuario.php");
                    break;

                case 'inserir-usuario':
                    include("paginas/usuario/inserir-usuario.php");
                    break;

                case 'editar-usuario':
                    include("paginas/usuario/editar-usuario.php");
                    break;

                case 'alterar-senha':
                    include("paginas/usuario/alterar-senha.php");
                    break;

                case 'atualizar-senha':
                    include("paginas/usuario/atualizar-senha.php");
                    break;

                case 'excluir-usuario':
                    include("paginas/usuario/excluir-usuario.php");
                    break;

                case 'atualizar-usuario':
                    include("paginas/usuario/atualizar-usuario.php");
                    break;

                case 'projetos':
                    include("paginas/projetos/projetos.php");
                    break;

                case 'criar-projetos':
                    include("paginas/projetos/criar-projetos.php");
                    break;

                case 'formulario-projetos':
                    include("paginas/projetos/formulario-projetos.php");
                    break;

                case 'info-projetos':
                    include("paginas/projetos/info-projetos.php");
                    break;

                case 'editar-projetos':
                    include("paginas/projetos/editar-projetos.php");
                    break;

                case 'formulario-editar-projetos':
                    include("paginas/projetos/formulario-editar-projetos.php");
                    break;

                case 'confirmar-excluir-projetos':
                    include("paginas/projetos/confirmar-excluir-projetos.php");
                    break;

                case 'excluir-projetos':
                    include("paginas/projetos/excluir-projetos.php");
                    break;

                case 'escolher-restaurar-projetos':
                    include("paginas/projetos/escolher-restaurar-projetos.php");
                    break;

                case 'restaurar-projetos':
                    include("paginas/projetos/restaurar-projetos.php");
                    break;

                case 'confirmar-deletar-projeto':
                    include("paginas/projetos/confirmar-deletar-projeto.php");
                    break;

                case 'deletar-projeto':
                    include("paginas/projetos/deletar-projeto.php");
                    break;

                case 'impressora':
                    include("paginas/impressora/impressora.php");
                    break;

                case 'impressora-step1':
                    include("paginas/impressora/impressora-step1.php");
                    break;

                case 'impressora-step2':
                    include("paginas/impressora/impressora-step2.php");
                    break;

                case 'impressora-step3':
                    include("paginas/impressora/impressora-step3.php");
                    break;

                case 'impressora-edit-step1':
                    include("paginas/impressora/impressora-edit-step1.php");
                    break;

                case 'impressora-edit-step2':
                    include("paginas/impressora/impressora-edit-step2.php");
                    break;

                case 'impressora-edit-step3':
                    include("paginas/impressora/impressora-edit-step3.php");
                    break;

                case 'impressora-confirmar-excluir':
                    include("paginas/impressora/impressora-confirmar-excluir.php");
                    break;

                case 'impressora-excluir':
                    include("paginas/impressora/impressora-excluir.php");
                    break;

                case 'monitores':
                    include("paginas/monitores/monitores.php");
                    break;

                case 'step1-monitores':
                    include("paginas/monitores/step1-monitores.php");
                    break;

                case 'step2-monitores':
                    include("paginas/monitores/step2-monitores.php");
                    break;

                case 'edit1-monitores':
                    include("paginas/monitores/edit1-monitores.php");
                    break;

                case 'edit2-monitores':
                    include("paginas/monitores/edit2-monitores.php");
                    break;

                case 'confirmar-excluir-monitores':
                    include("paginas/monitores/confirmar-excluir-monitores.php");
                    break;

                case 'excluir-monitores':
                    include("paginas/monitores/excluir-monitores.php");
                    break;


                case 'more':
                    include("paginas/more/more.php");
                    break;
                
        

                default:
                    include("paginas/home/home.php");
                    break;
            }
            ?>
        </div>
    </main>

    <!-- <div class="bg-ceub d-flex justify-content-start" style="color: white;">
        Feito por:
    </div> -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>


</body>

</html>