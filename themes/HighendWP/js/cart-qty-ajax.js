jQuery( function( $ ) {

    $( document ).on( 'change', 'input.qty', function() {

        var item_hash = $( this ).attr( 'name' ).replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
        var item_quantity = $( this ).val();
        var currentVal = parseFloat(item_quantity);

        function qty_cart() {

            $.ajax({
                type: 'POST',
                url: cart_qty_ajax.ajax_url,
                data: {
                    action: 'qty_cart',
                    hash: item_hash,
                    quantity: currentVal
                },
                success: function(data) {
                    $( '.col-12, .hb-main-content' ).html(data);
                }
            });  

        }

        qty_cart();

    });

});