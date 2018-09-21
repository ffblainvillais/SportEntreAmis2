(function($){
    'use strict'

    class Book {

        constructor() {

            this.$selectableItems   = $('.js-book__selectable');
            this.addCrenelsUrl      = '/user/etablissement/ajout-horaire-ouverture';

            this.init()
        }

        mapCrenels($selectedCrenels) {

            const toRender = []

            $.each( $selectedCrenels, function( key, value ) {

                let $crenelSelected     = $(value)
                let crenelValue         = {'day': $crenelSelected.data('day'), 'crenelBeginHour': $crenelSelected.data('crenel_begin_hour')}

                toRender.push(crenelValue)
            })

            return toRender
        }

        addOpeningHours(selectedCrenelsMapped) {

            $.post(this.addCrenelsUrl, { selectedCrenelsMapped }).done(res => {
                console.log(res)
            })

        }

        init() {

            const that = this

            this.$selectableItems.selectable({
                filter: '.js-book_selectable_item',
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
                },
                unselected: function (event, ui) {
                    $(ui.unselected).removeClass('table-danger');
                },
                stop: function (event, ui) {

                    let $selectedCrenels = $('.ui-selected')

                    if ($selectedCrenels.length > 0) {

                        let mappedSelectedCrenels = that.mapCrenels($selectedCrenels);

                        that.addOpeningHours(mappedSelectedCrenels)
                    }

                    window.location.reload()
                }
            });

        }

    }

    new Book()

})(jQuery);
