var _time = new Date();
var chat = new Chat();
//var user = new User();

$(document).ready(function() {
	$.post('index.php?register', function(data) {
		$('div.attention.right').html('Total users online: 0 / Users in search: 0 <br> You\'r name is: <b>'+data+'</b>');
	});
    //$('.chat').hide();

	registerClickEvents();
	$('.footer>div').text('ClanWar Search Script v1.0 loaded in ' + (((new Date).getTime() - _time.getTime())/1000) + ' seconds');

});

registerClickEvents = function() {

	$('button.btn.large.green').on('click', function() {
		$.post('index.php?search', function(data) {
			user.searchInit();
		});
	});


	$('button.btn.small.green').on('click', function() {
		var message = $('input.chat-input').val();
		chat.send(message);
	});



	
}

