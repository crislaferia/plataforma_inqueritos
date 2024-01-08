<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>LoginADMIN</title>
   <link rel="stylesheet" href="../css/style.css" />
   
</head>
<body>
    <div class="div">
        <div class="div-2">
          <img
            loading="lazy"
            srcset="https://cencal.pt/versions/v7.1.2.0/public/branding.501886354/logo.png?a=1698141962"
            class="img"
          />
            <div class="container">
                <form class="login-form" action="processa_login.php" method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" value="Login">
                    <a href="#" class="access">Não consegue aceder? Clique aqui.</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>