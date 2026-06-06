// JavaScript Document



function notifyMessage(message) {
  if (!("Notification" in window)) {
    console.log("This browser does not support desktop notification");
  }
  else if (Notification.permission === "granted") {
	  
	  	console.log('message zusammenbasteln');
	  
        var options = {
                body: message.body,
                icon: "fileadmin/templateBackend/dsl_icon_gross.png",
                dir : "ltr"
             };
	  	if(message.icon) options.icon = message.icon;
	  
          var notification = new Notification(message.titel,options);
  }
  
}


$(document).ready(function() {
	console.log('notification test init');
	
	if (!("Notification" in window)) {
		console.log("This browser does not support desktop notification");
	  } else if (Notification.permission !== 'denied') {
		Notification.requestPermission(function (permission) {
			console.log('Notification.requestPermission');
		  if (!('permission' in Notification)) {
			Notification.permission = permission;
		  }

		  if (permission === "granted") {

			  console.log('Mitteilungszentrum aktiviert!');

		  }
		});
	  }
	
});

/*

new Notification('titel der benachrichtigung',{ body: 'nachricht', icon: "fileadmin/templateBackend/dsl_icon_gross.png", dir : "ltr"})
*/