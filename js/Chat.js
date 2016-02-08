Chat = function(Block) {
	var self = this;

	this.block = Block ? Block : '.chat-body';
	this.history = null;
	this.timer = null;
	

	this.init = function() {
		self.timer = setInterval(self.update, 5000);
	}

	this.destroy = function() {
		if (self.timer) clearInterval(self.timer);
		delete(self);
	}
	this.send = function(message) {
		return $.ajax({
			type: 'POST',
			url: 'index.php?send',
			data: { 'message' : message },
			success: function(History) {
				$(self.block).html('');
				if(!History) $(self.block).html('failed to load history chat');
				else {
					self.history = JSON.parse(History);
					self.history.forEach(function(h) { $(self.block).append(h) });
				}
				$(self.block).scrollTop($(self.block).get(0).scrollHeight);
				$('input[value="message"').val('');
			}
		});
	}

	this.update = function() {
		return $.ajax({
			type: 'GET',
			url: 'index.php?update',
			success: function(History) {
				self.history = History;
				$(self.block).html(self.history);
			}
		});
	}

	/** 
	 *
	 * start constructor processes 
	 *
	 */
	//this.init();

}