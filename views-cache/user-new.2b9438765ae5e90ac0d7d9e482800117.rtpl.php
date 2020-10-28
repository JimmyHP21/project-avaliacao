<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    User List
  </h1>
  <ol class="breadcrumb">
    <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/home/user/list">User List</a></li>
    <li class="active"><a href="/home/user/new">Register</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">New User</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/home/user/new" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="desname">Name</label>
              <input type="text" class="form-control" id="desname" name="desname" placeholder="Type the Name">
            </div>
            <div class="form-group">
              <label for="deslogin">Login</label>
              <input type="text" class="form-control" id="deslogin" name="deslogin" placeholder="Type the login">
            </div>
            <div class="form-group">
              <label for="despassword">Password</label>
              <input type="password" class="form-control" id="despassword" name="despassword" placeholder="Type the senha">
            </div>
            <div class="form-group">
              <label for="balance">Balance</label>
              <input type="number" class="form-control" id="balance" name="balance" placeholder="Type the balance">
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="signature" value="1"> is Signature
              </label>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Register</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->