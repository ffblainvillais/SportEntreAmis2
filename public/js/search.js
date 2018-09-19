(function($){
    'use strict'

    class Search {

        constructor() {

            this.autocompleteUrl    = $('.js-search__input').data('url')

            this.init()
        }

        init() {

            const that = this

            $(".js-search__input").autocomplete({

                source: function( request, response ) {
                    $.ajax({
                        url: that.autocompleteUrl,
                        type: `POST`,
                        dataType: "json",
                        data: {
                            part: request.term
                        },
                        success: function (json) {
                            console.log(json)
                            response($.map(json, function (value) {
                                return value;
                            }));
                        },
                    });
                },
                minLength: 2,
                select: function( event, ui ) {
                    console.log( ui.item ?
                        "Selected: " + ui.item.label :
                        "Nothing selected, input was " + this.value);
                },
                open: function() {
                    $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                },
                close: function() {
                    $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                }
            });
        }

    }

    new Search()

})(jQuery);
