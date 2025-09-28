<?php
require_once '../includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (empty($username) || empty($password) || empty($email)) {
        $message = 'Veuillez remplir tous les champs.';
    } else {
        // Check if user already exists
        $stmt = $pdd->prepare('SELECT * FROM utilisateurs WHERE nom_utilisateur = ? OR email = ?');
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $message = 'Ce nom d\'utilisateur ou cet email existe déjà.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdd->prepare('INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, email) VALUES (?, ?, ?)');
            if ($stmt->execute([$username, $hashed_password, $email])) {
                $message = 'Utilisateur administrateur créé avec succès ! Vous pouvez maintenant vous connecter. Veuillez supprimer ce fichier (register.php) pour des raisons de sécurité.';
            } else {
                $message = 'Une erreur est survenue lors de la création de l\'utilisateur.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Inscription</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f5f5f5; }
        .register-container { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .register-container h1 { text-align: center; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; }
        .message { margin-bottom: 1rem; text-align: center; }
        .submit-btn { width: 100%; padding: 0.75rem; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; }
        .submit-btn:hover { background-color: #218838; }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Créer un administrateur</h1>
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Créer l'utilisateur</button>
        </form>
    </div>
</body>
</html>