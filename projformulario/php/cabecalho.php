<div class="header-container">
    <a href="index.php">
        <img src="https://cencal.pt/versions/v7.1.2.0/public/branding.501886354/logo.png?a=1698141962" class="header-img">
    </a>
</div>

<div class="menu-links" style="font-family: Arial, sans-serif";>
    <?php
    
    if (isset($_SESSION['username'])) {
        $usernameCaps = strtoupper($_SESSION['username']);
        echo "<span class='link-id'>Bem-vindo, " . $usernameCaps . "!</span>";

        // Verificar se o utilizador é admin
        if (isset($_SESSION['admin']) && $_SESSION['admin']) {
            echo "<a class='link-dir' href='php/manage_user.php'>Utilizadores</a>";
        } /*else {
            echo "<p>Utilizador não é um administrador</p>";
        }*/ //verificar quem é utilizador

        echo "<a class='link-dir' href='php/logout.php'>Sair</a>";
        echo "<a class='link-dir'  href='php/sobre.php'>Sobre</a>";
    } else {
        echo "<a class='link-dir' href='loginadmin.php'>Login</a>";
    }
    ?>
</div>

