var _time = new Date();
var chat = new Chat();

$(document).ready(function() {
	$.post('index.php');
	$('.attention').text('ClanWar Search Script v1.0 loaded in 0.00 seconds');
	$('#chat').hide();
	
	registerClickEvents();
	$('.attention').text('ClanWar Search Script v1.0 loaded in ' + (((new Date).getTime() - _time.getTime())/1000) + ' seconds');

});

registerClickEvents = function() {

	$('#button-search').on('click', function() {
		alert('search button');
		$.post('search.php?init');
	});
/*	$('#chat-button-send').on('click', function() {
		var msg = $('#chat-text').val();
		$('#chat-text').val('');
		chat.send(msg);
	});	

	$('#create-chat').on('click', function() {
		$.post('chat.php?create', function() {alert('zero'); });
		if($('#chat').is(':hidden')) alert('Can\'t create new chat')
	});

	$('#toogle-chat').on('click', function() {
		var chatLabel = $('#toogle-chat').text();
		chatLabel = chatLabel == 'Open chat' ? 'Close chat' : 'Open chat';
		$('#toogle-chat').text(chatLabel);
	});*/
}