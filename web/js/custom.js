jQuery(document).ready(function () {
    "use strict";
    tm_countDown();

    jQuery('ul.wc-tabs').on('click', 'li:not(.active)', function () {
        jQuery(this).addClass('active').siblings().removeClass('active').parents('div.wc-tabs-wrapper').find('div.panel').eq(jQuery(this).index()).fadeIn().siblings('div.panel').hide();
        return false;
    });
    
    tm_countDown();

});

function tm_countDown() {
    "use strict";

    if (jQuery("#countdowntimer-2-dashboard").length) {
        jQuery('#countdowntimer-2-dashboard').countDown({
            targetDate: {
                'day': 26,
                'month': 4,
                'year': 2016,
                'hour': 11,
                'min': 17,
                'sec': 0
            },
            style: 'cutechurch',
            id: 'countdowntimer-2',
            event_id: '',
            launchtarget: 'bothtml',
            omitWeeks: 'true', onComplete: function () {
                jQuery('#countdowntimer-2-bothtml').css({'width': 'auto', 'height': 'auto'});
                jQuery('#countdowntimer-2-bothtml').html("<span class=\"date\">STAFF MEMBERS, MEETING STARTED!!!<\/span>");
            }
        });
    }

    if (jQuery("#countdowntimer-4-dashboard").length) {
        jQuery('#countdowntimer-4-dashboard').countDown({
            targetDate: {
                'day': 26,
                'month': 4,
                'year': 2016,
                'hour': 11,
                'min': 17,
                'sec': 0
            },
            style: 'cutechurch-2',
            id: 'countdowntimer-4',
            event_id: '',
            launchtarget: 'countdown',
            omitWeeks: 'true', onComplete: function () {
                jQuery('#countdowntimer-4-countdown').css({'width': 'auto', 'height': 'auto'});
                jQuery('#countdowntimer-4-countdown').html("");
            }
        });
    }

    if (jQuery("#countdowntimer-3-dashboard").length) {
        jQuery('#countdowntimer-3-dashboard').countDown({
            targetDate: {
                'day': 26,
                'month': 4,
                'year': 2016,
                'hour': 11,
                'min': 17,
                'sec': 0
            },
            style: 'cutechurch',
            id: 'countdowntimer-3',
            event_id: '',
            launchtarget: 'countdown',
            omitWeeks: 'false',
            onComplete: function () {
                jQuery('#countdowntimer-3-countdown').css({
                    'width': 'auto',
                    'height': 'auto'
                });
                jQuery('#countdowntimer-3-countdown').html("");
            }
        });
    }

}
