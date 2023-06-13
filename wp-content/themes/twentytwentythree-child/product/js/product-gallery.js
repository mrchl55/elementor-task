// click event
jQuery(function ($) {

$( '.product-upload-button' ).on( 'click', function( event ){ // button click
    // prevent default link click event
    event.preventDefault();

    const button = $(this)
    const hiddenField = button.prev()
    const hiddenFieldValue = hiddenField.val().split( ',' )

    const customUploader = wp.media({
        title: 'Insert images',
        library: {
            type: 'image'
        },
        button: {
            text: 'Use these images'
        },
        multiple: true
    }).on( 'select', function() {
        let selectedImages = customUploader.state().get( 'selection' ).map( item => {
            item.toJSON();
            return item;
        } )

        selectedImages.map( image => {
            $( '.product-gallery' ).append( '<li data-id="' + image.id + '"><span style="background-image:url(' + image.attributes.url + ')"></span><a href="#" class="product-gallery-remove">×</a></li>' );
            hiddenFieldValue.push( image.id )
        } );
        $( '.product-gallery' ).sortable( 'refresh' );
        hiddenField.val( hiddenFieldValue.join() );

    }).open();
});

$( 'body' ).on('click', 'a.product-gallery-remove',  function( event ){

    event.preventDefault();

    const button = $(this)
    const imageId = button.parent().data( 'id' )
    console.log(imageId)
    const container = button.parent().parent()
    const hiddenField = container.next()
    console.log(container.parent())
    console.log(typeof hiddenField.val())
    const hiddenFieldValue = hiddenField.val().split(",").map( Number );
    const i = hiddenFieldValue.indexOf( imageId )

    button.parent().remove();
console.log(imageId, i, hiddenFieldValue)
    // remove certain array element
    if( i != -1 ) {

        hiddenFieldValue.splice(i, 1);
    }

    // add the IDs to the hidden field value
    console.log('before', hiddenField.val())
    hiddenField.val( hiddenFieldValue.join() );
    console.log('after', hiddenField.val())

    // refresh sortable
    container.sortable( 'refresh' );

});

// reordering the images with drag and drop
$( '.product-gallery' ).sortable({
    items: 'li',
    cursor: '-webkit-grabbing', // mouse cursor
    scrollSensitivity: 40,
    /*
    You can set your custom CSS styles while this element is dragging
    start:function(event,ui){
        ui.item.css({'background-color':'grey'});
    },
    */
    stop: function( event, ui ){
        ui.item.removeAttr( 'style' );

        let sort = new Array() // array of image IDs
        const container = $(this) // .product-gallery

        // each time after dragging we resort our array
        container.find( 'li' ).each( function( index ){
            sort.push( $(this).attr( 'data-id' ) );
        });
        // add the array value to the hidden input field
        container.parent().next().val( sort.join() );
        // console.log(sort);
    }
});})