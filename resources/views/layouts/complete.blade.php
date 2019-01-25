{!! Html::script('assets/autocomplete/jquery.min.js') !!}
{!! Html::script('assets/autocomplete/jquery-ui.min.js') !!}
<script type="text/javascript">

    (function(  ) {
        $.widget( "ui.combobox", {
            _create: function() {
                var self = this,
                        select = this.element.hide(),
                        selected = select.children( ":selected" ),
                        value = selected.val() ? selected.text() : "";

                var input = this.input = $( "<input placeholder='Items' >" )
                        .insertAfter( select )
                        .val( value)
                        .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: function( request, response ) {
                                var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                                response( select.children( "option" ).map(function() {
                                    var text = $( this ).text();
                                    if ( this.value && ( !request.term || matcher.test(text) ) )
                                        return {
                                            label: text.replace(
                                                    new RegExp(
                                                            "(?![^&;]+;)(?!<[^<>]*)(" +
                                                            $.ui.autocomplete.escapeRegex(request.term) +
                                                            ")(?![^<>]*>)(?![^&;]+;)", "gi"
                                                    ), "<strong>$1</strong>" ),
                                            value: text,
                                            option: this
                                        };
                                }) );
                            },
                            select: function( event, ui ) {
                                cambio(ui.item.option.value);
                                ui.item.option.selected = true;
                                self._trigger( "selected", event, {
                                    item: ui.item.option
                                });
                            },
                            change: function( event, ui ) {
                                if ( !ui.item ) {
                                    var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
                                            valid = false;
                                    select.children( "option" ).each(function() {
                                        if ( $( this ).text().match( matcher ) ) {
                                            this.selected = valid = true;
                                            return false;
                                        }
                                    });
                                    if ( !valid ) {
                                        // remove invalid value, as it didn't match anything
                                        $( this ).val( "" );
                                        select.val( "" );
                                        input.data( "autocomplete" ).term = "";
                                        return false;
                                    }
                                }
                            }
                        })
                        .addClass( "form-control" );
                input.data( "autocomplete" )._renderItem = function( ul, item ) {
                    return $( "<li></li>" )
                            .data( "item.autocomplete", item )
                            .append( "<a>" + item.label + "</a>" )
                            .appendTo( ul );
                };
               
            },
            destroy: function() {
                this.input.remove();
                this.button.remove();
                this.element.show();
                $.Widget.prototype.destroy.call( this );
            }
        });
    })( jQuery );
    $(function() {
        $( "#items" ).combobox();
    });

</script>