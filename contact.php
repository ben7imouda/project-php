<?php
include 'includes/header.php';

$message = '';
if ($_POST) {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message_text = trim($_POST['message'] ?? '');

    if ($nom && $email && $message_text) {
        // En vrai, on enverrait un mail avec mail()
        // Ici : juste simulation (typique projet scolaire)
        $message = '<div class="alert alert-success">Merci ' . htmlspecialchars($nom) . ' ! Votre message a bien été envoyé.</div>';
    } else {
        $message = '<div class="alert alert-danger">Veuillez remplir tous les champs.</div>';
    }
}
?>

<div class="container mt-5">
    <h2>Nous contacter</h2>
    <?php echo $message; ?>

    <form method="POST">
        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email :</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Message :</label>
            <textarea name="message" rows="5" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>