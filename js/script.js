var _time = new Date();
var chat = new Chat();

Renderer = function() {
		var self = this;
		this.block = null;
		this.timer = null;
		this.timerInit = function() {
			self.timer = setInterval(self.go, 800);
		}
		this.go = function() {
			if (self.block.text().length < 12) {
				self.block.append('.');
			}
			else if (self.block.text().length == 12) {
				var text = self.block.text();
				text = text.slice(0, -1);
				self.block.text(text); 
			}
		}
}
var render = new Renderer();

$(document).ready(function() {
	$.post('index.php?register', function(data) {
		$('div.attention.right').html('Total users online: 0 / Users in search: 0 <br> You\'r name is: <b>'+data+'</b>');
	});

	$('.footer>div').text('ClanWar Search Script v1.0 loaded in 0.00 seconds');
	$('.chat').hide();
	
	registerClickEvents();
	$('.footer>div').text('ClanWar Search Script v1.0 loaded in ' + (((new Date).getTime() - _time.getTime())/1000) + ' seconds');

});

registerClickEvents = function() {

	$('button.btn.large.green').on('click', function() {
		$('button.btn.large.green').text('SEARCHING');
		render.block = $('button.btn.large.green');
		render.timerInit();
		$.post('index.php?search', function(data) {
			$('div.search-result').html(data);
		})
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

