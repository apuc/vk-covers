/**
 * Created by apuc0 on 17.01.2018.
 */
function handleFileSelect(evt) {
    var file = evt.target.files; // FileList object
    var f = file[0];
    // Only process image files.
    if (!f.type.match('image.*')) {
        alert("Только изображения....");
    }
    var reader = new FileReader();
    // Closure to capture the file information.
    reader.onload = (function (theFile) {
        return function (e) {
            // Render thumbnail.
            var box = document.getElementById('mainCover');
            //box.innerHTML = ['<img class="cover-img" src="', e.target.result, '" />'].join('');
            //document.getElementById('output').insertBefore(span, null);
            var image = new Image();
            image.src = e.target.result;
            image.onload = function () {
                console.log(this.width);

                var data = new FormData();

                // заполняем объект данных файлами в подходящем для отправки формате
                $.each($(file), function (key, value) {
                    data.append(key, value);
                });
                if ((this.width === 795 && this.height === 200) || (this.width === 1590 && this.height === 400)) {
                    data.append('crop', 0);
                }
                else {
                    data.append('crop', 1);
                }

                $.ajax({
                    url: '/secure/covers/covers/load-cover-img',
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    // отключаем обработку передаваемых данных, пусть передаются как есть
                    processData: false,
                    // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
                    contentType: false,
                    // функция успешного ответа сервера
                    success: function (respond, status, jqXHR) {
                        //box.innerHTML = ['<img class="cover-img" src="', respond.imgUrl, '" />'].join('');
                        $('.cover-img').attr('src', respond.imgUrl);
                        console.log(respond);
                    },
                    // функция ошибки ответа сервера
                    error: function (jqXHR, status, errorThrown) {
                        console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
                    }

                });
            };
        };
    })(f);
    // Read in the image file as a data URL.
    reader.readAsDataURL(f);
}

document.getElementById('coverFile').addEventListener('change', handleFileSelect, false);

$(document).on('click', '.layer-item-head', function () {
    $(this).next().slideToggle(400);
});

$(document).on('click', '.addWidgetImg', function () {
    var wId = $(this).data('id');
    $('#file_' + wId).click();
});

$(document).on('change', '.RIFile', function (evt) {
    var file = evt.target.files;
    var data = new FormData();
    var wId = $(this).data('id');

    // заполняем объект данных файлами в подходящем для отправки формате
    $.each($(file), function (key, value) {
        data.append(key, value);
    });

    $.ajax({
        url: '/secure/covers/covers/load-random-img',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        // отключаем обработку передаваемых данных, пусть передаются как есть
        processData: false,
        // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
        contentType: false,
        // функция успешного ответа сервера
        success: function (respond, status, jqXHR) {
            $('.l-i-' + wId).append('<div class="widget-load-img"><img src="' + respond.imgUrl + '"><span>X</span></div>')

        },
        // функция ошибки ответа сервера
        error: function (jqXHR, status, errorThrown) {
            console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
        }

    });
});

$(document).on('click', '.delWidget', function () {
    var wId = $(this).data('id');
    $('.layer-item').each(function (item) {
        if ($(this).attr('data-id') == wId) {
            $(this).remove();
        }
    });
    $('#widget_' + wId).remove();
    $.ajax({
        url: '/secure/covers/covers/del-widget',
        type: 'POST',
        data: {id: wId}
    });
    return false;
});

$('.widget-item').on('click', function () {
    var widgetName = $(this).attr('data-name');
    var widgetRusName = $(this).attr('data-rus-name');
    var coverId = $('.wrap').attr('data-cover-id');
    $.ajax({
        url: '/secure/covers/covers/add-widget',
        type: 'POST', // важно!
        data: {
            widgetName: widgetName,
            widgetRusName: widgetRusName,
            coverId: coverId
        },
        dataType: 'json',
        // функция успешного ответа сервера
        success: function (respond, status, jqXHR) {
            $('.layers').append(respond.html);
            var div = generateDragElem(respond.id);
            $('#mainCover').append(div);
            $cg('#widget_' + respond.id).draggable({
                parentBoxCross: false,
                stopDrag: function (el, x, y) {
                    $('#x_' + respond.id).val(x);
                    $('#y_' + respond.id).val(y);
                }
            });
            $cg('#widget_' + respond.id).resizable({
                stopResize: function (elem, w, h) {
                    $('#width_' + respond.id).val(w);
                    $('#height_' + respond.id).val(h);
                }
            });
        },
        // функция ошибки ответа сервера
        error: function (jqXHR, status, errorThrown) {
            console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
        }

    });

});

