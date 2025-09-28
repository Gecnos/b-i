<?php
$pageTitle = "Message envoyé";
$activePage = "contact";
include 'includes/header.php';

$message_status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST["subject"]), FILTER_SANITIZE_STRING);
    $message_body = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    // Validate input data
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($subject) || empty($message_body)) {
        $message_status = "Erreur : Veuillez remplir tous les champs correctement.";
    } else {
        // --- SIMULATION DE L'ENVOI D'EMAIL ---
        // Dans une application réelle, vous utiliseriez ici la fonction mail() de PHP
        // ou une bibliothèque comme PHPMailer pour envoyer un email.
        // Exemple :
        //
        // $to = "contact@behanzin-institute.org";
        // $headers = "From: " . $name . " <" . $email . ">";
        //
        // if (mail($to, $subject, $message_body, $headers)) {
        //     $message_status = "Merci ! Votre message a bien été envoyé.";
        // } else {
        //     $message_status = "Désolé, une erreur est survenue lors de l'envoi de votre message.";
        // }

        // Pour ce projet, nous allons simplement afficher un message de succès.
        $message_status = "Merci, " . htmlspecialchars($name) . " ! Votre message a bien été reçu (simulation).";
        
        // On peut aussi afficher les données reçues pour le débogage
        $message_status .= "<div style='margin-top: 20px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9; text-align: left;'>";
        $message_status .= "<strong>Sujet :</strong> " . htmlspecialchars($subject) . "<br>";
        $message_status .= "<strong>Message :</strong><br>" . nl2br(htmlspecialchars($message_body));
        $message_status .= "</div>";
    }
} else {
    // Redirect if accessed directly
    header("Location: contact.php");
    exit;
}
?>

<main>
    <section class="contact-status-section" style="padding: 4rem 0;">
        <div class="container" style="text-align: center;">
            <h2>Statut de votre message</h2>
            <div style="margin: 1rem 0;"><?php echo $message_status; ?></div>
            <a href="contact.php" style="display: inline-block; margin-top: 2rem;">Retour au formulaire</a>
        </div>
    </section>
</main>

<?php
include 'includes/footer.php';
?>
