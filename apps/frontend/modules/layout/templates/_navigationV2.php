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
      <?php if ($sf_user->hasCredential("access_video_sessions")): ?>
      <li class="nmb-tut"><a href="<?php echo url_for("@video_session") ?>"><i></i>Tutorias</a></li>
      <?php endif; ?>
    </ul>

    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <?php include_component("notification","notifications") ?>
      </li>
      <!-- <li><a href="javascript:void(0)" class="nav-btn nav-btn-srch"><i></i></a></li> -->
      <li class="dropdown">

        <a id="drop1" href="#" role="button" class="nav-btn nav-btn-prfl dropdown-toggle" data-toggle="dropdown">
          <span class="nav-avatar">
            <img src="<?php echo $profile->getAvatarImage() ?>" class="">
          </span>
        </a>
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
    <?php if ($sf_user->hasCredential("access_messages")): ?>
    <a href="<?php echo url_for("@messages") ?>" class="cbp-msg"><i></i>Mensajes</a>
    <?php endif; ?>
    <?php if ($sf_user->hasCredential("access_video_sessions")): ?>
    <a href="<?php echo url_for("@video_session") ?>" class="cbp-tsk"><i></i>Tutorias</a> 
    <?php endif; ?>
    <a href="<?php echo url_for('user/index') ?>" class="cbp-usr"><i></i>Mi Perfil</a>
    <a href="<?php echo url_for('@sf_guard_signout') ?>" class="cbp-set"><i></i>Salir</a>
  </div>

  <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
    <div class="title">Camino de Aprendizaje <span id="edit-learning-path"><i class="icon-edit"></i></span></div>
    <?php include_partial("layout/learning_path_item_template") ?>
  </div>
<?php endif; ?>