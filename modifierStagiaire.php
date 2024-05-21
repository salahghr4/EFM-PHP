
<?php 
require_once 'config.php';

session_start();

if(isset($_GET['id'])) {
    $sql = "SELECT * FROM stagiaire WHERE idFiliere = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $stagiaire = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       try {

        $sql = "UPDATE stagiaire set 
        nom = ?
        prenom = ?
        dateNaissance = ?
        photoProfil = ?
        intitule = ?";
        $stmt = $conn->prepare($sql);
        if($stmt->execute([$_POST['nom'], $_POST['prenom'], $_POST['dateNaissance'], "img/".$_FILES['photoProfil']['name'], $_POST['intitule']])) {
            $_SESSION['message'] = 'Le stagiaire à été modifier avec succès';
            header('Location: espaceprivee.php');
            exit;
        } else {
            $_SESSION['error'] = 'Erreur lors de la modification de le stagiaire';
        }

       } catch(PDOExecption $e) {
        echo $sql . "<br>" . $e->getMessage();
       }
    } else {
        $_SESSION['error'] = 'svp saisir tout les champs';
        header("Location: modifier.php?code=");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Modifier le Stagiaire</h1>
<a href="espaceprivee.php">Retour</a>
    <form action="InsererStagiaire.php" method='POST'>
        <fieldset>
            <h2>Ajouter un stagiaire</h2>
            <p>veullier remplir tous les champs</p>
            <label for="nom">Nom</label><br>
            <input type="text" name="nom" id="nom" value=<?= $stagiaire['nom']?>><br>
            <label for="prenom">PRENOM</label><br>
            <input type="text" name="prenom" id="prenom" value=<?= $stagiaire['prenom']?>><br>
            <label for="dateNaissance">DATE E NAISSANCE</label><br>
            <input type="date" name="dateNaissance" id="dateNaissance" value=<?= $stagiaire['dateNaissance']?>><br>
            <label for="photoProfil">PHOTO PROFIL</label><br>
            <input type="file" name="photoProfil" id="photoProfil"><br>
            <label for="filiere">Filiere</label><br>
            <select name="filiere" id="filiere">
                <?php foreach($result as $filiere):?>
                    <option value="<?=$filiere['idFiliere']?>"><?=$filiere['intitule']?></option>
                <?php endforeach; ?>
            </select><br>

            <input type="submit" value="Ajouter">

        </fieldset>
    </form>
    <p style='color:red;'>
        <?= isset($_SESSION['error']) ? $_SESSION['error'] : '' ?>
        <?php unset($_SESSION['error']); ?>
    </p>
</body>
</html>