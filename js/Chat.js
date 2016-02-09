Chat = function(Block) {
	var self = this;

	this.block = Block ? Block : '.chat-body';
	this.history = null;
	this.timer = null;
	

	this.init = function() {
		if (!self.timer) self.timer = setInterval(self.update, 1000);
		$('.chat').show();
		$('.search-result').html('Chat loaded.');
	}

	this.destroy = function() {
		if (self.timer) clearInterval(self.timer);
		$('.chat').hide();
	}
	this.send = function(message) {
		return $.ajax({
			type: 'POST',
			url: 'index.php?send',
			data: { 'message' : message },
			success: function(data) {
				$('input[value="message"').val('');
				self.renderChat(data);
			}
		});
	}

	this.update = function() {
		return $.ajax({
			type: 'GET',
			url: 'index.php?update',
			success: self.renderChat
		});
	}


	this.renderChat = function(History) {
		if(!History) $(self.block).html('failed to load history chat');
		else {
			$(self.block).html('');
			self.history = JSON.parse(History);
			self.history.forEach(function(h) { $(self.block).append(h) });
		}
		$(self.block).scrollTop($(self.block).get(0).scrollHeight);
	}



}