<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		
		{!! HTML::style('bootstrap/css/bootstrap.css') !!}
		{!! HTML::style('bootstrap/css/bootstrap-theme.css') !!}
		
		{!! HTML::script('bootstrap/js/jquery.min.js') !!}
		{!! HTML::script('bootstrap/js/bootstrap.js') !!}
		{!! HTML::script('js/angular.min.js') !!}
		
		<!--Custom Font-->
		{!! HTML::style('font-awesome/css/font-awesome.min.css') !!}
		<title>Miland</title>
	</head>
	<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="#">Miland</a>
			</div>
		</div>
	</nav>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-4 col-lg-offset-4">
				<div class="panel panel-default">
				<div class="panel-body">
				{!! Form::open(array('ng-app' => 'MyApp','name' => 'login_form', 'novalidate' => 'novalidate', 'ng-controller' => 'FormController', 'action' => 'LoginController@login')) !!}
				<?php
					$error = Session::get('error_login');
					if(!empty($error)){
				?>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<?=$error?>
					</div>
				<?php
					Session::forget('error_login');
					}
				?>
					<div class="form-group" ng-class="{ 'has-error' : ( login_form.username_text.$invalid && !login_form.username_text.$pristine ) || login_form.username_text.$error.minlength }">
					<div class="form-inline">
					<label>Username</label>
					<label style="color:red;font-size:x-small;" ng-show="login_form.username_text.$error.required && !login_form.username_text.$pristine">Username is required.</label>
					<label style="color:red;font-size:x-small;" ng-show="login_form.username_text.$error.minlength">Minimal 3 character.</label>
					<label style="color:red;font-size:x-small;"><?=$errors->first('username_text');?></label>
					</div>
					<input type="text" class="form-control" ng-model="username_text" name="username_text" placeholder="Enter username. . ." ng-minlength="3" required>
					</div>
					<div class="form-group" ng-class="{ 'has-error' : ( login_form.password_text.$invalid && !login_form.password_text.$pristine ) || login_form.password_text.$error.minlength }">
					<div class="form-inline">
					<label>Password</label>
					<label style="color:red;font-size:x-small;" ng-show="login_form.password_text.$error.required && !login_form.password_text.$pristine">Password is required.</label>
					<label style="color:red;font-size:x-small;" ng-show="login_form.password_text.$error.minlength">Minimal 3 character.</label>
					<label style="color:red;font-size:x-small;"><?=$errors->first('password_text');?></label>
					</div>
					<input type="password" class="form-control" ng-model="password_text" name="password_text" ng-minlength="3" placeholder="Enter password . . ." required>
					
					</div>
					<hr>
					<center><button type="submit" ng-disabled="login_form.$invalid" class="btn btn-default">Submit</button></center>
				</form>
				</div>
				</div>	
			</div>
			</div>
		</div>
	</div>
	<script>
	var myapp = angular.module('MyApp', []);

	myapp.controller('FormController', function($scope){
	  $scope.username_text = '{!!Form::old('username_text')!!}';
	  $scope.password_text = '{!!Form::old('password_text')!!}';
	})
	</script>
	</body>
</html>
