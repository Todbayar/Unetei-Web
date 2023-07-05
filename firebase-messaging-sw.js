importScripts('https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.1.1/firebase-messaging.js');

const firebaseConfig = {
	apiKey: "AIzaSyAJxCfAZKgG4vy_nd6UVX3UKhZAF0iyKl4",
	authDomain: "unetei-bc717.firebaseapp.com",
	projectId: "unetei-bc717",
	storageBucket: "unetei-bc717.appspot.com",
	messagingSenderId: "834168591977",
	appId: "1:834168591977:web:ee2f1d66da1dcd0e33b4f8",
	measurementId: "G-Q1YLJDB3KC"
};
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
	console.log('<notification>:[firebase-messaging-sw.js] Received background message ', payload);
	const notificationTitle = payload.notification.title;
	const notificationOptions = {
		body: payload.notification.body,
	};
	return self.registration.showNotification(notificationTitle, notificationOptions);
});

self.addEventListener('notificationclick', event => {
   console.log(event)
});