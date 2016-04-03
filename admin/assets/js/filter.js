jQuery.noConflict();
(function($) {
    var outer = [],
        inner = [];
    inner.events = function() {
        $(document).on('click', 'a[data=all]', function() {
            $(this).parent().find('a.mcs-item').not('.active').click();
        });
        $(document).on('click', 'a[data=none]', function() {
            $(this).parent().find('a.active').click();
        });
        $(document).on('click', 'a[data=invert]', function() {
            $(this).parent().find('a.mcs-item').click();
        });
        $(document).on('click', 'a[data=submit]', function() {
            document.getElementById('adminForm').submit();
        });
    };
    inner.build = function() {
        var selectcontrols = document.querySelectorAll("[data-filter]");
        for (var i=0; i<selectcontrols.length; i++) {
            $selectcontrol = $(selectcontrols[i]);
            $selectcontrol.MultiColumnSelect({
                multiple: true,
                useOptionText: true,
                hideselect: true,
                openmenuClass: 'mcs-open',
                openmenuText: $selectcontrol.data('filter'),
                openclass: 'open',
                containerClass: 'mcs-container',
                itemClass: 'mcs-item',
                idprefix: 'wards-',
                duration: 200,
                onOpen: function() {},
                onClose: function() {},
                onItemSelect: function() {}
            });
            $selectcontrol.children('.mcs-container').append('<hr class="clear" />');
            $selectcontrol.MultiColumnSelectAddItem('all', 'All', 'wards-');
            $selectcontrol.MultiColumnSelectAddItem('none', 'None', 'wards-');
            $selectcontrol.MultiColumnSelectAddItem('invert', 'Invert', 'wards-');
            $selectcontrol.MultiColumnSelectAddItem('submit', 'Submit', 'wards-');
        }
    };
    outer.init = function() {
        inner.build();
        inner.events();
    };
    window.addEvent('domready', function() {
        outer.init();
    });
})(jQuery);