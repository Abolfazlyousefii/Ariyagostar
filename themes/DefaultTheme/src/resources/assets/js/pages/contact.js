$(document).ready(function () {
    'use strict';

    if (info_map_type == 'google') {
        if (typeof google !== 'undefined') {
            var text = info_site_title;
            var myLatlng = new google.maps.LatLng(
                info_latitude,
                info_Longitude
            );
        }

        function initialize() {
            var mapProp = {
                center: myLatlng,
                zoom: 16,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(
                document.getElementById('map'),
                mapProp
            );

            var marker = new google.maps.Marker({
                position: myLatlng
            });

            var infowindow = new google.maps.InfoWindow({
                content: text
            });

            infowindow.open(map, marker);

            marker.setMap(map);
        }

        if ($('#map').length > 0 && typeof google !== 'undefined') {
            google.maps.event.addDomListener(window, 'load', initialize);
        }
    } else {
        var app = new Mapp({
            element: '#map',
            presets: {
                latlng: {
                    lat: info_latitude,
                    lng: info_Longitude
                },
                zoom: 16
            },
            apiKey: mapIrApiKey
        });
        app.addLayers();

        var marker = app.addMarker({
            name: 'marker',
            latlng: {
                lat: info_latitude,
                lng: info_Longitude
            },
            icon: app.icons.red,
            popup: false,
            pan: true
        });

        var popup = app.generatePopupHtml({
            title: {
                i18n: info_site_title
            },
            class: 'custom-css-class'
        });

        marker.bindPopup(popup);
    }
});

jQuery('#contact-form').validate({
    rules: {
        name: {
            required: true
        },
        mobile: {
            required: true
        },
        subject: {
            required: true
        },
        message: {
            required: true
        }
    }
});

$('#contact-form').submit(function (e) {
    e.preventDefault();

    if ($(this).valid()) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                Swal.fire({
                    text: 'پیام شما با موفقیت ارسال شد. با تشکر',
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'باشه'
                });

                reloadCaptcha();

                $('#contact-form').trigger('reset');
            },

            beforeSend: function (xhr) {
                block('.form-ui');
                xhr.setRequestHeader(
                    'X-CSRF-TOKEN',
                    $('meta[name="csrf-token"]').attr('content')
                );
            },
            complete: function () {
                unblock('.form-ui');
            },

            cache: false,
            contentType: false,
            processData: false
        });
    }
});
