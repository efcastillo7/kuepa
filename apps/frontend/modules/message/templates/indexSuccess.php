<?php use_javascript("/js/libs/messageService.js") ?>
<?php use_javascript("/js/libs/datetime.js") ?>
<?php use_javascript("/js/libs/message.js") ?>

  <div class="container">
    <div class="head-message">
      <h1 class="secondary">
        <i class="spr ico-messages"></i>Mensajes
      </h1>
    </div><!-- /row -->
  </div>

  <div class="full-back-messages">

    <div class="container container-messages">

      <div class="row">

        <div class="col-md-4 omega">
          <form>
            <div class="input-prepend">
              <span class="add-on">
                <i class="spr ico-new-message"></i>
              </span>
              <input id="prependedInput" type="text" placeholder="Filtrar contacto">
              <input type="hidden" name="">
            </div>
          </form>

          <div class="cont-inboxes">
              
          </div><!-- /cont-inboxes -->
        </div><!-- /col-md-4 -->

        <div class="col-md-8 chat alpha">
          <div class="head-message">
            <h1>Seleccione una conversación</span></h1>

            <div class="right">

            </div><!-- /right -->
          </div><!-- /head-message -->

          <div class="body-message">

            <div class="loading">
              <div class="content">
                <img src="/assets/v2/img/loading.GIF"><br>
                <span>Cargando...</span>
              </div>
            </div>

            <div class="cont-scroll scroll">
              <?php /* ACA SE CARGAN LOS MENSAJES (CHAT) */ ?>
              <div class="load-data"></div>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>
          </div><!-- /body-message -->

          <div class="input-append-pos send-message">
            <form id="send-message">
              <div class="cont-inputs">
                <span class="add-on">
                  <i class="spr ico-message"><i class="spr ico-message-hover"></i></i>
                </span>
                <input type="text" placeholder="Escribe un mensaje" class="input-send-message" disabled>
                <button type="submit" class="btn-inside btn-gray">Enviar</button>
              </div>
            </form>
          </div>

        </div><!-- /col-md-8 chat -->

      </div><!-- /row -->
    </div><!-- /container-messages -->

  </div><!-- /full-back-messages -->