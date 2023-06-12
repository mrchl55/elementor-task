jQuery(function ($) {
    const isValidUrl = urlString => { // some basic URL validation
        try {
            return Boolean(new URL(urlString));
        } catch (e) {
            return false;
        }
    }
    wp.domReady(function () {
        let error = false;
        const urlInputField = $('input[name="yt_video_field"]')
        urlInputField.on('change', function (e) {
            const inputUrl = $(this).val()
            if (!inputUrl) {
                return
            }
            if (!isValidUrl(inputUrl)) {
                error = true
            } else {
                error = false
            }

            if (error === true) {
                $(this).parent().append('<span class="error-message" style="color:red;">This does not seem to be valid URL</span>')
            } else {
                $(this).parent().find($('.error-message')).remove()
            }
        })

    })
})
