<?php  /** @var \Framework\Models\ViewModels\AdminChangeRoleViewModel $model */ ?>

<h2>Change user role</h2>

<?php
if(isset($_SESSION["binding-errors"]) && count($_SESSION["binding-errors"]) > 0){
    require_once("Views/partials/binding-errors.php");
}
?>

<form action="<?= \Framework\Helpers\Helpers::url() . "admin/users/" . htmlspecialchars($model->getUser()->getId()) . "/role/editPst"?>" class="form-horizontal" method="post" role="form">
    <hr>
    <input type="hidden" name="redirect" value="<?= "admin/users/" . htmlspecialchars($model->getUser()->getId()) . "/role/edit" ?>">
    <div class="form-group col-md-7">
        <label class="col-md-3 control-label" for="username">Username</label>
        <div class="col-md-9">
            <input class="form-control input-group" id="username" type="text" value="<?= htmlspecialchars($model->getUser()->getUsername()) ?>" readonly>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-3 control-label" for="fullname">Fullname</label>
        <div class="col-md-9">
            <input class="form-control input-group" id="fullname" type="text" value="<?= htmlspecialchars($model->getUser()->getFullName()) ?>" readonly>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-3 control-label" for="current-role">Current role</label>
        <div class="col-md-9">
            <input class="form-control input-group" id="current-role" type="text" value="<?= htmlspecialchars($model->getRole()->getName()) ?>" readonly>
        </div>
    </div>
    <div class="form-group col-md-7">
        <label class="col-md-3 control-label" for="new-role">New role</label>
        <div class="col-md-9">
            <select id="new-role" class="form-control" name="newRole" required>
            <option value="">-- Select role --</option>
            <?php foreach($model->getRoles() as $role): ?>
                <option value="<?= htmlspecialchars($role["id"]) ?>"><?= htmlspecialchars($role["name"]) ?></option>
            <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group  col-md-7 ">
        <input type="submit" class="btn btn-primary col-md-offset-4" value="Add">
        <a class="btn btn-default" href="<?= \Framework\Helpers\Helpers::url() . "admin/users" ?>">Cancel</a>
    </div>
</form>