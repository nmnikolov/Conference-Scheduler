<?php  /** @var \Framework\Models\ViewModels\UserProfileViewModel $model */ ?>

<?php
    if(isset($_SESSION["binding-errors"])){
        require_once("Views/partials/binding-errors.php");
    }
?>

<form action="" class="register form-horizontal col-md-6" method="post">
    <fieldset>
        <legend>Profile</legend>
        <div class="col-lg-9 form-info">
            <div class="form-group">
                <label for="username" class="col-lg-4 control-label">Username: </label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($model->getUsername()); ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="fullName" class="col-lg-4 control-label">FullName: </label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="fullName" name="fullName" value="<?= htmlspecialchars($model->getFullName()); ?>" required>
                </div>
            </div>
        <div class="form-group col-lg-12" id="profileButtons">
            <div class="col-lg-10 col-lg-offset-2">
                <input id="save-btn" type="submit" name="edit" value="Save" class="btn btn-lg btn-primary">
            </div>
        </div>
    </fieldset>
</form>