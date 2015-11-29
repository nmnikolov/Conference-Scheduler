<div class="alert alert-danger fade in">
    <span class="close" data-dismiss="alert">&times;</span>
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <span class="sr-only">Error:</span>
    <strong>Error!</strong>
    <?php foreach($_SESSION["binding-errors"] as $error): ?>
    <p> <?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>
</div>