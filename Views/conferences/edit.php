<?php  /** @var \Framework\Models\ViewModels\EditConferenceViewModel $model */ ?>

<h2>Edit conference</h2>

<?php
if(isset($_SESSION["binding-errors"]) && count($_SESSION["binding-errors"]) > 0){
    require_once("Views/partials/binding-errors.php");
}
?>

<form action="" class="form-horizontal" method="post" role="form">
    <hr>
    <input type="hidden" name="redirect" value="conferences/edit/<?= $model->getId(); ?>">
    <div class="form-group col-md-7">
        <label class="col-md-3 control-label" for="title">Title</label>
        <div class="input-group col-md-9">
            <input class="form-control input-group" id="title" name="title" type="text" value="<?= $model->getTitle(); ?>" required>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-3 control-label" for="description">Description</label>
        <div class="col-md-9 input-group">
            <textarea id="description" class="form-control" rows="5" name="description" required><?= $model->getDescription(); ?></textarea>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-3 control-label" for="start-time">Start time</label>
        <div id="start-time-picker" class="input-group col-md-9 date date-input date-picker">
            <input class="form-control" id="start-time" name="startTime" value="<?= $model->getStartTime(); ?>" type="datetime" required>
            <div class="input-group-addon">
                <span class="datepicker-icon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-3 control-label" for="end-time">End time</label>
        <div id="end-time-picker" class="input-group col-md-9 date date-input date-picker">
            <input class="form-control" id="end-time" name="endTime" type="datetime" value="<?= $model->getEndTime(); ?>" required>
            <div class="input-group-addon">
                <span class="datepicker-icon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
        <div class="form-group col-md-7">
            <label class="col-md-3 control-label" for="venue">Venue</label>
            <div class="col-md-9 input-group">
                <select id="venue" class="form-control input-group" name="venueId" required>
                    <option value="">-- Select venue --</option>
                    <?php foreach($model->getVenues() as $venue): ?>
                        <?php $selected = $venue["id"] === $model->getVenue()->getId() ? "selected" : ""; ?>
                        <option value="<?= $venue["id"]; ?>" <?= $selected ?>><?= $venue["name"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    <div class="form-group  col-md-7">
        <div class="col-md-offset-2 col-md-10">
            <?php if($model->getIsDismissed()): ?>
                <a class="btn btn-danger" href="<?= \Framework\Helpers\Helpers::url() . "conferences/details/" . $model->getId(); ?> ?>">Back to conference</a>
            <?php else: ?>
                <input type="submit" class="btn btn-primary" value="Save">
                <?php if(!$model->getIsActive()): ?>
                    <a class="btn btn-success" href="<?= \Framework\Helpers\Helpers::url() . "conferences/activate/" . $model->getId(); ?>">Activate</a>
                <?php endif; ?>
                <a class="btn btn-default" href="<?= \Framework\Helpers\Helpers::url() . "conferences/details/" . $model->getId(); ?>">Cancel</a>
            <?php endif; ?>
        </div>
    </div>
</form>