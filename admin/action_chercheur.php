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

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
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
        try {
            $pdd->beginTransaction();

            $photo_url = handle_image_upload('photo_url');

            $stmt = $pdd->prepare('INSERT INTO chercheurs (nom, prenom, titre, email, bio, photo_url, linkedin_url) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $_POST['nom'] ?? '',
                $_POST['prenom'] ?? '',
                $_POST['titre'] ?? '',
                $_POST['email'] ?? '',
                $_POST['bio'] ?? '',
                $photo_url,
                $_POST['linkedin_url'] ?? ''
            ]);
            $id_chercheur = $pdd->lastInsertId();

            if (!empty($_POST['axes'])) {
                $assoc_stmt = $pdd->prepare('INSERT INTO axes_chercheurs (id_chercheur, id_axe) VALUES (?, ?)');
                foreach ($_POST['axes'] as $id_axe) {
                    $assoc_stmt->execute([$id_chercheur, $id_axe]);
                }
            }

            $pdd->commit();
            header('Location: gestion_chercheurs.php?success=Chercheur ajouté avec succès.');
        } catch (Exception $e) {
            $pdd->rollBack();
            header('Location: gestion_chercheurs.php?error=' . urlencode($e->getMessage()));
        }
        exit;

    case 'edit':
        $id_chercheur = $_POST['id_chercheur'] ?? null;
        if (!$id_chercheur) {
            header('Location: gestion_chercheurs.php?error=ID manquant.');
            exit;
        }

        try {
            $pdd->beginTransaction();

            $existing_photo_url = $_POST['existing_photo_url'] ?? '';
            $photo_url = handle_image_upload('photo_url', $existing_photo_url);

            $stmt = $pdd->prepare('UPDATE chercheurs SET nom = ?, prenom = ?, titre = ?, email = ?, bio = ?, photo_url = ?, linkedin_url = ? WHERE id_chercheur = ?');
            $stmt->execute([
                $_POST['nom'] ?? '',
                $_POST['prenom'] ?? '',
                $_POST['titre'] ?? '',
                $_POST['email'] ?? '',
                $_POST['bio'] ?? '',
                $photo_url,
                $_POST['linkedin_url'] ?? '',
                $id_chercheur
            ]);

            // Update associations
            $delete_assoc_stmt = $pdd->prepare('DELETE FROM axes_chercheurs WHERE id_chercheur = ?');
            $delete_assoc_stmt->execute([$id_chercheur]);

            if (!empty($_POST['axes'])) {
                $assoc_stmt = $pdd->prepare('INSERT INTO axes_chercheurs (id_chercheur, id_axe) VALUES (?, ?)');
                foreach ($_POST['axes'] as $id_axe) {
                    $assoc_stmt->execute([$id_chercheur, $id_axe]);
                }
            }

            $pdd->commit();
            header('Location: gestion_chercheurs.php?success=Chercheur mis à jour avec succès.');
        } catch (Exception $e) {
            $pdd->rollBack();
            header('Location: gestion_chercheurs.php?error=' . urlencode($e->getMessage()));
        }
        exit;

    case 'delete':
        $id_chercheur = $_GET['id'] ?? null;
        if ($id_chercheur) {
            // First, get the image url to delete the file
            $stmt = $pdd->prepare('SELECT photo_url FROM chercheurs WHERE id_chercheur = ?');
            $stmt->execute([$id_chercheur]);
            $chercheur = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($chercheur && !empty($chercheur['photo_url']) && file_exists('../' . $chercheur['photo_url'])) {
                unlink('../' . $chercheur['photo_url']);
            }

            // The ON DELETE CASCADE in the DB will handle the axes_chercheurs table
            $delete_stmt = $pdd->prepare('DELETE FROM chercheurs WHERE id_chercheur = ?');
            $delete_stmt->execute([$id_chercheur]);
            header('Location: gestion_chercheurs.php?success=Chercheur supprimé avec succès.');
        } else {
            header('Location: gestion_chercheurs.php?error=ID manquant.');
        }
        exit;

    default:
        header('Location: gestion_chercheurs.php');
        exit;
}
?>
