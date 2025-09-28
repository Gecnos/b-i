<?php
session_start();

// Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Administration</title>
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
                <li><a href="index.php" class="active">Tableau de Bord</a></li>
                <li><a href="gestion_axes.php">Gérer les Axes</a></li>
                <li><a href="gestion_chercheurs.php">Gérer les Chercheurs</a></li>
                <li><a href="gestion_partenaires.php">Gérer les Partenaires</a></li>
            </ul>
        </nav>
    </div>

    <div class="main-content">
        <div class="welcome-msg">
            <h2>Bonjour, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?> !</h2>
            <p>Bienvenue dans le panneau d'administration. Utilisez le menu latéral pour naviguer entre les différentes sections de gestion.</p>
        </div>

        <!-- Future dashboard widgets or summary can go here -->
        <div class="card">
            <h3>Statistiques Rapides</h3>
            <p>Nombre d'axes: X</p>
            <p>Nombre de chercheurs: Y</p>
            <p>Nombre de partenaires: Z</p>
        </div>
    </div>
</body>
</html>