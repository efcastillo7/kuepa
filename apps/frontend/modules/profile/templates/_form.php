<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('profile/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('profile/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'profile/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['nickname']->renderLabel() ?></th>
        <td>
          <?php echo $form['nickname']->renderError() ?>
          <?php echo $form['nickname'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['first_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['first_name']->renderError() ?>
          <?php echo $form['first_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['last_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['last_name']->renderError() ?>
          <?php echo $form['last_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['birthdate']->renderLabel() ?></th>
        <td>
          <?php echo $form['birthdate']->renderError() ?>
          <?php echo $form['birthdate'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['sex']->renderLabel() ?></th>
        <td>
          <?php echo $form['sex']->renderError() ?>
          <?php echo $form['sex'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['valid_until']->renderLabel() ?></th>
        <td>
          <?php echo $form['valid_until']->renderError() ?>
          <?php echo $form['valid_until'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['colleges_list']->renderLabel() ?></th>
        <td>
          <?php echo $form['colleges_list']->renderError() ?>
          <?php echo $form['colleges_list'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['components_list']->renderLabel() ?></th>
        <td>
          <?php echo $form['components_list']->renderError() ?>
          <?php echo $form['components_list'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
