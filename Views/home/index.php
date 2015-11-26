<?php if(\Framework\HttpContext\HttpContext::getInstance()->getIdentity()->isLogged()): ?>
    <h1>logged</h1>
    <h2><?= \Framework\HttpContext\HttpContext::getInstance()->getIdentity()->getCurrentUser()->getFullName() ?></h2>
<?php else: ?>
    <h1>not logged</h1>
<?php endif; ?>