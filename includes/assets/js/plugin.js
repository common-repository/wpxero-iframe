; (function ($) {
    $(document).ready(function () {
        let iframe = $(document).find('.bdt-iframe > iframe');
        var dataAttributes = iframe.data();
        if(iframe.length) {
            iframe.recliner({
                throttle: dataAttributes.throttle,
                threshold: dataAttributes.threshold,
                live: dataAttributes.live
            });
        }

    });
}(jQuery));