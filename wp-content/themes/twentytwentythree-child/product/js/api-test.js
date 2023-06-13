jQuery(function ($) {
    $(document).ready(function () {
const listProducts = async () => {
    console.log(`${window.location.href}wp-json/products/list`)
    const response = await fetch(`${window.location.href}wp-json/products/list`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
        cat_id:3,
        }),
    });
    const responseBody = await response.json();
    console.log( responseBody)
}

listProducts()
    })
})
