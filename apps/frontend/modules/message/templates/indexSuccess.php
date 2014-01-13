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
                <button type="button" class="btn-inside btn-gray">Enviar</button>
              </div>
            </form>
          </div>

          <!-- <div class="send-message">
            <form id="send-message">
              <div class="cont-inputs">
                <span class="add-on">
                  <i class="spr ico-message"><i class="spr ico-message-hover"></i></i>
                </span>
                <input type="text" name="content" placeholder="Escribe un mensaje" class="input-send-message" disabled>
                <input type="button" class="btn-gray" value="Enviar">
              </div>
            </form>
          </div> -->

        </div><!-- /col-md-8 chat -->

      </div><!-- /row -->
    </div><!-- /container-messages -->

  </div><!-- /full-back-messages -->

  <div class="templates" style="display: none;">
    <a href="#" class="inbox box-data-user" data-chat="" data-user="" data-name="" id="active-contact">
      <span class="cont-chat cont-ico">
        <i class="spr ico-chat"></i>
      </span>
      <span class="cont-text">
        <span class="name"><span>Marcos Aurelio</span> <!-- <i class="connected"></i> --> </span>
        <span class="abstract">Lorem ipsum dolor sit amet con...</span>
        <span class="time">-</span>
      </span>
    </a>

    <a href="#" class="inbox box-data-user" data-chat="" data-user="" data-name="" id="contact">
      <span class="cont-chat cont-ico">
        <!-- <i class="spr ico-chat"></i> -->
      </span>
      <span class="cont-text">
        <span class="name"><span>Marcos Aurelio</span> <!-- <i class="connected"></i> --> </span>
        <span class="abstract">Lorem ipsum dolor sit amet con...</span>
        <span class="time">Argentina, Buenos Aires</span>
      </span>
    </a>

    <div class="each-message" id="message">
      <div class="avatar">
        <img src="">
      </div>
      <div class="chat-box">
        onsectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi.
      </div>
      <div class="time">Time</div>
    </div>

  </div>

  <script>
    

  </script>