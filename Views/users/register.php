<?php
if(isset($_SESSION["binding-errors"])){
    require_once("Views/partials/binding-errors.php");
}
?>
<div class="row pad-top">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Register Yourself</strong>
            </div>
            <div class="panel-body">
                <form action="" role="form" method="post">
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
                        <input id="login-username" type="text" class="form-control" name="userName" value="" placeholder="Desired Username" required>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="login-fullname" type="text" class="form-control" name="fullName" value="" placeholder="Your Name" required>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="login-password" type="password" class="form-control" name="password" placeholder="Enter Password" required>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="login-password" type="password" class="form-control" name="confirmPassword" placeholder="Repeat Password" required>
                    </div>
                    <input type="submit" value="Register me" id="login-btn" class="btn btn-success " />
                    <hr />
                    Already Registered ?  <a href="<?= \Framework\Helpers\Helpers::url() . 'users/login'?>">Login here</a>
                </form>
            </div>
        </div>
    </div>
</div>