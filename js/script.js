var _time = new Date();
var chat = new Chat();
var search = new Search();

$(document).ready(function() {
    
    $('.chat').hide();

	registerClickEvents();

	$.post('index.php?init', function(data) {

		try {
			var data = JSON.parse(data);
			$('div.attention.right').html('Total users online: 0 / Users in search: 0 <br> You\'r name is: <b>'+data.username+'</b>');
			$('.footer>div').text('ClanWar Search Script v1.0 loaded in ' + (((new Date).getTime() - _time.getTime())/1000) + ' seconds');
			search.destroy();
			$('.search-result').html('Loading chat...');
			setTimeout(chat.init, 2000);
		} 
		catch(e) {
			$('div.attention.right').html('Total users online: 0 / Users in search: 0 <br> You\'r name is: <b>'+data+'</b>');
			$('.footer>div').text('ClanWar Search Script v1.0 loaded in ' + (((new Date).getTime() - _time.getTime())/1000) + ' seconds');
		}
	});

});

$(window).on('beforeunload', function() {
	$.post('index.php?quit');
});	


registerClickEvents = function() {

	$('button.btn.large.green').on('click', function() {
		$.post('index.php?search', function(data) {
			search.init();
		});
	});


	$('button.btn.small.green').on('click', function() {
		var message = $('input.chat-input').val();
		chat.send(message);
	});



	
}

