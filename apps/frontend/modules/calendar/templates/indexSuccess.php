  <section class="container">
    <div class="row head-calendar">
      <div class="col-xs-4">
        <h2 class="primary">
          <i class="spr ico-calendar"></i>
          Calendario
        </h2>
      </div>
    </div>

    <?php include("aside_calendar.php"); ?>

    <div id="calendar"></div>

    <div class="add-event">
        <div class="close-cluetip" id="close-add-event"></div>
          <h3 class="date"></h3>
          <div>
            <?php echo $form["title"]->render(); ?>
          </div>
          <?php echo $form["component_id"]->render(); ?>
          <?php if(isset($form["public"])): ?>
          <div class="wrapper-checks">
              <?php echo $form["public"]->render(); ?>
              <label class="chk-label checkbox-default" name="lbl_public" for="public">
                  <?php echo $form["public"]->renderLabel(); ?>
              </label>
          </div>
          <?php endif; ?>
        <div>
        <button id="btn-add-event" class="btn-small btn-orange">Crear evento</button>
        <a href="<?php echo url_for('calendar/editEvent'); ?>" id="btn-edit-event">Editar evento >></a>
      </div>
      <i class="spr ico-arrow-tooltip"></i>
    </div>

  </section><!-- /container -->
<div class="push"></div>