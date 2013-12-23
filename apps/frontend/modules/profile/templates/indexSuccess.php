<h1>Profiles List</h1>

<table class="table">
  <thead>
    <tr>
      <th>Id</th>
      <th>Sf guard user</th>
      <th>Nickname</th>
      <th>First name</th>
      <th>Last name</th>
      <th>Birthdate</th>
      <th>Sex</th>
      <th>Valid until</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Deleted at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($profiles as $profile): ?>
    <tr>
      <td><a href="<?php echo url_for('profile/edit?id='.$profile->getId()) ?>"><?php echo $profile->getId() ?></a></td>
      <td><?php echo $profile->getSfGuardUserId() ?></td>
      <td><?php echo $profile->getNickname() ?></td>
      <td><?php echo $profile->getFirstName() ?></td>
      <td><?php echo $profile->getLastName() ?></td>
      <td><?php echo $profile->getBirthdate() ?></td>
      <td><?php echo $profile->getSex() ?></td>
      <td><?php echo $profile->getValidUntil() ?></td>
      <td><?php echo $profile->getCreatedAt() ?></td>
      <td><?php echo $profile->getUpdatedAt() ?></td>
      <td><?php echo $profile->getDeletedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('profile/new') ?>">New</a>
