<?php
// On démarre une session
session_start();

// On inclut la connexion à la base
require_once('connect.php');

$sql = 'SELECT * FROM `intervention`';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body><span style="text-align: center;">
    <main class="container">
        <div class="row">
            <section class="col-12">
                <br><br>
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <?php
                    if(!empty($_SESSION['message'])){
                        echo '<div class="alert alert-success" role="alert">
                                '. $_SESSION['message'].'
                            </div>';
                        $_SESSION['message'] = "";
                    }
                ?>
                <span style=" font-family: 'Roboto';"><h1> Liste des interventions</h1>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Type d'intervention</th>
                        <th>Date</th>
                        <th>Etages</th>
                    </thead></span>
                    <tbody>
                        <?php
                        // On boucle sur la variable result
                        foreach($result as $intervention){
                        ?>
                        <tr>
                            <td><?= $intervention['id_intervention'] ?></td>
                            <td><?= $intervention['type_intervention'] ?></td>
                            <td><?= $intervention['date_intervention'] ?></td>
                            <td><?= $intervention['etage_intervention'] ?></td>
                            <td><a href="edit.php?id=<?= $intervention['id_intervention'] ?>">Modifier</a> <a
                                    href="delete.php?id=<?= $intervention['id_intervention'] ?>">Supprimer</a></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="add.php" class="btn btn-primary">Ajouter une intervention</a>
            </section>
        </div>
    </main></span>
</body>

</html>