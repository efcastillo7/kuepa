<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $register_code->getId() ?></td>
    </tr>
    <tr>
      <th>Profile:</th>
      <td><?php echo $register_code->getProfileId() ?></td>
    </tr>
    <tr>
      <th>Valid from:</th>
      <td><?php echo $register_code->getValidFrom() ?></td>
    </tr>
    <tr>
      <th>Valid until:</th>
      <td><?php echo $register_code->getValidUntil() ?></td>
    </tr>
    <tr>
      <th>Valid days:</th>
      <td><?php echo $register_code->getValidDays() ?></td>
    </tr>
    <tr>
      <th>College:</th>
      <td><?php echo $register_code->getCollegeId() ?></td>
    </tr>
    <tr>
      <th>Active:</th>
      <td><?php echo $register_code->getActive() ?></td>
    </tr>
    <tr>
      <th>In use:</th>
      <td><?php echo $register_code->getInUse() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('codes/edit?id='.$register_code->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('codes/index') ?>">List</a>
