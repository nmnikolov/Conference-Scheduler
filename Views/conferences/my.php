<?php  /** @var \Framework\Models\ViewModels\MyConferencesViewModel $model */ ?>

<h2>My conferences</h2>

<?php if(count($model->getConferences()) === 0): ?>
    <p>You have no conferences.</p>
<?php else: ?>
    <?php foreach($model->getConferences() as $conference): ?>
        <div class="well">
            <h2><?= htmlspecialchars($conference["title"]); ?></h2>
            <p class="well"><?= htmlspecialchars($conference["description"]); ?></p>
            <p>Venue: <?= $conference["venueName"] ? htmlspecialchars($conference["venueName"]) : "no venue" ?></p>
            <p>Start time: <span class="start-time-span"><?= htmlspecialchars($conference["startTime"]); ?></span></p>
            <p>End time: <span class="end-time-span"><?= htmlspecialchars($conference["endTime"]); ?></span></p>
            <?php if($conference["isDismissed"]): ?>
                <p><span class="dismissed-span">Dismissed</span></p>
            <?php elseif($conference["isActive"]): ?>
                <p><span class="active-span">Active</span></p>
            <?php else: ?>
                <p><span class="inactive-span">Inactive</span></p>
            <?php endif; ?>
            <p><a href="<?= \Framework\Helpers\Helpers::url() . "conferences/details/" . htmlspecialchars($conference["id"]); ?>" class="btn btn-primary" role="button">Learn more</a></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>