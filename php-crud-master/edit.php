<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['intervention']) && !empty($_POST['intervention'])
    && isset($_POST['date']) && !empty($_POST['date'])
    && isset($_POST['etage']) && !empty($_POST['etage'])){
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['id']);
        $intervention = strip_tags($_POST['intervention']);
        $date = strip_tags($_POST['date']);
        $etage = strip_tags($_POST['etage']);

        $sql = 'UPDATE `intervention` SET `id_intervention`=:id,`type_intervention`=:intervention, `date_intervention`=:date, `etage_intervention`=:etage WHERE `intervention`.`id_intervention`=:id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':intervention', $intervention, PDO::PARAM_STR);
        $query->bindValue(':date', $date, PDO::PARAM_STR);
        $query->bindValue(':etage', $etage, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "Intervention modifié";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `intervention` WHERE `id_intervention` = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $intervention = $query->fetch();

    // On vérifie si le produit existe
    if(!$intervention){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une intervention</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <br><br>
                <h1>Modifier une intervention</h1>
                <br><br>
                <form method="post">
                    <div class="form-group">
                        <label for="intervention">Intervention</label>
                        <input type="text" id="intervention" name="intervention" class="form-control" value="<?= $intervention['type_intervention']?>">
                    </div>
                    <div class="form-group">
                        <label for="date">date</label>
                        <input type="date" id="date" name="date" class="form-control" value="<?= $intervention['date_intervention']?>">

                    </div>
                    <div class="form-group">
                        <label for="etage">Etages</label>
                        <input type="number" id="etage" name="etage" class="form-control" value="<?= $intervention['etage_intervention']?>">
                    </div>
                    <input type="hidden" value="<?= $intervention['id_intervention']?>" name="id">
                    <button class="btn btn-primary">Envoyer</button>
                    <a href="index.php" class="btn btn-primary">Retour</a>
                </form>
            </section>
        </div>
    </main>
</body>
</html>