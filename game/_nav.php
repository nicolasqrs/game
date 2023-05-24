<ul id="nav"> 
    <?php if (!isset($_SESSION['user'])) { ?>
        <li><a href="register.php">Créer un compte</a></li>
        <li><a href="login.php">Connexion</a></li>
    <?php } else { ?>
        <a href="persos.php"><?php echo $_SESSION['user']['email'] ?></a>
        <a href="logout.php">déconnexion</a>
    <?php } ?>
</ul>