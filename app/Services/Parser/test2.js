var webpage = require('webpage').create();
var system = require('system');
webpage.viewportSize = {width: 1920, height: 2080};
webpage.settings.userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36';
webpage.customHeaders = {
    'Accept-Language': 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7'
}







webpage.open("https://workshop.autodata-group.com/", function (status) {
    if (status === 'success') {


        // определение основных переменных и функций
        var manufacture_name = system.args[1].replace('_', ' ');
        var manufacture_uid = system.args[2];
        var model_name = system.args[3].replace('_', ' ');
        var model_uid = system.args[4];
        var engine_number = system.args[5];
        var engine_code_number = system.args[6];
        var manufacture_selector = 'li[data-manufacturer-name*="' + manufacture_name + '"]';
//        var manufacture_selector = 'li[data-manufacturer-name*="Alfa"]';
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
        var elem = null;
        while (elem === null) {
            var elem = webpage.evaluate(function () {
                return document.querySelector('.home-box.tech-info-btn');
            });
        }
        console.log('elem_rect '+elem);
//        slimer.wait(1000);
        var click = true;
        while (click) {
            elem.addEventListener('click', clickEvaluate);
            webpage.sendEvent('click', elem.getBoundingClientRect().left + 5, elem.getBoundingClientRect().top + 5);
        }
        
        console.log(click);
        var url_model_selection = 'https://workshop.autodata-group.com/w1/model-selection';
        var current_url = webpage.evaluate(getCurrentUrl);

        while (current_url.toLowerCase() !== url_model_selection.toLowerCase()) {
            var current_url = webpage.evaluate(getCurrentUrl);
        }
        slimer.wait(3000);
        slimer.exit();
///////////////////////////////////////////////////////////////////////////////
        // Выбор марки
        var manufacture = null;
        while (manufacture === null) {
            var manufacture = webpage.evaluate(function (manufacture_selector) {
                return document.querySelector(manufacture_selector);
            }, manufacture_selector);
        }
        slimer.wait(1000);
        manufacture.style.position = "absolute";
        manufacture.style.top = 0;

        click = true;
        while (click) {
            info.addEventListener('click', clickEvaluate);
            webpage.sendEvent('click', manufacture.getBoundingClientRect().left + 5, manufacture.getBoundingClientRect().top + 5);
        }
        slimer.wait(2000);
///////////////////////////////////////////////////////////////////////////////
//         Выбор модели
        var model = null;
        while (model === null) {
            var model = webpage.evaluate(function (model_selector) {
                return document.querySelector(model_selector);
            }, model_selector);
        }
        slimer.wait(1000);
        model.style.position = "absolute";
        model.style.top = 0;

        click = true;
        while (click) {
            info.addEventListener('click', clickEvaluate);
            webpage.sendEvent('click', model.getBoundingClientRect().left + 5, model.getBoundingClientRect().top + 5);
        }
        var url_select_oil = 'https://workshop.autodata-group.com/w1/vehicles/' + manufacture_uid + '/' + model_uid;
        var current_url = webpage.evaluate(getCurrentUrl);

        while (current_url.toLowerCase() !== url_model_selection.toLowerCase()) {
            var current_url = webpage.evaluate(getCurrentUrl);
        }
        slimer.wait(1000);
        console.log(current_url);
//        slimer.exit()
///////////////////////////////////////////////////////////////////////////////


//        var model = webpage.evaluate(function (model_selector) {
//            return document.querySelector(model_selector);
//        }, model_selector);
//
//        while (model === null) {
//            var model = webpage.evaluate(function (model_selector) {
//                return document.querySelector(model_selector);
//            }, model_selector);
//            slimer.wait(500);
//        }
//        slimer.wait(2000);
//        model.style.position = "absolute";
//        model.style.top = 0;
//
//        var model_rect = webpage.evaluate(function (model_selector) {
//            return document.querySelector(model_selector).getBoundingClientRect();
//        }, model_selector);
//        webpage.sendEvent('click', model_rect.left + 5, model_rect.top + 5);
//
        var oil = webpage.evaluate(function () {
            return document.querySelector('a[href$="engines?route_name=engine-oil&module=TD"]');
        });
        while (oil === null) {
            var oil = webpage.evaluate(function () {
                return document.querySelector('a[href$="engines?route_name=engine-oil&module=TD"]');
            });
//            console.log(oil === null);
            slimer.wait(500);
        }
        slimer.wait(1000);
        var oil_rect = webpage.evaluate(function () {
            return document.querySelector('a[href$="engines?route_name=engine-oil&module=TD"]').getBoundingClientRect();
        });
        webpage.sendEvent('click', oil_rect.left + 5, oil_rect.top + 5);
//
//        var engine = webpage.evaluate(function (engine_number) {
//            return document.querySelectorAll('ul[id^=engine-model-list] li')[engine_number];
//        }, engine_number);
//        while (engine === null) {
//            var engine = webpage.evaluate(function (engine_number) {
//                return document.querySelectorAll('ul[id^=engine-model-list] li')[engine_number];
//            }, engine_number);
////            console.log(engine === null);
//            slimer.wait(500);
//        }
//        slimer.wait(1000);
////        engine.style.position = "absolute";
////        engine.style.top = 0;
////        engine.style.z-index = 99999;
//        var engine_rect = webpage.evaluate(function (engine_number) {
//            return document.querySelectorAll('ul[id^=engine-model-list] li')[engine_number].getBoundingClientRect();
//        }, engine_number);
//        webpage.sendEvent('click', engine_rect.left + 5, engine_rect.top + 5);
//        slimer.wait(2000);
//
//        var engine_code = webpage.evaluate(function (engine_code_number) {
//            return document.querySelectorAll('tr.enabled')[engine_code_number];
//        }, engine_code_number);
//        while (engine_code === null) {
//            var engine_code = webpage.evaluate(function (engine_code_number) {
//                return document.querySelectorAll('tr.enabled')[engine_code_number];
//            }, engine_code_number);
////            console.log(engine_code === null);
//            slimer.wait(500);
//        }
//        slimer.wait(2000);
//        var engine_code_rect = webpage.evaluate(function (engine_code_number) {
//            return document.querySelectorAll('tr.enabled')[engine_code_number].getBoundingClientRect();
//        }, engine_code_number);
//        webpage.sendEvent('click', engine_code_rect.left + 5, engine_code_rect.top + 5);
//
//        var current_url_2 = webpage.evaluate(function () {
//            return window.location.href;
//        });
//
//        var card_url = 'https://workshop.autodata-group.com/w1/engine-oil/' + system.args[5];
//
////        var content = webpage.evaluate(function () {
////            return document.querySelector('#content');
////        });
////        console.log('cur ' + current_url_2 + 'card ' + card_url);
//
//        while (current_url_2.toLowerCase() !== card_url.toLowerCase()) {
//            slimer.wait(500);
//            var current_url_2 = webpage.evaluate(function () {
//                return window.location.href;
//            });
////            console.log(current_url_2.toLowerCase() !== card_url.toLowerCase());
//        }
//
////        while (content === null) {
////            var content = webpage.evaluate(function () {
////                return document.querySelector('#content');
////            });
////            console.log(content === null);
////            slimer.wait(1000);
////        }
//        slimer.wait(2000);
//        var content = webpage.evaluate(function () {
//            return document.querySelector('div#content').outerHTML;
//        });
//        slimer.wait(1500);
//        console.log(content);
//        slimer.wait(1000);
//        slimer.exit();
//
    }
//
});






