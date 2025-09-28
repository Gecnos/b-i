<?php
$pageTitle = "Contact";
$activePage = "contact";

include 'includes/header.php'; 
?>

<main>
    <section class="contact-section" style="padding: 4rem 0;">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 3rem;">Contactez-nous</h2>

            <div class="contact-wrapper" style="display: grid; grid-template-columns: 1fr 2fr; gap: 3rem; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                
                <!-- Left Column: Contact Info -->
                <div class="contact-info">
                    <h3>Informations</h3>
                    <p><strong>Behanzin Institute</strong></p>
                    <p>123 Avenue de la Recherche<br>75001 Paris, France</p>
                    <br>
                    <p><strong>Téléphone :</strong><br>+33 1 23 45 67 89</p>
                    <br>
                    <p><strong>Email :</strong><br><a href="mailto:contact@behanzin-institute.org">contact@behanzin-institute.org</a></p>
                </div>

                <!-- Right Column: Contact Form -->
                <div class="contact-form-container">
                    <h3>Envoyer un message</h3>
                    <form id="contact-form" action="send_contact.php" method="POST">
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label for="name" style="display: block; margin-bottom: 0.5rem;">Nom et prénom</label>
                            <input type="text" id="name" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
                        </div>
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label for="email" style="display: block; margin-bottom: 0.5rem;">Votre email</label>
                            <input type="email" id="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
                        </div>
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label for="subject" style="display: block; margin-bottom: 0.5rem;">Sujet</label>
                            <input type="text" id="subject" name="subject" required style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
                        </div>
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label for="message" style="display: block; margin-bottom: 0.5rem;">Votre message</label>
                            <textarea id="message" name="message" rows="6" required style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; resize: vertical;"></textarea>
                        </div>
                        <button type="submit" class="submit-btn" style="padding: 0.75rem 1.5rem; background-color: #333; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem;">Envoyer</button>
                    </form>
                </div>

            </div>
        </div>
    </section>
</main>

<?php
include 'includes/footer.php'; 
?>