<?php session_start();
?>
<!doctype html>
<html>
<head>
    <title>Create Account</title>
</head>
<body>

    <?php include('../library/nav-bar.html'); ?>
    <div class="create-account">
        <form method="POST" action="" autocomplete="off" class="form-horizontal">
            <div class="form-group">
                <div class="col-md-4">
                    <label class="control-label" for="account-name">Account Name:</label>
                    <input class="form-control" type="text" name="account-name" placeholder="Account Name" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <label class="control-label" for="email">E-mail:</label>
                    <input class="form-control" type="text" name="email" placeholder="E-mail" />
                </div>
            </div>
        </form>
    </div>

</body>
</html>
