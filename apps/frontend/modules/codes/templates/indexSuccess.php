<h1>Register codes List</h1>

<table class="table">
  <thead>
    <tr>
      <th>Code</th>
      <th>Profile</th>
      <th>Valid from</th>
      <th>Valid until</th>
      <th>Valid days</th>
      <th>College</th>
      <th>Active</th>
      <th>In use</th>
      <th>Options</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($register_codes as $register_code): ?>
    <tr>
      <td><?php echo $register_code->getId() ?></td>
      <td><?php echo $register_code->getProfile() ? $register_code->getProfile()->getFullName() : ""  ?></td>
      <td><?php echo $register_code->getValidFrom() ?></td>
      <td><?php echo $register_code->getValidUntil() ?></td>
      <td><?php echo $register_code->getValidDays() ?></td>
      <td><?php echo $register_code->getCollege() ?></td>
      <td><?php echo $register_code->getActive() ? "Si" : "No" ?></td>
      <td><?php echo $register_code->getInUse() > 0 ? "Si" : "No" ?></td>
      <td><a href="<?php echo url_for('codes/show?id='.$register_code->getId()) ?>">Edit</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('codes/new') ?>">New</a>
