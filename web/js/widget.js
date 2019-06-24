//vars for widget url generation (defaults)
var widgetColor = "light";
var widgetLanguage = "hy";
var widgetBackground = 'ffffff';
var widgetTextColor = '000000';
var widgetWidth = 215;
var widgetHeight = 135;

generateLink(widgetLanguage, widgetBackground, widgetHeight, widgetWidth);

$(document).ready(function () {

    $('#jb').click(function () {
        $(this).removeClass('topen')
        $('#cb').removeClass('topen')
        $(this).addClass('topen')

        $(this).css({
            'text-decoration': 'none',
            'border-bottom': '1px solid #'+widgetBackground,
            'background': '#'+widgetBackground
        })

        $('#cb').css({
            'text-decoration': 'none',
            'border-bottom': '1px solid #39b54a',
            'background': '#eaeaea'
        })
    })
    $('#cb').click(function () {
        $(this).removeClass('topen')
        $('#jb').removeClass('topen')
        $(this).addClass('topen')

        $(this).css({
            'text-decoration': 'none',
            'border-bottom': '1px solid #'+widgetBackground,
            'background': '#'+widgetBackground
        })

        $('#jb').css({
            'text-decoration': 'none',
            'border-bottom': '1px solid #39b54a',
            'background': '#eaeaea'
        })
    })

    $('#arq').click(function () {

        $(this).removeClass('ytopen')
        $('#vacharq').removeClass('ytopen')
        $(this).addClass('ytopen')


        $(this).css({
            'text-decoration': 'none',
            'border-right': '1px solid #'+widgetBackground,
            'background': '#'+widgetBackground
        })

        $('#vacharq').css({
            'text-decoration': 'none',
            'border-right': '1px solid #39b54a',
            'background': '#eaeaea'
        })
    })
    $('#vacharq').click(function () {

        $(this).removeClass('ytopen')
        $('#arq').removeClass('ytopen')
        $(this).addClass('ytopen')

        $(this).css({
            'text-decoration': 'none',
            'border-right': '1px solid #'+widgetBackground,
            'background': '#'+widgetBackground
        })

        $('#arq').css({
            'text-decoration': 'none',
            'border-right': '1px solid #39b54a',
            'background': '#eaeaea'
        })
    })


    $(".data-tab-open").click(function () {
        $(this).tab('show');
    });

    $colorPicker = $('#widget-color-pick')

    /*** WIDGET PROPERTIES ***/
    var currentLanguage = $('#current-language').val();

    //call this from first to change language
    setWidgetLanguageToCurrentLanguage(currentLanguage);

    //main widget container
    $widgetContainer = $('.widget-container');

    //take widget color object
    $widgetColorObject = $('.widget-color')

    //take widget language object
    $widgetLanguageObject = $('.widget-language')

    //take widget size object
    $widgetSizeObject = $('.widget-size')

    //take widget length
    $widgetHeigth = $('#widget-height')
    $widgetWidth = $('#widget-width')

    var height = 0;
    var width = 0;

    $widgetHeigth.keyup(function () {
        height = $(this).val()

        if (height >= 135) {
            $widgetContainer.animate({
                'height': height
            }, 300)

            var trHeight = (height - 70) / 4;
            var trHeight1 = (height - 70) / 4;
            $('#widget-table-container-table').find('tr').each(function () {
                $(this).animate({
                    'height': trHeight + "px"
                }, 300)
            })
            $('#widget-table-container-table-1').find('tr').each(function () {
                $(this).animate({
                    'height': trHeight1 + "px"
                }, 300)
            })
            $('#widget-table-container-table-2').find('tr').each(function () {
                $(this).animate({
                    'height': trHeight1 + "px"
                }, 300)
            })

            widgetHeight = height
            generateLink(widgetLanguage, widgetBackground, widgetHeight, widgetWidth);
        }

    })
    $widgetWidth.keyup(function () {

        width = $(this).val()

        if (width <= 840 && width >= 215) {
            $widgetContainer.animate({
                'width': width
            }, 300)

            widgetWidth = width
            generateLink(widgetLanguage, widgetBackground, widgetHeight, widgetWidth);
        }
    })


    $widgetLanguageObject.click(function () {
        setWidgetLanguageToCurrentLanguage($(this).val())
    })

})

var canChangeLanguage = true;

function setWidgetLanguageToCurrentLanguage(lang) {

    $('.checker-lang-design').each(function () {
        $(this).removeClass("activeL")
        $(this).removeClass("notActiveL")
    })

    switch (lang) {
        case "hy":
            $('.hy-lang').addClass('activeL')
            $('.en-lang').addClass('notActiveL')

            widgetLanguage = "hy";
            generateLink(widgetLanguage, widgetBackground, widgetHeight, widgetWidth);
            break;

        case "en":
            $('.hy-lang').addClass('notActiveL')
            $('.en-lang').addClass('activeL')

            // $('.bank-name-translatable').each(function () {
            //     var inner = $(this).html()
            //     var trans = $(this).attr('data-translation')
            //     $(this).html(trans)
            //     $(this).attr('data-translation', inner)
            // })


            widgetLanguage = "en";
            generateLink(widgetLanguage, widgetBackground, widgetHeight, widgetWidth);
            break;
    }
}

function generateLink(language, color_background, size_height, size_width) {
    var html = '<iframe src="http://bankinfo.toolbox.am/'+language+'/bankinfo-widget/' + color_background + '/' + size_height + '/' + size_width + '" frameborder="0" scrolling="no" allowtransparency="true" height="'+size_height+'px" width="'+size_width+'px"></iframe>';

    $('#widget-link').text(html);
    $('#widget-link-block-show').html(html);
}


function getWidgetColor(obj) {
    /*** change descriptor value ***/
    $('#colo-value-label').html(obj.value)

    /*** change bg of color box ***/
    $('#color-value').css({
        'background': obj.value
    })

    $widgetContainer.css({
        'background': obj.value
    })

    $('.topen').css({
        'background': obj.value,
        'border-bottom':'1px solid '+obj.value,
    })

    $('.yopen').css({
        'background': obj.value,
        'border-right':'1px solid '+obj.value,
    })


    widgetBackground = obj.value
    widgetBackground = widgetBackground.slice(1)


    generateLink(widgetLanguage, widgetBackground, widgetHeight, widgetWidth);
}


function getWidgetColorFonts(obj) {
    /*** change descriptor value ***/
    $('#colo-value-label-fonts').html(obj.value)

    /*** change bg of color box ***/
    $('.widget-text').css({
        'color': obj.value
    })


    $('#color-value-fonts').css({
        'background': obj.value
    })
    widgetTextColor = obj.value
    widgetTextColor = widgetTextColor.slice(1)

    generateLink(widgetLanguage, widgetBackground, widgetHeight, widgetWidth);
}

