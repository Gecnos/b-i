<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch all axes
$stmt = $pdd->query('SELECT * FROM axes ORDER BY titre ASC');
$axes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Gestion des Axes";
$activePage = "gestion_axes"; // For sidebar highlighting
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
        /* Specific styles for content tables */
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
        .content-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color: white;
            border-radius: 8px;
            overflow: hidden; /* Ensures rounded corners apply to children */
        }
        .content-table th, .content-table td {
            padding: 1rem;
            border: 1px solid #eee;
            text-align: left;
        }
        .content-table th {
            background-color: #ecf0f1;
            color: #2c3e50;
            font-weight: 600;
        }
        .content-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .content-table tr:hover {
            background-color: #f2f2f2;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .actions .edit {
            color: white;
            background-color: #3498db;
        }
        .actions .edit:hover {
            background-color: #2980b9;
        }
        .actions .delete {
            color: white;
            background-color: #e74c3c;
        }
        .actions .delete:hover {
            background-color: #c0392b;
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
                <li><a href="gestion_axes.php" class="<?php echo ($activePage === 'gestion_axes') ? 'active' : ''; ?>">Gérer les Axes</a></li>
                <li><a href="gestion_chercheurs.php">Gérer les Chercheurs</a></li>
                <li><a href="gestion_partenaires.php">Gérer les Partenaires</a></li>
            </ul>
        </nav>
    </div>

    <div class="main-content">
        <div class="content-header">
            <h2>Liste des axes de recherche</h2>
            <a href="form_axe.php?action=add" class="add-new-btn">Ajouter un axe</a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <p class="success-msg"><?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <p class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <table class="content-table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Code</th>
                    <th>Description Courte</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($axes)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Aucun axe de recherche trouvé.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($axes as $axe): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($axe['titre']); ?></td>
                            <td><?php echo htmlspecialchars($axe['code_axe']); ?></td>
                            <td><?php echo htmlspecialchars($axe['description_courte']); ?></td>
                            <td class="actions">
                                <a href="form_axe.php?action=edit&id=<?php echo $axe['id_axe']; ?>" class="edit">Modifier</a>
                                <a href="action_axe.php?action=delete&id=<?php echo $axe['id_axe']; ?>" class="delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet axe ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>