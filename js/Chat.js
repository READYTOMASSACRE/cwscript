Chat = function(Block) {
	var self = this;

	this.block = Block ? Block : '#chat-body';
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
			url: 'chat.php?send',
			data: { 'author' : 'guest_1', 'message' : message },
			success: self.update
		});
	}

	this.update = function() {
		return $.ajax({
			type: 'GET',
			url: 'chat.php?update',
			success: function(chatHistory) {
				self.history = (JSON.parse(chatHistory)).history;
				//alert(self.history);
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