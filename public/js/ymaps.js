ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map("map", {
            center: [54.328095, 48.396116],
            zoom: 17
        }, {
            searchControlProvider: 'yandex#search'
        });

    myMap.geoObjects
        .add(new ymaps.Placemark([54.328095, 48.396116], {
            balloonContent: '<strong>"Аукцион"</strong> г. Ульяновск',
            iconCaption: 'Аукцион'
        }, {
            preset: 'islands#greenDotIconWithCaption',
            iconColor: '#735184'
        }));
}
