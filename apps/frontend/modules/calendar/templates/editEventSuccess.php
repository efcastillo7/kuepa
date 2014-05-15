<section class="container">
    <div class="row head-calendar">
        <div class="col-md-4">
            <h2 class="primary">
                <i class="spr ico-calendar"></i>
                Calendario
            </h2>
        </div>
    </div>
    <form>
        <div class="row new-event">
            <div class="col-md-6">
                <h3 id="eventHeader" class="orange" data-id="<?php echo $id; ?>" data-edit="<?php echo $id ? "editEvent": "createEvent"; ?>"><?php if($id): ?>Editar <?php else: ?>Nuevo <?php endif; ?>evento</h3>
                    <input type="hidden" value="put" name="sf_method">
                    <?php echo $form->renderHiddenFields(); ?>
                    <div class="sf_admin_form_row sf_admin_text sf_admin_form_field_title">
                        <?php echo $form["title"]->render(); ?>
                    </div>

                    <section class="wrapper-date">
                        <div class="wrap-date">
                            <?php echo $form["start_date"]->render(); ?>
                        </div>
                        <div class="wrap-hour">
                            <?php echo $form["start_time"]->render(); ?>
                           <span class="hs">hs</span>
                        </div>
                        <div class="middle">a</div>
                        <div class="wrap-date">
                            <?php echo $form["end_date"]->render(); ?>
                        </div>
                        <div class="wrap-hour">
                            <?php echo $form["end_time"]->render(); ?>
                            <span class="hs">hs</span>
                        </div>
                    </section>
                    <br/>
                    <div class="wrapper-checks">
                        <input id="allDay" class="checkbox checkbox-default" type="checkbox"/>
                        <label for="allDay" name="lbl_allDay" class="chk-label checkbox-default">Todo el día</label>
                    </div>
                    <?php if(isset($form["public"])): ?>
                    <div class="wrapper-checks">
                        <?php echo $form["public"]->render(); ?>
                        <label class="chk-label checkbox-default" name="lbl_public" for="public">
                            <?php echo $form["public"]->renderLabel(); ?>
                        </label>
                    </div>
                    <?php endif; ?>
            </div>
        </div>

        <div class="row new-event">
            <div class="col-md-6">
                <h3 class="blue">Detalles del evento</h3>
                <div class="form-group sf_admin_form_row sf_admin_text sf_admin_form_field_address">
                    <?php echo $form["address"]->renderLabel(); ?>
                    <?php echo $form["address"]->render(); ?>
                </div>
                <div class="sf_admin_form_row sf_admin_text sf_admin_form_field_address">
                    <?php echo $form["component_id"]->renderLabel(); ?>
                    <?php echo $form["component_id"]->render(); ?>
                </div>
                <div class="form-group sf_admin_form_row sf_admin_text sf_admin_form_field_description">
                    <?php echo $form["description"]->renderLabel(); ?>
                    <?php echo $form["description"]->render(); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div style ="display: none; visibility: hidden;">
                    <h3 class="blue">Invitados</h3>
                    <div class="form-group">
                        <label>Agregar invitados</label>
                        <div class="input-append-pos">
                            <div class="cont-inputs">
                                <input type="text" placeholder="Ingresa nombre, usuario o email" class="input-send-message">
                                <button type="button" class="btn-inside btn-gray">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row new-event bottom-row">
            <div class="clearfix"></div>
            <div class="separator margintop marginbottom"></div>
            <div class="col-md-4">
                <button id="btn-save-event" class="btn-primary btn-orange">Guardar</button>
                <button id="btn-cancel-event" class="btn-primary btn-gray">Cancelar</button>
            </div>
        </div>
    </form>
</section>
<div class="push"></div>