//MessageService init
var ms = new MessageService();
var chat_id = "";
var url_send_message;
var last_message;
var active_user = "";

function mysqlDateToTimestamp(date){
  var t = date.split(/[- :]/);

// Apply each element to the Date function
  var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

  return d.getTime()/1000;
}

$(document).ready(function(){
  "use strict";

  $(".input-send-message").on("focus",function(){
    $(".ico-message-hover").css("opacity","1");
  });
  $(".input-send-message").on("blur",function(){
    $(".ico-message-hover").css("opacity","0");
  });
  
  $(".cont-scroll").scrollTop($(".cont-scroll").height()*2);
  $(".cont-scroll").perfectScrollbar('update');
  
  //filter contacts
  $("#prependedInput").keyup(function(e){
    var val = $(this).val();
    $(".inbox").hide();

    if(val != ""){
      $(".inbox[data-name*='" + val.toLowerCase() + "']:hidden").show();
    }else{
      $(".inbox").show();
    }
  });

  $('.cont-inboxes').perfectScrollbar({wheelSpeed:30,wheelPropagation:true}); //inicializa el scroll de los inbox (barra izquierda)
  $('.cont-scroll').perfectScrollbar({wheelSpeed:30,wheelPropagation:true});

  //send
  // $('form#send-message').submit();

setInterval(function(){
   if( typeof chat_id !== "undefined" && chat_id != ""){
    ms.getThread({
      message_id: chat_id,
      from_time: last_message,
      onSuccess: addMessagesToScreen,
      onError: onError
    });
  }
}, 3000);

  $('form#send-message').submit (function() { 
   if(typeof chat_id !== "undefined"){
         replyMessage();
      }else{
         sendMessage();
      }
      $("#send-message .input-send-message").val("");
    return false; 
  });


  // Agrega la clase .active al box de mensajes
  $("body").delegate("a.inbox","click",function(){
    //enable input
    $(".input-send-message").prop('disabled', false);

    //remove bg if has message
    $(this).removeClass('unread');

    //active
    $(this).addClass("active");
    $(".inbox").not($(this)).removeClass("active");

    //fetch message
    $(".loading").fadeIn();
    chat_id = $(this).attr("data-chat");
    var name = $(".name",this).html();

    $(".load-data").html("");

    $(".chat > .head-message > h1").html(name);
    
    last_message = null;
    if(typeof chat_id === "undefined"){
      active_user = $(this).data("user");;
      //new message
      $(".loading").fadeOut(200);
    }
    
  });

  //fetch all messages
  ms.getAll({
    onSuccess: addContacts,
    onError: onError
  });

//  set interval for unread messages
   setInterval(function(){
     ms.getUnreadMessages({
       onSuccess: setContactAsUnread,
       onError: onError
     });
  }, 3000);
});

//functions for window management
function sendMessage(){
  //get values
  var text = $("#send-message .input-send-message").val();
  //send message
  ms.send({
    recipients: [active_user],
    subject: "",
    content: text,
    //if ok add to screen
    onSuccess: function(messages, b, c){
      
      message = messages[0];
      $("#" + active_user).attr("data-chat", message.id);
      $("#" + active_user + " .cont-chat.cont-ico i").removeClass('hidden');
      $("#" + active_user + " .cont-text .abstract").text(message.content);
      
      addMessagesToScreen(messages);

      //set active chat
      chat_id = message.id;
    },
    onError: onError
  });
}

function replyMessage(){
  //get values
  var text = $("#send-message .input-send-message").val();
  //reply message
  ms.reply({
    message_id: chat_id,
    content: text,
    //if ok add to screen
    onSuccess: function(data, b, c){
        
      $("a[data-chat='" + chat_id + "'] .cont-text .abstract").text(data.content);

      last_message = data.created_at;
      addMessageToScreen(data);
    },
    onError: onError
  });
}

function setContactAsUnread(message){
  if(message.length){
    var elem = $("#"+$.trim(message[0].author_id));
    //set chat id if undefined
    if(elem.data('chat') == ""){
      elem.attr('data-chat', message[0].id);
    }
    elem.find(".abstract").text(message[0].content);
    //check for class
    if(!elem.hasClass('unread')){
        elem.prependTo(".cont-inboxes");
        elem.addClass('unread');
    }
    //effect
    $(elem).show("highlight", 3000 );
    //add icon if is hidden
    $(".cont-chat.cont-ico i", elem).removeClass('hidden');
  }
}

function addContacts(contacts){
  //clear inboxes
  $(".cont-inboxes").html("");
  // CARGO TODOS LOS CONTACTOS
  $(".cont-inboxes").append(new EJS({url: "/js/templates/messages/contacts.ejs"}).render({contacts: contacts}));
}

function addMessageToScreen(message)
{
    $(".inbox[data-name='" + message.author.toLowerCase() + "'] .cont-text .abstract").text(message.content);
    $(".load-data").append(new EJS({url: "/js/templates/messages/message.ejs"}).render({message: message}));
    $('.cont-scroll').scrollTop($('.load-data').height());
}

function addMessagesToScreen(messages)
{
  
  if(messages.length > 0){
    //update time
    $(".inbox[data-name='" + messages[messages.length-1].author.toLowerCase() + "'] .cont-text .abstract").text(messages[messages.length-1].content);
    last_message = messages[messages.length-1].created_at;
    $(".load-data").append(new EJS({url: "/js/templates/messages/messages.ejs"}).render({messages: messages}));
    $('.cont-scroll').scrollTop($('.load-data').height());
  }
  //hide loading
  $(".loading").fadeOut(200);
}

function onError(messages){
  alert('surgió un error');
}