///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

//        var car = webpage.evaluate(function(){
// 		return document.querySelector('li[data-model-name="145 "]')[0].getBoundingClientRect();
// 	});
// 	webpage.sendEvent('click', car.left+5, car.top+5, 'left');
// 	slimer.wait(3000);



//        var oil = webpage.evaluate(function () {
//            return document.querySelector('li.eo');
//        });
//
//        while (oil === null) {
//            slimer.wait(500);
//            var oil = webpage.evaluate(function () {
//                return document.querySelector('li.eo');
//            });
//            console.log(oil === null);
//        }
//
//        var oil_rect = webpage.evaluate(function () {
//            return document.querySelector('li.eo').getBoundingClientRect();
//        });
//        webpage.sendEvent('click', oil_rect.left + 5, oil_rect.top + 5);
//
////        тип двигателя
//
//        var engine = webpage.evaluate(function () {
//            return document.querySelectorAll('ul#engine-model-list>li')[system.args[3]].getBoundingClientRect();
//        });
//
//        while (engine === null) {
//            slimer.wait(500);
//            var engine = webpage.evaluate(function () {
//                return document.querySelectorAll('ul#engine-model-list>li')[system.args[3]].getBoundingClientRect();
//            });
//            console.log(oil === null);
//        }
//
//        var engine_rect = webpage.evaluate(function () {
//            return document.querySelectorAll('ul#engine-model-list>li')[system.args[3]].getBoundingClientRect();
//        });
//        webpage.sendEvent('click', engine_rect.left + 5, engine_rect.top + 5);
//
//        slimer.wait(4000);
//
////        код двигателя
//
//        var code = webpage.evaluate(function () {
//            return document.querySelectorAll('ul#engine-code-filtered>tbody>tr')[system.args[4]].getBoundingClientRect();
//        });
//
//        while (code === null) {
//            slimer.wait(500);
//            var code = webpage.evaluate(function () {
//                return document.querySelectorAll('ul#engine-code-filtered>tbody>tr')[system.args[4]].getBoundingClientRect();
//            });
//            console.log(oil === null);
//        }
//
//        var code_rect = webpage.evaluate(function () {
//            return document.querySelectorAll('ul#engine-code-filtered>tbody>tr')[system.args[4]].getBoundingClientRect();
//        });
//        webpage.sendEvent('click', code_rect.left + 5, code_rect.top + 5);




//        if (current_url.toLowerCase() == url_model_selection.toLowerCase()) {
//            webpage.evaluate(function () {
//                var ready = document.readyState;
//                while(ready != 'complete'){
//                    var ready = document.readyState;
//                }
//                var elem = document.querySelector('li[data-model-name="145 "]').style.height = 50 + 'px';
//                // var i;
//                // for(i = 0; i < elems.length; ++i){
//                //     elems[i].style.height = 2000 + 'px';
//                // }
//            });
//            console.log('yeyeye' + current_url);
//        } else {
//            console.log('nonono' + current_url);
//        }
//        slimer.wait(5000);




//      webpage.open("https://workshop.autodata-group.com/", function(status){
//          slimer.wait(2000);
//          // slimer.exit();
//      })


		