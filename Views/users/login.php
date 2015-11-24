<?= $model->error ? $model->error : ''; ?>

<form action="" class="login form-horizontal col-md-6" method="post">
    <fieldset>
        <legend>
            <h2>Login</h2>
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
            <input type="submit" value="Login" id="login-btn" class="btn btn-lg btn-primary" />
            <span>or</span>
            <a href="<?= \Framework\Helpers\Helpers::url() . 'users/register'?>"><button id="register-btn" type="button" class="btn btn-lg btn-primary">Register</button></a>
        </div>
    </div>
</form>