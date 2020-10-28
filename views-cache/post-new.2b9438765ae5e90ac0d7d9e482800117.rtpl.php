<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Post List
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/home/post/list">Post List</a></li>
            <li class="active"><a href="/home/post/new">Register</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">New Post</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/home/post/new" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="description">Name</label>
                                <input type="text" class="form-control" id="description" name="description" placeholder="Type the Description">
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <div class="custom-select">
                                    <select name="type" id="type">
                                        <option value="0">Text</option>
                                        <option value="1">Picture</option>
                                        <option value="2">Video</option>
                                    </select>
                                </div>
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