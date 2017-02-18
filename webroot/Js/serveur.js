var http = require('http');

var serveur = http.createServer(function(req, res){
	console.log('serveur demarrer');
	res.write('<h1>salut les mioches</h1>');
});
serveur.listen(8080);

var io = require('socket.io').listen(serveur);
	io.sockets.on('connection', function(socket){
		socket.emit("statue");
		console.log('Vous êtes connecter');

		socket.on('disconnect', function(){
			console.log('Vous êtes Déconnecter');
		});
	});