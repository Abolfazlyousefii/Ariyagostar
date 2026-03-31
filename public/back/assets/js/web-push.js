var loading = false,
    isPushEnabled = false,
    pushButtonDisabled = true;

/**
 * Register the service worker.
 */
function registerServiceWorker() {
    if (!('serviceWorker' in navigator)) {
        console.log('Service workers aren\'t supported in this browser.')
        return false;
    }

    navigator.serviceWorker.register('/sw.js?v=' + Date.now())
        .then(() => initialiseServiceWorker());

    return true;
}

function initialiseServiceWorker() {
    if (!('showNotification' in ServiceWorkerRegistration.prototype)) {
        console.log('Notifications aren\'t supported.')
        return
    }

    if (Notification.permission === 'denied') {
        console.log('The user has blocked notifications.')
        return
    }

    if (!('PushManager' in window)) {
        console.log('Push messaging isn\'t supported.')
        return
    }

    navigator.serviceWorker.ready.then(registration => {
        registration.pushManager.getSubscription()
            .then(subscription => {
                pushButtonDisabled = false

                if (!subscription) {
                    return
                }

                updateSubscription(subscription)

                isPushEnabled = true
            })
            .catch(e => {
                console.log('Error during getSubscription()', e)
            })
    })
}

/**
 * Subscribe for push notifications.
 */
function subscribe() {
    if (!registerServiceWorker()) {
        return;
    }

    navigator.serviceWorker.ready.then(registration => {
        const options = { userVisibleOnly: true }
        const vapidPublicKey = window.Laravel.vapidPublicKey

        if (vapidPublicKey) {
            options.applicationServerKey = urlBase64ToUint8Array(vapidPublicKey)
        }

        registration.pushManager.subscribe(options)
            .then(subscription => {
                isPushEnabled = true
                pushButtonDisabled = false

                updateSubscription(subscription)
            })
            .catch(e => {
                if (Notification.permission === 'denied') {
                    console.log('Permission for Notifications was denied')
                    pushButtonDisabled = true
                } else {
                    console.log('Unable to subscribe to push.', e)
                    pushButtonDisabled = false
                }
            })
    })
}

/**
 * Unsubscribe from push notifications.
 */
function unsubscribe() {
    if (!registerServiceWorker()) {
        return;
    }

    navigator.serviceWorker.getRegistrations().then(function(registrations) {
        for (let registration of registrations) {
            registration.unregister()
        }
    });

    navigator.serviceWorker.ready.then(registration => {
        registration.pushManager.getSubscription().then(subscription => {
            if (!subscription) {
                isPushEnabled = false
                pushButtonDisabled = false
                return
            }

            subscription.unsubscribe().then(() => {
                deleteSubscription(subscription)

                isPushEnabled = false
                pushButtonDisabled = false
            }).catch(e => {
                console.log('Unsubscription error: ', e)
                pushButtonDisabled = false
            })
        }).catch(e => {
            console.log('Error thrown while unsubscribing.', e)
        })
    })
}

/**
 * Send a request to the server to update user's subscription.
 *
 * @param {PushSubscription} subscription
 */
function updateSubscription(subscription) {
    const key = subscription.getKey('p256dh')
    const token = subscription.getKey('auth')
    const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0]

    const data = {
        endpoint: subscription.endpoint,
        publicKey: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
        authToken: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null,
        contentEncoding
    }

    loading = true

    axios.post('/subscriptions', data)
        .then(() => { loading = false })
}

/**
 * Send a requst to the server to delete user's subscription.
 *
 * @param {PushSubscription} subscription
 */
function deleteSubscription(subscription) {
    loading = true

    axios.post('/subscriptions/delete', { endpoint: subscription.endpoint })
        .then(() => { loading = false })
}

/**
 * https://github.com/Minishlink/physbook/blob/02a0d5d7ca0d5d2cc6d308a3a9b81244c63b3f14/app/Resources/public/js/app.js#L177
 *
 * @param  {String} base64String
 * @return {Uint8Array}
 */
function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4)
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/')

    const rawData = window.atob(base64)
    const outputArray = new Uint8Array(rawData.length)

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i)
    }

    return outputArray
}

registerServiceWorker();