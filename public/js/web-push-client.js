/**
 * Web Push Notification Client Manager
 */

(function (window) {
    'use strict';

    const WebPushManager = {
        swRegistration: null,
        isSubscribed: false,
        vapidPublicKey: null,
        hasPrompted: false,

        urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        },

        async init() {
            if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
                console.warn('[WebPush] Push messaging is not supported in this browser.');
                return false;
            }

            try {
                // Register Service Worker
                this.swRegistration = await navigator.serviceWorker.register('/sw.js');
                console.log('[WebPush] Service Worker Registered successfully.');

                // Fetch VAPID Public Key
                const response = await fetch('/push-public-key');
                const data = await response.json();

                if (data.success && data.public_key) {
                    this.vapidPublicKey = data.public_key;
                    await this.checkSubscription();
                } else {
                    console.warn('[WebPush] VAPID Public Key not available.');
                }
            } catch (error) {
                console.error('[WebPush Init Error]', error);
            }
        },

        async checkSubscription() {
            if (!this.swRegistration) return;
            const subscription = await this.swRegistration.pushManager.getSubscription();
            this.isSubscribed = !(subscription === null);

            // Auto-subscribe silently if browser permission is already granted but endpoint not saved
            if (!this.isSubscribed && Notification.permission === 'granted') {
                await this.subscribeSilently();
            }

            // Show floating UI prompt banner if permission is 'default'
            if (!this.isSubscribed && Notification.permission === 'default' && !this.hasPrompted) {
                this.showPromptBanner();
            }

            // Dispatch custom event for UI updates
            window.dispatchEvent(new CustomEvent('webpush:status', {
                detail: { isSubscribed: this.isSubscribed, permission: Notification.permission }
            }));
        },

        showPromptBanner() {
            if (document.getElementById('webpush-prompt-banner')) return;
            if (Notification.permission !== 'default') return;

            this.hasPrompted = true;

            const style = document.createElement('style');
            style.id = 'webpush-banner-styles';
            style.innerHTML = `
                @keyframes webPushSlideUp {
                    from { transform: translateY(100px); opacity: 0; }
                    to { transform: translateY(0); opacity: 1; }
                }
                .webpush-banner-btn-allow {
                    background: linear-gradient(135deg, #f59e0b, #d97706) !important;
                    color: #ffffff !important;
                    border: none !important;
                    padding: 8px 18px !important;
                    border-radius: 20px !important;
                    font-weight: 600 !important;
                    font-size: 13px !important;
                    cursor: pointer !important;
                    transition: all 0.2s ease !important;
                    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3) !important;
                }
                .webpush-banner-btn-allow:hover {
                    transform: translateY(-1px) !important;
                    box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4) !important;
                }
                .webpush-banner-btn-close {
                    background: transparent !important;
                    color: rgba(255, 255, 255, 0.6) !important;
                    border: none !important;
                    font-size: 18px !important;
                    cursor: pointer !important;
                    padding: 0 4px !important;
                    line-height: 1 !important;
                }
                .webpush-banner-btn-close:hover {
                    color: #ffffff !important;
                }
            `;
            document.head.appendChild(style);

            const banner = document.createElement('div');
            banner.id = 'webpush-prompt-banner';
            banner.style.cssText = `
                position: fixed;
                bottom: 24px;
                right: 24px;
                z-index: 999999;
                max-width: 380px;
                width: calc(100% - 48px);
                background: linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(30, 41, 59, 0.96));
                color: #ffffff;
                padding: 18px 20px;
                border-radius: 18px;
                border: 1px solid rgba(255, 255, 255, 0.15);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 20px rgba(245, 158, 11, 0.25);
                backdrop-filter: blur(12px);
                font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                animation: webPushSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            `;

            banner.innerHTML = `
                <div style="display: flex; align-items: flex-start; gap: 14px;">
                    <div style="background: rgba(245, 158, 11, 0.18); color: #f59e0b; padding: 10px; border-radius: 14px; font-size: 22px; line-height: 1; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-bell-fill text-warning"></i>
                    </div>
                    <div style="flex: 1;">
                        <h6 style="margin: 0 0 4px 0; font-size: 15px; font-weight: 700; color: #ffffff;">Enable Push Notifications</h6>
                        <p style="margin: 0 0 14px 0; font-size: 12px; color: rgba(255, 255, 255, 0.75); line-height: 1.45;">
                            Get instant updates for your orders, exclusive discount offers & status alerts!
                        </p>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <button id="webpush-allow-now-btn" class="webpush-banner-btn-allow">Allow Notifications</button>
                            <button id="webpush-later-btn" style="background: transparent; color: rgba(255,255,255,0.7); border: none; font-size: 12px; cursor: pointer; text-decoration: none;">Later</button>
                        </div>
                    </div>
                    <button id="webpush-close-x-btn" class="webpush-banner-btn-close">&times;</button>
                </div>
            `;

            document.body.appendChild(banner);

            const removeBanner = () => {
                banner.style.opacity = '0';
                banner.style.transform = 'translateY(20px)';
                banner.style.transition = 'all 0.3s ease';
                setTimeout(() => banner.remove(), 300);
            };

            document.getElementById('webpush-allow-now-btn').addEventListener('click', async () => {
                removeBanner();
                await WebPushManager.subscribe();
            });

            document.getElementById('webpush-later-btn').addEventListener('click', removeBanner);
            document.getElementById('webpush-close-x-btn').addEventListener('click', removeBanner);
        },

        async subscribeSilently() {
            if (!this.vapidPublicKey || !this.swRegistration) return false;
            try {
                const applicationServerKey = this.urlBase64ToUint8Array(this.vapidPublicKey);
                const subscription = await this.swRegistration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: applicationServerKey
                });

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                await fetch('/push-subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: JSON.stringify(subscription)
                });
                this.isSubscribed = true;
                return true;
            } catch (err) {
                console.error('[WebPush Silent Subscribe Failed]', err);
            }
            return false;
        },

        async subscribe() {
            if (!this.vapidPublicKey || !this.swRegistration) {
                console.error('[WebPush] Service worker or VAPID key not initialized.');
                return false;
            }

            try {
                const permission = await Notification.requestPermission();
                console.log('[WebPush] User Permission Response:', permission);

                if (permission === 'denied') {
                    if (typeof Swal === 'function') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Notifications Blocked',
                            text: 'Notifications are blocked in your browser settings. Click the lock icon (🔒) in your address bar and set Notifications to "Allow".',
                            confirmButtonColor: '#f59e0b'
                        });
                    } else {
                        alert('Notifications are blocked in your browser settings. Click the lock icon (🔒) next to the URL bar to allow.');
                    }
                    return false;
                }

                if (permission !== 'granted') {
                    console.warn('[WebPush] Permission not granted by user.');
                    return false;
                }

                const applicationServerKey = this.urlBase64ToUint8Array(this.vapidPublicKey);
                const subscription = await this.swRegistration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: applicationServerKey
                });

                // Send Subscription payload to backend
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch('/push-subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: JSON.stringify(subscription)
                });

                const data = await res.json();
                if (data.success) {
                    this.isSubscribed = true;
                    console.log('[WebPush] Subscribed & Saved on server!');
                    if (typeof showToast === 'function') {
                        showToast('Notifications Enabled', 'You will now receive instant order & offer updates!', 'success');
                    } else if (typeof Swal === 'function') {
                        Swal.fire('Notifications Enabled!', 'You will now receive instant order & offer updates.', 'success');
                    }
                    this.checkSubscription();
                    return true;
                }
            } catch (err) {
                console.error('[WebPush Subscribe Failed]', err);
            }
            return false;
        },

        async unsubscribe() {
            if (!this.swRegistration) return false;
            try {
                const subscription = await this.swRegistration.pushManager.getSubscription();
                if (subscription) {
                    const endpoint = subscription.endpoint;
                    await subscription.unsubscribe();

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    await fetch('/push-unsubscribe', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken || ''
                        },
                        body: JSON.stringify({ endpoint: endpoint })
                    });
                }
                this.isSubscribed = false;
                this.checkSubscription();
                if (typeof showToast === 'function') {
                    showToast('Notifications Disabled', 'You have unsubscribed from web push notifications.', 'info');
                }
                return true;
            } catch (err) {
                console.error('[WebPush Unsubscribe Error]', err);
            }
            return false;
        }
    };

    window.WebPushManager = WebPushManager;

    document.addEventListener('DOMContentLoaded', () => {
        WebPushManager.init();
    });

})(window);
