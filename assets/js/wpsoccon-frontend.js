function checkOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;

    //Check mobile device is Android
    if (/android/i.test(userAgent)) {
        return "phone";
    }

    //Check mobile device is IOS
    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        return "phone";
    }

    //Check device os is Windows (For Laptop and PC)
    if (navigator.appVersion.indexOf("Win") != -1) {
        return "pc";
    }

    //Check device os is MAC (For Laptop and PC)
    if (navigator.appVersion.indexOf("Mac") != -1) {
        return "pc";
    }
}
jQuery(function($) {

    jQuery('.wpsoccon-toggle').on('click', (e) => {
        e.preventDefault()
        $('#wpsoccon').slideToggle()
        e.stopPropagation()
    })

    jQuery('.wpsoccon-close').on('click', (e) => {
        e.preventDefault()
        $('#wpsoccon').removeClass('wpsoccon-show')
    })

    if ("pc" === checkOperatingSystem()) {
        jQuery('.wpsoccon-account').each(function() {
            var phone = $(this).data("phone")
            var newHref = 'https://web.whatsapp.com/send?phone=' + phone;
            $(this).attr('href', newHref)
        })
    } else {
        jQuery('.wpsoccon-account').each(function() {
            var phone = $(this).data("phone")
            var newHref = 'https://api.whatsapp.com/send?phone=' + phone;
            $(this).attr('href', newHref)
        })
    }
})

jQuery(document).click(function() {
    jQuery("#wpsoccon").hide();
});