import 'bootstrap';

(function($) {
    $('.sidebar-toggle').on('click', function() {
        $(this).closest('.sidebar-wrapper').toggleClass('open');
    });
    $('.sidebar-dropdown > a').on('click', function(e) {
        e.preventDefault();
        $(this).parent().toggleClass('open');
    });
    $('.input-search').on('keypress', function(e) {
        if (e.which === 13) {
            $(this). closest('.input-group').find('.btn-search').trigger('click');
        }
    });
    $('.btn-search').on('click', function() {
        var params = new URLSearchParams(location.search), input = $(this).closest('.input-group').find('.input-search')[0];
        params.set(input.name, input.value);
        window.location.search = params.toString();
    });
    $('input[type="submit"], button[type="submit"]').on('click', function(e) {
        let $button = $(this);
        if ($button.hasClass('loading')) {
            e.preventDefault();
            return;
        }
        $button.addClass('loading');
    });
})(jQuery);
