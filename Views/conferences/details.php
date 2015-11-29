<?php  /** @var \Framework\Models\ViewModels\ConferenceDetailsViewModel $model */ ?>

<div class="well">
    <h2><?= htmlspecialchars($model->getTitle()); ?></h2>
    <p class="well"><?= htmlspecialchars($model->getDescription()); ?></p>
    <?php if($model->getVenue()->getId() != ""): ?>
        <div class="well">
            <p><?= htmlspecialchars($model->getVenue()->getName()); ?></p>
            <p><?= htmlspecialchars($model->getVenue()->getDescription()); ?></p>
            <p><?= htmlspecialchars($model->getVenue()->getAddress()); ?></p>
        </div>
    <?php else: ?>
        <p>Venue: no venue</p>
    <?php endif; ?>

    <p>Start time: <span class="start-time-span"><?= htmlspecialchars($model->getStartTime()); ?></span></p>
    <p>End time: <span class="end-time-span"><?= htmlspecialchars($model->getEndTime()); ?></span></p>
    <?php if($model->getIsDismissed()): ?>
        <p><span class="dismissed-span">Dismissed</span></p>
    <?php elseif($model->getIsActive()): ?>
        <p><span class="active-span">Active</span></p>
    <?php else: ?>
        <p><span class="inactive-span">Inactive</span></p>
    <?php endif; ?>

    <?php if($model->getIsConferenceOwner() && !$model->getIsDismissed() && $model->getEndTime() >= Date('Y-m-d H:i:s')): ?>
        <a href="<?= \Framework\Helpers\Helpers::url() . "conferences/edit/" . htmlspecialchars($model->getId()) ?>" class="btn btn-primary" role="button">Edit</a>
        <a href="<?= \Framework\Helpers\Helpers::url() . "conferences/dismiss/" . htmlspecialchars($model->getId()) ?>" class="btn btn-danger" role="button">Dismiss</a>
    <?php endif; ?>
</div>