import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// ============================================
// PUSHER / ECHO CONFIGURATION
// ============================================
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    // Uncomment below to enable debug logs in console
    // enabledTransports: ['ws', 'wss'],
});



// ============================================
// ADMIN DASHBOARD REAL-TIME POPUP LISTENER
// ============================================

window.Echo.channel('admin-orders')
    .listen('NewOrderPlaced', (e) => {
        console.log("🔔 Real-time order received:", e);

        // 1. CREATE THE POPUP HTML
        // This creates a green Bootstrap Toast notification
        let toastHtml = `
            <div id="liveToast" class="toast align-items-center text-white bg-success border-0 show" 
                 role="alert" aria-live="assertive" aria-atomic="true" 
                 style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong style="font-size: 1.1rem;">🛒 New Order #${e.order_id}</strong><br>
                        <span>Customer: ${e.customer_name}</span><br>
                        <span>Total: $${e.total_amount}</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

        // 2. ADD THE POPUP TO THE SCREEN
        document.body.insertAdjacentHTML('beforeend', toastHtml);

        // 3. AUTO-REMOVE THE POPUP AFTER 10 SECONDS
        // This prevents the page from getting cluttered with old notifications
        setTimeout(() => {
            let toastElement = document.getElementById('liveToast');
            if(toastElement) {
                toastElement.remove(); 
            }
        }, 10000); // 10000 milliseconds = 10 seconds
    });
// Optional: Enable Pusher debug logging (remove in production)
// window.Pusher.logToConsole = true;