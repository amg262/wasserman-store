/**
 * Created by andy on 2/24/17.
 */

jQuery(document).ready(function ($) {

    var s = false;
    $('#sideshuffle').click(function (e) {

        if (s === false) {
            $('#secondary').css('display','none');
            $('#primary-mono').css('width','100%');

            s = true;
        } else {
            $('#secondary').css('display','block');
            $('#primary-mono').css('width','75%');
            s = false;
        }



    });

});

jQuery(function ($) {


});

