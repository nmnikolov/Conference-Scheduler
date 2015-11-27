<h2>Create venue</h2>

<?php
if(isset($_SESSION["binding-errors"]) && count($_SESSION["binding-errors"]) > 0){
    require_once("Views/partials/binding-errors.php");
}
?>

<form action="<?= \Framework\Helpers\Helpers::url() . "admin/venues/createPst" ?>" class="form-horizontal" method="post" role="form">
    <hr>
    <input type="hidden" name="redirect" value="admin/venues/create">
    <div class="form-group col-md-7">
        <input class="form-control" data-val="true" name="name" type="text" placeholder="Venue name">
    </div>
    <div class="form-group  col-md-7">
        <textarea class="form-control" name="description" placeholder="Venue description"></textarea>
    </div>
    <div class="form-group  col-md-7">
        <textarea class="form-control" name="address" placeholder="Venue address"></textarea>
    </div>

    <div class="form-group  col-md-7">
            <input type="submit" class="btn btn-primary" value="Add">
            <a class="btn btn-default" href="<?= \Framework\Helpers\Helpers::url() . "admin/venues" ?>">Cancel</a>
    </div>
</form>