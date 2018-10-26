var webpage = require('webpage').create();
var system = require('system');
webpage.viewportSize = {width: 1920, height: 1080};
webpage.settings.userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36';
webpage.customHeaders = {
    'Accept-Language': 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7'
}


webpage.open('https://workshop.autodata-group.com/')
        .then(function (status) {
            if (status === 'success') {
                function clickEvaluate() {
                    click = false;
                }
//            var selector = 'body > div > div > div.col-md-8 > div:nth-child(4) > div.col-lg-5 > div > div > a > img';
                var selector = '.big';
                var elem = null;
                while (elem === null) {
                    var elem = webpage.evaluate(function (selector) {
                        return document.querySelector(selector);
                    }, selector)
                }

                console.log('elem_rect ' + elem);
//                var click = true;
//                while (click) {
//                    elem.addEventListener('click', clickEvaluate);
//                    webpage.sendEvent('click', elem.getBoundingClientRect().left + 5, elem.getBoundingClientRect().top + 5);
//                }
//                console.log(click);
//                function getCurrentUrl() {
//                    return window.location.href;
//                }
//                slimer.wait(3000);
//                var current_url = webpage.evaluate(getCurrentUrl);
//                console.log(current_url);
//            webpage.evaluate(function(elem){
//                elem.addEventListener('click', foo, false);
//                function foo() {
//                    elem.style.color = 'red';
//                }
//            }, elem)
//            
//            elem.addEventListener('click', foo, false);

//            function foo() {
//                elem.style.color = 'red';
//            }



//            console.log(click);
//            return webpage.open('http://3dtechno.site/a3be4179fff4b5f220c2cec9433b53808c5cc4ed');
            }
        })
//    .then(function(status){
//        if (status === 'success') {
//            console.log('page2 '+status);
//            slimer.exit();
//        }
//    })


//webpage.open('https://www.proxy-web.info/', function(status){
//    if (status === 'success') {
//        console.log(status);
//    }
//});