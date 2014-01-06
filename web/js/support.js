var iframeMouseOverSupport = false;
var $hoveredElSupport      = {};

$(function(){

    //When a support agent access to a support request
    $(".accessSupport-button").click( onAccessSupportClicked );

    //When a teacher clicks on the Finish Hangout button a modal form is shown
    $(".finishSupport-trigger").click( onSupportFinishTriggered );

    //When a teacher confirms to finish a video session
    $(".finishSupport-button").click( onSupportFinishClicked );

    //Detects when a Start Hangot button is pressed (Hack to detect iframe clicks)
    $(window).blur( onWindowBluredSupport );
    $(".catchHangoutUrl").parent().hover(
        function(){ iframeMouseOverSupport = true; $hoveredElSupport = $(this); },
        function(){ iframeMouseOverSupport = false; $hoveredElSupport = {}; }
    );

    $(".support_status,.accessSupport-button").tooltip();

});

function onAccessSupportClicked(e){
    var $this = $(this);
    var $tr = $this.parents("tr[data-id]");
    var id = $tr.attr("data-id");
    $.getJSON("/support/update_profile",{support_id:id},function(data){
        if(data.status == "success"){
            location.href = "/support";
        }else{
            if(window.console){
                console.log(data.template);
            }
        }
    });

}

/**
 *
 * @param {type} $tr
 * @returns {void}
 */
function onSupportFinishTriggered(e){
    var $this       = $(this);
    var id          = $this.closest("tr").attr("data-id");
    var modal_id    = "modal-finish-support";

    $("#"+modal_id).attr("data-support_id",id);

    triggerModalSuccess({
        id      : modal_id,
        effect  : "md-effect-17"
    });

}

/**
 *
 * @param {type} $tr
 * @returns {void}
 */
function onSupportFinishClicked(e){
    var $modal  = $("#modal-finish-support");
    var $cont   = $("#modal-finish-support-container");
    var id      = $modal.attr("data-support_id");

    e.preventDefault();

    $(".message",$cont).hide();
    $(".loading",$cont).show();

    $.get("/support/finish/id/"+id,function(data){
        $cont.text(data.template);

        if(data.status === "success"){
            location.href="/support";
        }

    },"json");
}

/**
 * Callback to window onBlur
 * @returns {void}
 */
function onWindowBluredSupport(){
    if(iframeMouseOverSupport){
        setTimeout(function(){
            onSupportStartClicked($hoveredElSupport);
        },10);
    }
}