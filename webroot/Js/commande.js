$(document).ready(function() {
  var socket = '';
  $('#log').click(function(){
    

    if($(this).hasClass('btn-success')){
      //quand j'appuis sur le bouton je me connect
      $(this).removeClass('btn-success').addClass('btn-danger').val('Se déconnecter');
            socket = io.connect('http://localhost:8080');
            socket.on('connect', function(){
                socket.on('statue', function(){
                    $('#header span').text('Statue : Connecter');
                });
            });
      //quand j'appuis une autre fois sur le bouton je me déconnect 
      }else{
          $(this).removeClass('btn-danger').addClass('btn-success').val('Se connecter');
          socket.disconnect();
          $('#header span').text('Statue : DéConnecter');
      }

     });

});