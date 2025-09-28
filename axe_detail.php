<?php
require_once 'includes/db.php';

// Validate ID
$id_axe = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id_axe) {
    header("Location: axes.php");
    exit;
}

// Fetch axis details
$stmt_axe = $pdd->prepare('SELECT * FROM axes WHERE id_axe = ?');
$stmt_axe->execute([$id_axe]);
$axe = $stmt_axe->fetch(PDO::FETCH_ASSOC);

// If axis not found, redirect
if (!$axe) {
    header("Location: axes.php");
    exit;
}

// Fetch associated researchers
$stmt_chercheurs = $pdd->prepare('
    SELECT c.* 
    FROM chercheurs c
    JOIN axes_chercheurs ac ON c.id_chercheur = ac.id_chercheur
    WHERE ac.id_axe = ?
    ORDER BY c.nom, c.prenom
');
$stmt_chercheurs->execute([$id_axe]);
$chercheurs_associes = $stmt_chercheurs->fetchAll(PDO::FETCH_ASSOC);


$pageTitle = $axe['titre'];
// Set $activePage to 'axes' to highlight the parent menu item
$activePage = "axes"; 

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-axe" style="
    background-image: url('<?php echo htmlspecialchars($axe['url_image'] ?: 'img/default-axe-image.jpg'); ?>');
    background-size: cover;
    background-position: center;
    color: white;
    padding: 6rem 0;
    text-align: center;
    position: relative;
">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
    <div class="container" style="position: relative; z-index: 2;">
        <h1 style="font-size: 3rem; margin: 0;"><?php echo htmlspecialchars($axe['titre']); ?></h1>
    </div>
</section>

<main>
    <section class="axe-detail-section" style="padding: 4rem 0;">
        <div class="container">
            
            <article class="axe-content" style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); margin-bottom: 3rem;">
                <div class="axe-description" style="line-height: 1.7;">
                    <?php echo nl2br(htmlspecialchars($axe['description_complete'])); ?>
                </div>
            </article>

            <?php if (!empty($chercheurs_associes)): ?>
                <section class="associated-researchers">
                    <h2 style="margin-bottom: 2rem; border-bottom: 2px solid #eee; padding-bottom: 1rem;">Chercheurs associés à cet axe</h2>
                    <div class="team-grid">
                        <?php foreach ($chercheurs_associes as $chercheur): ?>
                            <div class="team-member">
                                <img src="<?php echo htmlspecialchars($chercheur['photo_url'] ?: 'img/default-avatar.png'); ?>" alt="Photo de <?php echo htmlspecialchars($chercheur['prenom'] . ' ' . $chercheur['nom']); ?>" class="team-photo">
                                <h3><?php echo htmlspecialchars($chercheur['prenom'] . ' ' . $chercheur['nom']); ?></h3>
                                <p class="team-title"><?php echo htmlspecialchars($chercheur['titre']); ?></p>
                                <div class="team-social">
                                    <?php if (!empty($chercheur['linkedin_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($chercheur['linkedin_url']); ?>" target="_blank" rel="noopener noreferrer">in</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

        </div>
    </section>
</main>

<?php
include 'includes/footer.php';
?>
