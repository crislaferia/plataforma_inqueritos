<div class="header-container">
    <a href="index.php">
        <img src="https://cencal.pt/versions/v7.1.2.0/public/branding.501886354/logo.png?a=1698141962" class="header-img">
    </a>
</div>

<div class="menu-links">
    <?php
    
    if (isset($_SESSION['username'])) {
        $usernameCaps = strtoupper($_SESSION['username']);
        echo "<span>Bem-vindo, " . $usernameCaps . "!</span>";

        // Verificar se o utilizador é admin
        if (isset($_SESSION['admin']) && $_SESSION['admin']) {
            echo "<a class='link-dir' href='php/manage_user.php'>Utilizadores</a>";
        } else {
            echo "<p>Utilizador não é um administrador</p>";
        }

        echo "<a class='link-dir' href='php/logout.php'>Sair</a>";
    } else {
        echo "<a class='link-dir' href='loginadmin.php'>Login</a>";
    }
    ?>
</div>
