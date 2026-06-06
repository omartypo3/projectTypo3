!function(o){
    o.fn.YouTubePopUp = function(e){
        var u = o.extend({autoplay:1}, e);
        
        o(this).on("click", function(e){
            var a = o(this).attr("href");
            var c, isLocalVideo = false;
            
            // Handle YouTube
            if(a.match(/(youtube\.com)/)) {
                var p = "v=", t = 1;
                var i = a.split(p)[t].replace(/(&)+(.*)/,"");
                c = "https://www.youtube.com/embed/"+i+"?autoplay="+u.autoplay;
            } 
            // Handle youtu.be
            else if(a.match(/(youtu\.be)/)) {
                var p = "/", t = 3;
                var i = a.split(p)[t].replace(/(&)+(.*)/,"");
                c = "https://www.youtube.com/embed/"+i+"?autoplay="+u.autoplay;
            } 
            // Handle Vimeo
            else if(a.match(/(vimeo\.com\/)+[0-9]/)) {
                var p = "/", t = 3;
                var i = a.split(p)[t].replace(/(&)+(.*)/,"");
                c = "https://player.vimeo.com/video/"+i+"?autoplay="+u.autoplay;
            }
            // Handle local videos (fileadmin)
            else if(a.match(/fileadmin\//)) {
                isLocalVideo = true;
                c = a; // Use the direct file path
            }
            
            // Create popup content
            var popupContent = '';
            if(isLocalVideo) {
                popupContent = '<video controls autoplay style="width:100%;position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);">' +
                               '<source src="'+c+'" type="video/'+getFileExtension(c)+'">' +
                               'Your browser does not support the video tag.</video>';
            } else {
                popupContent = '<iframe src="'+c+'" allowfullscreen></iframe>';
            }
            
            // Create and show popup
            o("body").append(
                '<div class="YouTubePopUp-Wrap YouTubePopUp-animation">' +
                '<div class="YouTubePopUp-Content">' +
                '<span class="YouTubePopUp-Close"></span>' +
                popupContent +
                '</div></div>'
            );
            
            // Animation handling
            if(o(".YouTubePopUp-Wrap").hasClass("YouTubePopUp-animation")) {
                setTimeout(function(){
                    o(".YouTubePopUp-Wrap").removeClass("YouTubePopUp-animation");
                }, 600);
            }
            
            // Close handlers
            o(".YouTubePopUp-Wrap, .YouTubePopUp-Close").click(function(){
                o(".YouTubePopUp-Wrap").addClass("YouTubePopUp-Hide")
                    .delay(515)
                    .queue(function(){ o(this).remove(); });
            });
            
            e.preventDefault();
        });
        
        // ESC key handler
        o(document).keyup(function(e){
            if(27 == e.keyCode) {
                o(".YouTubePopUp-Wrap, .YouTubePopUp-Close").click();
            }
        });
        
        // Helper function to get file extension
        function getFileExtension(filename) {
            return filename.split('.').pop().split(/\#|\?/)[0];
        }
    };
}(jQuery);