
<?php $racine_site = '/b-i'; // Définit le dossier racine du site ?>
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
                        <?php
                        // On ne se connecte que si la variable $pdd n'existe pas déjà
                        if (!isset($pdd)) {
                            require_once 'includes/db.php';
                        }
                        $axes_menu_stmt = $pdd->query('SELECT id_axe, titre FROM axes ORDER BY code_axe ASC');
                        $axes_menu = $axes_menu_stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($axes_menu as $axe_item) {
                            echo '<li><a href="axe_detail.php?id=' . $axe_item['id_axe'] . '">' . htmlspecialchars($axe_item['titre']) . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                
                <li><a href="equipes.php" class="<?php if ($activePage === 'equipes') echo 'active'; ?>">Équipes</a></li>
                <li><a href="partenaires.php" class="<?php if ($activePage === 'partenaires') echo 'active'; ?>">Partenaires</a></li>
                <li><a href="contact.php" class="<?php if ($activePage === 'contact') echo 'active'; ?>">Contact</a></li>
            </ul>
            
            <div class="header-actions">
                <!-- <div class="search-container">
                    <input type="search" placeholder="Rechercher..." class="search-input" id="search-input">
                </div> -->
                <a href="https://research-journal.behanzin.org" target="_blank" class="research-journal-btn">
                    Behanzin Research Journal
                </a>
            </div>
            
            <button class="mobile-menu-toggle" id="mobile-menu-toggle">☰</button>
        </nav>
    </header>