importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
firebase.initializeApp({
    apiKey: "AIzaSyAaZcwyp2qRfFNX1huIeYeTOb0ZVNgkBq0",
    projectId: "kof-715a6",
    storageBucket: "kof-715a6.appspot.com",
    messagingSenderId: "208143821357",
    appId: "1:208143821357:web:a8306645d22fb5e8f6a6a4",
});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    console.log('1');
    return self.registration.showNotification(title,{body,icon});
});
