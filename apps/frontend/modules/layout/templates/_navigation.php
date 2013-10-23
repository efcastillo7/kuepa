<!-- navbar -->
<div class="plataforma-nav navbar navbar-fixed-top">
    <div class="navbar-inner">
            <!-- <ul class="nav">
                <li class="nav-menu">
                    <a href="#myModal" role="button" class="nav-menu-icon" data-toggle="modal"><span>Menu</span></a>
                </li>
            </ul> -->
            <?php if($profile): ?>
            <a class="nav-logo" href="<?php echo url_for("@homepage") ?>"></a>
            <ul class="nav nav-mainbtn">
                <li class="nmb-ins"><a href="<?php echo url_for("stats/index") ?>"><i></i>Reportes</a></li>
                <li class="nmb-mat"><a href="<?php echo url_for("stats/timeline") ?>"><i></i>Aprendizaje</a></li>
            </ul>
            <ul class="nav pull-right">
                <!-- <li><a href="" class="nav-btn nav-btn-srch"><i></i></a></li> -->
                <!-- <li class="dropdown">
                    <a id="drop2" href="#" role="button" class="nav-btn nav-btn-ntfc dropdown-toggle" data-toggle="dropdown"><i></i></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="http://google.com">Action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#anotherAction">Another action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                    </ul>
                </li> -->
                <li class="dropdown">
                    <a id="drop1" href="#" role="button" class="nav-btn nav-btn-prfl dropdown-toggle" data-toggle="dropdown"><i></i> <?php echo $profile->getNickname() ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo url_for('@sf_guard_signout') ?>">Log out</a></li>
                    </ul>
                </li>
            </ul>
            <?php endif; ?>
    </div>
</div><!-- /navbar -->

    
<!-- Modal -->
<div id="myModal" class="nav-menu-modal modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <ul class="unstyled">
            <li class="nav-menu-btn nmb-ini"><a href=""><i></i>Inicio</a></li>
            <li class="nav-menu-btn nmb-cal"><a href=""><i></i>Calendario</a></li>
            <li class="nav-menu-btn nmb-msg"><a href=""><i></i>Mensajes</a></li>
            <li class="nav-menu-btn nmb-tar"><a href=""><i></i>Tareas</a></li>
            <li class="nav-menu-btn nmb-mat"><a href=""><i></i>Materias</a></li>
            <li class="nav-menu-btn nmb-dsh"><a href=""><i></i>Dashboard</a></li>
            <li class="nav-menu-btn nmb-prf"><a href=""><i></i>Mi Perfil</a></li>
            <li class="nav-menu-btn nmb-ajs"><a href=""><i></i>Ajustes</a></li>
        </ul>
</div>