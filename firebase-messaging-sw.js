importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
firebase.initializeApp({
    apiKey: "AIzaSyC5oSthGSNaMR7mJcEjsr-eDDs6_tSks3w",
    projectId: "khareedo-farokht-buyer",
    storageBucket: "khareedo-farokht-buyer.appspot.com",
    messagingSenderId: "293469813726",
    appId: "1:293469813726:web:c980e56d099b12de26bb4f",
});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    alert('New message');
    return self.registration.showNotification(title,{body,icon});
});
