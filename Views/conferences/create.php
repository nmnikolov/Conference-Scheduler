<h2>Add conference</h2>

<?php
if(isset($_SESSION["binding-errors"]) && count($_SESSION["binding-errors"]) > 0){
    require_once("Views/partials/binding-errors.php");
}
?>

<form action="" class="form-horizontal" method="post" role="form">
    <hr>
    <input type="hidden" name="redirect" value="conferences/create">
    <div class="form-group col-md-7">
        <label class="col-md-2 control-label" for="title">Title</label>
        <div class="input-group col-md-10">
            <input class="form-control" id="title" name="title" type="text" required>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-2 control-label" for="description">Description</label>
        <div class="input-group col-md-10">
            <textarea class="form-control" name="description" id="description" cols="30" rows="5" required></textarea>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-2 control-label" for="start-time">Start time</label>
        <div id="start-time-picker" class="input-group col-md-10 date date-input date-picker">
            <input class="form-control" id="start-time" name="startTime" type="datetime" required>
            <div class="input-group-addon">
                <span class="datepicker-icon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-2 control-label" for="end-time">End time</label>
        <div id="end-time-picker" class="input-group col-md-10 date date-input date-picker">
            <input class="form-control" id="end-time" name="endTime" type="datetime" required>
            <div class="input-group-addon">
                <span class="datepicker-icon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group  col-md-7">
        <div class="col-md-offset-2 col-md-10">
            <input type="submit" class="btn btn-primary" value="Add">
            <a class="btn btn-default" href="<?= \Framework\Helpers\Helpers::url() . "conferences/my" ?>">Cancel</a>
        </div>
    </div>
</form>