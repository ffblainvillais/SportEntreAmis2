(function($){
    'use strict'

    class Book {

        constructor() {

            this.$selectableItems   = $('.js-book__selectable');
            this.addCrenelsUrl      = '/user/etablissement/ajout-horaire-ouverture';
            this.selectableClass    = 'js-book_selectable_item';
            this.unselectableClass  = 'js-book_unselectable_item';
            this.$establishmentPage = '/user';
            this.alertDiv           = $('.js-book_alert');

            this.init()
        }

        showAlert(message) {

            this.alertDiv.text(message)
            this.alertDiv.show()
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

        removeAllClasses($objectSelected) {

            $objectSelected.removeClass('table-active')
            $objectSelected.removeClass('table-danger')
            $objectSelected.removeClass('table-success')
        }

        addSelectingClasses($objectSelected) {

            if ($objectSelected.hasClass(this.selectableClass)) {

                this.removeAllClasses($objectSelected)
                $objectSelected.addClass('table-active')

            } else if ($objectSelected.hasClass(this.unselectableClass)) {

                this.removeAllClasses($objectSelected)
                $objectSelected.addClass('table-danger')
            }
        }

        addUnselectingClasses($objectSelected) {

            if ($objectSelected.hasClass(this.selectableClass)) {

                this.removeAllClasses($objectSelected)


            } else if ($objectSelected.hasClass(this.unselectableClass)) {

                this.removeAllClasses($objectSelected)
                $objectSelected.addClass('table-success');
            }
        }

        addSelectedClass($objectSelected) {

            if ($objectSelected.hasClass(this.selectableClass)) {

                this.removeAllClasses($objectSelected)
                $objectSelected.addClass('table-success');
                $objectSelected.addClass('js-book_selected');
                $objectSelected.addClass(this.unselectableClass);
                $objectSelected.removeClass(this.selectableClass);

            } else if ($objectSelected.hasClass(this.unselectableClass)) {

                this.removeAllClasses($objectSelected)
                $objectSelected.addClass(this.selectableClass);
                $objectSelected.removeClass(this.unselectableClass);
                $objectSelected.removeClass('js-book_selected');
            }
        }

        init() {

            const that = this

            this.$selectableItems.selectable({
                filter: 'td',
                selecting: function (event, ui) {

                    let $objectSelected = $(ui.selecting)

                    that.addSelectingClasses($objectSelected)

                },
                selected: function (event, ui) {

                    let $objectSelected = $(ui.selected)

                    that.addSelectedClass($objectSelected)

                },
                unselecting: function (event, ui) {

                    let $objectSelected = $(ui.unselecting)

                    that.addUnselectingClasses($objectSelected)
                }
            });

            $('.js-book_apply').on('click', (e) => {

                let $selectedCrenels        = $('.js-book_selected')
                let mappedSelectedCrenels   = this.mapCrenels($selectedCrenels);

                if ($selectedCrenels.length > 0) {

                    this.addOpeningHours(mappedSelectedCrenels)

                    document.location.href = this.$establishmentPage;

                } else {

                    this.showAlert('Veuillez séléctionner au moins un créneau')
                }
            })
        }
    }

    new Book()

})(jQuery);
