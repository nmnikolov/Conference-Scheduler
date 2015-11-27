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
                <strong>   Change your password </strong>
            </div>
            <div class="panel-body">
                <form role="form" action="" method="post">
                    <br />
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
                        <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($model->getUsername()); ?>" disabled />
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"  ></i></span>
                        <input type="password" class="form-control" id="password" name="currentPassword" placeholder="Your current password" required>
                    </div>

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"  ></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Yor new password" required>
                    </div>

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"  ></i></span>
                        <input type="password" class="form-control" id="repeat-password" name="confirmPassword" placeholder="Repeat your new password" required>
                    </div>

                    <input id="save-btn" type="submit" name="edit" value="Change password" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
</div>