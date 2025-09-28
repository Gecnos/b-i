<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// --- All Logic Up Top ---
$action = $_GET['action'] ?? 'add';
$pageTitle = 'Ajouter un chercheur';
$submitButtonText = 'Ajouter';
$hidden_input_id = '';

$chercheur_data = [
    'id_chercheur' => '',
    'nom' => '',
    'prenom' => '',
    'titre' => '',
    'email' => '',
    'bio' => '',
    'photo_url' => '',
    'linkedin_url' => ''
];
$associated_axes_ids = [];

// Fetch all axes for the checkboxes
$axes_stmt = $pdd->query('SELECT id_axe, titre FROM axes ORDER BY titre ASC');
$all_axes = $axes_stmt->fetchAll(PDO::FETCH_ASSOC);

if ($action === 'edit' && isset($_GET['id'])) {
    $id_chercheur = $_GET['id'];
    $stmt = $pdd->prepare('SELECT * FROM chercheurs WHERE id_chercheur = ?');
    $stmt->execute([$id_chercheur]);
    $fetched_chercheur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fetched_chercheur) {
        $chercheur_data = $fetched_chercheur;
        $pageTitle = 'Modifier le chercheur';
        $submitButtonText = 'Mettre à jour';
        $hidden_input_id = '<input type="hidden" name="id_chercheur" value="' . htmlspecialchars($chercheur_data['id_chercheur']) . '">';

        // Fetch associated axes for this researcher
        $assoc_stmt = $pdd->prepare('SELECT id_axe FROM axes_chercheurs WHERE id_chercheur = ?');
        $assoc_stmt->execute([$id_chercheur]);
        $associated_axes_ids = $assoc_stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
}

$activePage = "gestion_chercheurs"; // For sidebar highlighting
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Administration</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            display: flex; /* Use flexbox for main layout */
            min-height: 100vh; /* Full viewport height */
        }
        .admin-header {
            background-color: #2c3e50; /* Darker header */
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 100%; /* Full width */
            position: fixed; /* Fixed header */
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .admin-header h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
        }
        .admin-header a {
            color: #ecf0f1;
            text-decoration: none;
            padding: 0.6rem 1.2rem;
            background-color: #e74c3c; /* Red for logout */
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .admin-header a:hover {
            background-color: #c0392b;
        }

        .sidebar {
            width: 250px;
            background-color: #34495e; /* Dark sidebar */
            color: white;
            padding-top: 80px; /* Space for fixed header */
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            flex-shrink: 0; /* Prevent shrinking */
        }
        .sidebar-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-nav li a {
            display: block;
            padding: 1rem 2rem;
            color: #ecf0f1;
            text-decoration: none;
            border-bottom: 1px solid #3f576e;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .sidebar-nav li a:hover, .sidebar-nav li a.active {
            background-color: #2c3e50;
            color: #3498db; /* Highlight color */
        }
        .sidebar-nav li:last-child a {
            border-bottom: none;
        }

        .main-content {
            flex-grow: 1; /* Take remaining space */
            padding: 80px 2rem 2rem 2rem; /* Space for fixed header */
            background-color: #f4f7f6;
        }
        .welcome-msg {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        .welcome-msg h2 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 1.8rem;
        }
        .welcome-msg p {
            color: #7f8c8d;
            line-height: 1.6;
        }
        /* General card style for future use */
        .card {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }
        /* Specific styles for content tables and forms */
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .content-header h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #2c3e50;
        }
        .add-new-btn {
            background-color: #28a745;
            color: white;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .add-new-btn:hover {
            background-color: #218838;
        }
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-width: 800px; /* Constrain width for forms */
            margin: 0 auto; /* Center the form */
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #34495e;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        .axes-checkboxes {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            max-height: 200px;
            overflow-y: auto;
        }
        .axes-checkboxes label {
            font-weight: normal;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .submit-btn {
            padding: 0.75rem 1.5rem;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .submit-btn:hover {
            background-color: #2980b9;
        }
        .current-image {
            max-width: 150px;
            max-height: 150px;
            display: block;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
        }
        .success-msg, .error-msg {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 5px;
            font-weight: bold;
        }
        .success-msg {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
        .error-msg {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <h1>Tableau de Bord Admin</h1>
        <a href="logout.php">Se déconnecter</a>
    </header>

    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul>
                <li><a href="index.php">Tableau de Bord</a></li>
                <li><a href="gestion_axes.php">Gérer les Axes</a></li>
                <li><a href="gestion_chercheurs.php" class="<?php echo ($activePage === 'gestion_chercheurs') ? 'active' : ''; ?>">Gérer les Chercheurs</a></li>
                <li><a href="gestion_partenaires.php">Gérer les Partenaires</a></li>
            </ul>
        </nav>
    </div>

    <div class="main-content">
        <div class="content-header">
            <h2><?php echo htmlspecialchars($pageTitle); ?></h2>
            <a href="gestion_chercheurs.php" class="add-new-btn" style="background-color: #6c757d;">Retour à la liste</a>
        </div>

        <div class="form-container">
            <form action="action_chercheur.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="<?php echo htmlspecialchars($action); ?>">
                <?php echo $hidden_input_id; ?>

                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($chercheur_data['nom']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($chercheur_data['prenom']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="titre">Titre (ex: Chercheur associé, Directeur...)</label>
                    <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($chercheur_data['titre']); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($chercheur_data['email']); ?>">
                </div>
                <div class="form-group">
                    <label for="bio">Biographie</label>
                    <textarea id="bio" name="bio"><?php echo htmlspecialchars($chercheur_data['bio']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="photo_url">Photo</label>
                    <?php if (!empty($chercheur_data['photo_url'])): ?>
                        <p>Photo actuelle :</p>
                        <img src="../<?php echo htmlspecialchars($chercheur_data['photo_url']); ?>" alt="Photo actuelle" class="current-image">
                    <?php endif; ?>
                    <input type="file" id="photo_url" name="photo_url" accept="image/png, image/jpeg, image/gif">
                    <input type="hidden" name="existing_photo_url" value="<?php echo htmlspecialchars($chercheur_data['photo_url']); ?>">
                    <p style="font-size: 0.9rem; color: #666;">Laissez vide pour conserver la photo actuelle.</p>
                </div>

                <div class="form-group">
                    <label for="linkedin_url">URL du profil LinkedIn</label>
                    <input type="text" id="linkedin_url" name="linkedin_url" value="<?php echo htmlspecialchars($chercheur_data['linkedin_url']); ?>">
                </div>

                <div class="form-group">
                    <label>Axes de recherche associés</label>
                    <div class="axes-checkboxes">
                        <?php if (empty($all_axes)): ?>
                            <p>Veuillez d'abord créer des axes de recherche.</p>
                        <?php else: ?>
                            <?php foreach ($all_axes as $axe_item): ?>
                                <label>
                                    <input type="checkbox" name="axes[]" value="<?php echo $axe_item['id_axe']; ?>" <?php echo in_array($axe_item['id_axe'], $associated_axes_ids) ? 'checked' : ''; ?>>
                                    <?php echo htmlspecialchars($axe_item['titre']); ?>
                                </label>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" class="submit-btn"><?php echo htmlspecialchars($submitButtonText); ?></button>
            </form>
        </div>
    </div>
</body>
</html>