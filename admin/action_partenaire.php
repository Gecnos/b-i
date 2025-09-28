<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// --- Helper function for image upload ---
function handle_image_upload($file_input_name, $existing_image_url = '') {
    $upload_dir = '../uploads/';

    if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES[$file_input_name];
        $file_name = uniqid() . '-' . basename($file['name']);
        $target_path = $upload_dir . $file_name;

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
        if (!in_array($file['type'], $allowed_types)) {
            return $existing_image_url;
        }

        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            if ($existing_image_url && file_exists('../' . $existing_image_url)) {
                unlink('../' . $existing_image_url);
            }
            return 'uploads/' . $file_name;
        }
    }
    
    return $existing_image_url;
}

$action = $_POST['action'] ?? $_GET['action'] ?? null;

switch ($action) {
    case 'add':
        $logo_url = handle_image_upload('logo_url');

        $stmt = $pdd->prepare('INSERT INTO partenaires (nom, type_partenariat, logo_url, site_web_url) VALUES (?, ?, ?, ?)');
        $stmt->execute([
            $_POST['nom'] ?? '',
            $_POST['type_partenariat'] ?? '',
            $logo_url,
            $_POST['site_web_url'] ?? ''
        ]);
        header('Location: gestion_partenaires.php?success=Partenaire ajouté avec succès.');
        exit;

    case 'edit':
        $id_partenaire = $_POST['id_partenaire'] ?? null;
        if ($id_partenaire) {
            $existing_logo_url = $_POST['existing_logo_url'] ?? '';
            $logo_url = handle_image_upload('logo_url', $existing_logo_url);

            $stmt = $pdd->prepare('UPDATE partenaires SET nom = ?, type_partenariat = ?, logo_url = ?, site_web_url = ? WHERE id_partenaire = ?');
            $stmt->execute([
                $_POST['nom'] ?? '',
                $_POST['type_partenariat'] ?? '',
                $logo_url,
                $_POST['site_web_url'] ?? '',
                $id_partenaire
            ]);
            header('Location: gestion_partenaires.php?success=Partenaire mis à jour avec succès.');
        } else {
            header('Location: gestion_partenaires.php?error=ID manquant.');
        }
        exit;

    case 'delete':
        $id_partenaire = $_GET['id'] ?? null;
        if ($id_partenaire) {
            // First, get the logo url to delete the file
            $stmt = $pdd->prepare('SELECT logo_url FROM partenaires WHERE id_partenaire = ?');
            $stmt->execute([$id_partenaire]);
            $partenaire = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($partenaire && !empty($partenaire['logo_url']) && file_exists('../' . $partenaire['logo_url'])) {
                unlink('../' . $partenaire['logo_url']);
            }

            // Then, delete the record
            $delete_stmt = $pdd->prepare('DELETE FROM partenaires WHERE id_partenaire = ?');
            $delete_stmt->execute([$id_partenaire]);
            header('Location: gestion_partenaires.php?success=Partenaire supprimé avec succès.');
        } else {
            header('Location: gestion_partenaires.php?error=ID manquant.');
        }
        exit;

    default:
        header('Location: gestion_partenaires.php');
        exit;
}
?>
