$(function(){
    
    // Date Time
    var timeContainer = $('.header__time');
    
    var timeInterval = setInterval(function(){
        timeContainer.html(getGmt4DateTime(systemLocale));
    }, 1000);
    
    function getGmt4DateTime(locale) {

        var offset = 4;
        var gmt4Time = {};
        var dateStr = "";

        var location = {
            "en": "Yerevan",
            "hy": "Երևան",
            "ru": "Ереван"
        };
        
        var dateLocales = {
            "en": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            "hy": ["Հունվար", "Փետրվար", "Մարտ", "Ապրիլ", "Մայիս", "Հունիս", "Հուլիս", "Օգոստոս", "Սեպտեմբեր", "Հոկտեմբեր", "Նոյեմբեր", "Դեկտեմբեր"],
            "ru": ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"]
        };

        var weekLocales = {
            "en": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            "hy": ["Երկուշաբթի", "Երեքշաբթի", "Չորեքշաբթի", "Հինգշաբթի", "Ուրբաթ", "Շաբաթ", "Կիրակի"],
            "ru": ["Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье"]
        };

        var gmt4DateRaw = new Date(new Date().getTime() + offset * 3600 * 1000);

        gmt4Time.year = gmt4DateRaw.getUTCFullYear();
        gmt4Time.month = gmt4DateRaw.getUTCMonth();
        gmt4Time.date = (gmt4DateRaw.getUTCDate() <= 9) ? "0"+gmt4DateRaw.getUTCDate() : gmt4DateRaw.getUTCDate();
        gmt4Time.day = gmt4DateRaw.getUTCDay();

        gmt4Time.hour = (gmt4DateRaw.getUTCHours() <= 9) ? "0"+gmt4DateRaw.getUTCHours() : gmt4DateRaw.getUTCHours();
        gmt4Time.minutes = (gmt4DateRaw.getUTCMinutes() <= 9) ? "0"+gmt4DateRaw.getUTCMinutes() : gmt4DateRaw.getUTCMinutes();
        gmt4Time.seconds = (gmt4DateRaw.getUTCSeconds() <= 9) ? "0"+gmt4DateRaw.getUTCSeconds() : gmt4DateRaw.getUTCSeconds();

        dateStr = gmt4Time.hour + ":" + gmt4Time.minutes + ":" + gmt4Time.seconds;
        dateStr += ", " + gmt4Time.date + " " + dateLocales[locale][gmt4Time.month] + " " + gmt4Time.year + ", " + weekLocales[locale][gmt4Time.day]+" "+location[locale]+" (GMT + 04:00)";
        
        return dateStr;

    }
    
    //time picker
    $calendar = $('.date-block-icon')
    $dateTimeBlock = $('.date-picker-container')
    $dateTimeBlockCloser = $('.date-picker-container-closer')
    $timeSelect = $('#filter-rate-time')
    var startH = 4;
    var startM = 15;
    var stopH = 23;
    var stopM = 60;
    var stepM = 15;

    var h = "";
    var m = "";
    while(true){
        if(startM == 60){
            startM = 0;
            startH++;
        }
        if(startH < 10){
            h = "0"+startH;
        }else{
            h = startH;
        }
        if(startM == 0){
            m = "0"+startM;
        }else{
            m = startM;
        }
        $timeSelect.append('<option value="'+h+':'+m+'">'+h+':'+m+'</option>');
        if(startH == stopH ){
            break;
        }
        startM = startM + stepM;
    }




    $calendar.click(function () {
        $dateTimeBlock.css({
            'display':'block'
        })

    })
    $dateTimeBlockCloser.click(function () {
        $dateTimeBlock.css({
            'display':'none'
        })
    })


    // Currency table column highlight
    var dataTable = $('.featured-table');
    var dataTableFixed = $('.featured-table.fixed-header');
    var currencyTable = $('.content__table.highlightable');
    var currencyTableRows = $('.content__table.highlightable tbody tr');
    var currencyTableCells = $('.content__table.highlightable tbody tr td');
    
    currencyTableCells.hover(function(){
        var cellIndex = $(this).index();
        highlightTableElements(currencyTableRows, cellIndex);
    }, function(){
        var cellIndex = $(this).index();
        highlightTableElements(currencyTableRows, cellIndex);
    });
    
    function highlightTableElements(tableRows, cellIndex){
        
        if(cellIndex !== 0){
            
            tableRows.each(function(){

                var rowIndexed = $(this).children().eq(cellIndex)
                rowIndexed.toggleClass('active');

            });
            
        }
        
    }
    
    // Right column
    var content = $('.content');
    var rightBar = $('.right-bar');
    
    // Map height
    var bankList = $('.bank-list');
    var mapContainer = $('#map');
    var mapContainerHeight = mapContainer.height();

    // Bank list
    var bankListItem = $('.bank-list li a');
    bankListItem.on('click', function(){
        bankListItem.removeClass('new-button');
        $(this).addClass('new-button');
    });
    
    // Bank branch
    var branchContainer = $('.branch-container');
    bankListItem.on('click', function(){
        var bankAttr = $(this).attr('data-bank');
        // console.log(systemLocale);
        if(bankAttr == 'all'){
            branchContainer.html("");
        } else {
            branchContainer.html('<div class="loading"><img src="/img/design-elements/ring.svg" /></div>');

            console.log('/'+systemLocale+'/data/branches/'+datType+'/'+bankAttr+'?t='+Date.now())
            $.ajax({
                url: '/'+systemLocale+'/data/branches/'+datType+'/'+bankAttr+'?t='+Date.now(),
                success: function(d){
                    
                    branchContainer.html(d);
                    
                }
            });
            
        }
        
    });
    
    // Get market quotes
    getQuotes();
    setInterval(function(){ getQuotes(); }, 1500);
    
    function getQuotes(){
        
        var quoteContainer = $('.right-bar__widget-quotes.market-quotes tbody');
        
        $.ajax({
            url: '/data/quotes.json',
            method: 'GET',
            success: function(data){
                
                var dataString = "";
                
                $.each(data.indices, function(){
                    
                    var current  = $(this)[0];
                    var changeClass = "";
                    
                    if(current.color == 'red'){ changeClass = "trend-negative"; }
                    if(current.color == 'green'){ changeClass = "trend-positive"; }
                    
                    dataString += '<tr><td>'+current.name+'</td><td>'+current.date+'</td><td>'+current.value1+'</td><td class="'+changeClass+'">'+current.value2+'</td></tr>';
                    
                });
                
                quoteContainer.html(dataString);
                
            }
        });
        
    }
    
    // *** Plugins ***
    
    // Owl caoursel
    
    if($(".owl-carousel").length > 0){
        
        var owlCarousel = $(".owl-carousel");
        owlCarousel.owlCarousel({
            navigation : true,
            navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            pagination: false,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem: true,
            loop: true,
            autoPlay: true,
            autoplayTimeout: 1000,
            autoplayHoverPause: true,
            afterMove: function(e){
                var currentSlide = this.currentItem;
                
                switch(currentSlide){
                    case 0:
                        $('.content__service-buttons-people').addClass('active');
                        $('.content__service-buttons-business').removeClass('active');
                        $('.content__service-buttons-farmer').removeClass('active');
                        break;
                    case 1:
                        $('.content__service-buttons-people').removeClass('active');
                        $('.content__service-buttons-business').addClass('active');
                        $('.content__service-buttons-farmer').removeClass('active');
                        break;
                    case 2:
                        $('.content__service-buttons-people').removeClass('active');
                        $('.content__service-buttons-business').removeClass('active');
                        $('.content__service-buttons-farmer').addClass('active');
                        break;
                }
                
            }
        });
                
    }
    
    
    // Range Slider
    if($('input[type="range"]').length > 0){
        
        $('input[type="range"]').rangeslider({
            polyfill: false,
            update: true,
            rangeClass: 'rangeslider',
            disabledClass: 'rangeslider--disabled',
            horizontalClass: 'rangeslider--horizontal',
            verticalClass: 'rangeslider--vertical',
            fillClass: 'rangeslider__fill',
            handleClass: 'rangeslider__handle',
            onSlide: function (position, value) {

                var handle = $('.rangeslider__handle');
                var depositDays = $('input[name=deposit_days]');

                depositDays.val(value);

            }
        });
        
        $('input[name=deposit_days]').change(function(){ changeRangeValue($(this).val()); });
        
        function changeRangeValue(value){
            $('input[name=deposit_range]').val(value);
            $('input[name=deposit_range]').val(value).change();
        }
        
    }
    
    
    
    // iCheck
    if($('input[name=currency_check]').length > 0){
        
        $('input[name=currency_check]').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
            increaseArea: '20%' // optional
        });
        
    }
    
    // Data tables
    if(dataTable.length > 0){
        
        dataTable.DataTable({
            responsive: false,
            paging: false,
            searching: false,
            info: false,
            order: []
        });
        
    }
    if(dataTableFixed.length > 0){
        
        dataTable.DataTable({
            responsive: false,
            paging: false,
            searching: false,
            info: false,
            order: [],
            fixedHeader: { header: true }
        });
        
    }
   
    // Temporary
    $('.btn-filter').on('click', function(){
        
        $('.hide-this').hide();
        $('.content__table').removeClass('block-hidden');
        
    });


    setInterval(function () {
        var k = 0;
        $('.carousel-inner').find('.item').each(function () {

            if($(this).hasClass('active')){
                $('.main-content-item').find('button').each(function () {
                    $(this).removeClass('new-button-activated')
                })

                $('.main-content-item').eq(k).find('button').addClass('new-button-activated')
            }
            k++;
        })
    },2)


});