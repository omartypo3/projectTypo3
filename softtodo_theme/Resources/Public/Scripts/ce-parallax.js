$(function(){var a=$(".ce-parallax"),i=a.offset().top;$(window).scroll(function(){$(window).scrollTop()+$(window).height()/2>=i&&function(a){!a.hasClass("animate")&&a.addClass("animate")}(a)}),a.find(".bubbles > div").matchHeight()});