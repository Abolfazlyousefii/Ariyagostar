$(document).ready(function () {
    /*=========+===================
      Information Tab Js Codes
    ===============================*/

    $('#tags').tagsInput({
        defaultText: 'افزودن',
        width: '100%'
    });

    $('#product-default-tags').tagsInput({
        defaultText: 'افزودن',
        width: '100%'
    });

    // validate form with jquery validation plugin
    jQuery('#information-form').validate({
        rules: {
            info_site_title: {
                required: true
            }
        },
        messages: {
            info_site_title: {
                required: 'لطفا عنوان وبسایت را وارد کنید'
            }
        }
    });

    $('#information-form').submit(function (e) {
        e.preventDefault();

        if ($(this).valid()) {
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function (data) {
                    Swal.fire({
                        type: 'success',
                        title: 'تغییرات با موفقیت ذخیره شد',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'باشه',
                        buttonsStyling: false
                    });

                    if (data.admin_route_prefix_changed) {
                        if (data.admin_route_prefix) {
                            window.location.href =
                                FRONT_URL +
                                '/admin/' +
                                data.admin_route_prefix +
                                '/settings/information';
                        } else {
                            window.location.href =
                                FRONT_URL + '/admin/settings/information';
                        }
                    }
                },
                beforeSend: function (xhr) {
                    block('#main-card');
                    xhr.setRequestHeader(
                        'X-CSRF-TOKEN',
                        $('meta[name="csrf-token"]').attr('content')
                    );
                },
                complete: function () {
                    unblock('#main-card');
                },

                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
});

$(document).ready(function () {
    //---------------------- google map js codes
    if (typeof google !== 'undefined') {
        var myLatlng = new google.maps.LatLng(info_latitude, info_Longitude);
    }
    var map;
    var gmarkers = [];

    function initialize() {
        var mapOptions = {
            zoom: 16,
            center: myLatlng,
            scrollwheel: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(
            document.getElementById('googleMap'),
            mapOptions
        );

        google.maps.event.addListener(map, 'click', function (event) {
            addMapMarkers(event.latLng.lat(), event.latLng.lng());
        });

        addMapMarkers(info_latitude, info_Longitude);
    }

    function removeMarkers() {
        for (i = 0; i < gmarkers.length; i++) {
            gmarkers[i].setMap(null);
        }
    }
    if (typeof google !== 'undefined')
        google.maps.event.addDomListener(window, 'load', initialize);

    //---------------------- map.ir js codes
    var mapIr = new Mapp({
        element: '#mapIr',
        presets: {
            latlng: {
                lat: info_latitude,
                lng: info_Longitude
            },
            zoom: 16
        },
        apiKey: mapIrApiKey
    });

    mapIr.addLayers();

    mapIr.map.on('click', function (e) {
        addMapMarkers(e.latlng.lat, e.latlng.lng);
    });

    function addMapMarkers(latitude, Longitude) {
        //------ google map
        removeMarkers();
        var googlemarker = new google.maps.Marker({
            position: new google.maps.LatLng(latitude, Longitude),
            map: map
        });

        gmarkers.push(googlemarker);

        //-------- map.ir
        var mapirmarker = mapIr.addMarker({
            name: 'advanced-marker',
            latlng: {
                lat: latitude,
                lng: Longitude
            },
            icon: mapIr.icons.red,
            popup: false,
            pan: false,
            draggable: false,
            history: false
        });

        //------ change inputs
        $('#Longitude').val(Longitude);
        $('#latitude').val(latitude);
    }

    // add markers to both maps
    addMapMarkers(info_latitude, info_Longitude);

    $('#Longitude, #latitude').on('change', function () {
        if (!$('#Longitude').val() || !$('#latitude').val()) {
            return;
        }

        addMapMarkers($('#latitude').val(), $('#Longitude').val());
    });

    $('.info_map_type').on('change', function () {
        $('.map').hide();

        var checked = $('input[name=info_map_type]:checked').val();

        if (checked == 'google') {
            $('#googleMap').show();
        } else if (checked == 'mapir') {
            $('#mapIr').show();
        }
    });

    $('.info_map_type').trigger('change');
});
