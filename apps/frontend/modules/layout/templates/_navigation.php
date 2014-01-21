<!-- MENU -->
<?php if($profile): ?>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
    <a href="<?php echo url_for("@homepage") ?>" class="cbp-hom"><i></i>Inicio</a>
    <!-- <a href="#" class="cbp-cal"><i></i>Calendario</a> -->
    <a href="<?php echo url_for("@messages") ?>" class="cbp-msg"><i></i>Mensajes</a>
    <a href="<?php echo url_for("@video_session") ?>" class="cbp-tsk"><i></i>Tutorias</a>
    <!-- <a href="#" class="cbp-tsk"><i></i>Tareas</a> -->
    <a href="<?php echo url_for('user/index') ?>" class="cbp-usr"><i></i>Mi Perfil</a>
    <a href="<?php echo url_for('@sf_guard_signout') ?>" class="cbp-set"><i></i>Salir</a>
    <a href="#myModal" role="button" class="cbp-set" data-toggle="modal"><i></i>modal 1</a>
</nav>

<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">

    <div class="title">Camino de Aprendizaje <span id="edit-learning-path"><i class="icon-edit"></i></span></div>
    <?php include_partial("layout/learning_path_item_template") ?>

</nav>
<?php endif; ?>

<!-- navbar -->
<div class="plataforma-nav navbar navbar-fixed-top">
    <div class="navbar-inner">
            <?php if($profile): ?>
            <ul class="nav">
                <li class="nav-menu">
                    <a id="showLeft" role="button" class="nav-menu-icon"><span>Menu</span></a>
                </li>
            </ul>
            <?php endif; ?>
            <a class="nav-logo" href="<?php echo url_for("@homepage") ?>"></a>
            <?php if($profile): ?>
            <ul class="nav nav-mainbtn">
                <li class="nmb-ins"><a href="<?php echo url_for("stats/index") ?>"><i></i>Reportes</a></li>
                <li class="nmb-mat"><a href="<?php echo url_for("stats/timeline") ?>"><i></i>Aprendizaje</a></li>
                <li class="nmb-tut"><a href="<?php echo url_for("@video_session") ?>"><i></i>Tutorias</a></li>
            </ul>
            <ul class="nav pull-right">
                
                <li class="dropdown">
                    <a id="drop2" href="#" role="button" class="nav-btn nav-btn-ntfc dropdown-toggle" data-toggle="dropdown"><i></i></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="http://google.com">Action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#anotherAction">Another action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0)" class="nav-btn nav-btn-srch"><i></i></a></li>
                <li class="dropdown">
                    <a id="drop1" href="#" role="button" class="nav-btn nav-btn-prfl dropdown-toggle" data-toggle="dropdown"><i></i><!--<?php echo $profile->getNickname() ?> --></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                        <!-- <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="requestSupport-button">Llamar a soporte</a></li> -->
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo url_for('@sf_guard_signout') ?>">Salir</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0)" class="nav-btn nav-btn-path" id="open-learning-path"><i></i></a></li>
            </ul>
            <?php endif; ?>
    </div>
</div><!-- /navbar -->


<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <p id="myModalLabel"><span class="orange">Modal Title.</span> <span class="HelveticaLt">Flash Message.</span></p>
  </div>
  <div class="modal-body">
    <p>
        "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.
    </p>
  </div>
  <div class="modal-footer">
    <a class="btn btn-large" data-dismiss="modal" aria-hidden="true">Close</a>
    <a class="btn btn-primary btn-large">Save changes</a>
  </div>
</div>

