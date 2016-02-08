/*var UPDATE_TIME = 2000;
User = function() {
	var self = this;

	var chat = new Chat();
		$('button.btn.large.green').text('SEARCHING');
		if(!data) $('div.search-result').html('You are got nothing. Still searching...');
			else $('div.search-result').html(data);
		

	this.searchInit = function() {
		self.timer = setInterval(self.search, UPDATE_TIME);
	}

	this.searchStop = function() {
		clearInterval(self.timer);
	}

	this.search = function() {
		$.post('index.php?update', function(success) {
			if(success) {
				chat.init();
				self.searchStop();
			}
		});
	}
}*/