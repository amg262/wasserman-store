/**
 * Created by andy on 2/24/17.
 */

jQuery(document).ready(function ($) {


console.log('STILL HERE');
    var s = false;
    $('#toggle_sidebar').click(function (e) {

        if (s === false) {
            $('#secondary').css('display', 'none');
            $('#primary-mono').css('width', '100%');
            //$('#primary').css('width','100%');
            //console.log($('#toggle_sidebar'));// 'Show Sidebar';
            $('#toggle_sidebar').innerText = 'Show';

            s = true;
        } else {
            $('#secondary').css('display', 'block');
            $('#primary-mono').css('width', '75%');
            //$('#primary').css('width','75%');
            $('#toggle_sidebar').innerText = 'Hide Sidebar';
            s = false;
        }
    });

});

jQuery(function ($) {


});

