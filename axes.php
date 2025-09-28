<?php
$pageTitle = "Axes de recherche";
$activePage = "axes";

include 'includes/header.php'; 
?>

<main>
    <section class="axes-list-section" style="padding: 4rem 0;">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 2rem;">Nos Axes de Recherche</h2>
            <p class="section-intro" style="text-align: center; max-width: 700px; margin: 0 auto 3rem auto;">
                Le Behanzin Institute structure ses activités scientifiques autour de quatre axes de recherche principaux, conçus pour aborder de manière interdisciplinaire les enjeux contemporains.
            </p>
            
            <?php
            require_once 'includes/db.php'; 

            $stmt = $pdd->query('SELECT * FROM axes ORDER BY code_axe ASC');
            $axes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="axes-list-container">
                <?php if (empty($axes)): ?>
                    <p style="text-align: center;">Aucun axe de recherche à afficher pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($axes as $axe): ?>
                        <div class="axe-item" style="display: flex; align-items: center; background: white; padding: 2rem; margin-bottom: 2rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                            <?php if (!empty($axe['url_image'])): ?>
                                <div class="axe-image" style="flex: 0 0 200px; margin-right: 2rem;">
                                    <img src="<?php echo htmlspecialchars($axe['url_image']); ?>" alt="Image pour <?php echo htmlspecialchars($axe['titre']); ?>" style="width: 100%; height: auto; border-radius: 5px;">
                                </div>
                            <?php endif; ?>
                            <div class="axe-text" style="flex: 1;">
                                <h3><?php echo htmlspecialchars($axe['titre']); ?></h3>
                                <p><?php echo htmlspecialchars($axe['description_courte']); ?></p>
                                <a href="axe_detail.php?id=<?php echo $axe['id_axe']; ?>" class="read-more-btn" style="display: inline-block; margin-top: 1rem; text-decoration: none; background-color: #333; color: white; padding: 0.6rem 1.2rem; border-radius: 5px;">En savoir plus</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php
include 'includes/footer.php'; 
?>
