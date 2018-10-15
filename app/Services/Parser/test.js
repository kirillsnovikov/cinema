var webpage = require('webpage').create();
webpage.viewportSize = { width: 1920, height: 1080 };
webpage.settings.userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36';
webpage.customHeaders = {
	'Accept-Language': 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7'
}
webpage
	.open('https://workshop.autodata-group.com')
	.then(function(){ 
		webpage.evaluate(function () { 
			document.getElementById("edit-name").focus();
		});
		webpage.sendEvent('keypress', "kirillsnovikov");
		var rect = webpage.evaluate(function(){
			return document.getElementById('edit-pass').getBoundingClientRect();
		});
		webpage.sendEvent('click', rect.left+5, rect.top+5);
		webpage.sendEvent('keypress', "UmSzenZ91W");
		var button = webpage.evaluate(function(){
			return document.querySelector('input[type="submit"]').getBoundingClientRect();
		});
		webpage.sendEvent('click', button.left+5, button.top+5);
		console.log("Top:"+rect.top+", Left:"+rect.left+", Right:"+rect.right+", Bottom:"+rect.bottom);
		console.log("Top:"+button.top+", Left:"+button.left+", Right:"+button.right+", Bottom:"+button.bottom);
		var cookies = webpage.cookies;
		console.log('Listing cookies:');
		for(var i in cookies) {
			console.log(cookies[i].name + '=' + cookies[i].value);
		};
		wait(3000);
		// var webpage2 = require('webpage').create();
		// webpage2.viewportSize = { width: 1920, height: 1080 };
		// webpage2.settings.userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36';
		// webpage2.customHeaders = {
		// 	'Accept-Language': 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7'
		// }
		webpage
			.open('https://workshop.autodata-group.com/w1/manufacturers/ALF0/3000007/engines?route_name=engine-oil&module=TD')
			.then(function(){
				var code = webpage.evaluate(function(){
					return document.getElementsByClassName('engine-code-link')[0].getBoundingClientRect();
				});
				webpage.sendEvent('click', code.left+5, code.top+5);
				var model = webpage.evaluate(function(){
					return document.getElementsByClassName('enabled')[0].getBoundingClientRect();
				});
				webpage.sendEvent('click', model.left+5, model.top+5);
			});
	});
// 	.open('https://workshop.autodata-group.com/w1/manufacturers/ALF0/3000007/engines?route_name=engine-oil&module=TD');

// webpage
// 	.open('https://workshop.autodata-group.com/w1/manufacturers/ALF0/3000007/engines?route_name=engine-oil&module=TD');
// 	.then(function(){
// 		var code = webpage.evaluate(function(){
// 			return document.getElementsByClassName('engine-code-link')[0].getBoundingClientRect();
// 		});
// 		webpage.sendEvent('click', code.left+5, code.top+5);
// 		var model = webpage.evaluate(function(){
// 			return document.getElementsByClassName('enabled')[0].getBoundingClientRect();
// 		});
// 		webpage.sendEvent('click', model.left+5, model.top+5);
// 	});
// slimer.exit();

