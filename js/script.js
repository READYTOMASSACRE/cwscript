var _time = new Date();
var chat = new Chat();

$(document).ready(function() {
	$.post('index.php');
	$('.footer>div').text('ClanWar Search Script v1.0 loaded in 0.00 seconds');
	$('.chat').hide();
	
	registerClickEvents();
	$('.footer>div').text('ClanWar Search Script v1.0 loaded in ' + (((new Date).getTime() - _time.getTime())/1000) + ' seconds');

});

registerClickEvents = function() {

	$('button.btn.large.green').on('click', function() {
		$('button.btn.large.green').text('SEARCHING...');
	})

	$('button.btn.small.green').on('click', function() {
		var message = $('input.chat-input').val();
		chat.send(message);
/*		$('input.chat-input').val(null);
		$.post('index.php?send', {"message":message}, function(data) {
			$('.chat-body').html(data);
		})
*/	});
}