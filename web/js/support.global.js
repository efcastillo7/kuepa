$(function(){

    initEditSupportForm();

    //When a student clicks on the start support button
    $(".requestSupport-button").click( onSupportClicked );
});

/**
 * Instanciates an ajax form for the hangout url submission
 * @returns void
 */
function initEditSupportForm(){
    $("form","#modal-update-support-url").ajaxForm({
        success : onSupportFormSuccess,
        dataType: 'json'
    });
}

/**
 * Callback to the form submit success
 *
 * @param string data
 * @returns {void}
 */
function onSupportFormSuccess(data){
    var $hangoutUrlModal = $("#modal-update-support-url-container");

    $hangoutUrlModal
        .html(data.template)
        .show();

    if (data.status === "success") {
        //location.reload();
    }
}

/**
 * Callback triggered when a Start Hangout button is pressd
 *
 * @param jQuery $tr
 * @returns {void}
 */
function onSupportClicked(){
    var $hangoutUrlModal    = $("#modal-update-support-url");
    var $hidden             = $("[name=support_id]",$hangoutUrlModal);
    var $_creating          = $(".creating",$hangoutUrlModal);
    var $_form              = $(".urlForm",$hangoutUrlModal);
    var url                 = "https://talkgadget.google.com/hangouts/_/?hl=en&hcb=0&lm1=1388977962798&hscid=1388977962798205692&ssc=WyIiLDAsbnVsbCxudWxsLG51bGwsW10sbnVsbCxudWxsLG51bGwsbnVsbCxudWxsLG51bGwsbnVsbCxudWxsLG51bGwsWzEzODg5Nzc5NjI3OThdLG51bGwsbnVsbCxbXSxudWxsLCIxMzg4OTc3OTYyNzk4MjA1NjkyIixudWxsLG51bGwsbnVsbCxudWxsLG51bGwsbnVsbCxudWxsLFtdLFtdLG51bGwsbnVsbCxudWxsLFtdLG51bGwsbnVsbCxudWxsLFtdLG51bGwsbnVsbCxbWyIzNjcwMDA4MTE4NSIsImRRdzR3OVdnWGNRIiwyXV1d";

    triggerModalSuccess({
        id      : "modal-update-support-url",
        title   : "Iniciando sesión con soporte...",
        effect  : "md-effect-17"
    });

    $_creating.show(0);
    $_form.hide(0);

    window.open(url, "Sesión de soporte","width=900,height=700");

    $.getJSON("/support/create",function(data){
        if(data.status == "success"){
            $hidden.val(data.id);
            $_creating.slideUp(500);
            $_form.slideDown(500);
        }else{

        }
    });

}