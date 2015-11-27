<?php
if(isset($_SESSION["binding-errors"]) && count($_SESSION["binding-errors"]) > 0){
    require_once("Views/partials/binding-errors.php");
}
?>

<div class="row  pad-top">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>   Enter Details To Login </strong>
            </div>
            <div class="panel-body">
                <form role="form" action="" method="post">
                    <br />
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-tag"  ></i></span>
                        <input type="text" class="form-control" name="username" placeholder="Your Username " required/>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"  ></i></span>
                        <input type="password" class="form-control"  name="password" placeholder="Your Password" required/>
                    </div>

                    <input type="submit" value="Login Now" class="btn btn-primary" />
                    <hr />
                    Not Registered ? <a href="<?= \Framework\Helpers\Helpers::url() . 'users/register'?>">click here</a>
                </form>
            </div>
        </div>
    </div>
</div>