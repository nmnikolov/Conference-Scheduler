<?php  /** @var \Framework\Models\ViewModels\UserProfileViewModel $model */ ?>

<?php
if(isset($_SESSION["binding-errors"]) && count($_SESSION["binding-errors"]) > 0){
    require_once("Views/partials/binding-errors.php");
}
?>

<div class="row  pad-top">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>   Update your profile </strong>
            </div>
            <div class="panel-body">
                <form role="form" action="" method="post">
                    <br />
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
                        <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($model->getUsername()); ?>" disabled>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" id="fullName" name="fullName" value="<?= htmlspecialchars($model->getFullName()); ?>" required>
                    </div>

                    <input id="save-btn" type="submit" name="edit" value="Update profile" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>