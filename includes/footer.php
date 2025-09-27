<?php
$racine_site = 'b_i'; 
?>
    <footer class="footer" id="footer">
        <div class="container">
            <div class="footer-content">
                
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <ul>
                        <li><a href="<?php echo $racine_site; ?>/index.php">Accueil</a></li>
                        <li><a href="<?php echo $racine_site; ?>/axes.php">Axes de recherche</a></li>
                        <li><a href="<?php echo $racine_site; ?>/equipes.php">Équipes</a></li>
                        <li><a href="<?php echo $racine_site; ?>/contact.php">Contact</a></li>
                        <li><a href="<?php echo $racine_site; ?>/mentions-legales.php">Mentions légales</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Newsletter</h3>
                    <p>Restez informé de nos dernières actualités</p>
                    <form class="newsletter-form" id="newsletter-form">
                        <input type="email" placeholder="Votre email" class="newsletter-input" required>
                        <button type="submit" class="newsletter-btn">S'inscrire</button>
                    </form>
                </div>
                
                <div class="footer-section">
                    <h3>Suivez-nous</h3>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook">f</a>
                        <a href="#" aria-label="Twitter">t</a>
                        <a href="#" aria-label="LinkedIn">in</a>
                        <a href="#" aria-label="YouTube">yt</a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>123 Avenue de la Recherche<br>75001 Paris, France</p>
                    <p>Tél: +33 1 23 45 67 89<br>Email: contact@behanzin-institute.org</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date("Y"); ?> Behanzin Institute. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo $racine_site; ?>/assets/js/main.js?v=1"></script> 
    
    </body>
</html>