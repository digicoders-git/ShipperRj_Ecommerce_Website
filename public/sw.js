// Service Worker for Web Push Notifications

self.addEventListener('push', function (event) {
    if (!event.data) {
        return;
    }

    let data = {};
    try {
        data = event.data.json();
    } catch (e) {
        data = {
            title: 'Shopping Club India',
            body: event.data.text()
        };
    }

    const title = data.title || 'Shopping Club India';
    const options = {
        body: data.body || '',
        icon: data.icon || '/images/logo-icon.png',
        badge: data.badge || '/images/logo-icon.png',
        image: data.image || null,
        data: {
            url: data.url || '/'
        },
        vibrate: [100, 50, 100],
        requireInteraction: true,
        actions: data.actions || []
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    const targetUrl = (event.notification.data && event.notification.data.url) ? event.notification.data.url : '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (clientList) {
            for (let i = 0; i < clientList.length; i++) {
                let client = clientList[i];
                if (client.url.includes(targetUrl) && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});
