<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RENTme</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/fontawesome-free/css/all.min.css"); ?>" >
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>" >
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/dist/css/adminlte.min.css"); ?>">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="../../index2.html" class="h1"><b>RENT</b>me</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <?php if(isset($msj)){?>
                            <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>
                                <?php echo $msj;//mensaje de error ?>
                            </div>
                    <?php } ?>
                    <form  name="form" id="form" role="form" method="post" action="<?php echo base_url("login/validateUser"); ?>" >
                        
                        <div class="form-group input-group mb-3">
                            <input type="text" id="inputLogin" name="inputLogin" class="form-control"  placeholder="User" required autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>     

                        <div class="form-group  input-group mb-3">
                            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" value="" >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">

                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="<?php echo base_url("assets/bootstrap/plugins/jquery/jquery.min.js"); ?>"></script>
        <!-- Bootstrap 4 -->
        <script src="<?php echo base_url("assets/bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
        <!-- jquery-validation -->
        <script src="<?php echo base_url("assets/bootstrap/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>
        <script src="<?php echo base_url("assets/bootstrap/plugins/jquery-validation/additional-methods.min.js"); ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url("assets/bootstrap/dist/js/adminlte.min.js"); ?>"></script>

        <script type="text/javascript" src="<?php echo base_url("assets/js/validate/login.js"); ?>"></script>
    </body>
</html>