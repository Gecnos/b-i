<?php
$pageTitle = "";
$activePage = "accueil";
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Behanzin Institute</title>
    <meta name="description" content="Découvrez les équipes de recherche du Behanzin Institute et leurs expertises scientifiques.">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

    <header class="header" id="header">
        <nav class="nav-container">
            <a href="index.php" class="logo">Behanzin Institute</a>
            
            <ul class="nav-menu">
                <li><a href="index.php" class="<?php if ($activePage === 'accueil') echo 'active'; ?>">Accueil</a></li>
                
                <li class="nav-dropdown-item">
                    <a href="axes.php" class="<?php if ($activePage === 'axes') echo 'active'; ?>">Axes</a>
                    <ul class="dropdown-content">
                        <li><a href="axes1.php">Dynamiques sociales, démographiques et transformations culturelles</a></li>
                        <li><a href="axes2.php">Sécurité, conflictualités et reconstruction post-crise</a></li>
                        <li><a href="axes3.php">Géopolitique, ressources et relations internationales</a></li>
                        <li><a href="axes4.php">Gouvernance, justice sociale et droits humains</a></li>
                    </ul>
                </li>
                
                <li><a href="equipes.php" class="<?php if ($activePage === 'equipes') echo 'active'; ?>">Équipes</a></li>
                <li><a href="partenaires.php" class="<?php if ($activePage === 'partenaires') echo 'active'; ?>">Partenaires</a></li>
                <li><a href="contact.php" class="<?php if ($activePage === 'contact') echo 'active'; ?>">Contact</a></li>
            </ul>
            
            <div class="header-actions">
                <div class="search-container">
                    <input type="search" placeholder="Rechercher..." class="search-input" id="search-input">
                </div>
                <a href="https://research-journal.behanzin.org" target="_blank" class="research-journal-btn">
                    Behanzin Research Journal
                </a>
            </div>
            
            <button class="mobile-menu-toggle" id="mobile-menu-toggle">☰</button>
        </nav>
    </header>