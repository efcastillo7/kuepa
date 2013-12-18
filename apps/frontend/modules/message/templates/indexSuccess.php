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
              <input id="prependedInput" type="text" placeholder="Mensaje nuevo">
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

              <!-- <a href="#" role="button" class="dropdown-toggle a-friend" data-toggle="dropdown">
                <i class="spr ico-add-friend">
                  <i class="spr ico-add-friend-hover"></i>
                </i>
              </a>

              <div class="dropdown">
                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="spr ico-settings">
                    <i class="spr ico-settings-hover"></i>
                  </i>
                </a>
                <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="drop2">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                  <li role="presentation" class="divider"></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                </ul>
              </div> -->

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

          <div class="send-message">
            <form id="send-message">
              <div class="cont-inputs">
                <span class="add-on">
                  <i class="spr ico-message"><i class="spr ico-message-hover"></i></i>
                </span>
                <input type="text" name="content" placeholder="Escribe un mensaje" class="input-send-message">
                <input type="button" class="btn-gray" value="Enviar">
              </div>
            </form>
          </div>

        </div><!-- /col-md-8 chat -->

      </div><!-- /row -->
    </div><!-- /container-messages -->

  </div><!-- /full-back-messages -->

  <div class="templates" style="display: none;">
    <a href="#" class="inbox" data-chat="" data-user="" id="message">
      <span class="cont-chat">
        <i class="spr ico-chat"></i>
      </span>
      <span class="cont-text">
        <span class="name">Marcos Aurelio <i class="connected"></i> </span><br>
        <span class="abstract">Lorem ipsum dolor sit amet con...</span><br>
        <span class="time">-</span>
      </span>
    </a>

    <a href="#" class="inbox" data-chat="" data-user="" id="new-message">
      <span class="cont-chat">
        <!-- <i class="spr ico-chat"></i> -->
      </span>
      <span class="cont-text">
        <span class="name">Marcos Aurelio <i class="connected"></i> </span><br>
        <span class="abstract">Lorem ipsum dolor sit amet con...</span><br>
        <span class="time">-</span>
      </span>
    </a>

    <div class="each-message" id="thread-message">
      <div class="chat-box">
        onsectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi.
      </div>
      <div class="time">Time</div>
    </div>

  </div>

  <script>
  // locals
    function addThreadMessage(values){
      var elem = values.template.clone().attr("id", null); 

      var date = new Date(values.created_at*1000);

      $(elem).addClass(values.in ? "in" : "out");
      $(".chat-box", elem).addClass(values.in ? "in" : "out");
      $(".chat-box", elem).html(values.content);
      // $(".time", elem).html("El " + date.getDay() + "/" + date.getMonth() + "/" + date.getFullYear() + " a las " + date.getMinutes() + ":" + date.getSeconds());
      $(".load-data").append(elem);

      last_message = values.created_at;
    }

    function sendNewMessage(){
      var text = $("#send-message .input-send-message").val();

      ms.send({
        recipients: [active_user],
        subject: "",
        content: text
      });
    }

    function sendMessage(){
      var text = $("#send-message .input-send-message").val();

      ms.reply({
        message_id: chat_id,
        content: text
      });
    }

    //MessageService init
    var ms = new MessageService({
      parseFriends: function(data){
        var template = $(".templates #message").first();
        var template_new = $(".templates #new-message").first();

        $(".cont-inboxes").html("");

        for(var i=0; i<data.length; i++){
          //if is array then is null
          if(data[i].last_message instanceof Array){
            var elem = template_new.clone().attr("id", null); 
            $(".abstract", elem).html('');
          }else{
            var elem = template.clone().attr("id", null); 
            $(elem).attr("data-chat", data[i].last_message.id);
            $(".abstract", elem).html(data[i].last_message.content);
          }

          $(elem).attr("data-user", data[i].id);
          $(".name", elem).html(data[i].nickname);
          $(".cont-inboxes").append(elem);
        }
      },

      parseMessages: function(data){
        var template = $(".templates #message").first();
        $(".cont-inboxes").html("");

        for(var i=0; i<data.length; i++){
          var elem = template.clone().attr("id", null); 
          $(elem).attr("data-chat", data[i].id);
          $(".name", elem).html(data[i].recipients.join(", "));
          $(".abstract", elem).html(data[i].content);
          $(".cont-inboxes").append(elem);
        }          
      },

      parseThread: function(data){
        var template = $(".templates #thread-message").first();

        for(var i=0; i<data.length; i++){
          //add message to thread
          addThreadMessage({
            template: template,
            in: data[i].in,
            content: data[i].content,
            created_at: data[i].created_at,
          });
        } 
        if(data.length > 0){
          $('.cont-scroll').perfectScrollbar({wheelSpeed:30,wheelPropagation:true}).scrollTop($('.cont-scroll')[0].scrollHeight);
        }
        $(".loading").fadeOut(200);
        // $('.cont-scroll').hide().fadeIn()//anima la ventana de mensajes
      },

      replyMessage: function(data, b, c, values){
        $("#send-message .input-send-message").val("");

        var template = $(".templates #thread-message").first();

        //add message to thread
        addThreadMessage({
            template: template,
            in: data.in,
            content: data.content,
            created_at: data.created_at,
        });

        $('.cont-scroll').perfectScrollbar({wheelSpeed:30,wheelPropagation:true}).scrollTop($('.cont-scroll')[0].scrollHeight);
      }
    });

    var chat_id = "";
    var url_send_message;
    var last_message;
    var active_user = "";

    $(document).ready(function(){
      "use strict";

      $(".input-send-message").on("focus",function(){
        $(".ico-message-hover").css("opacity","1");
      });
      $(".input-send-message").on("blur",function(){
        $(".ico-message-hover").css("opacity","0");
      });

      $('.cont-inboxes').perfectScrollbar({wheelSpeed:30,wheelPropagation:true}); //inicializa el scroll de los inbox (barra izquierda)

      //send
      $('form#send-message').submit(function (evt) {
          evt.preventDefault();
          console.log(chat_id)
          //there is an active chat
          if(chat_id != ""){
            sendMessage();
          }else{
            sendNewMessage();
          }
      });

      setInterval(function(){
        if(chat_id != ""){
          ms.getThread({
            message_id: chat_id,
            from_time: last_message
          });
        }
      }, 1000);

      $("form#send-message input[type=button]").click(sendMessage);
    
      // Agrega la clase .active al box de mensajes
      $("body").delegate("a.inbox","click",function(){
        //active
        $(this).addClass("active");
        $(".inbox").not($(this)).removeClass("active");

        //fetch message
        $(".loading").fadeIn();
        chat_id = $(this).data("chat");
        var name = $(".name",this).html();

        $(".load-data").html("");

        $(".chat > .head-message > h1").html(name);

        last_message = null;

        if(chat_id !== ""){
          ms.getThread({
            message_id: chat_id,
            from_time: last_message
          });  
        }else{
          active_user = $(this).data("user");
          //new message
          $(".loading").fadeOut(200);
        }
      });

      //fetch all messages
      ms.getAll();
    });

  </script>