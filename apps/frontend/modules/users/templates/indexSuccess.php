<h1>Listado de Usuarios</h1>

<a class="btn btn-success" href="<?php echo url_for('users/new') ?>">Agregar Nuevo</a>

<div class="row">
  <form class="navbar-form navbar-left" role="search">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Filtros</h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-2">
            <div class="input-group">
              <span class="input-group-addon">Nombre</span>
              <?php echo $searchForm['first_name']->render(array('class' => 'form-control', 'placeholder' => 'Nombre')) ?>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="input-group">
              <span class="input-group-addon">Apellido</span>
              <?php echo $searchForm['last_name']->render(array('class' => 'form-control', 'placeholder' => 'Apellido')) ?>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="input-group">
              <span class="input-group-addon">Email</span>
              <?php echo $searchForm['email_address']->render(array('class' => 'form-control', 'placeholder' => 'Email')) ?>
            </div>
          </div>
          <div class="col-lg-2">
            <div class="input-group">
              <span class="input-group-addon">Usuario</span>
              <?php echo $searchForm['username']->render(array('class' => 'form-control', 'placeholder' => 'Usuario')) ?>
            </div>
          </div>
          <div class="col-lg-1">
            <button type="submit" class="btn btn-default">Buscar</button>
          </div>
          <div class="col-lg-1">
            <a href="<?php echo url_for("users/index") ?>" class="btn btn-default">Limpiar</a>
          </div>
        </div>
      </div>
    </div>

    <?php echo $searchForm->renderHiddenFields() ?>
  </form>
</div>

<div class="row">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Usuarios</h3>
    </div>
    <div class="panel-body">
      <table class="table">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Usuario</th>
            <th>Activo</th>
            <th>Último Acceso</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($pager->getResults() as $sf_guard_user): ?>
          <tr>
            <td><?php echo $sf_guard_user->getFirstName() ?></td>
            <td><?php echo $sf_guard_user->getLastName() ?></td>
            <td><?php echo $sf_guard_user->getEmailAddress() ?></td>
            <td><?php echo $sf_guard_user->getUsername() ?></td>
            <td><?php echo $sf_guard_user->getIsActive() ?></td>
            <td><?php echo $sf_guard_user->getLastLogin() ?></td>
            <td><a class="btn btn-info btn-sm" href="<?php echo url_for('users/edit?id='.$sf_guard_user->getId()) ?>">Editar</a></td>
          </tr>
        <?php endforeach; ?>

        </tbody>
      </table>

      <?php if ($pager->haveToPaginate()): ?>
        <ul class="pagination">
          <li><a href="<?php echo url_for('users/index') ?>?page=1">&laquo;</a></li>
          <li><a href="<?php echo url_for('users/index') ?>?page=<?php echo $pager->getPreviousPage() ?>">&laquo;</a></li>
          <?php foreach ($pager->getLinks() as $page): ?>
            <?php if ($page == $pager->getPage()): ?>
              <li class="active"><a href="#"><?php echo $page ?></a></li>
            <?php else: ?>
              <li><a href="<?php echo url_for('users/index') ?>?page=<?php echo $page ?>"><?php echo $page ?></a></li>
            <?php endif; ?>
          <?php endforeach; ?>
          
          <li><a href="<?php echo url_for('users/index') ?>?page=<?php echo $pager->getNextPage() ?>">&raquo;</a></li>
          <li><a href="<?php echo url_for('users/index') ?>?page=<?php echo $pager->getLastPage() ?>">&raquo;</a></li>
        </ul>

        <div class="pagination_desc">
          Página <span class="badge"><?php echo $pager->getPage() ?></span> de <span class="badge"><?php echo $pager->getLastPage() ?></span>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
