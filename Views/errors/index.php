<h2>Something went wrong!</h2>
<?php if($model->getError() !== ""): ?>
    <pre><?= $model->getError() ?></pre>
<?php endif; ?>
