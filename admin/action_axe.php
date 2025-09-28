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

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowed_types)) {
            // Handle error - for now, just return existing url
            return $existing_image_url;
        }

        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            // If a new file is uploaded and an old one exists, delete the old one
            if ($existing_image_url && file_exists($upload_dir . basename($existing_image_url))) {
                unlink($upload_dir . basename($existing_image_url));
            }
            return 'uploads/' . $file_name; // Return the path relative to the root
        }
    }
    
    // If no new file or an error occurred, return the existing url
    return $existing_image_url;
}

$action = $_POST['action'] ?? $_GET['action'] ?? null;

switch ($action) {
    case 'add':
        $url_image = handle_image_upload('url_image');

        $stmt = $pdd->prepare('INSERT INTO axes (titre, code_axe, description_courte, description_complete, url_image) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([
            $_POST['titre'] ?? '',
            $_POST['code_axe'] ?? '',
            $_POST['description_courte'] ?? '',
            $_POST['description_complete'] ?? '',
            $url_image
        ]);

        header('Location: gestion_axes.php?success=Axe ajouté avec succès.');
        exit;

    case 'edit':
        $id_axe = $_POST['id_axe'] ?? null;
        if (!$id_axe) {
            header('Location: gestion_axes.php?error=ID manquant.');
            exit;
        }

        $existing_url = $_POST['existing_image_url'] ?? '';
        $url_image = handle_image_upload('url_image', $existing_url);

        $stmt = $pdd->prepare('UPDATE axes SET titre = ?, code_axe = ?, description_courte = ?, description_complete = ?, url_image = ? WHERE id_axe = ?');
        $stmt->execute([
            $_POST['titre'] ?? '',
            $_POST['code_axe'] ?? '',
            $_POST['description_courte'] ?? '',
            $_POST['description_complete'] ?? '',
            $url_image,
            $id_axe
        ]);

        header('Location: gestion_axes.php?success=Axe mis à jour avec succès.');
        exit;

    case 'delete':
        $id_axe = $_GET['id'] ?? null;
        if ($id_axe) {
            // First, get the image url to delete the file
            $stmt = $pdd->prepare('SELECT url_image FROM axes WHERE id_axe = ?');
            $stmt->execute([$id_axe]);
            $axe = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($axe && !empty($axe['url_image']) && file_exists('../' . $axe['url_image'])) {
                unlink('../' . $axe['url_image']);
            }

            // Then, delete the record from the database
            $delete_stmt = $pdd->prepare('DELETE FROM axes WHERE id_axe = ?');
            $delete_stmt->execute([$id_axe]);

            header('Location: gestion_axes.php?success=Axe supprimé avec succès.');
        } else {
            header('Location: gestion_axes.php?error=ID manquant.');
        }
        exit;

    default:
        header('Location: gestion_axes.php');
        exit;
}
?>
