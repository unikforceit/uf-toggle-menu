(function ($) {
"use strict";

    var UFTOGGLEMENUGlobal = function ($scope, $) {

        // Js Start
        $('[data-background]').each(function() {
            $(this).css('background-image', 'url('+ $(this).attr('data-background') + ')');
        });
        // Js End

    };
    var PopJs = function ($scope, $) {
        $scope.find('.uf-toggle-menu').each(function () {
            // Js Start
        // zeynepjs initialization for demo
            $('.zeynep ul > li.has-submenu > a').each( function (){
                var text = $(this).text();
                var text_id = text.toLowerCase();
                var sub_menu = $(this).next('ul.sub-menu').html();
                text_id = text_id.replace(" ", "");
                $(this).attr('href', '#');
                $(this).attr('data-submenu', text_id);
                $(this).after('<div id="'+text_id+'" class="submenu">' +
                    '                    <div class="submenu-header">' +
                    '                        <a href="#" data-submenu-close="'+text_id+'">Main Menu</a>' +
                    '                    </div>' +
                    '                    <label>'+text+'</label>'+
                    '<ul>'+ sub_menu + '</ul>' +
                    '</div>');
            });

            var zeynep = $('.zeynep').zeynep({
                opened: function () {
                    //console.log('the side menu is opened')
                }
            });

            // dynamically bind 'closing' event
            zeynep.on('closing', function () {
                //console.log('this event is dynamically binded')
            });

            // handle zeynepjs overlay click
            $('.zeynep-overlay').on('click', function () {
                zeynep.close()
            });

            // open zeynepjs side menu
            $('.btn-open').on('click', function () {
                zeynep.open()
            });
        // Js End
        })
    };


    $(window).on('elementor/frontend/init', function () {
        if (elementorFrontend.isEditMode()) {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', UFTOGGLEMENUGlobal);
            //elementorFrontend.hooks.addAction('frontend/element_ready/uf_toggle_menu.default', PopJs);
        }
        else {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', UFTOGGLEMENUGlobal);
            //elementorFrontend.hooks.addAction('frontend/element_ready/uf_toggle_menu.default', PopJs);
        }
    });
console.log('addon js loaded');
})(jQuery);