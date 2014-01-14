<?php if($profile): ?>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
    <a href="<?php echo url_for("@homepage") ?>" class="cbp-hom"><i></i>Inicio</a>
    <!-- <a href="#" class="cbp-cal"><i></i>Calendario</a> -->
    <a href="<?php echo url_for("@messages") ?>" class="cbp-msg"><i></i>Mensajes</a>
    <a href="<?php echo url_for("@video_session") ?>" class="cbp-tsk"><i></i>Tutorias</a>
    <!-- <a href="#" class="cbp-tsk"><i></i>Tareas</a> -->
    <a href="<?php echo url_for('user/index') ?>" class="cbp-usr"><i></i>Mi Perfil</a>
    <!-- <a href="" class="cbp-set"><i></i>Ajustes</a> -->
    <a href="<?php echo url_for('@sf_guard_signout') ?>" class="cbp-set"><i></i>Salir</a>
</nav>
<?php endif; ?>

<nav class="navbar navbar-default navbar-fixed-top nav-header">
    <div class="container">
      <div class="navbar-header">

        <ul class="nav nav-pills">
          <li>
            <a id="showLeft" href="#" role="button"><i class="spr ico-menu"><i class="spr ico-menu-hover"></i></i></a>
          </li>
          <li><a href="index.php"><img src="/assets/v2/img/kuepa_navbar.png" alt="kuepa" title="kuepa"></a></li>
        </ul>

      </div><!-- /navbar-header -->

      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav nav-items">
          <li>
            <a href="#" class="a-subjects">
              <i class="spr ico-subjects"><i class="spr ico-subjects-hover"></i></i>Materias
            </a>
          </li>
          <li>
            <a href="#" class="a-instruments">
              <i class="spr ico-instruments"><i class="spr ico-instruments-hover"></i></i>Instrumentos
            </a>
          </li>
          <li>
            <a href="<?php echo url_for("@video_session") ?>" class="a-instruments">
              <i class="spr ico-subjects"><i class="spr ico-subjects-hover"></i></i>Tutorias
            </a>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a id="notifications" href="#" role="button" class="dropdown-toggle a-arrow" data-toggle="dropdown">
              <i class="spr ico-pin"><i class="spr ico-pin-hover"></i></i>
              <span class="counter animated shake">4</span>
            </a>

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

          </li>

          <li>
            <a href="#" id="open-learning-path">
              <i class="spr ico-search"><i class="spr ico-search-hover"></i></i>
            </a>
          </li>

          <li class="dropdown">
            <a id="drop2" href="#" role="button">
              <i class="spr ico-user"><i class="spr ico-user-hover"></i></i>
              <!-- <i class="spr ico-arrow-down"></i> -->
              <!-- <i class="spr ico-arrow-down-hover"></i> -->
            </a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
              <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="requestSupport-button">Llamar a soporte</a></li>
              <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo url_for('user/index') ?>">Editar Perfil</a></li>
              <li role="presentation" class="divider"></li>
              <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo url_for('@sf_guard_signout') ?>">Salir</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /navbar-collapse collapse -->
    </div><!-- /container -->
  </nav><!-- /navbar navbar-fixed-top -->

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
