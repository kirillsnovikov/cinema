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
        slimer.wait(3000);

//        webpage.evaluate(function () {
//            document.addEventListener('DOMContentLoaded', function () {
//                var elem = document.querySelector('li[data-model-name="145 "]').style.height = 50 + 'px';
//            });
//        });

        var a = system.args;
        var index;
        for (index = 0; index < a.length; ++index) {
            console.log(a[index]);
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
            for (i = 0; i < elems.length; ++i) {
                elems[i].style.height = 2000 + 'px';
            }
        });




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

		