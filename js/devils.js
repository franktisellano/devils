$(document).ready(function() {	
	$.getJSON('service.php', function(games) {
		
		var today = 0,
			tomorrow = 0;
		
		$.each(games, function(game) {
			switch(this.when)
			{
				case 'today':
					var str = 'Devils vs ' + this.opponent + ' today at ' + this.gametime + ' on ' + this.network_results + '.';
					$('#today').html(str);
					
					today = 1;
				break;
				
				case 'tomorrow':
					if (today != 1) {
						var str = 'Tomorrow: Devils vs ' + this.opponent + ' today at ' + this.gametime + ' on ' + this.network_results + '.';
						$('#today').html(str);
						today = 1;
						
					} else {
						var str = 'Devils vs ' + this.opponent + ' today at ' + this.gametime + ' tomorrow.';
						$('#tomorrow').html(str);
					}
					
					tomorrow = 1;
				break;
				
				case 'past':
				break;
			}
		});
		
		if (today == 0) $('#today').html('No game today.');
		if (tomorrow == 0) $('#tomorrow').html('No game tomorrow.');

		$('#loading').remove();
	});
});