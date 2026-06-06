// JavaScript Document



function notifyMe(message) {
  if (!("Notification" in window)) {
    console.log("This browser does not support desktop notification");
  }
  else if (Notification.permission === "granted") {
        var options = {
                body: message.body,
                icon: "fileadmin/templateBackend/dsl_icon_gross.png",
                dir : "ltr"
             };
          var notification = new Notification("DSL factory | Intranet",options);
  }
  else if (Notification.permission !== 'denied') {
    Notification.requestPermission(function (permission) {
      if (!('permission' in Notification)) {
        Notification.permission = permission;
      }
    
      if (permission === "granted") {
        var options = {
              body: message.body,
              icon: "fileadmin/templateBackend/dsl_icon_gross.png",
              dir : "ltr"
          };
        var notification = new Notification("DSL factory | Intranet",options);
      }
    });
  }
}


var dslAutoLogoutCheckTimestampTimeout = false;

function dslAutoLogoutCheckTimestamp(selector){
	
	var diff = Math.ceil(Math.abs((parseInt($(selector).data('last-timestamp'))-($.now()/1000)-parseInt($(selector).data('timestamp-diff')))));
	
	 
	//console.log('differenz aktuell:'+diff);
	
	//test sofort prüfen
	if(diff>120){
		//console.log('prüfung');
		//if(dslAutoLogoutCheckForLoginTimeout) clearTimeout(dslAutoLogoutCheckForLoginTimeout);
		dslAutoLogoutCheckForLogin(selector);
	} else {
		dslAutoLogoutCheckTimestampTimeout = setTimeout(function(){ dslAutoLogoutCheckTimestamp(selector); }, 60000);
	}
	
	
}

function dslAutoLogoutCheckForLogin(selector){
	var jqxhrLoginCheck = $.get( $(selector).data('reload-uri'), function(data) {
		
		
		
		//alert(data);
		if(!data){
		
			
			$('#checkForLoginOverload').show();
			//var message = {'body':'Ihr Login ist verfallen! Bitte loggen Sie sich neu ein.'};
			//notifyMe( message );
		
			window.top.location.replace($('#checkForLogin').data('redirect-uri'));
			
		} else {
			$('#checkForLogin').data('last-timestamp',data);
			$('#checkForLogin').data('timestamp-diff',   (parseInt($('#checkForLogin').data('last-timestamp'))-($.now()/1000)));
			dslAutoLogoutCheckTimestampTimeout = setTimeout(function(){ dslAutoLogoutCheckTimestamp(selector); }, 4000);
		}
//		console.log('last-timestamp:'+$(selector).data('last-timestamp'));
//		console.log('timestamp-diff'+$(selector).data('timestamp-diff'));
		
		/*var message = {'body':'noch eingeloggt'+data};
		notifyMe( message );*/
		//dslAutoLogoutCheckForLoginTimeout = setTimeout(function(){ dslAutoLogoutCheckForLogin(selector); }, 15000);
		
	}).done(function(data) {
	//	console.log( "second success" );
		//console.log(data);
	}).fail(function(event, jqxhr, thrownError) {
		//$('#checkForLoginOverload').show();
		/*
		dslAutoLogoutCheckTimestampTimeout = setTimeout(function(){ 
			$('#checkForLoginOverload').show();
			var message = {'body':'Ihr Login ist verfallen! Sie wurden auf den Login weitergeleitet.'};
			notifyMe( message );
		
			window.top.location.replace($(selector).data('redirect-uri'));
		}, 4000);
		*/
		
		
		//var message = {'body':'Ihr Login ist verfallen! Sie wurden auf den Login weitergeleitet.'};
		//notifyMe( message );
		
		//window.top.location.replace($(selector).data('redirect-uri'));
		
		
	}).always(function() {
		//console.log( "finished" );
	});
}


$(document).ready(function() {
	
	//setdefaultdiffbettween server and browsertime
	$('#checkForLogin').data('timestamp-diff',   (parseInt($('#checkForLogin').data('last-timestamp'))-($.now()/1000)));
	
//	console.log('last-timestamp:'+$('#checkForLogin').data('last-timestamp'));
//	console.log('timestamp-diff'+$('#checkForLogin').data('timestamp-diff'));
	
	dslAutoLogoutCheckTimestamp('#checkForLogin');
	
	//dslAutoLogoutCheckForLoginTimeout = setTimeout(function(){ dslAutoLogoutCheckForLogin('#checkForLogin'); }, 15000);
	
	
	
	
});

