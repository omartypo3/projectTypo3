jQuery(document).ready(function() {
//Implement the cookie message
    $.cookieBar({
        message: "Cookies help us deliver our services. By using our services, you agree to our use of cookies.",
        policyButton: true,
        policyText: "Learn more",
        policyURL: '/cookies-policy/',
        acceptText: 'OK',
        fixed: true,
        zindex: 9999
    });

//Make the cookie bar policy link open page in a new tab
    $("#cookie-bar a.cb-policy").click(function (event) {

        event.preventDefault();

        //Get the href of the link
        var href = $(this).attr('href');

        //open it in a new tab
        window.open(href, '_blank');
    });
});