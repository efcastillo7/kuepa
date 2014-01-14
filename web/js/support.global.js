$(function(){

    //When a student clicks on the start support button
    $(".requestSupport-button").click( onSupportClicked );
});

/**
 * Callback triggered when a Start Hangout button is pressd
 *
 * @param jQuery $tr
 * @returns {void}
 */
function onSupportClicked(e){

    e.preventDefault();

    triggerModalSuccess({
        id      : "modal-update-support-url",
        title   : "Iniciar sesión de soporte...",
        effect  : "md-effect-17"
    });

    gapi.hangout.render('placeholder-support_hangout', {
        'render': 'createhangout',
        'initial_apps':[{
            'app_id':'36700081185',
            'start_data':{'profile_id':''+$("#profile_id_support").val(),'type':'support'},
            'app_type':'ROOM_APP'
        }]
    });

}