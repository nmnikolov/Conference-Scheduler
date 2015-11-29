<?php  /** @var \Framework\Models\ViewModels\ConferencePreviewViewModel $model */ ?>

<h2>Activate conference</h2>

<?php
if(isset($_SESSION["binding-errors"]) && count($_SESSION["binding-errors"]) > 0){
    require_once("Views/partials/binding-errors.php");
}
?>

<form action="" class="form-horizontal" method="post" role="form">
    <hr>
    <input type="hidden" name="redirect" value="conferences/edit/<?= htmlspecialchars($model->getId()); ?>">
    <div class="form-group col-md-7">
        <label class="col-md-3 control-label" for="title">Title</label>
        <div class="input-group col-md-9">
            <input class="form-control input-group" id="title" name="title" type="text" value="<?= htmlspecialchars($model->getTitle()); ?>" readonly>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-3 control-label" for="description">Description</label>
        <div class="col-md-9 input-group">
            <textarea id="description" class="form-control" rows="5" name="description" readonly><?= htmlspecialchars($model->getDescription()); ?></textarea>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-3 control-label" for="start-time">Start time</label>
        <div id="start-time-picker" class="input-group col-md-9 date date-input date-picker">
            <input class="form-control" id="start-time" name="startTime" value="<?= htmlspecialchars($model->getStartTime()); ?>" type="datetime" readonly>
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
            <input class="form-control" id="end-time" name="endTime" type="datetime" value="<?= htmlspecialchars($model->getEndTime()); ?>" readonly>
            <div class="input-group-addon">
                <span class="datepicker-icon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>

    <div class="form-group  col-md-7">
        <div class="col-md-offset-2 col-md-10">
            <input type="submit" class="btn btn-primary" value="Activate">
            <a class="btn btn-default" href="<?= \Framework\Helpers\Helpers::url() . "conferences/edit/" . htmlspecialchars($model->getId()); ?>">Cancel</a>
        </div>
    </div>
</form>