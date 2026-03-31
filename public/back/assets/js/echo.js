$(document).ready(function() {
    Echo.channel('orders').listen('OrderPaid', (event) => {

        toastr.info('سفارش شماره ' + event.order.id + ' با موفقیت ثبت و پرداخت شد', 'سفارش جدید ثبت شد', '', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left', timeOut: 0 });
        var sound = document.getElementById("notification-sound");
        sound.play();
    });

    Echo.channel('contacts').listen('ContactCreated', (event) => {

        toastr.info('تماس جدید از  ' + event.contact.name + ' با موضوع ' + event.contact.subject + ' ثبت شد', '', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left', timeOut: 0 });
        var sound = document.getElementById("notification-sound");
        sound.play();
    });
});