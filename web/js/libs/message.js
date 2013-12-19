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

  //filter contacts
  $("#prependedInput").keyup(function(e){
    var val = $(this).val();

    $(".inbox").hide();

    if(val != ""){
      $(".inbox[data-name*='" + val + "']:hidden").show();
    }else{
      $(".inbox").show();
    }
  });

  $('.cont-inboxes').perfectScrollbar({wheelSpeed:30,wheelPropagation:true}); //inicializa el scroll de los inbox (barra izquierda)

  //send
  // $('form#send-message').submit();

  setInterval(function(){
    if(chat_id != ""){
      ms.getThread({
        message_id: chat_id,
        from_time: last_message,
        onSuccess: addMessagesToScreen,
        onError: onError
      });
    }
  }, 1000);

  $('form#send-message').submit (function() { 
    if(chat_id != ""){
        replyMessage();
      }else{
        sendMessage();
      }

    return false; 
  });

  $("form#send-message input[type=button]").click(function (evt) {
      evt.preventDefault();
      
      //there is an active chat
      if(chat_id != ""){
        replyMessage();
      }else{
        sendMessage();
      }
  });

  // Agrega la clase .active al box de mensajes
  $("body").delegate("a.inbox","click",function(){
    //enable input
    $(".input-send-message").prop('disabled', false);

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
        from_time: last_message,
        onSuccess: addMessagesToScreen,
        onError: onError
      });  
    }else{
      active_user = $(this).data("user");
      //new message
      $(".loading").fadeOut(200);
    }
  });

  //fetch all messages
  ms.getAll({
    onSuccess: addContacts,
    onError: onError
  });
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
    onSuccess: function(data, b, c){
      addMessageToScreen(data);
      $("#send-message .input-send-message").val("");
    },
    onError: onError
  });
}

function replyMessage(){
  //get values
  var text = $("#send-message .input-send-message").val();

  console.log(chat_id);

  //reply message
  ms.reply({
    message_id: chat_id,
    content: text,
    //if ok add to screen
    onSuccess: function(data, b, c){
      addMessageToScreen(data);
      $("#send-message .input-send-message").val("");
    },
    onError: onError
  });
}

function addMessageToScreen(values){
  //get values
  var template = $(".templates #message");
  elem = template.clone().attr("id", null),
  date = mysqlDateToTimestamp(values.date);

  $(elem).addClass(values.in ? "in" : "out");
  $(".chat-box", elem).addClass(values.in ? "in" : "out");
  $(".chat-box", elem).html(values.content);
  //mejorar
  $(".time", elem).html(timeSince(date*1000));
  $(".load-data").append(elem);

  //update last_message date
  last_message = mysqlDateToTimestamp(values.date);

  $('.cont-scroll').perfectScrollbar({wheelSpeed:30,wheelPropagation:true}).scrollTop($('.cont-scroll')[0].scrollHeight);
}

function addContacts(contacts){
  //clear inboxes
  $(".cont-inboxes").html("");

  //foreach contact add
  for(var i=0; i<contacts.length; i++){
    addContact(contacts[i]);
  }
}

function addContact(values){
  //if is array then is null
  if(values.last_message instanceof Array){
    var template = $(".templates #contact").first();
    var elem = template.clone().attr("id", null); 
    $(".abstract", elem).html('Profesor');
  }else{
    var template = $(".templates #active-contact").first();
    var elem = template.clone().attr("id", null); 
    $(elem).attr("data-chat", values.last_message.id);
    $(".abstract", elem).html(values.last_message.content);
  }
  $(elem).attr("data-user", values.id);
  (elem).attr("data-name", values.nickname);
  $(".name", elem).html(values.nickname);

  //add to screen
  $(".cont-inboxes").append(elem);
}

function addMessagesToScreen(messages){
  //it must have an active conversation

  //add new messages to screen
  if(messages.length > 0){
    for(var i=0; i<messages.length; i++){
      addMessageToScreen(messages[i]);
    }

    $('.cont-scroll').perfectScrollbar({wheelSpeed:30,wheelPropagation:true}).scrollTop($('.cont-scroll')[0].scrollHeight);
  }

  //hide loading
  $(".loading").fadeOut(200);
}

function onError(){
  alert('surgió un erorr');
}