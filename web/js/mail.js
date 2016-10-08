/**
 * Torbara CuteChurch Responsive HTML Template, exclusively on Envato Market: http://themeforest.net/user/torbara?ref=torbara
 * @encoding     UTF-8
 * @version      1.0
 * @copyright    Copyright (C) 2015 Torbara (http://torbara.com). All rights reserved.
 * @license      GNU General Public License version 2 or later, see http://www.gnu.org/licenses/gpl-2.0.html
 * @author       Alexandr Khmelnytsky (support@torbara.com)
 */

jQuery(function($) {
    "use strict";
    
    //Contact us
    jQuery("form.wpcf7-form").submit(function() {

        if(IsEmail(jQuery("input[name='email-774']").val())){
            var url = "mail.php"; // the mail script

            jQuery.ajax({
                    type: "POST",
                    url: url,
                    data: jQuery("form.wpcf7-form").serialize()+"&tm_form=1", // serializes the form's elements.
                    success: function(data) {
                        alert(data); // show response from the php script.
                    }
                });

            jQuery(this)[0].reset();//Clear all form fields
        }else{
            alert("Please fill all fields.");
        }
        
        return false; // avoid to execute the actual submit of the form.
    });    
    
    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    
});