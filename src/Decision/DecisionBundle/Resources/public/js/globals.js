$(document).ready(function() {
    $("div[id^='btn_']").button().click(function( event ) {
        //event.preventDefault();
    });
    $("button").button().click(function( event ) {
        //event.preventDefault();
    });

    if(typeof strAjaxDelPlayer != 'undefined') {
        $("button[id^='delete_player_'").click(function() {
            strId = $(this).attr('id');
            arrId = strId.split('_')
            strPath = strAjaxDelPlayer.replace('PPPP',arrId[2]);
            $.ajax({
                url : strPath,
                success: function(data, textStatus, jqXHR)
                {
                    var decoded = $('<div/>').html(data).text();
                    var myObject = eval('(' + decoded + ')');
                    //alert(myObject.message);
                    if(myObject.error != 0) {
                        $(this).hide( 'explode', {}, 1000);;
                    }
                    $('#nb_players').html(myObject.players);
                    $('#alerts').html(myObject.message);
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                        
                }
            });
        });
    }
});