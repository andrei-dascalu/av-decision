$(document).ready(function() {
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
                }
                $('#nb_players').html(myObject.players);
                $('#alerts').html(myObject.message);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
         
            }
        });
    });
});