
<?php
    require 'includes/functions.php';

    $login = new DbHelper();

    if(isset ($_REQUEST['login'])){
        $login-> selectUser();
    }
?>

<html>

<head>
    <title>Log in</title>

    <script type="text/javascript" src="index.js"></script>

    <link rel="stylesheet" type="text/css" href="css/index.css" />
</head>

<body>
    <div class="login">
  <div class="login-triangle"></div>
  
  <h2 class="login-header">Log in</h2>

  <form class="login-container">
    <p><input type="email" placeholder="Gebruikersnaam"></p>
    <p><input type="password" placeholder="Wachtwoord"></p>
    <p><input type="submit" value="Log in"></p>
  </form>
</div>
</body>

</html>
