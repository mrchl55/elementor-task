// click event
jQuery(function ($) {

$( '.product-upload-button' ).on( 'click', function( event ){ // button click
    // prevent default link click event
    event.preventDefault();

    const button = $(this)
    // we are going to use <input type="hidden"> to store image IDs, comma separated
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
        // get selected images and rearrange the array
        let selectedImages = customUploader.state().get( 'selection' ).map( item => {
            item.toJSON();
            return item;
        } )

        selectedImages.map( image => {
            // add every selected image to the <ul> list
            $( '.product-gallery' ).append( '<li data-id="' + image.id + '"><span style="background-image:url(' + image.attributes.url + ')"></span><a href="#" class="product-gallery-remove">×</a></li>' );
            // and to hidden field
            hiddenFieldValue.push( image.id )
        } );

        // refresh sortable
        $( '.product-gallery' ).sortable( 'refresh' );
        // add the IDs to the hidden field value
        hiddenField.val( hiddenFieldValue.join() );

    }).open();
});

// remove image event
$( 'body' ).on('click', 'a.product-gallery-remove',  function( event ){

    event.preventDefault();

    const button = $(this)
    const imageId = button.parent().data( 'id' )
    console.log(imageId)
    const container = button.parent().parent()
    const hiddenField = container.next()
    console.log(container.parent())
    // const hiddenFieldValue = hiddenField.val().split(",")
    const hiddenFieldValue = ((hiddenField.val().indexOf(',') !== -1)
        ? hiddenField.val().split(',')
        : (hiddenField.val().length > 0)
            ? [hiddenField.val()]
            : []);
    const i = hiddenFieldValue.indexOf( imageId )

    button.parent().remove();

    // remove certain array element
    if( i != -1 ) {
        hiddenFieldValue.splice(i, 1);
    }

    // add the IDs to the hidden field value
    hiddenField.val( hiddenFieldValue.join() );

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