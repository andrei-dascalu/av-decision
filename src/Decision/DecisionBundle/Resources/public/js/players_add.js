$(document).ready(function() {
    $( "[id^='player_box_']").draggable();
    $("[id^='player_select_']").click(function() {
        strId = this.id;
        arrId = strId.split('_')
        strPath = strAjaxPath.replace('PPPP',arrId[2]);
        $.ajax({
            url : strPath,
            success: function(data, textStatus, jqXHR)
            {
                var decoded = $('<div/>').html(data).text();
                var myObject = eval('(' + decoded + ')');
                //alert(myObject.message);
                if(myObject.error == 0) {
                    $( "#player_box_"+arrId[2] ).hide( 'explode', {}, 1000);
                } else if(myObject.error == 2) {
                    $('#player_select_'+arrId[2]).unbind('click');
                    $('#player_select_'+arrId[2]).attr('disabled','true');
                }
                $('#nb_players').html(myObject.players);
                $('#alerts').html(myObject.message);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
         
            }
        });
    });

    $("[id^='player_del_']").click(function() {
        strId = this.id;
        arrId = strId.split('_')
        strPath = strAjaxPath.replace('PPPP',arrId[2]);
        $.ajax({
            url : strPath,
            success: function(data, textStatus, jqXHR)
            {
                var decoded = $('<div/>').html(data).text();
                var myObject = eval('(' + decoded + ')');
                //alert(myObject.message);
                if(myObject.error == 0) {
                    $( "#player_box_"+arrId[2] ).hide( 'explode', {}, 1000);
                }
                $('#nb_players').html(myObject.players);
                $('#alerts').html(myObject.message);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
         
            }
        });
    });

/*
    $( "#team_container" ).droppable({
      drop: function( event, ui ) {
        obj = ui.draggable;
        nbElems = arrSelectedPlayers.length;
        containerOffset = $( "#team_container" ).offset();
        obj.offset({top: containerOffset.top+12, left: containerOffset.left+15+(nbElems * (obj.width() + 5)) });
        arrSelectedPlayers[nbElems] = obj.attr('id');
      }
    });
*/
});