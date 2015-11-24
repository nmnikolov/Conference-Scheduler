<?php if($model->error): ?>
    <h2><?= $model->error ?></h2>
<?php elseif($model->success):?>
    <h2>Successfully updated profile</h2>
<?php endif; ?>

<form action="" class="register form-horizontal col-md-6" method="post">
    <fieldset>
        <legend>Profile</legend>
        <div class="col-lg-9 form-info">
            <div class="form-group">
                <label for="username" class="col-lg-4 control-label">Username: </label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($model->getUser()->getUsername()); ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-lg-4 control-label">Password:</label>
                <div class="col-lg-8">
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>

            <div class="form-group">
                <label for="repeat-password" class="col-lg-4 control-label">Repeat password:</label>
                <div class="col-lg-8">
                    <input type="password" class="form-control" id="repeat-password" name="confirmPassword">
                </div>
            </div>
        </div>

        <div class="form-group col-lg-12" id="profileButtons">
            <div class="col-lg-10 col-lg-offset-2">
                <input id="save-btn" type="submit" name="edit" value="Save" class="btn btn-lg btn-primary">
            </div>
        </div>
    </fieldset>
</form>