var webpage = require('webpage').create();
var system = require('system');
webpage.viewportSize = {width: 1920, height: 1080};
webpage.settings.userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36';
webpage.customHeaders = {
    'Accept-Language': 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7'
}

function duration() {

}

webpage.open("https://workshop.autodata-group.com/", function (status) {
    if (status === 'success') {
        var info = webpage.evaluate(function () {
            return document.getElementsByClassName('matchHeight')[0].getBoundingClientRect();
        });
        webpage.sendEvent('click', info.left + 5, info.top + 5);
        var url_model_selection = 'https://workshop.autodata-group.com/w1/model-selection';
        var current_url = webpage.evaluate(function () {
            return window.location.href;
        });
        // var url_model_selection = 'https://workshop.autodata-group.com/w1/model-selection';
        // console.log('current_url = ');
        // if(current_url.toLowerCase() == url_model_selection.toLowerCase()){
//         	console.log('current_url = ' + current_url);
        // 	var current_url = window.location.href;
        // };


        while (current_url.toLowerCase() !== url_model_selection.toLowerCase()) {
            slimer.wait(500);
            var current_url = webpage.evaluate(function () {
                return window.location.href;
            });
        }
//        slimer.wait(3000);

        var scroll_wraper = webpage.evaluate(function () {
            return document.querySelector('div.scroll-wrapper');
        });
        console.log(scroll_wraper === null);

        while (scroll_wraper === null) {
            slimer.wait(500);
            var scroll_wraper = webpage.evaluate(function () {
                return document.querySelector('div.scroll-wrapper');
            });
            console.log(scroll_wraper === null);
        }

//        webpage.evaluate(function () {
//            document.addEventListener('DOMContentLoaded', function () {
//                var elem = document.querySelector('li[data-model-name="145 "]').style.height = 50 + 'px';
//            });
//        });

        var a = system.args;
        var index;
        for (index = 0; index < a.length; ++index) {
            console.log(a[index] + ' index' + index);
        }

//        console.log('asdf ' + system.args.length + '  fff ' + system.args[0] + system.args[1] + system.args[2] + system.args[3] + system.args[4] + system.args[5]);

//        while (document.readyState !== "complete") {
//            var ready = webpage.evaluate(function () {
//                return document.readyState;
//            });
//            console.log('yeyeye' + ready);
//            slimer.wait(50);
//        }
//
        webpage.evaluate(function () {
            var elems = document.querySelectorAll('div.scroll-wrapper');
//            window.onload = function(){
//                var elem = document.querySelector('li[data-model-name="145 "]').style.height = 50 + 'px';
//            }
//            
            // var i;
//            for (i = 0; i < elems.length; ++i) {
//                elems[i].style.height = 2000 + 'px';
//            }
        });


//        data-manufacturer-name="Alfa Romeo"
        var manufacture_name = system.args[1].replace('_', ' ');
        var model_name = system.args[2].replace('_', ' ');
//        var manufacture_selector = 'li[data-manufacturer-name="Audi"]';
        var manufacture_selector = 'li[data-manufacturer-name="' + manufacture_name + '"]';
        var model_selector = 'li[data-model-name="' + model_name + ' "]';
        console.log(manufacture_selector);
        console.log(model_selector);


        var manufacture = webpage.evaluate(function (manufacture_selector) {
            return document.querySelector(manufacture_selector);
        }, manufacture_selector);

        while (manufacture === null) {
            var manufacture = webpage.evaluate(function (manufacture_selector) {
                return document.querySelector(manufacture_selector);
            }, manufacture_selector);
            console.log(manufacture === null);
            slimer.wait(500);
        }
//        slimer.wait(2000);
            
        var manufacture_rect = webpage.evaluate(function (manufacture_selector) {
            return document.querySelector(manufacture_selector).getBoundingClientRect();
        }, manufacture_selector);
        webpage.sendEvent('click', manufacture_rect.left + 5, manufacture_rect.top + 5);
        
        
        var model = webpage.evaluate(function (model_selector) {
            return document.querySelector(model_selector);
        }, model_selector);

        while (manufacture === null) {
            var manufacture = webpage.evaluate(function (model_selector) {
                return document.querySelector(model_selector);
            }, model_selector);
            console.log(manufacture === null);
            slimer.wait(500);
        }
        slimer.wait(2000);
            
        var model_rect = webpage.evaluate(function (model_selector) {
            return document.querySelector(model_selector).getBoundingClientRect();
        }, model_selector);
        webpage.sendEvent('click', model_rect.left + 5, model_rect.top + 5);

        
        
        
        
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

    }


//      webpage.open("https://workshop.autodata-group.com/", function(status){
//          slimer.wait(2000);
//          // slimer.exit();
//      })
});

		