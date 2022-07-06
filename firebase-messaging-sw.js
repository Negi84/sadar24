/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
  
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/

importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');
   
firebase.initializeApp({
  apiKey: "AIzaSyBAZyM4Qt13J65TuLwW_UuVVvabOm-NulM",
        authDomain: "my-project-1476269173238.firebaseapp.com",
        databaseURL: "https://localhost/eccom/",
        projectId: "my-project-1476269173238",
        storageBucket: "my-project-1476269173238.appspot.com",
        messagingSenderId: "633066582550",
        appId: "1:633066582550:web:532b3b4a095679789abb37",
        measurementId: "G-H1CYV3PL83"
    });
  
 
      
/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };
  
    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});