<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau des Utilisateurs</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            padding: 10px;
            display: block;
        }
        
        .container {
            max-width: 90%;
            width: 1200px;
            margin: 20px auto;
        }
        
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 16px;
        }
        
        th, td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #4a90e2;
            color: white;
            font-weight: 600;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .back-btn, .action-btn {
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 5px;
        }
        
        .back-btn {
            margin-top: 20px;
            padding: 10px 15px;
            font-size: 16px;
        }
        
        .action-btn.delete {
            background-color: #e74c3c;
        }
        
        .action-btn:hover, .back-btn:hover {
            opacity: 0.9;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        
        .actions-cell {
            white-space: nowrap;
        }
        
        h2 {
            font-size: 28px;
            margin-bottom: 30px;
        }
        
        .success-message {
            background-color: #e8f5e9;
            color: #43a047;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #43a047;
            font-size: 16px;
        }
        
        .error-message {
            background-color: #ffebee;
            color: #e53935;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #e53935;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tableau des Utilisateurs</h2>
        
        <?php
        // Afficher les messages de succès ou d'erreur
        if (isset($_GET['success'])) {
            echo '<div class="success-message">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        if (isset($_GET['error'])) {
            echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>CIN</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Connexion à la base de données
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "adfm";
                    
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    $conn->set_charset("utf8mb4"); // Important pour les caractères accentués
                    
                    if ($conn->connect_error) {
                        die("La connexion a échoué: " . $conn->connect_error);
                    }
                    
                    // Vérifier s'il y a une demande de suppression
                    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
                        $cin_to_delete = $_GET['delete'];
                        
                        // Préparer la requête de suppression
                        $delete_stmt = $conn->prepare("DELETE FROM user WHERE CIN = ?");
                        $delete_stmt->bind_param("i", $cin_to_delete);
                        
                        if ($delete_stmt->execute()) {
                            echo '<div class="success-message">Utilisateur supprimé avec succès!</div>';
                        } else {
                            echo '<div class="error-message">Erreur lors de la suppression: ' . $delete_stmt->error . '</div>';
                        }
                        
                        $delete_stmt->close();
                    }
                    
                    // Récupérer tous les utilisateurs
                    $sql = "SELECT CIN, `prénom`, nom, email, `téléphone` FROM user";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        // Afficher les données de chaque utilisateur
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["CIN"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["prénom"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["nom"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["téléphone"]) . "</td>";
                            echo "<td class='actions-cell'>";
                            echo "<a href='modifier.php?cin=" . $row["CIN"] . "' class='action-btn'>Modifier</a>";
                            echo "<a href='javascript:void(0)' onclick='confirmDelete(" . $row["CIN"] . ")' class='action-btn delete'>Supprimer</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='no-data'>Aucun utilisateur trouvé</td></tr>";
                    }
                    
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
        
        <a href="index.php" class="back-btn">Retour au formulaire</a>
    </div>
    
    <script>
        function confirmDelete(cin) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
                window.location.href = "tableau.php?delete=" + cin;
            }
        }
    </script>
</body>
</html>
