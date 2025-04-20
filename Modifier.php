<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur</title>
    <link rel="stylesheet" href="style.css"> <!-- CSS séparé -->
</head>

<body>
    <div class="container">
        <h2>Modifier l'utilisateur</h2>

        <form id="modificationForm" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="cin">CIN:</label>
                <input type="text" id="cin" name="cin" value="AA123456" readonly>
                <span class="note">Le CIN ne peut pas être modifié</span>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value="">
                <span class="error" id="prenomError"></span>
            </div>

            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="">
                <span class="error" id="nomError"></span>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="">
                <span class="error" id="emailError"></span>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone:</label>
                <input type="text" id="telephone" name="telephone" value="">
                <span class="error" id="telephoneError"></span>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" placeholder="Entrez un nouveau mot de passe">
                <span class="error" id="passwordError"></span>
            </div>

            <div class="button-group">
                <button type="submit" class="submit-btn">Enregistrer les modifications</button>
            </div>
        </form>
    </div>

    <script>
        function validateForm() {
            let isValid = true;

            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            const prenom = document.getElementById('prenom').value.trim();
            if (prenom === '') {
                document.getElementById('prenomError').textContent = 'Le prénom est obligatoire';
                isValid = false;
            } else if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(prenom)) {
                document.getElementById('prenomError').textContent = 'Le prénom doit contenir uniquement des lettres';
                isValid = false;
            }

            const nom = document.getElementById('nom').value.trim();
            if (nom === '') {
                document.getElementById('nomError').textContent = 'Le nom est obligatoire';
                isValid = false;
            } else if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(nom)) {
                document.getElementById('nomError').textContent = 'Le nom doit contenir uniquement des lettres';
                isValid = false;
            }

            const email = document.getElementById('email').value.trim();
            if (email === '') {
                document.getElementById('emailError').textContent = 'L\'email est obligatoire';
                isValid = false;
            } else if (!email.endsWith('@gmail.com')) {
                document.getElementById('emailError').textContent = 'L\'email doit être au format @gmail.com';
                isValid = false;
            }

            const telephone = document.getElementById('telephone').value.trim();
            if (telephone === '') {
                document.getElementById('telephoneError').textContent = 'Le téléphone est obligatoire';
                isValid = false;
            } else if (!/^06\d{8}$/.test(telephone)) {
                document.getElementById('telephoneError').textContent = 'Le téléphone doit être au format 06XXXXXXXX';
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>
</html>
