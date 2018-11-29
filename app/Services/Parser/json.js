{
"Name": "http://news-bitcoin.ru/ - [teaser ua.traffim.com]", // для Name и Description можно задать любое
        "Description": "visits only", // своё значение (участвует в поиске по cp)
        "SaveCookiesAfterVisit": false, // Если true, то по завершению скрипта кука с изменениями будет
//        внесена в нашу базу кук
        "BaseScripts": [], // Перечень базовых скриптов, которые нужно подключить
        "EntryPoints": [	// Массив точек входа
        {
        "Url": "http://news-bitcoin.ru/", // URL точки входа
                "Chance": 100, // Всегда 100!
                "Referrers": [		// Массив реферреров для точки входа
                {
                "Url": "https://www.google.ru/", // URL реферрера
                        "Chance": 600	// Число визитов в сутки с данного реферрера
                },
                {
                "Url": "https://yandex.ru/",
                        "Chance": 600
                }
                ]
        },
        {
        "Url": "http://news-bitcoin.ru/category/",
                "Chance": 100,
                "Referrers": [
                {
                "Url": "https://www.google.ru/",
                        "Chance": 100
                },
                {
                "Url": "https://yandex.ru/",
                        "Chance": 100
                }
                ]
        }
        ],
        "Locations": [	// Массив локаций
        {
        "Id": "63ccb4b1-f257-44bf-bcac-c7e0d8681921", // Идентификатор локации
                "Chance": 100	// Вероятность выпадения данной локации при очередном визите
        }
        ],
        "VisitQueue": null, // Имя очередь (например, mobile)

        "Script": "<БОЛЬШОЙ И ДЛИННЫЙ СКРИПТ>", // Скрипт, который будет исполняться
// при выполнении визита.
// По сути, именно скриптом определяются
// действия бота
        "IsAbsolute": true,
        "DayVisits": null,
        "Parameters": {	// Параметры для передачи в скрипт
        // Например, идентификаторы рекламных блоков
        // или селекторы для закрытия всплывающих окон        
        "linksForClickSelectors": [
                "h2.title>a",
                ".tab-pane.active .story_line>a>i",
                "header>a.logotype"
        ],
                "yandexBlockId": "yandex_rtb_R-A-327179-1"
        },
        "DailyWeight": [100, 100, 100, 100, 100, 100, 100], // Процент траффика по дням недели
        "BrowserType": null, // Тип браузера, но лучше его не использовать!
        "UseImagePlaceholders": true
        }