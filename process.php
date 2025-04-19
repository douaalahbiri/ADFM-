<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Nom d'utilisateur par défaut pour phpMyAdmin
$password = ""; // Mot de passe par défaut (vide)
$dbname = "adfm"; // Nom de la base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4"); // Important pour les caractères accentués

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $cin = $_POST['cin'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $password = $_POST['password']; // Dans un cas réel, il faudrait hacher le mot de passe
    
    // Validation côté serveur
    $errors = [];
    
    // Validation CIN
    if (empty($cin)) {
        $errors[] = "Le CIN est obligatoire";
    }
    
    // Validation prénom
    if (empty($prenom)) {
        $errors[] = "Le prénom est obligatoire";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $prenom)) {
        $errors[] = "Le prénom doit contenir uniquement des lettres";
    }
    
    // Validation nom
    if (empty($nom)) {
        $errors[] = "Le nom est obligatoire";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nom)) {
        $errors[] = "Le nom doit contenir uniquement des lettres";
    }
    
    // Validation email
    if (empty($email)) {
        $errors[] = "L'email est obligatoire";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide";
    } elseif (!preg_match("/@gmail\.com$/", $email)) {
        $errors[] = "L'email doit être au format @gmail.com";
    }
    
    // Validation téléphone
    if (empty($telephone)) {
        $errors[] = "Le téléphone est obligatoire";
    } elseif (!preg_match("/^\d+$/", $telephone)) {
        $errors[] = "Le téléphone doit contenir uniquement des chiffres";
    }
    
    // Validation mot de passe
    if (empty($password)) {
        $errors[] = "Le mot de passe est obligatoire";
    }
    
    // S'il y a des erreurs, rediriger vers le formulaire avec les erreurs
    if (!empty($errors)) {
        $error_string = implode("<br>", $errors);
        header("Location: index.php?error=" . urlencode($error_string));
        exit();
    }
    
    // Préparer et exécuter la requête SQL pour insérer les données
    // Utiliser les noms de colonnes exacts et les entourer de backticks pour éviter les problèmes de syntaxe
    $stmt = $conn->prepare("INSERT INTO user (CIN, nom, `prénom`, email, `téléphone`, `mot de passe`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $cin, $nom, $prenom, $email, $telephone, $password);
    
    if ($stmt->execute()) {
        // Rediriger vers la page du tableau des utilisateurs
        header("Location: tableau.php");
        exit();
    } else {
        // Rediriger vers le formulaire avec un message d'erreur
        header("Location: index.php?error=Erreur lors de l'inscription: " . $stmt->error);
        exit();
    }
    
    $stmt->close();
}

$conn->close();
?>
