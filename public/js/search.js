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
                            response($.map(json, function (value) {
                                return value;
                            }));
                        },
                    });
                },
                minLength: 2,
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
