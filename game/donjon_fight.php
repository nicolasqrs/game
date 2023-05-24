<?php
require_once('./classes/gobelin.php');
require_once('./classes/géant.php');
require_once('./classes/dark_knight.php');
require_once('functions.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['perso'])) {
    header('Location: persos.php');
    exit();
}

// On crée un combat s'il n'y en a pas encore
if (!isset($_SESSION['fight'])) {
    $nb = random_int(0, 16);

    if ($nb <= 8) {
        $ennemi = new Gobelin();
    } elseif ($nb <= 10) {
        $ennemi = new DarkKnight();
    } elseif ($nb <= 12) {
        $ennemi = new Geant();
    }

    $_SESSION['fight']['ennemi'] = $ennemi;
    $_SESSION['fight']['html'][] = "Vous tombez sur un " . $ennemi->name . '.';
}

// On gère le tour de combat.
// L'ennemi tape en premier
if ($_SESSION['fight']['ennemi']->speed > $_SESSION['perso']['vit']) {
    $_SESSION['fight']['html'][] = $_SESSION['fight']['ennemi']->name . ' tape en premier';

    $touche = random_int(0, 20);
    $_SESSION['fight']['html'][] = $touche;

    if ($touche >= 9) {
        $_SESSION['fight']['html'][] = "Il vous touche.";
        $degat = random_int(0, $_SESSION['fight']['ennemi']->power) + floor($_SESSION['fight']['ennemi']->power/3);
        $_SESSION['fight']['html'][] = "Il vous inflige " . ($degat - floor($_SESSION['perso']['for']/3)) . " dégats";
        $_SESSION['perso']['pdv'] -= ($degat - floor($_SESSION['perso']['for']/3));
    } else {
        $_SESSION['fight']['html'][] = "Il vous rate.";
    }

    if ($_SESSION['perso']['pdv'] <= 0) {
        $_SESSION['fight']['html'][] = "Vous êtes mort.";
        header('Location: mort.php');
        exit();
    } else {
        $_SESSION['fight']['html'][] = "Vous attaquez";

        $touche = random_int(0, 20);
        $_SESSION['fight']['html'][] = $touche;

        if ($touche >= 9) {
            $_SESSION['fight']['html'][] = "Vous touchez votre ennemi.";
            $degat = random_int(0, 10) + floor($_SESSION['perso']['for']/3);

            $_SESSION['fight']['html'][] = "Vous lui infligez " . ($degat - floor($_SESSION['fight']['ennemi']->constitution/3)) . " dégats";
            $_SESSION['fight']['ennemi']->pol -=  ($degat - floor($_SESSION['fight']['ennemi']->constitution/3));

            if ($_SESSION['fight']['ennemi']->pol <= 0) {
                $_SESSION['perso']['gold'] += $_SESSION['fight']['ennemi']->gold;
                $_SESSION['perso']['xp'] += $_SESSION['fight']['ennemi']->xp;
                $_SESSION['fight']['html'][] = "Vous gagnez " . $_SESSION['fight']['ennemi']->gold . " Or";
                $_SESSION['fight']['html'][] = "Vous gagnez " . $_SESSION['fight']['ennemi']->xp . " xp";
                $_SESSION['fight']['html'][] = "Vous avez tué votre ennemi.";
            }
        } else {
            $_SESSION['fight']['html'][] = "Vous ratez votre ennemi.";
        }
    }
} else {
    $_SESSION['fight']['html'][] = $_SESSION['perso']['name'] . ' tape en premier';

    $touche = random_int(0, 20);
    $_SESSION['fight']['html'][] = $touche;

    if ($touche >= 9) {
        $_SESSION['fight']['html'][] = "Vous touchez votre ennemi.";
        $degat = random_int(0, 10) + floor($_SESSION['perso']['for']/3);
        $_SESSION['fight']['html'][] = "Il vous inflige " . ($degat - floor($_SESSION['fight']['ennemi']->constitution/3)) . " dégats";
        $_SESSION['fight']['ennemi']->pol -= ($degat - floor($_SESSION['fight']['ennemi']->constitution/3));

        if ($_SESSION['fight']['ennemi']->pol <= 0) {
            $_SESSION['perso']['gold'] += $_SESSION['fight']['ennemi']->gold;
            $_SESSION['perso']['xp'] += $_SESSION['fight']['ennemi']->xp;
            $_SESSION['fight']['html'][] = "Vous gagnez " . $_SESSION['fight']['ennemi']->gold . " Or";
            $_SESSION['fight']['html'][] = "Vous gagnez " . $_SESSION['fight']['ennemi']->xp . " xp";
            $_SESSION['fight']['html'][] = "Vous avez tué votre ennemi.";

            if ($_SESSION['perso']['xp'] >= 20) {
                $niveauxGagnes = floor($_SESSION['perso']['xp'] / 20);
                $_SESSION['perso']['niveau'] += 1;
            
                // Augmenter la valeur de 'for' à chaque niveau gagné
                $_SESSION['perso']['for'] += $niveauxGagnes;
            
                // Soustraire les points d'expérience gagnés
                $_SESSION['perso']['xp'] -= ($niveauxGagnes * 20);
            
                // Soustraire 20 points d'expérience supplémentaires pour chaque niveau gagné
                $_SESSION['perso']['xp'] -= 20;
            
                // Vérifier si l'expérience est devenue négative
                if ($_SESSION['perso']['xp'] < 0) {
                    $_SESSION['perso']['xp'] = 0; // Réinitialiser l'expérience à zéro
                }
            
                $_SESSION['fight']['html'][] = "Félicitations ! Vous avez atteint le niveau " . $_SESSION['perso']['niveau'] . ".";
            }
            
            
            
        } else {
            $_SESSION['fight']['html'][] = "Votre ennemi attaque";
            $touche = random_int(0, 20);
            $_SESSION['fight']['html'][] = $touche;

            if ($touche >= 9) {
                $_SESSION['fight']['html'][] = "Il vous touche.";
                $degat = random_int(0, $_SESSION['fight']['ennemi']->power) + floor($_SESSION['fight']['ennemi']->power/3);
                $_SESSION['fight']['html'][] = "Il vous inflige " . ($degat - floor($_SESSION['perso']['for']/3)) . " dégats";
                $_SESSION['perso']['pdv'] -=  ($degat - floor($_SESSION['perso']['for']/3));
            } else {
                $_SESSION['fight']['html'][] = "Il vous rate.";
            }
        }
    } else {
        $_SESSION['fight']['html'][] = "Vous ratez votre ennemi.";

        // Attaque de l'ennemi
        $_SESSION['fight']['html'][] = "Votre ennemi attaque";
        $touche = random_int(0, 20);
        $_SESSION['fight']['html'][] = $touche;

        if ($touche >= 9) {
            $_SESSION['fight']['html'][] = "Il vous touche.";
            $degat = random_int(0, $_SESSION['fight']['ennemi']->power) + floor($_SESSION['fight']['ennemi']->power/3);
            $_SESSION['fight']['html'][] = "Il vous inflige " . ($degat - floor($_SESSION['perso']['for']/3)) . " dégats";
            $_SESSION['perso']['pdv'] -=  ($degat - floor($_SESSION['perso']['for']/3));

            if ($_SESSION['perso']['pdv'] <= 0) {
                $_SESSION['fight']['html'][] = "Vous êtes mort.";
                header('Location: mort.php');
                exit();
            }
        } else {
            $_SESSION['fight']['html'][] = "Il vous rate.";
        }
    }
}

