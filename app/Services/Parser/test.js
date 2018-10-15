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
  });
// slimer.exit();

