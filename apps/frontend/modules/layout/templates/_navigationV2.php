<nav class="navbar navbar-default navbar-fixed-top nav-message">
    <div class="container messages">
      <div class="navbar-header">

        <ul class="nav nav-pills">
          <!-- <li class="dropdown">

            <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
              <i class="spr ico-menu"><i class="spr ico-menu-hover"></i></i>
            </a>

            <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
              <li role="presentation"><a role="menuitem" tabindex="-1" href="http://google.com">Action</a></li>
              <li role="presentation"><a role="menuitem" tabindex="-1" href="#anotherAction">Another action</a></li>
              <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
              <li role="presentation" class="divider"></li>
              <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
            </ul>
          </li> -->
          <li><a href="index.php"><img src="img/kuepa_navbar.png" alt="kuepa" title="kuepa"></a></li>
        </ul>

      </div><!-- /navbar-header -->

      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav nav-messages">
          <li>
            <a href="<?php echo url_for("stats/index") ?>" class="a-subjects">
              <i class="spr ico-instruments"><i class="spr ico-instruments-hover"></i></i>Reportes
            </a>
          </li>
          <li>
            <a href="<?php echo url_for("stats/timeline") ?>" class="a-instruments">
              <i class="spr ico-subjects"><i class="spr ico-subjects-hover"></i></i>Aprendizaje
            </a>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <!-- <li>
            <a href="#">
              <i class="spr ico-pin"><i class="spr ico-pin-hover"></i></i>
              <span class="counter animated shake">4</span>
            </a>
          </li>

          <li>
            <a href="">
              <i class="spr ico-search"><i class="spr ico-search-hover"></i></i>
            </a>
          </li> -->

          <li class="dropdown">
            <a id="drop2" href="#" role="button" class="dropdown-toggle a-arrow" data-toggle="dropdown">
              <i class="spr ico-user"><i class="spr ico-user-hover"></i></i>
              <i class=""><?php echo $profile->getNickname() ?></i>
              <i class="spr ico-arrow-down"></i>
              <i class="spr ico-arrow-down-hover"></i>
            </a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
              <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo url_for('user/index') ?>">Editar Perfil</a></li>
              <li role="presentation" class="divider"></li>
              <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo url_for('@sf_guard_signout') ?>">Logout</a></li>
            </ul>
          </li>


        </ul>


      </div><!-- /navbar-collapse collapse -->
    </div><!-- /container -->
  </nav><!-- /navbar navbar-fixed-top -->