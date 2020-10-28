<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Comment List
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="/home/comment/list">Comment List</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header">
                        <a href="/home/post/<?php echo htmlspecialchars( $idpost, ENT_COMPAT, 'UTF-8', FALSE ); ?>/comment/new" class="btn btn-success">Create new Comment</a>
                    </div>

                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Comment</th>
                                <th>Type</th>
                                <th>Id User</th>
                                <th>Login User</th>
                                <th>Spotlight</th>
                                <th>Date Created</th>
                                <th style="width: 140px">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $counter1=-1;  if( isset($comments) && ( is_array($comments) || $comments instanceof Traversable ) && sizeof($comments) ) foreach( $comments as $key1 => $value1 ){ $counter1++; ?>
                            <tr>
                                <td><?php echo htmlspecialchars( $value1["idcomment"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["commentvalue"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php if( $value1["type"] == 1 ){ ?>Foto<?php }elseif( $value1["type"] == 0 ){ ?>Text<?php }else{ ?>Video<?php } ?></td>
                                <td><?php echo htmlspecialchars( $value1["iduser"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["deslogin"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php if( $value1["destaquecomment"] == 1 ){ ?>True<?php }else{ ?>False<?php } ?></td>
                                <td><?php echo htmlspecialchars( $value1["dtcommnet"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td>
                                    <a href="/home/post/<?php echo htmlspecialchars( $idpost, ENT_COMPAT, 'UTF-8', FALSE ); ?>/comment/<?php echo htmlspecialchars( $value1["idcomment"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Editar</a>
                                    <a href="/home/post/<?php echo htmlspecialchars( $idpost, ENT_COMPAT, 'UTF-8', FALSE ); ?>/comment/<?php echo htmlspecialchars( $value1["idcomment"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Excluir</a>
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 paginator-center">
                <div class="paginator text-center">
                    <?php $counter1=-1;  if( isset($pages) && ( is_array($pages) || $pages instanceof Traversable ) && sizeof($pages) ) foreach( $pages as $key1 => $value1 ){ $counter1++; ?>
                    <a href="<?php echo htmlspecialchars( $value1["link"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["page"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->