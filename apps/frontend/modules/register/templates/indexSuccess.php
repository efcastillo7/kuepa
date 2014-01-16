  <section class="container">
    <div class="row head-calendar">
      <div class="col-md-12">
        <h2 class="primary">
          Arranca hoy mismo a estudiar completando el siguiente formulario
        </h2>
      </div>

    </div><!-- /row -->

	<form action="" method="POST" enctype='multipart/form-data'>
		<?php echo $form->renderGlobalErrors()?>
	    <div class="row new-event form">
	      <div class="col-md-6">
	          <?php echo $form['nickname']->renderRow(array('class' => 'input-big')); ?>
	          <?php echo $form['first_name']->renderRow(array('class' => 'input-big')); ?>
	          <?php echo $form['last_name']->renderRow(array('class' => 'input-big')); ?>
	          <?php echo $form['email_address']->renderRow(array('class' => 'input-big')); ?>
	          <?php echo $form['birthdate']->renderRow(array('class' => 'selectpicker')); ?>
	          <?php echo $form['sex']->renderRow(array('class' => 'selectpicker')); ?>
	          <?php echo $form['password']->renderRow(array('class' => 'input-big')); ?>
	          <?php echo $form['repassword']->renderRow(array('class' => 'input-big')); ?>
	          <?php echo $form['code']->renderRow(array('class' => 'input-big')); ?>
	      </div><!-- /col-md-6 -->
	    </div><!-- /row -->

		<div class="clearfix"></div>
		<div class="separator margintop marginbottom"></div>

		<div class="col-md-4">
		  <button type="submit" class="btn-primary btn-orange">Confirmar</button>
		  <button class="btn-primary btn-gray">Cancelar</button>
		</div>

		<?php echo $form->renderHiddenFields(false)?>
	</form>

    </div><!-- /row -->

  </section><!-- /container -->