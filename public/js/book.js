(function($){
    'use strict'

    class Book {

        constructor() {

            this.$selectableItems   = $('.js-book__selectable');
            this.$crenels           = $('.js-book__crenel');

            this.init()
        }

        init() {

            const that = this

            this.$selectableItems.selectable({
                filter: 'td',
                selecting: function (event, ui) {
                    $(ui.selecting).addClass('table-active');
                },
                selected: function (event, ui) {
                    $(ui.selected).removeClass('table-active');
                    $(ui.selected).removeClass('table-danger');
                    $(ui.selected).addClass('table-success');
                },
                unselecting: function (event, ui) {
                    $(ui.unselecting).removeClass('table-success');
                    $(ui.unselecting).removeClass('table-active');
                    //$(ui.unselecting).addClass('table-danger');
                },
                unselected: function (event, ui) {
                    $(ui.unselected).removeClass('table-danger');
                }
            });

        }

    }

    new Book()

})(jQuery);
