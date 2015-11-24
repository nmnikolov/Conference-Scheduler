<?php if($model->getUser()->isLogged() === false): ?>
    <h1>not logged</h1>
<?php else: ?>
    <h1>logged</h1>
    <h2><?= $model->getUser()->getUsername() ?></h2>
<?php endif; ?>