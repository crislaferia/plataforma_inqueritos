<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Texte Index</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <style>
        /* Adicione estilos específicos */

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        header {
            background-color: #2c2e3e;
            color: white;
            padding: 20px;
            padding-left: 30px;
            padding-right: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 2; /* Garante que o header esteja acima dos outros elementos */
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img {
            width: 120px;
            height: 100px;
        }

        .link-dir {
            color: white;
            font: 350 22px Inter, sans-serif;
            margin-left: 20px;
        }

        nav {
            width: 220px;
            background-color: #2c2e3e;
            padding: 15px;
            height: 75vh;
            color: #fff;
            font: 350 24px Inter, sans-serif;
            text-decoration: none;
            z-index: 1; /* Garante que o nav esteja acima da section */
        }

        .sectionhome {
            flex: 1;
            padding: 20px;
            background-color: #F5F8FA;
            display: flex;
            flex-direction: column;
            margin-left: 240px;
            z-index: 0; /* Garante que a section esteja abaixo do nav */
        }

        footer {
            background-color: #2c2e3e;
            color: white;
            padding: 10px;
            text-align: center;
            margin-top: auto; /* Empurra o footer para a parte inferior */
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <img src="https://cencal.pt/versions/v7.1.2.0/public/branding.501886354/logo.png?a=1698141962" alt="Logo">

            <div>
                <a class="link-dir" href="php\formresp.php">Os meus formulários</a>
                <a class="link-dir" href="php\loginadmin.php">Login ADMIN</a>
                <a class="link-dir" href="php\loginuser.php">Login USER</a>
                <a class="link-dir" href="php\adeus.php">Sair</a>
            </div>
        </div>
    </header>

    <div style="display: flex;">
        <nav>
            <!-- Seu conteúdo nav aqui -->
            <div class="menu">
                <div class="menu-item">
                    <img src="img/Vector.png">
                    <a href="index.php" class="menu-link" aria-current="page">Inicio</a>
                </div>
                <div class="menu-item">
                    <img src="img/Vector2.png">
                    <div class="dropdown">
                        <a href="teste3.php" class="menu-link">Formulários</a>
                        <div class="dropdown-content">
                            <a href="#" class="dropdown-item">Criar</a>
                            <a href="#" class="dropdown-item">Consultar</a>
                        </div>
                    </div>
                </div>
                <div class="menu-item">
                    <img src="img/Frame.png">
                    <a href="teste2.php" class="menu-link">Estatisticas</a>
                </div>
            </div>
        </nav>

        <section class="sectionhome">
            <!-- Seu conteúdo section aqui -->
            <div class="white-box"></div>

            <div class="menu-item inicio">Inicio</div>
            <div class="menu-item formularios">Formulários</div>
            <div class="menu-item estatisticas">Estatisticas</div>

            <div class="content-box"></div>

            <div class="welcome-message">Bem vindo @user</div>
            <div class="recent-forms">Formulários recentes</div>
            <div class="form-list">
                <!-- Lista de formulários aqui -->
                <div class="form-item">
                    <div class="form-title">Formulário 1</div>
                    <div class="form-date">Data: 01/01/2023</div>
                </div>
                <div class="form-item">
                    <div class="form-title">Formulário 2</div>
                    <div class="form-date">Data: 02/01/2023</div>
                </div>
                <!-- Adicione mais formulários conforme necessário -->
            </div>
        </section>
    </div>

    <footer>
        <p>Seu Rodapé</p>
    </footer>
</body>

</html>
