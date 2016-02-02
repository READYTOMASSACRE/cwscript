
User = function(id) {
	var self = this;
	//self.chat = new Chat();






	this.push = function() {
		return $.ajax({
			type: 'GET',
			url: 'action.php?param=add',
			success: function(id) { 
				$.ajax({
					type: 'GET',
					url: 'tmp/users.json',
					success: function(data) { self.show(id, data); }
				});
			}
		});
	}

	this.show = function(id, data) {
		var formatString = '<table>';
		formatString += '<thead><td>id</td><td>status</td><td>mmr</td></thead>';
		data.forEach(function(item, i, data) {
			formatString+='<tr>'
			formatString+='<td>'+item.id+'</td> <td>false</td><td>'+item.mmr+'</td>';
			formatString+='</tr>'
		});
		formatString+='</table>';
		$('#users').html(formatString);
		$('#div_1').text('last user wil added with id: ' + id);	
		delete(formatString);
	}
}
//var user = new User();


var chat = {
	var historyChat = '';
	send: function() {
		
	}
}



change = function() {
}

push = function() {
	$.ajax({
		type: 'POST',
		url: 'action.php?param=add',
		success: function(id) {
			$('#div_1').text('last user wil added with id: ' + id);
			getusers();
		}
	});
}


getjson = function() {
	return $.ajax({
		type: 'GET',
		url: 'js/users.json',
		success: function(data) {
			alert(JSON.stringify(data));
		}
	});
}

userdata = function(param) {
	if (param == 'default') return default_userdata;
}

clearjson = function(arg) {
	$('#users').html('');
	if (arg) return true; 
	$('#div_1').text('text will edited');
	return $.ajax({
		url: 'action.php?param=clear'
	});
}

getusers = function() {
	this.show = function(users) {
		var formatString = '<table>';
		formatString += '<thead><td>id</td><td>status</td><td>mmr</td></thead>';
		users.forEach(function(item, i, users) {
			formatString+='<tr>'
			formatString+='<td>'+item.id+'</td> <td>false</td><td>'+item.mmr+'</td>';
			formatString+='</tr>'
		});
		formatString+='</table>';
		$('#users').html(formatString);
	}

	$.ajax({
		type: 'GET',
		url: 'tmp/users.json',
		success: this.show
	});
}