$(document).on('click', '.setWidgetSettings', function () {
    var widgetId = $(this).data('id');
    $cg('#widget_' + widgetId).draggable().setCoordinates($('#x_' + widgetId).val(), $('#y_' + widgetId).val());
    $cg('#widget_' + widgetId).resizable().setWH($('#width_' + widgetId).val(), $('#height_' + widgetId).val());
    return false;
});

$('#saveCover').on('click', function () {
    var data = {widgets: []};
    data.coverId = $('.wrap').data('cover-id');
    data.coverImg = $('#mainCover').find('img').attr('src');
    $('.layer-item').each(function () {
        var wId = $(this).data('id');
        var w = {widgetId: wId};
        $('.widget_input_' + wId).each(function () {
            var type = $(this).data('type');
            w[type] = $(this).val();
        });
        w.imgs = [];
        $('.l-i-' + wId).find('img').each(function () {
            w.imgs.push($(this).attr('src'));
        });
        data.widgets.push(w);
    });
    $.ajax({
        url: '/secure/covers/covers/save-cover-widgets',
        type: 'POST', // важно!
        data: data,
        //dataType    : 'json',
        // функция успешного ответа сервера
        success: function (respond, status, jqXHR) {

        },
        // функция ошибки ответа сервера
        error: function (jqXHR, status, errorThrown) {
            console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
        }

    });
    return false;
});

$('#previewCover').on('click', function () {
    $('.coverPreviewBox').html('');
    $('#saveCover').click();
    var coverId = $('.wrap').data('cover-id');
    $.ajax({
        url: '/secure/covers/covers/preview-cover',
        type: 'POST', // важно!
        data: {coverId: coverId},
        dataType    : 'json',
        // функция успешного ответа сервера
        success: function (respond, status, jqXHR) {
            var img = document.createElement('img');
            img.setAttribute('src', respond.imgUrl);
            $('.coverPreviewBox').html(img);
        },
        // функция ошибки ответа сервера
        error: function (jqXHR, status, errorThrown) {
            console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
        }

    });
    return false;
});

$('#useCover').on('click', function () {
    $('#saveCover').click();
    var coverId = $('.wrap').data('cover-id');
    $.ajax({
        url: '/secure/covers/covers/preview-cover',
        type: 'POST', // важно!
        data: {coverId: coverId, use:1},
        dataType    : 'json',
        // функция успешного ответа сервера
        success: function (respond, status, jqXHR) {
            var img = document.createElement('img');
            img.setAttribute('src', respond.imgUrl);
            $('.coverPreviewBox').html(img);
        },
        // функция ошибки ответа сервера
        error: function (jqXHR, status, errorThrown) {
            console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
        }

    });
    return false;
});

$(document).on('click', '.widget-load-img span', function () {
    $(this).closest('.widget-load-img').remove();
});

function loadWidget() {
    $('.layer-item').each(function () {
        var wId = $(this).data('id');
        $cg('#widget_' + wId).draggable({
            parentBoxCross: false,
            stopDrag: function (el, x, y) {
                $('#x_' + wId).val(x);
                $('#y_' + wId).val(y);
            }
        });
        $cg('#widget_' + wId).resizable({
            stopResize: function (elem, w, h) {
                $('#width_' + wId).val(w);
                $('#height_' + wId).val(h);
            }
        });
    });
}

function generateDragElem(id) {
    var div = document.createElement('div');
    div.setAttribute('id', 'widget_' + id);
    div.style.position = 'absolute';
    div.style.width = '100px';
    div.style.height = '100px';
    div.style.backgroundColor = 'grey';
    div.style.opacity = '0.7';
    div.style.top = '10px';
    div.style.left = '10px';
    div.style.border = '2px dashed black';
    return div;
}

// $('#coverFile').on('change', function(){
//     var files = this.files;
//     console.log(files);
// });