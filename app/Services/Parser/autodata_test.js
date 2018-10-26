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
                // определение основных переменных и функций
                var manufacture_name = system.args[1].replace('_', ' ');
                var manufacture_uid = system.args[2];
                var model_name = system.args[3].replace('_', ' ');
                var model_uid = system.args[4];
                var engine_number = system.args[5];
                var engine_code_number = system.args[6];
                var manufacture_selector = 'li[data-manufacturer-name*="' + manufacture_name + '"]';
                var model_selector = 'li[data-model-name*="' + model_name + '"]';
//        console.log('manufacture_name '+manufacture_name+'manufacture_uid '+manufacture_uid+'model_name '+model_name+'engine_number '+engine_number+'model_uid '+model_uid+'engine_code_number '+engine_code_number);

                function getCurrentUrl() {
                    return window.location.href;
                }
                function clickEvaluate() {
                    click = false;
                }

///////////////////////////////////////////////////////////////////////////////
                // Техническая информация
                var info = null;
                while (info === null) {
                    slimer.wait(100);
                    var info = webpage.evaluate(function () {
                        return document.querySelector('.home-box.tech-info-btn');
                    });
                }
                var click = true;
                while (click) {
                    slimer.wait(100);
                    info.addEventListener('click', clickEvaluate);
                    webpage.sendEvent('click', info.getBoundingClientRect().left + 5, info.getBoundingClientRect().top + 5);
                }
                var url_model_selection = 'https://workshop.autodata-group.com/w1/model-selection';
                var current_url = webpage.evaluate(getCurrentUrl);
                console.log('current_url5555 '+current_url);
                console.log(current_url.toLowerCase() !== url_model_selection.toLowerCase());

                while (current_url.toLowerCase() !== url_model_selection.toLowerCase()) {
                    slimer.wait(100);
                    var current_url = webpage.evaluate(getCurrentUrl);
                    console.log('current_url5555 '+current_url);
                    console.log(current_url.toLowerCase() !== url_model_selection.toLowerCase());
                }
                slimer.wait(2000);
///////////////////////////////////////////////////////////////////////////////
                // Выбор марки
                var manufacture = null;
                while (manufacture === null) {
                    slimer.wait(100);
                    var manufacture = webpage.evaluate(function (manufacture_selector) {
                        return document.querySelector(manufacture_selector);
                    }, manufacture_selector);
                }
                console.log(manufacture.getBoundingClientRect().left + '  ' + manufacture.getBoundingClientRect().top);
                slimer.wait(1000);
                manufacture.style.position = "absolute";
                manufacture.style.top = 0;
                console.log(manufacture.getBoundingClientRect().left + '  ' + manufacture.getBoundingClientRect().top);

                var click = true;
                while (click) {
                    slimer.wait(100);
                    manufacture.addEventListener('click', clickEvaluate);
                    webpage.sendEvent('click', manufacture.getBoundingClientRect().left + 5, manufacture.getBoundingClientRect().top + 5);
                }
                slimer.wait(3000);
///////////////////////////////////////////////////////////////////////////////
                // Выбор модели
                var model = null;
                while (model === null) {
                    slimer.wait(100);
                    var model = webpage.evaluate(function (model_selector) {
                        return document.querySelector(model_selector);
                    }, model_selector);
                }
                slimer.wait(1000);
                model.style.position = "absolute";
                model.style.top = 0;

                var click = true;
                while (click) {
                    slimer.wait(100);
                    model.addEventListener('click', clickEvaluate);
                    webpage.sendEvent('click', model.getBoundingClientRect().left + 5, model.getBoundingClientRect().top + 5);
                }
//                slimer.wait(2000);
                var url_select_oil = 'https://workshop.autodata-group.com/w1/vehicles/' + manufacture_uid + '/' + model_uid;
                var current_url = webpage.evaluate(getCurrentUrl);
                console.log('current_url '+current_url);
//                console.log('url_select_oil '+url_select_oil);
//                console.log(current_url.toLowerCase() !== url_select_oil.toLowerCase());

                while (current_url.toLowerCase() !== url_select_oil.toLowerCase()) {
                    slimer.wait(100);
                    var current_url = webpage.evaluate(getCurrentUrl);
                    console.log(current_url.toLowerCase() !== url_select_oil.toLowerCase());
                    console.log('current_url '+current_url);
                }
                slimer.wait(1000);
//                slimer.wait(5000);
//                console.log(current_url.toLowerCase() !== url_select_oil.toLowerCase());
//                
//                console.log('current_url222 '+current_url);
//                console.log('url_select_oil222 '+url_select_oil);
                slimer.exit();
///////////////////////////////////////////////////////////////////////////////
                //Моторное масло
//                var oil = null;
//                while (oil === null) {
//                    slimer.wait(100);
//                    var oil = webpage.evaluate(function () {
//                        return document.querySelector('.left-inf>li');
//                    });
//                }
//                var click = true;
//                while (click) {
//                    slimer.wait(100);
//                    oil.addEventListener('click', clickEvaluate);
//                    webpage.sendEvent('click', oil.getBoundingClientRect().left + 5, oil.getBoundingClientRect().top + 5);
//                }
//                var url_model_selection = 'https://workshop.autodata-group.com/w1/model-selection';
//                var current_url = webpage.evaluate(getCurrentUrl);
//
//                while (current_url.toLowerCase() !== url_model_selection.toLowerCase()) {
//                    slimer.wait(100);
//                    var current_url = webpage.evaluate(getCurrentUrl);
//                }
//                slimer.wait(2000);
            }
        })
