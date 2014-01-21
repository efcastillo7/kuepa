<nav class="navbar navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <?php if($profile):?>
    <ul class="nav">
      <li class="nav-menu">
        <a id="showLeft" role="button" class="nav-menu-icon"><span>Toggle Menu</span></a>
      </li>
    </ul>
    <?php endif; ?>
    <a class="nav-logo navbar-brand" href="<?php echo url_for("@homepage") ?>"></a>
  </div>

  <?php if($profile):?>
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse">
    <ul class="nav navbar-nav nav-mainbtn">
      <li class="nmb-ins"><a href="<?php echo url_for("stats/index") ?>"><i></i>Reportes</a></li>
      <li class="nmb-mat"><a href="<?php echo url_for("stats/timeline") ?>"><i></i>Aprendizaje</a></li>
      <li class="nmb-tut"><a href="<?php echo url_for("@video_session") ?>"><i></i>Tutorias</a></li>
    </ul>

    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a id="drop2" href="#" role="button" class="nav-btn nav-btn-ntfc dropdown-toggle" data-toggle="dropdown"><i></i></a>

        <!-- Notifications Dropdown -->
        <?php if(false): ?>
        <div class="dropdown-menu notifications arrow-right-img" role="menu" aria-labelledby="notifications">
          <h1>Notificaciones</h1>
          <div class="cont-notifications">
            <div class="item event">
              <h2>
                <a href="#"><span class="name">Marcos Aurelio</span></a>
                <span>agregó un nuevo evento:</span>
              </h2>
              <div class="left">
                <i class="spr ico-notification-calendar"></i>
              </div>
              <div class="">
                <a href="#">
                  <span class="text">Repaso Biología - Organismos Unicelulares</span>
                  <span class="time">31/08/2013 de 15hs a 17hs</span>
                </a>
              </div>
            </div><!-- item -->
            <div class="item message">
              <h2>
                <span>Mensaje de</span>
                <a href="#"><span class="name">Esteban Pichot</span></a>
              </h2>
              <div class="left">
                <i class="spr ico-notification-message"></i>
              </div>
              <div class="">
                <a href="#">
                  <span class="text">Horacio, la función es así:...</span>
                  <span class="time">Hace 2 horas</span>
                </a>
              </div>
            </div><!-- item -->
            <div class="item task">
              <h2>
                <a href="#"><span class="name">Javier Terrada</span></a>
                <span>asignó una nueva tarea:</span>
              </h2>
              <div class="left">
                <i class="spr ico-notification-task"></i>
              </div>
              <div class="">
                <a href="#">
                  <span class="text">Ejercitación álgebra</span>
                  <span class="time">Para el15/09/2013 a las 16hs</span>
                </a>
              </div>
            </div><!-- item -->
            <div class="item task">
              <h2>
                <a href="#"><span class="name">Javier Terrada</span></a>
                <span>asignó una nueva tarea:</span>
              </h2>
              <div class="left">
                <i class="spr ico-notification-task"></i>
              </div>
              <div class="">
                <a href="#">
                  <span class="text">Ejercitación álgebra</span>
                  <span class="time">Para el15/09/2013 a las 16hs</span>
                </a>
              </div>
            </div><!-- item -->
          </div><!-- /cont-notifications -->
          <div class="cont-button">
            <button class="btn-tiny btn-gray">Ver todas</button>
          </div>
        </div><!-- /dropdown-menu -->
      <?php endif; ?>


      </li>
      <li><a href="javascript:void(0)" class="nav-btn nav-btn-srch"><i></i></a></li>
      <li class="dropdown">
        <a id="drop1" href="#" role="button" class="nav-btn nav-btn-prfl dropdown-toggle" data-toggle="dropdown"><i></i></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
          <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo url_for('user/index') ?>">Editar perfil</a></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo url_for('@sf_guard_signout') ?>">Log out</a></li>
        </ul>
      </li>
      <li><a href="javascript:void(0)" class="nav-btn nav-btn-path" id="open-learning-path"><i></i></a></li>
    </ul>

    
  </div><!-- /.navbar-collapse -->
  <?php endif; ?>
</nav>




<?php if($profile):?>
  <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
    <a href="<?php echo url_for("@homepage") ?>" class="cbp-hom"><i></i>Inicio</a>
    <a href="<?php echo url_for("@messages") ?>" class="cbp-msg"><i></i>Mensajes</a>
    <a href="<?php echo url_for('user/index') ?>" class="cbp-usr"><i></i>Mi Perfil</a>
    <a href="<?php echo url_for('@sf_guard_signout') ?>" class="cbp-set"><i></i>Salir</a>
  </div>

  <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
    <div class="title">Camino de Aprendizaje <span id="edit-learning-path"><i class="icon-edit"></i></span></div>
    <?php include_partial("layout/learning_path_item_template") ?>
  </div>
<?php endif; ?>