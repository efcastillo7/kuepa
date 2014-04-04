

<!-- navbar -->
<div class="plataforma-nav navbar navbar-fixed-top">
    <div class="navbar-inner">
        <?php if ($profile): ?>
            <ul class="nav">
                <li class="nav-menu">
                    <a id="showLeft" role="button" class="nav-menu-icon"><span>Menu</span></a>
                </li>
            </ul>
        <?php endif; ?>
        <a class="nav-logo" href="<?php echo url_for("@homepage") ?>"></a>
        <?php if ($profile): ?>
            <ul class="nav nav-mainbtn">
                <li class="nmb-ins"><a href="<?php echo url_for("stats/index") ?>"><i></i>Reportes</a></li>
                <li class="nmb-mat"><a href="<?php echo url_for("stats/timeline") ?>"><i></i>Aprendizaje</a></li>
                <li class="nmb-tut"><a href="<?php echo url_for("@video_session") ?>"><i></i>Tutorias</a></li>
            </ul>
            <ul class="nav pull-right">
                <li class="dropdown">
                    <?php include_component("notification","notifications") ?>
                </li>
                <!-- <li><a href="javascript:void(0)" class="nav-btn nav-btn-srch"><i></i></a></li> -->
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

