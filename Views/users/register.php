<?= $model->error ? $model->error : ''; ?>

<form action="" class="register form-horizontal col-md-6" method="post">
    <fieldset>
        <legend>
            <h2>Registers</h2>
        </legend>
        <div class="input-group input-group-md col-lg-8 login-field">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username...">
        </div>
        <div class="input-group input-group-md col-lg-8 login-field">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="login-password" type="password" class="form-control" name="password" placeholder="password...">
        </div>
    </fieldset>
    <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
            <input type="submit" value="Register" id="login-btn" class="btn btn-lg btn-primary" />
            <span>or</span>
            <a href="<?= \Framework\Helpers\Helpers::url() . 'users/login'?>"><button id="register-btn" type="button" class="btn btn-lg btn-primary">Login</button></a>
        </div>
    </div>
</form>
