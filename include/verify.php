<?php 
require 'header.html';
require_once '../data/db.php';

// Vérifier si des paramètres sont présents dans l'URL et que c'est un GET et non autre
if ($_GET) {
    // Vérifier si l'e-mail est présent dans les paramètres
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
    } 

    // Vérifier si le jeton est présent dans les paramètres
    if (isset($_GET['token'])) {
        $token = $_GET['token'];
    }

    // Vérifier si l'e-mail et le jeton ne sont pas vides
    if (!empty($email) && !empty($token)) {
        // Préparer et exécuter une requête pour récupérer l'utilisateur avec l'e-mail et le jeton donnés
        $request = $bdd->prepare('SELECT * FROM users WHERE email=:email AND token=:token');
        $request->bindValue(':email', $email);
        $request->bindValue(':token', $token);
        $request->execute();

        // Obtenir le nombre de résultats
        $number = $request->rowCount();

        // Vérifier si un utilisateur correspondant a été trouvé
        if ($number === 1) {
            // Préparer et exécuter une requête pour mettre à jour l'utilisateur comme validé
            $update = $bdd->prepare('UPDATE users SET validation=:validation, token=:token WHERE email=:email');
            $update->bindValue(':validation', 1); // Une fois validé, on le passe à 1
            $update->bindValue(':token', 'Email Valid'); // Réinitialisation du champ de la table après validation
            $update->bindValue(':email', $email);

            // Exécuter la mise à jour
            $result = $update->execute();

            // Vérifier si la mise à jour a réussi
            if ($result) {
                // Afficher une alerte JavaScript indiquant que l'e-mail est valide
                echo '<script type="text/javascript"> alert("Your email is valid"); </script>';

                // Redirection vers la page form.php après 3 secondes
                header("Refresh: 3; URL=/index.php");
            }
        }
    }
}
?>
