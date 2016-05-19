/**
 * Gradient text jQuery plugin
 * 
 * Replaces text elements with a canvas element of the same size
 * that shows the text with a gradient color.
 * 
 * Dual licensed under the MIT and GPL3 licenses.
 * 
 * @author      Codefocus (http://www.codefocus.ca/)
 * @copyright   2011 Codefocus
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 * @license     http://www.opensource.org/licenses/mit-license.php
 * @version     0.1
 * @link        http://www.codefocus.ca/
 */
(function($) {
/**
 *  Function executed by jQuery
 *
 */
    $.fn.gradienttext = function(options) {
    //  Merge options and defaults
        var options = $.extend({
            colors:             ['#000000', '#FFFFFF'],
            style:              'vertical',
            shadow:             false,
            shadow_color:       '#000000',
            shadow_offset_x:    1,
            shadow_offset_x:    1,
            shadow_blur:        1
        }, options);
    //  Replace each matched element with a canvas
        $(this).each(function() {
            try {
            //  Create canvas
                var canvas              = document.createElement('canvas');
                canvas.width            = $(this).width();
                canvas.height           = $(this).height();
                var context             = canvas.getContext("2d");
            }
            catch(e) {
            //  Canvas not supported
                return false;
            }
        //  Get H1 font
            var font_family         = $(this).css('font-family');
            var font_size           = $(this).css('font-size');
            var font_weight         = $(this).css('font-weight');
            var line_height         = $(this).css('line-height');
        //  Get H1 text
            var text                = $(this).text();
        //  Set canvas font
            context.textBaseline    = 'top';
            context.font            = font_weight + ' ' + font_size + ' ' + font_family;
            var text_metrics        = context.measureText(text);
        //  Make canvas gradient
            switch(options.style) {
            case 'horizontal':
            //  Horizontal
                var gradient = context.createLinearGradient(0, 0, text_metrics.width, 0);
                break;
            case 'vertical':
            default:
            //  Vertical
                var gradient = context.createLinearGradient(0, 0, 0, canvas.height);
                break;
            }
            var gradient_step = 1 / options.colors.length;
            for (var idx_color=0; idx_color<options.colors.length; ++idx_color) {
                gradient.addColorStop(idx_color * gradient_step, options.colors[idx_color]);
            }
            context.fillStyle = gradient;
        //  Shadow?
            if (options.shadow === true) {
                context.shadowOffsetX = options.shadow_offset_x;
                context.shadowOffsetY = options.shadow_offset_x;
                context.shadowBlur    = options.shadow_blur;
                context.shadowColor   = options.shadow_color;
            }
        //  Set canvas text
            context.fillText(text, 0, 0);
        //  Replace!
            $(this).replaceWith($(canvas));
        }); //  each matched element
    };  //  function gradienttext
})(jQuery);