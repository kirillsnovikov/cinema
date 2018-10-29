var webpage = require('webpage').create();
var system = require('system');
webpage.viewportSize = {width: 1920, height: 1080};
webpage.settings.userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36';
webpage.customHeaders = {
    'Accept-Language': 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7'
}


webpage.open('https://workshop.autodata-group.com/w1/manufacturers/ALF0/3000007/engines?route_name=engine-oil&module=TD')
        .then(function (status) {
            if (status === 'success') {
                function getCurrentUrl() {
                    return window.location.href;
                }
                function getCurrentHostname() {
                    return window.location.hostname;
                }
                function getCurrentSearch() {
                    return window.location.search;
                }
                function clickEvaluate() {
                    click = false;
                }
                
                
                var url_engine_selection = 'https://workshop.autodata-group.com/w1/manufacturers/ALF0/3000007/engines?route_name=engine-oil&module=TD';
                var current_url = webpage.evaluate(getCurrentUrl);
                console.log(current_url.toLowerCase() !== url_engine_selection.toLowerCase());
                console.log('current_url ' + current_url);

                while (current_url.toLowerCase() !== url_engine_selection.toLowerCase()) {
                    console.log(current_url.toLowerCase() !== url_engine_selection.toLowerCase());
                    console.log('current_url ' + current_url);
                    slimer.wait(1000);
                    var current_url = webpage.evaluate(getCurrentUrl);
                }
                var model_engine = null;
                console.log('model_engine ' + model_engine);
                while (model_engine === null) {
                    slimer.wait(1000);
                    var model_engine = webpage.evaluate(function () {
                        return document.querySelectorAll('.scroll-wrapper.modelList.scrollbar-inner ul li')[0];
                    });
                    console.log('model_engine 22' + model_engine);
                }
                console.log('model_engine33 ' + model_engine);
//                slimer.wait(2000);
                console.log(window.getComputedStyle(model_engine).top);
                model_engine.style.position = "absolute";
                model_engine.style.top = 0;
//                slimer.wait(2000);
                console.log('after' + window.getComputedStyle(model_engine).top);
                var click = true;
                console.log('click' + click);
                while (click) {
                    slimer.wait(1000);
                    model_engine.addEventListener('click', clickEvaluate);
                    webpage.sendEvent('click', model_engine.getBoundingClientRect().left + 5, model_engine.getBoundingClientRect().top + 5);
                    console.log('click222' + click);
                }
                console.log('click333' + click);
                slimer.wait(2000);
                
                
                var code_engine = null;
                console.log('code_engine ' + code_engine);
                while (code_engine === null) {
                    slimer.wait(1000);
                    var code_engine = webpage.evaluate(function () {
                        return document.querySelectorAll('#engine-code-filtered>tbody>tr')[1];
                    });
                    console.log('code_engine 22' + code_engine);
                }
                console.log('code_engine33 ' + code_engine);
//                slimer.wait(2000);
                console.log(window.getComputedStyle(code_engine).top);
                code_engine.style.position = "absolute";
                code_engine.style.top = 0;
//                slimer.wait(2000);
                console.log('after' + window.getComputedStyle(code_engine).top);
                var click = true;
                console.log('click' + click);
                while (click) {
                    slimer.wait(1000);
                    code_engine.addEventListener('click', clickEvaluate);
                    webpage.sendEvent('click', code_engine.getBoundingClientRect().left + 5, code_engine.getBoundingClientRect().top + 5);
                    console.log('click222' + click);
                }
                console.log('click333' + click);
                slimer.wait(2000);
                
                
                var card_url = 'https://workshop.autodata-group.com/w1/engine-oil/ALF00136';
                var current_url = webpage.evaluate(getCurrentUrl);
                console.log('current_url '+current_url);
                console.log(current_url.toLowerCase() !== card_url.toLowerCase());

                while (current_url.toLowerCase() !== card_url.toLowerCase()) {
                    slimer.wait(1000);
                    var current_url = webpage.evaluate(getCurrentUrl);
                    console.log('current_url '+current_url);
                    console.log(current_url.toLowerCase() !== card_url.toLowerCase());
                }
//                console.log('current_url '+current_url);

                var content = null;
                while (content === null) {
                    slimer.wait(1000);
                    var content = webpage.evaluate(function () {
                        return document.querySelector('div#content').outerHTML;
                    });
                    console.log('cont'+content);
                }
                slimer.wait(2000);
                console.log('cont'+content);
                slimer.exit();
            }
        })