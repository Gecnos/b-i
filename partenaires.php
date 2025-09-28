<?php
$pageTitle = "Partenaires";
$activePage = "partenaires";

include 'includes/header.php'; 
?>

<main>
    <section class="partners-section" style="padding: 4rem 0;">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 2rem;">Nos Partenaires</h2>
            <p class="section-intro" style="text-align: center; max-width: 600px; margin: 0 auto 3rem auto;">
                Le Behanzin Institute collabore avec un réseau d'institutions académiques, d'organisations et d'experts pour enrichir ses recherches et étendre son impact.
            </p>
            
            <?php
            require_once 'includes/db.php'; 

            $stmt = $pdd->query('SELECT * FROM partenaires ORDER BY nom ASC');
            $partenaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="partners-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 2rem;">
                <?php if (empty($partenaires)): ?>
                    <p style="text-align: center; grid-column: 1 / -1;">Aucun partenaire à afficher pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($partenaires as $partenaire): ?>
                        <div class="partner-card" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); text-align: center; transition: all 0.3s ease;">
                            <a href="<?php echo htmlspecialchars($partenaire['site_web_url']); ?>" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: inherit;">
                                <img src="<?php echo htmlspecialchars($partenaire['logo_url'] ?: 'img/default-partner-logo.png'); ?>" alt="Logo de <?php echo htmlspecialchars($partenaire['nom']); ?>" style="width: 100%; height: 130px; object-fit: contain; filter: grayscale(100%); transition: filter 0.3s ease;">
                                <p style="margin-top: 1rem; font-weight: bold;"><?php echo htmlspecialchars($partenaire['nom']); ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<style>
.partner-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}
.partner-card:hover img {
    filter: grayscale(0%);
}
</style>

<?php
include 'includes/footer.php'; 
?>
