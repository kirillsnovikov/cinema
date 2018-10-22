var webpage = require('webpage').create();
webpage.viewportSize = {width: 1920, height: 1080};
webpage.settings.userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36';
webpage.customHeaders = {
    'Accept-Language': 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7'
}

webpage
        .open('https://workshop.autodata-group.com')
        .then(function (status) {
            if (status === 'success') {
                webpage.evaluate(function () {
                    document.getElementById("edit-name").focus();
                });
                webpage.sendEvent('keypress', "kirillsnovikov");
                webpage.evaluate(function () {
                    document.getElementById("edit-pass").focus();
                });
                webpage.sendEvent('keypress', "UmSzenZ91W");
                var button = webpage.evaluate(function () {
                    return document.querySelector('input[type="submit"]').getBoundingClientRect();
                });
                webpage.sendEvent('click', button.left + 5, button.top + 5);
                slimer.wait(5000);
//                slimer.exit();
                // webpage.onResourceReceived = function(response){
                // 	console.log(' id ' + response.id + ', url ' + response.url + ', time ' + response.time + ', headers ' + response.headers + ', bodySize ' + response.bodySize + ', contentType ' + response.contentType + ', contentCharset ' + response.contentCharset + ', redirectURL ' + response.redirectURL + ', stage ' + response.stage + ', status ' + response.status + ', statusText ' + response.statusText + ', referrer ' + response.referrer + ', body ' + response.body + ', httpVersion.major ' + response.httpVersion.major + ', httpVersion.minor ' + response.httpVersion.minor + ', isFileDownloading ' + response.isFileDownloading );
                // }
            }
        });

// .then(function(){
// 	if (document.readyState === "complete") {
// 		slimer.exit();
// 	}
// });
// webpage.evaluate(function(){
// 	if (document.readyState === "complete") {
// 		slimer.exit();
// 	}
// });
// return webpage.open('https://workshop.autodata-group.com/w1/manufacturers/ALF0/3000007/engines?route_name=engine-oil&module=TD');
// return webpage.open('https://workshop.autodata-group.com/w1/vehicles/ALF0/3000007');
// var webpage2 = require('webpage').create();
// webpage2.viewportSize = { width: 1920, height: 1080 };
// webpage2.settings.userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36';
// webpage2.customHeaders = {
// 	'Accept-Language': 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7'
// }
// webpage
// 	.open('https://workshop.autodata-group.com/w1/manufacturers/ALF0/3000007/engines?route_name=engine-oil&module=TD')
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

// .then(function(){
// 	var info = webpage.evaluate(function(){
// 		return document.getElementsByClassName('matchHeight')[0].getBoundingClientRect();
// 	});
// 	webpage.sendEvent('click', info.left+5, info.top+5);
// 	slimer.wait(3000);
// 	var car = webpage.evaluate(function(){
// 		return document.querySelector('li[data-model-name="145 "]')[0].getBoundingClientRect();
// 	});
// 	webpage.sendEvent('click', car.left+5, car.top+5);
// 	slimer.wait(3000);
// 	var oil = webpage.evaluate(function(){
// 		return document.querySelector('a[href="/w1/manufacturers/ALF0/3000007/engines?route_name=engine-oil&module=TD"]')[0].getBoundingClientRect();
// 	});
// 	webpage.sendEvent('click', oil.left+5, oil.top+5);
// 	slimer.wait(3000);
// 	var code = webpage.evaluate(function(){
// 		return document.getElementsByClassName('engine-code-link')[3].getBoundingClientRect();
// 	});
// 	webpage.sendEvent('click', code.left+5, code.top+5);
// 	slimer.wait(3000);
// 	var model = webpage.evaluate(function(){
// 		return document.getElementsByClassName('enabled')[1].getBoundingClientRect();
// 	});
// 	webpage.sendEvent('click', model.left+47, model.top+5);
// 	var cookies = webpage.cookies;
// 	console.log('Listing cookies:');
// 	for(var i in cookies) {
// 		console.log(cookies[i].name + '=' + cookies[i].value);
// 	};
// });
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

