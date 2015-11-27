<?php  /** @var \Framework\Models\ViewModels\AdminCreateHallViewModel $model */ ?>

<h2>Create hall</h2>

<?php
if(isset($_SESSION["binding-errors"]) && count($_SESSION["binding-errors"]) > 0){
    require_once("Views/partials/binding-errors.php");
}
?>

<form action="<?= \Framework\Helpers\Helpers::url() . "admin/halls/createPst" ?>" class="form-horizontal" method="post" role="form">
    <hr>
    <input type="hidden" name="redirect" value="admin/halls/create">
    <div class="form-group col-md-7">
        <label class="col-md-2 control-label" for="PhoneNumber">Name</label>
        <div class="col-md-10">
            <input class="form-control" name="name" type="text" placeholder="Hall name" required>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-2 control-label" for="PhoneNumber">Capacity</label>
        <div class="col-md-10">
            <input class="form-control" name="capacity" type="number" min="1" placeholder="Hall capacity" required>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-2 control-label" for="Category">Venue</label>
        <div class="col-md-10">
            <select class="form-control" name="venueId" required>
                <option value="">-- Select Venue --</option>-->
                <?php foreach($model->getVenues() as $venue):?>
                    <option value="<?= intval($venue["id"])?>"><?= $venue["name"]; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group  col-md-7">
        <div class="col-md-offset-2 col-md-10">
            <input type="submit" class="btn btn-primary" value="Add">
            <a class="btn btn-default" href="<?= \Framework\Helpers\Helpers::url() . "admin/halls" ?>">Calcel</a>
        </div>
    </div>
</form>