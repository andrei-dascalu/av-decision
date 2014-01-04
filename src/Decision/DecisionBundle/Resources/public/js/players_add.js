$(document).ready(function() {
    $( "#team_container, #players_container" ).sortable({
      connectWith: ".connect_sortable",
      receive: function(event,ui) {
        strId = ui.item.attr('id');
        arrId = strId.split('_')
        if ($(this).children('div').length > 5 && $(this).attr('id') != "players_container") {
                console.log('Max 5 in team!');
                $(ui.sender).sortable('cancel');
                ('#alerts').html('A team can have maximum 5 players');
                return false;
        } else if(ui.sender.attr('id') == 'players_container') {
            //action add
            strPath = strAjaxPath.replace('PPPP',arrId[2]);
        } else if(ui.sender.attr('id') == 'team_container') {
            //action remove
            strPath = strAjaxRemovePath.replace('PPPP',arrId[2]);
        }
        $.ajax({
            url : strPath,
            success: function(data, textStatus, jqXHR)
            {
                var decoded = $('<div/>').html(data).text();
                var myObject = eval('(' + decoded + ')');
                //alert(myObject.message);
                if(myObject.error != 0) {
                    $(ui.sender).sortable('cancel');
                }
                $('#nb_players').html(myObject.players);
                $('#alerts').html(myObject.message);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                    
            }
        });
      }
    }).disableSelection();
});