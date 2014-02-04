$(document).ready(function() {
    $(document).tooltip();
    $("div[id^='btn_']").button().click(function( event ) {
        //event.preventDefault();
    });
    $("button").button().click(function( event ) {
        //event.preventDefault();
    });

    if(typeof strAjaxRemovePlayerPath != 'undefined') {
        $("button[id^='delete_player_']").click(function() {
            strId = $(this).attr('id');
            arrId = strId.split('_')
            strPath = strAjaxRemovePlayerPath.replace('PPPP',arrId[2]);
            $.ajax({
                url : strPath,
                success: function(data, textStatus, jqXHR)
                {
                    var decoded = $('<div/>').html(data).text();
                    var myObject = eval('(' + decoded + ')');
                    //alert(myObject.message);
                    if(myObject.error == 0) {
                        $("#player_box_"+arrId[2]).hide( 'explode', {}, 1000);;
                    }
                    if(myObject.from_team == 1) {
                        $('#nb_players').html(myObject.players);
                    }
                    $('#alerts').html(myObject.message);
                },
                error: function (jqXHR, textStatus, errorThrown)
                {

                }
            });
        });
    }
});
