<h1>Listado de Usuarios</h1>

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
      <td><a href="<?php echo url_for('users/edit?id='.$sf_guard_user->getId()) ?>">Editar</a></td>
    </tr>
  <?php endforeach; ?>

</tbody>
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
<?php endif; ?>

<div class="pagination_desc">
  <strong><?php echo count($pager) ?></strong> Usuarios

  <?php if ($pager->haveToPaginate()): ?>
  - Página <strong><?php echo $pager->getPage() ?> de <?php echo $pager->getLastPage() ?></strong>
<?php endif; ?>
</div>
</table>

<a href="<?php echo url_for('users/new') ?>">Nuevo</a>
