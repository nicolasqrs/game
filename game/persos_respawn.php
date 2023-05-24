<?php
require_once('functions.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}

if (!isset($_GET['id'])) {
    header('Location: persos.php?msg=id non passé !');
}

$bdd = connect();

$sql = "SELECT * FROM persos WHERE id = :id AND user_id = :user_id;";
$sth = $bdd->prepare($sql);
        
$sth->execute([
    'id'          => $_GET['id'],
    'user_id'     => $_SESSION['user']['id']
]);

$perso = $sth->fetch();

if ($perso['gold'] >= 50) {
    $newGold = $perso['gold'] - 50;
    $newPdv = 20;

    $sql = "UPDATE persos SET `gold` = :gold, `pdv` = :pdv WHERE id = :id AND xp = :xp AND user_id = :user_id;";
    $sth = $bdd->prepare($sql);

    $sth->execute([
        'gold'      => $newGold,
        'pdv'       => $newPdv,
        'id'        => $perso['id'],
        'xp'        => $perso['xp'],
        'user_id'   => $_SESSION['user']['id']
    ]);

    header('Location: persos.php?msg=perso de retour !');
} else {
    header('Location: persos.php?msg=Pas assez d\'or pour la résurrection !');
    exit();
}
