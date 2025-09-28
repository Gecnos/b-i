<?php
$pageTitle = "Équipes";
$activePage = "equipes";

include 'includes/header.php'; 
?>

<main>
    <section class="team-section" style="padding: 4rem 0;">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 2rem;">Notre Équipe</h2>
            <p class="section-intro" style="text-align: center; max-width: 600px; margin: 0 auto 3rem auto;">
                Découvrez les experts qui animent la recherche au sein du Behanzin Institute.
            </p>
            
            <?php
            require_once 'includes/db.php'; 

            // Fetch and group researchers
            $stmt = $pdd->query('SELECT * FROM chercheurs ORDER BY titre, nom, prenom');
            $all_chercheurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $grouped_chercheurs = [];
            foreach ($all_chercheurs as $chercheur) {
                $titre = $chercheur['titre'] ?: 'Non spécifié';
                $grouped_chercheurs[$titre][] = $chercheur;
            }
            ?>

            <div class="team-groups-container">
                <?php if (empty($grouped_chercheurs)): ?>
                    <p style="text-align: center;">Aucun membre de l'équipe à afficher pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($grouped_chercheurs as $titre => $chercheurs_in_group): ?>
                        <div class="team-group" style="margin-bottom: 3rem;">
                            <h3 class="group-title" style="border-bottom: 2px solid #eee; padding-bottom: 1rem; margin-bottom: 2rem; text-align: center;"><?php echo htmlspecialchars($titre); ?></h3>
                            <div class="team-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 2rem;">
                                <?php foreach ($chercheurs_in_group as $chercheur): ?>
                                    <div class="team-member" style="text-align: center; padding: 1.5rem; border-radius: 8px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: all 0.3s ease;">
                                        <img src="<?php echo htmlspecialchars($chercheur['photo_url'] ?: 'img/default-avatar.png'); ?>" alt="Photo de <?php echo htmlspecialchars($chercheur['prenom'] . ' ' . $chercheur['nom']); ?>" class="team-photo" style="width: 100%; height: 180px; object-fit: cover; margin: 0 auto 1rem auto; display: block; border-radius: 4px;">
                                        <h3 style="margin-bottom: 0.5rem; font-size: 1.2rem;"><?php echo htmlspecialchars($chercheur['prenom'] . ' ' . $chercheur['nom']); ?></h3>
                                        <p style="color: #555; font-size: 0.9rem; margin-bottom: 1rem;"><?php echo htmlspecialchars($chercheur['titre']); ?></p>
                                        <p class="team-bio" style="font-size: 0.9rem; color: #666; line-height: 1.5; min-height: 75px;">
                                            <?php
                                                $bio = htmlspecialchars($chercheur['bio']);
                                                if (strlen($bio) > 150) {
                                                    echo substr($bio, 0, 150) . '...';
                                                } else {
                                                    echo $bio;
                                                }
                                            ?>
                                        </p>
                                        <div class="team-social" style="margin-top: 1rem;">
                                            <?php if (!empty($chercheur['linkedin_url'])): ?>
                                                <a href="<?php echo htmlspecialchars($chercheur['linkedin_url']); ?>" target="_blank" rel="noopener noreferrer" style="display: inline-block; width: 30px; height: 30px; line-height: 30px; border-radius: 50%; background-color: #007bff; color: white; text-decoration: none; font-size: 0.9rem;">in</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<style>
.team-member:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}
</style>

<?php
include 'includes/footer.php';
?>