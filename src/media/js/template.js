/**
 * Luchtreiziger template script.
 *
 * Replaces the parts of the luchtreiziger2014 scripts that the site still uses:
 * the mmenu off-canvas menu for small screens and the "naar boven" (back to top) link.
 *
 * @copyright   (C) 2014 Joostrap, (C) 2014-2026 Herman Peeren
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
(function ($) {
    'use strict';

    $(function () {
        var options = (window.Joomla && Joomla.getOptions('tpl_luchtreiziger')) || {};

        // Off-canvas menu (mmenu 4), as in luchtreiziger2014
        if ($.fn.mmenu) {
            $('div#sidebar').mmenu({
                classes: 'mm-dark',
                position: options.menuslide || 'right',
                header: true
            });
        }

        // Back to top
        var $goTop = $('.go-top');

        if ($goTop.length) {
            $(window).on('scroll', function () {
                if ($(this).scrollTop() > 200) {
                    $goTop.fadeIn(200);
                } else {
                    $goTop.fadeOut(200);
                }
            });

            $goTop.on('click', function (event) {
                event.preventDefault();
                $('html, body').animate({scrollTop: 0}, 300);
            });
        }
    });
})(jQuery);