// Sauvegarde de l'état de votre personnage
$bdd = connect();
$sql = "UPDATE persos SET `gold` = :gold,`niveau` =:niveau , `pdv` = :pdv, `xp` = :xp, `for` = :for  WHERE id = :id AND user_id = :user_id;";
$sth = $bdd->prepare($sql);

$sth->execute([
    'gold'      => $_SESSION['perso']['gold'],
    'xp'        => $_SESSION['perso']['xp'],
    'niveau'    => $_SESSION['perso']['niveau'],
    'pdv'       => $_SESSION['perso']['pdv'],
    'for'       => $_SESSION['perso']['for'], // Ajout de 'for'
    'id'        => $_SESSION['perso']['id'],
    'user_id'   => $_SESSION['user']['id']
]);

// dd($_SESSION);

if ($_SESSION['perso']['pdv'] <= 0) {
    unset($_SESSION['perso']);
    unset($_SESSION['fight']);
    header('Location: persos.php');
    exit();
}

require_once('acceuil.php');
?>
<div class="container">
    <div class="row mt-4">
        <div class="px-4">
            <?php require_once('_persos.php'); ?>
        </div>
        <div class="">
            <h1>Combat</h1>
            <?php
            foreach ($_SESSION['fight']['html'] as $html) {
                echo '<p>' . $html . '</p>';
            }
            ?>

            <?php if ($_SESSION['fight']['ennemi']->pol > 0) { ?>
                <a class="btn btn-green" href="donjon_fight.php?id=<?php echo $_GET['id']; ?>">
                    Attaquer
                </a>
                <a class="btn btn-blue" href="donjon_play.php?id=<?php echo $_GET['id']; ?>">
                    Fuir
                </a>
            <?php } else { ?>
                <a class="btn btn-green" href="donjon_play.php?id=<?php echo $_GET['id']; ?>">
                    Continuer l'exploration
                </a>
            <?php } ?>
        </div>
        <div class="px-4">
            <?php require_once('_ennemi.php'); ?>
        </div>
    </div>
</div>
</body>

</html>
