<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            New Comment
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/home/comment/list">Comment List</a></li>
            <li class="active"><a href="/home/comment/new">Register</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">New Comment</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/home/post/<?php echo htmlspecialchars( $idpost, ENT_COMPAT, 'UTF-8', FALSE ); ?>/comment/new" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="commentvalue">Comment</label>
                                <input type="text" class="form-control" id="commentvalue" name="commentvalue" placeholder="Type the Comment">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="destaquecomment" value="1" id="spotlight"> is Spotlight
                                </label>
                            </div>
                            <div class="form-group" id="spotlight-div" hidden>
                                <label for="valuedestaque">Value Spotlight</label>
                                <input type="number" class="form-control" id="valuedestaque" name="valuedestaque" placeholder="Type the Spotlight">
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