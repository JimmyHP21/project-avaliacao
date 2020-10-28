<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Comment
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/home/post/<?php echo htmlspecialchars( $idpost, ENT_COMPAT, 'UTF-8', FALSE ); ?>/comment/list">Comment List</a></li>
            <li class="active"><a href="/home/post/<?php echo htmlspecialchars( $idpost, ENT_COMPAT, 'UTF-8', FALSE ); ?>/comment/">Register</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Comment</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/home/post/<?php echo htmlspecialchars( $idpost, ENT_COMPAT, 'UTF-8', FALSE ); ?>/comment/<?php echo htmlspecialchars( $comment["idcomment"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="commentvalue">Comment</label>
                                <input type="text" class="form-control" id="commentvalue" name="commentvalue" placeholder="Type the Comment" value="<?php echo htmlspecialchars( $comment["commentvalue"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="destaquecomment" value="1" id="spotlight" <?php if( $comment["destaquecomment"] == 1 ){ ?>checked <?php } ?>> is Spotlight
                                </label>
                            </div>
                            <div class="form-group" id="spotlight-div" hidden>
                                <label for="valuedestaque">Value Spotlight</label>
                                <input type="number" class="form-control" id="valuedestaque" name="valuedestaque" placeholder="Type the Spotlight" value="<?php echo htmlspecialchars( $comment["valuedestaque"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
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