<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['intervention']) && !empty($_POST['intervention'])
    && isset($_POST['date']) && !empty($_POST['date'])
    && isset($_POST['etage']) && !empty($_POST['etage'])){
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $intervention = strip_tags($_POST['intervention']);
        $date = strip_tags($_POST['date']);
        $etage = strip_tags($_POST['etage']);

        $sql = 'INSERT INTO `intervention` (`id_intervention`,`type_intervention`, `date_intervention`, `etage_intervention`) VALUES (NULL, :intervention, :date, :etage);';

        $query = $db->prepare($sql);

        $query->bindValue(':intervention', $intervention, PDO::PARAM_STR);
        $query->bindValue(':date', $date, PDO::PARAM_STR);
        $query->bindValue(':etage', $etage, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "Intervention ajouté";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une intervention</title>

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
                <h1>Ajouter une intervention</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="intervention">Intervention</label>
                        <input type="text" id="intervention" name="intervention" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="etage">Etages</label>
                        <input type="number" id="etage" name="etage" class="form-control">
                    </div>
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>