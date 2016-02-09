Search = function() {
	var self = this;
	this.timer = null;
	this.block = 'button.btn.large.green';
	this.init = function() {
		if (!self.timer) {
			$.post('index.php?search');
			self.timer = setInterval(self.searching, 2000);
			$('.search-result').html('Not found... Still searching');
		}
	}

	this.destroy = function() {
		clearInterval(self.timer);
		self.timer = null;
		$(self.block).hide();
	}

	this.searching = function() {
		$.post('index.php?search=update', function(success) {
			if (success) {
				chat.init();
				self.destroy();
			}
			else {
				var text = $('.search-result').html();

				if(text[11] == '.')
					$('.search-result').html('Not found.. Still searching');
				else
					$('.search-result').html('Not found... Still searching');
			}
		});
	}
}