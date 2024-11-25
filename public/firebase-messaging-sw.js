importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging.js');

const firebaseConfig = {
    apiKey: "AIzaSyDN-0TG37jzJWHjdwCjj-4TBvtsiOCFcLE",
    authDomain: "triptok-3e794.firebaseapp.com",
    projectId: "triptok-3e794",
    storageBucket: "triptok-3e794.firebasestorage.app",
    messagingSenderId: "352427271199",
    appId: "1:352427271199:web:78c9e7d286278a0c41212a",
    measurementId: "G-PCMF34QDS3"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
