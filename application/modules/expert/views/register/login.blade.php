<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <title>{{isset($title)?$title:"BCS & BANK Job Preparation"}} || Iconpreparation</title>
        <link href="{{$base_url}}asset/frontend/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
       <link href="https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,300italic,300,100italic,100,900" rel="stylesheet" type="text/css">
         <!-- Bootstrap CSS -->
        <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" rel="stylesheet">
        <link href="{{ $base_url }}asset/expert/css/style" rel="stylesheet">
         <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
         <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
         <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			.container
			{
				padding-top: 10%;
			}
            .error{
                color:red;
            }
		</style>
    </head>
    <body>
        <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
        	<div class="panel panel-default">
        	    <div class="panel-heading">
        	        <h3 class="panel-title text-center">Login As An Expert</h3>
        	    </div>
        	    <div class="panel-body">
                <form action="{{ $base_url }}expert/login/check" method="POST" class="form-horizontal" role="form">
                        <div class="form-group">
                           <label for="email" class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Email</label>
                           <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                               <input type="email" name="email" id="email" class='form-control' placeholder="Email" required>
                           </div>
                        </div>
                
                        <div class="form-group">
                           <label for="password" class="control-label col-lg-3 col-md-3 col-sm-12 col-xs-12">Password</label>
                           <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                               <input type="password" name="password" id="password" placeholder="Password" class='form-control' required>
                           </div>
                        </div>
                        
                
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-3">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-lock-o"></i>Login</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-3">
                            <p>Don't have an account ? <a href="{{ $base_url }}expert/register">Register Now</a></p>
                            </div>
                        </div>
                </form>
        	    </div>
        	    <div class="panel-footer text-center">
        	        &copy;{{ date('Y') }} <a href="{{ $base_url }}">iconpreparation.com</a>
        	    </div>
        	</div>
        </div>
            
        </div>
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- Bootstrap JavaScript -->
        <script crossorigin="anonymous" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

        <script type="text/javascript">
        $(document).ready(function() {
            $('#email').blur(function(){
                var email=$(this).val();
                $.ajax({
                    url: '{{ $base_url }}expert/register/check_email',
                    type: 'POST',
                    data: {email: email},
                })
                .done(function(res) {
                    if(res==1){
                    $('.errEmail').html("Email already exist! Try another one.");
                   }else{
                    $('.errEmail').html("");
                }

                });
            });
        });
        </script>
    </body>
</html>