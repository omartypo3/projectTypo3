jQuery(document).ready(function($){


/*===================================*/
/*==============FONCTIONS===================*/
/*===================================*/


var ie11EstVraimentToutPourri = navigator.appName === 'Microsoft Internet Explorer' ||  !!(navigator.userAgent.match(/Trident/) || navigator.userAgent.match(/rv:11/)) || (typeof $.browser !== "undefined" && $.browser.msie === 1) ? true : false;

/*================*/
    /*hack Internet explorer */
    /*img-container  /  featured-image*/
/*================*/


var userAgent, ieReg, ie;
userAgent = window.navigator.userAgent;
ieReg = /msie|Trident.*rv[ :]*11\./gi;
ie = ieReg.test(userAgent);

if(ie) {
    $("body").addClass("ie");
}

if (document.documentMode || /Edge/.test(navigator.userAgent)) {
    $("body").addClass("ie_edge");

  $(".img-container").each(function () {
    var $container = $(this),
        imgUrl = $container.find("img").prop("src");
    if (imgUrl) {
      $container.css("backgroundImage", 'url(' + imgUrl + ')').addClass("custom-object-fit");
    }
  });


    if($('#part9 ').length >0 ){
        $("#content #block_content #part5 #part9 #block_info .case_info .swiper-container_salle .swiper-slide").css("background-size","cover");
    }
}

/*================*/
    /*hack Firefox*/
/*================*/

if (navigator.userAgent.search("Firefox") >= 0) {

$('body').addClass('firefox');

}


/*==================*/
/*apparition scroll*/
/*==================*/
/*
**ARGUMENTS
maclass = l'élement auquel la nouvelle class sera ajouté ou non.
newclass = Nom de la nouvelle class
whenadd = ajout de la nouvelle class avant ou apres l'apparition de l'élément sur la fenêtre.
*/
function anim_scroll_content(maclass,newclass,whenadd) {
	Maclass = maclass;
	Maclass = $('.'+Maclass);
	NewClass = newclass;
	whenAdd = whenadd;


	Maclass.each(function() {
		if(!ie11EstVraimentToutPourri){
		WindowsSizeH = $(window).height();
		windowScroll = $(window).scrollTop();
		objetScroll = $(this).offset().top;
		inScreen = objetScroll - WindowsSizeH + whenAdd;
	}

	// Ajout ou suppression de la class en fonction du scroll

if(!ie11EstVraimentToutPourri){
	if( windowScroll > inScreen )
		{
	        $(this).addClass(NewClass);
	    }
		else
		{
	        $(this).removeClass(NewClass);
	    }
}else{
	 $(this).addClass(NewClass);
}
	});
}// fin de la fonction anim_scroll_content


/*===================================*/
/*============== FIN FONCTIONS===================*/
/*===================================*/




//===================
//==========Menu Sidebar==========//
//===================

// si la sidebar existe => le menu section
if($('.frame-type-menu_section').length >0 ){


	//===================
	//Menu Sidebar (au clic)
	//===================

    $('.content_left ul li').on('click', function() {

        target_scroll = $(this).find('a').attr('target_scroll');
        nbr=target_scroll.indexOf("#");
        cible=target_scroll.substr(nbr);

        WindowsH = $(window).height();
        offset = $(cible).offset().top;
        next = offset - 150;

        speed = 900; // Durée de l'animation (en ms)
        $('html, body').animate({ scrollTop: next}, speed, 'swing' ); // Go
        return false;
    });


	//===================
	//Menu Sidebar (remplissage)
	//===================

	function progress_scroll_page() {
		windowScroll = $(window).scrollTop();

		$('.content_left ul li').each(function() {

		 	target_scroll = $(this).find('a').attr('target_scroll');
			nbr=target_scroll.indexOf("#");
			cible=target_scroll.substr(nbr);
			//alert(cible);

			//distance entre le haut de l'element et le haut de la page.
			offset = $(cible).offset().top;
			//hauteur de l'élement
			elementH = $(cible).height();
			//distance entre le bas de l'element et le haut de la page.
			bootom_distance = offset + elementH;

			progress_page = $(this).find('.progress_page');

			// la barre de progession commenssera à Xpx du haut de l'écran.
			distance_lecture = 100;

			progress_scroll = windowScroll-offset+distance_lecture;

			ratio_progress= progress_scroll/elementH*100;

			if(ratio_progress > 100){
				ratio_progress=100;
				$(this).removeClass('en_lecture');
			}
			else if(ratio_progress < 0){
				ratio_progress=0;
				$(this).removeClass('en_lecture');
			}
			else{
				$(this).addClass('en_lecture');
			}

			progress_pourcent= 100 - ratio_progress;

			progress_page.css( "width", progress_pourcent+"%" );

			footerTop = $("footer").offset().top;
			footerH = $("footer").height();
			WindowsSizeH = $(window).height();
			limiteAllProgress = windowScroll + WindowsSizeH;
			limiteAllProgressBottom = footerTop + footerH - 300;


			if( limiteAllProgress > limiteAllProgressBottom )
	        {
	            progress_page.css( "width", 0+"%" );

	        }

		});
	}


	progress_scroll_page();

	$(window).resize(function(){
	    progress_scroll_page();
	});

	$(window).scroll(function(event){
		progress_scroll_page();

		$(window).resize(function(){
		    progress_scroll_page();
		});
	});



	//===================
	//Menu Sidebar (fixed)
	//===================



	//affichage au scroll

	function fixe_sidebar() {
	    // Stockage des références des différents éléments dans des variables
	    part1= $('#part1');
	    sidebar= $('.content_left .block_content_left');

	    limiteTop_salle = sidebar.offset().top - 130;

	    // On déclenche un événement scroll pour mettre à jour le positionnement au chargement de la page
	    $(window).trigger('scroll');


	    $(window).scroll(function(event){
	        // Valeur de défilement lors du chargement de la page
	        windowScroll = $(window).scrollTop();

	        // Mise à jour du positionnement en fonction du scroll
	        if( windowScroll >= limiteTop_salle )
	        {
	            sidebar.addClass('fixe_sidebar');
	        }
	        else
	        {
	            sidebar.removeClass('fixe_sidebar');
	        }
	    });
	}






	    fixe_sidebar();

	    //ajustement si modif de la taille de l'ecran
	    $(window).resize(function(){
	      fixe_sidebar();
	    });






	//===================
	//Menu Sidebar (fix Bottom)
	//===================



	//hauteur de l'élement
	sidebarH = $('.block_content_left').height();
	sidebarH = sidebarH + 0; //50
	//distance top de la sidebar
	distanceSidebar = 0; //0
	////distance bottom de la sidebar
	bottomSidebar = distanceSidebar + sidebarH;
	//hauteur de l'ecran
	WindowsSizeH = $(window).height();
	//distance top du footer
	//distance entre le bas de la sidebare et le bas de lécran

	//difFix=WindowsSizeH-(sidebarH+distanceSidebar)-20;

	 // On déclenche un événement scroll pour mettre à jour le positionnement au chargement de la page
    $(window).trigger('scroll');


    $(window).scroll(function(event){

    		distanceFooter = $('#mainContent').height();
	//Moment déclancheur
	declanche = distanceFooter-0; //50

        // Valeur de défilement (haut de l'ecran) lors du chargement de la page
        windowScroll = $(window).scrollTop();
        // valleur du défillement du bas de la page
       	//////windowScrollBottom = windowScroll+WindowsSizeH;
       	sidebarH = $('.block_content_left').height();
       	limiteBottomside = windowScroll+sidebarH;

        // Mise à jour du positionnement en fonction du scroll
        if(limiteBottomside > declanche)
        {
            $('.block_content_left').addClass('fix_bottom');
            //$( '.fix_bottom.fixe_sidebar' ).css( "margin-bottom", difFix + "px" );
        }
        else
        {
            $('.block_content_left').removeClass('fix_bottom');
        }
    });



	//===================
	//Menu Sidebar (titre anim)
	//===================



    // Stockage des références des différents éléments dans des variables
    titre_anim= $('.case_title_anim');

    topTitre_anim = sidebar.offset().top -80;

    // On déclenche un événement scroll pour mettre à jour le positionnement au chargement de la page
    $(window).trigger('scroll');


    $(window).scroll(function(event){
        // Valeur de défilement lors du chargement de la page
        windowScroll = $(window).scrollTop();

        // Mise à jour du positionnement en fonction du scroll
        if( windowScroll >= topTitre_anim )
        {
            titre_anim.addClass('anim_active');
            $('.titre_page_menu_gauche').addClass('anim_active');

        }
        else
        {
            titre_anim.removeClass('anim_active');
            $('.titre_page_menu_gauche').removeClass('anim_active');
        }
    });





    //scroll bar
    height_screen = parseInt($(window).height());
    height_sidebar = height_screen - 290 + "px";
    if($(window).width() > 990){
    	$('.block_content_left ul').css("max-height", height_sidebar);
    }


	$(window).resize(function(){
	  	height_screen = parseInt($(window).height());
	    height_sidebar = height_screen - 290 + "px";
    if($(window).width() > 990){
    	$('.block_content_left ul').css("max-height", height_sidebar);
    }
	});







	/*==================*/
	/*apparition scroll*/
	/*==================*/

	/*--------*/
	/*Appel de la fonction anim_scroll_content*/
	/*--------*/
	the_whenadd= $(window).height()-80;



	anim_scroll_content('icon_title_anim','anim_active',the_whenadd);

	//ajustement si modif du scroll
	$(window).scroll(function(event){
		anim_scroll_content('icon_title_anim','anim_active',the_whenadd);
	});

	//ajustement si modif de la taille de l'ecran
	$(window).resize(function(){
	  anim_scroll_content('icon_title_anim','anim_active',the_whenadd);
	});
	/*--------*/
	/*FIN de l'appel de la fonction*/
	/*--------*/




//Fin sidebar
}
//Fin sidebar





//===================
//==========social share sidebar==========//
//===================
if($('.icon-Share_in_sidebar').length >0 ){

	$('.icon-Share_in_sidebar').on('click', function() {
		$('#share_sidebar').toggleClass('active');
		windowScroll_negatif = $(window).scrollTop()-200;
		windowScroll_positif = $(window).scrollTop()+200;

		$(window).scroll(function(event){
			windowScroll = $(window).scrollTop();
			if(windowScroll<windowScroll_negatif) {
				$('#share_sidebar').removeClass('active');
			}

			if(windowScroll>windowScroll_positif) {
				$('#share_sidebar').removeClass('active');
			}

		});
	});
}



$("#share_sidebar a").hover(function() { // Mouse over
  $(this).siblings('a').find('i').css('color', 'rgba(255,255,255,0.2)');

}, function() { // Mouse out
	$(this).siblings('a').find('i').css('color', 'rgba(255,255,255,1)');
});




$("#social_share_sidebar .icon_sidebar").hover(function() { // Mouse over
  $(this).siblings('a').find('i').css('opacity', '0.2');

}, function() { // Mouse out
	$(this).siblings('a').find('i').css('opacity', '1');
});


/*Appel de la fonction anim_scroll_content*/
/*--------*/
the_whenadd= -200;



anim_scroll_content('frame-titre_anime','anim_active',the_whenadd);

//ajustement si modif du scroll
$(window).scroll(function(event){
	anim_scroll_content('frame-titre_anime','anim_active',the_whenadd);
});

//ajustement si modif de la taille de l'ecran
$(window).resize(function(){
  anim_scroll_content('frame-titre_anime','anim_active',the_whenadd);
});
/*--------*/
/*FIN de l'appel de la fonction*/
/*--------*/

//===================
//==========bouton hover==========//
//===================


$( '.btn-animate' ).hover(
  function() {
    $(this).addClass( "hover" );

    $(this).delay(400).queue( function(next){
        $(this).addClass( "hover2" );
        next();
  	});

  }, function() {

	    $(this).removeClass( "hover" );
	    $(this).delay(400).queue( function(next){
	        $(this).removeClass( "hover2" );
	        next();
	  	});

  }
);


//===================
//==========Menu deroulant scroll droite gauche==========//
//===================

    /*! sly 1.6.1 - 8th Aug 2015 | https://github.com/darsain/sly */
    !function(a,b,c){"use strict";function d(b,p,q){function K(c){var d=0,e=Gb.length;if(yb.old=a.extend({},yb),wb=tb?0:ub[rb.horizontal?"width":"height"](),Bb=zb[rb.horizontal?"width":"height"](),xb=tb?b:vb[rb.horizontal?"outerWidth":"outerHeight"](),Gb.length=0,yb.start=0,yb.end=H(xb-wb,0),Rb){d=Ib.length,Hb=vb.children(rb.itemSelector),Ib.length=0;var f,g=j(vb,rb.horizontal?"paddingLeft":"paddingTop"),h=j(vb,rb.horizontal?"paddingRight":"paddingBottom"),i="border-box"===a(Hb).css("boxSizing"),l="none"!==Hb.css("float"),m=0,n=Hb.length-1;xb=0,Hb.each(function(b,c){var d=a(c),e=c.getBoundingClientRect(),i=G(rb.horizontal?e.width||e.right-e.left:e.height||e.bottom-e.top),k=j(d,rb.horizontal?"marginLeft":"marginTop"),o=j(d,rb.horizontal?"marginRight":"marginBottom"),p=i+k+o,q=!k||!o,r={};r.el=c,r.size=q?i:p,r.half=r.size/2,r.start=xb+(q?k:0),r.center=r.start-G(wb/2-r.size/2),r.end=r.start-wb+r.size,b||(xb+=g),xb+=p,rb.horizontal||l||o&&k&&b>0&&(xb-=I(k,o)),b===n&&(r.end+=h,xb+=h,m=q?o:0),Ib.push(r),f=r}),vb[0].style[rb.horizontal?"width":"height"]=(i?xb:xb-g-h)+"px",xb-=m,Ib.length?(yb.start=Ib[0][Pb?"center":"start"],yb.end=Pb?f.center:xb>wb?f.end:yb.start):yb.start=yb.end=0}if(yb.center=G(yb.end/2+yb.start/2),V(),Ab.length&&Bb>0&&(rb.dynamicHandle?(Cb=yb.start===yb.end?Bb:G(Bb*wb/xb),Cb=k(Cb,rb.minHandleSize,Bb),Ab[0].style[rb.horizontal?"width":"height"]=Cb+"px"):Cb=Ab[rb.horizontal?"outerWidth":"outerHeight"](),Db.end=Bb-Cb,ec||N()),!tb&&wb>0){var o=yb.start,p="";if(Rb)a.each(Ib,function(a,b){Pb?Gb.push(b.center):b.start+b.size>o&&o<=yb.end&&(o=b.start,Gb.push(o),o+=wb,o>yb.end&&o<yb.end+wb&&Gb.push(yb.end))});else for(;o-wb<yb.end;)Gb.push(o),o+=wb;if(Eb[0]&&e!==Gb.length){for(var q=0;q<Gb.length;q++)p+=rb.pageBuilder.call(sb,q);Fb=Eb.html(p).children(),Fb.eq(Jb.activePage).addClass(rb.activeClass)}}if(Jb.slideeSize=xb,Jb.frameSize=wb,Jb.sbSize=Bb,Jb.handleSize=Cb,Rb){c&&null!=rb.startAt&&(T(rb.startAt),sb[Qb?"toCenter":"toStart"](rb.startAt));var r=Ib[Jb.activeItem];L(Qb&&r?r.center:k(yb.dest,yb.start,yb.end))}else c?null!=rb.startAt&&L(rb.startAt,1):L(k(yb.dest,yb.start,yb.end));ob("load")}function L(a,b,c){if(Rb&&cc.released&&!c){var d=U(a),e=a>yb.start&&a<yb.end;Qb?(e&&(a=Ib[d.centerItem].center),Pb&&rb.activateMiddle&&T(d.centerItem)):e&&(a=Ib[d.firstItem].start)}cc.init&&cc.slidee&&rb.elasticBounds?a>yb.end?a=yb.end+(a-yb.end)/6:a<yb.start&&(a=yb.start+(a-yb.start)/6):a=k(a,yb.start,yb.end),ac.start=+new Date,ac.time=0,ac.from=yb.cur,ac.to=a,ac.delta=a-yb.cur,ac.tweesing=cc.tweese||cc.init&&!cc.slidee,ac.immediate=!ac.tweesing&&(b||cc.init&&cc.slidee||!rb.speed),cc.tweese=0,a!==yb.dest&&(yb.dest=a,ob("change"),ec||M()),Z(),V(),W(),O()}function M(){if(sb.initialized){if(!ec)return ec=t(M),void(cc.released&&ob("moveStart"));ac.immediate?yb.cur=ac.to:ac.tweesing?(ac.tweeseDelta=ac.to-yb.cur,D(ac.tweeseDelta)<.1?yb.cur=ac.to:yb.cur+=ac.tweeseDelta*(cc.released?rb.swingSpeed:rb.syncSpeed)):(ac.time=I(+new Date-ac.start,rb.speed),yb.cur=ac.from+ac.delta*a.easing[rb.easing](ac.time/rb.speed,ac.time,0,1,rb.speed)),ac.to===yb.cur?(yb.cur=ac.to,cc.tweese=ec=0):ec=t(M),ob("move"),tb||(m?vb[0].style[m]=n+(rb.horizontal?"translateX":"translateY")+"("+-yb.cur+"px)":vb[0].style[rb.horizontal?"left":"top"]=-G(yb.cur)+"px"),!ec&&cc.released&&ob("moveEnd"),N()}}function N(){Ab.length&&(Db.cur=yb.start===yb.end?0:((cc.init&&!cc.slidee?yb.dest:yb.cur)-yb.start)/(yb.end-yb.start)*Db.end,Db.cur=k(G(Db.cur),Db.start,Db.end),_b.hPos!==Db.cur&&(_b.hPos=Db.cur,m?Ab[0].style[m]=n+(rb.horizontal?"translateX":"translateY")+"("+Db.cur+"px)":Ab[0].style[rb.horizontal?"left":"top"]=Db.cur+"px"))}function O(){Fb[0]&&_b.page!==Jb.activePage&&(_b.page=Jb.activePage,Fb.removeClass(rb.activeClass).eq(Jb.activePage).addClass(rb.activeClass),ob("activePage",_b.page))}function P(){bc.speed&&yb.cur!==(bc.speed>0?yb.end:yb.start)||sb.stop(),hc=cc.init?t(P):0,bc.now=+new Date,bc.pos=yb.cur+(bc.now-bc.lastTime)/1e3*bc.speed,L(cc.init?bc.pos:G(bc.pos)),cc.init||yb.cur!==yb.dest||ob("moveEnd"),bc.lastTime=bc.now}function Q(a,b,d){if("boolean"===e(b)&&(d=b,b=c),b===c)L(yb[a],d);else{if(Qb&&"center"!==a)return;var f=sb.getPos(b);f&&L(f[a],d,!Qb)}}function R(a){return null!=a?i(a)?a>=0&&a<Ib.length?a:-1:Hb.index(a):-1}function S(a){return R(i(a)&&0>a?a+Ib.length:a)}function T(a,b){var c=R(a);return!Rb||0>c?!1:((_b.active!==c||b)&&(Hb.eq(Jb.activeItem).removeClass(rb.activeClass),Hb.eq(c).addClass(rb.activeClass),_b.active=Jb.activeItem=c,W(),ob("active",c)),c)}function U(a){a=k(i(a)?a:yb.dest,yb.start,yb.end);var b={},c=Pb?0:wb/2;if(!tb)for(var d=0,e=Gb.length;e>d;d++){if(a>=yb.end||d===Gb.length-1){b.activePage=Gb.length-1;break}if(a<=Gb[d]+c){b.activePage=d;break}}if(Rb){for(var f=!1,g=!1,h=!1,j=0,l=Ib.length;l>j;j++)if(f===!1&&a<=Ib[j].start+Ib[j].half&&(f=j),h===!1&&a<=Ib[j].center+Ib[j].half&&(h=j),j===l-1||a<=Ib[j].end+Ib[j].half){g=j;break}b.firstItem=i(f)?f:0,b.centerItem=i(h)?h:b.firstItem,b.lastItem=i(g)?g:b.centerItem}return b}function V(b){a.extend(Jb,U(b))}function W(){var a=yb.dest<=yb.start,b=yb.dest>=yb.end,c=(a?1:0)|(b?2:0);if(_b.slideePosState!==c&&(_b.slideePosState=c,Yb.is("button,input")&&Yb.prop("disabled",a),Zb.is("button,input")&&Zb.prop("disabled",b),Yb.add(Vb)[a?"addClass":"removeClass"](rb.disabledClass),Zb.add(Ub)[b?"addClass":"removeClass"](rb.disabledClass)),_b.fwdbwdState!==c&&cc.released&&(_b.fwdbwdState=c,Vb.is("button,input")&&Vb.prop("disabled",a),Ub.is("button,input")&&Ub.prop("disabled",b)),Rb&&null!=Jb.activeItem){var d=0===Jb.activeItem,e=Jb.activeItem>=Ib.length-1,f=(d?1:0)|(e?2:0);_b.itemsButtonState!==f&&(_b.itemsButtonState=f,Wb.is("button,input")&&Wb.prop("disabled",d),Xb.is("button,input")&&Xb.prop("disabled",e),Wb[d?"addClass":"removeClass"](rb.disabledClass),Xb[e?"addClass":"removeClass"](rb.disabledClass))}}function X(a,b,c){if(a=S(a),b=S(b),a>-1&&b>-1&&a!==b&&(!c||b!==a-1)&&(c||b!==a+1)){Hb.eq(a)[c?"insertAfter":"insertBefore"](Ib[b].el);var d=b>a?a:c?b:b-1,e=a>b?a:c?b+1:b,f=a>b;null!=Jb.activeItem&&(a===Jb.activeItem?_b.active=Jb.activeItem=c?f?b+1:b:f?b:b-1:Jb.activeItem>d&&Jb.activeItem<e&&(_b.active=Jb.activeItem+=f?1:-1)),K()}}function Y(a,b){for(var c=0,d=$b[a].length;d>c;c++)if($b[a][c]===b)return c;return-1}function Z(){cc.released&&!sb.isPaused&&sb.resume()}function $(a){return G(k(a,Db.start,Db.end)/Db.end*(yb.end-yb.start))+yb.start}function _(){cc.history[0]=cc.history[1],cc.history[1]=cc.history[2],cc.history[2]=cc.history[3],cc.history[3]=cc.delta}function ab(a){cc.released=0,cc.source=a,cc.slidee="slidee"===a}function bb(b){var c="touchstart"===b.type,d=b.data.source,e="slidee"===d;cc.init||!c&&eb(b.target)||("handle"!==d||rb.dragHandle&&Db.start!==Db.end)&&(!e||(c?rb.touchDragging:rb.mouseDragging&&b.which<2))&&(c||f(b),ab(d),cc.init=0,cc.$source=a(b.target),cc.touch=c,cc.pointer=c?b.originalEvent.touches[0]:b,cc.initX=cc.pointer.pageX,cc.initY=cc.pointer.pageY,cc.initPos=e?yb.cur:Db.cur,cc.start=+new Date,cc.time=0,cc.path=0,cc.delta=0,cc.locked=0,cc.history=[0,0,0,0],cc.pathToLock=e?c?30:10:0,u.on(c?x:w,cb),sb.pause(1),(e?vb:Ab).addClass(rb.draggedClass),ob("moveStart"),e&&(fc=setInterval(_,10)))}function cb(a){if(cc.released="mouseup"===a.type||"touchend"===a.type,cc.pointer=cc.touch?a.originalEvent[cc.released?"changedTouches":"touches"][0]:a,cc.pathX=cc.pointer.pageX-cc.initX,cc.pathY=cc.pointer.pageY-cc.initY,cc.path=E(F(cc.pathX,2)+F(cc.pathY,2)),cc.delta=rb.horizontal?cc.pathX:cc.pathY,cc.released||!(cc.path<1)){if(!cc.init){if(cc.path<rb.dragThreshold)return cc.released?db():c;if(!(rb.horizontal?D(cc.pathX)>D(cc.pathY):D(cc.pathX)<D(cc.pathY)))return db();cc.init=1}f(a),!cc.locked&&cc.path>cc.pathToLock&&cc.slidee&&(cc.locked=1,cc.$source.on(z,g)),cc.released&&(db(),rb.releaseSwing&&cc.slidee&&(cc.swing=(cc.delta-cc.history[0])/40*300,cc.delta+=cc.swing,cc.tweese=D(cc.swing)>10)),L(cc.slidee?G(cc.initPos-cc.delta):$(cc.initPos+cc.delta))}}function db(){clearInterval(fc),cc.released=!0,u.off(cc.touch?x:w,cb),(cc.slidee?vb:Ab).removeClass(rb.draggedClass),setTimeout(function(){cc.$source.off(z,g)}),yb.cur===yb.dest&&cc.init&&ob("moveEnd"),sb.resume(1),cc.init=0}function eb(b){return~a.inArray(b.nodeName,B)||a(b).is(rb.interactive)}function fb(){sb.stop(),u.off("mouseup",fb)}function gb(a){switch(f(a),this){case Ub[0]:case Vb[0]:sb.moveBy(Ub.is(this)?rb.moveBy:-rb.moveBy),u.on("mouseup",fb);break;case Wb[0]:sb.prev();break;case Xb[0]:sb.next();break;case Yb[0]:sb.prevPage();break;case Zb[0]:sb.nextPage()}}function hb(a){return dc.curDelta=(rb.horizontal?a.deltaY||a.deltaX:a.deltaY)||-a.wheelDelta,dc.curDelta/=1===a.deltaMode?3:100,Rb?(o=+new Date,dc.last<o-dc.resetTime&&(dc.delta=0),dc.last=o,dc.delta+=dc.curDelta,D(dc.delta)<1?dc.finalDelta=0:(dc.finalDelta=G(dc.delta/1),dc.delta%=1),dc.finalDelta):dc.curDelta}function ib(a){a.originalEvent[r]=sb;var b=+new Date;if(J+rb.scrollHijack>b&&Sb[0]!==document&&Sb[0]!==window)return void(J=b);if(rb.scrollBy&&yb.start!==yb.end){var c=hb(a.originalEvent);(rb.scrollTrap||c>0&&yb.dest<yb.end||0>c&&yb.dest>yb.start)&&f(a,1),sb.slideBy(rb.scrollBy*c)}}function jb(a){rb.clickBar&&a.target===zb[0]&&(f(a),L($((rb.horizontal?a.pageX-zb.offset().left:a.pageY-zb.offset().top)-Cb/2)))}function kb(a){if(rb.keyboardNavBy)switch(a.which){case rb.horizontal?37:38:f(a),sb["pages"===rb.keyboardNavBy?"prevPage":"prev"]();break;case rb.horizontal?39:40:f(a),sb["pages"===rb.keyboardNavBy?"nextPage":"next"]()}}function lb(a){return eb(this)?void(a.originalEvent[r+"ignore"]=!0):void(this.parentNode!==vb[0]||a.originalEvent[r+"ignore"]||sb.activate(this))}function mb(){this.parentNode===Eb[0]&&sb.activatePage(Fb.index(this))}function nb(a){rb.pauseOnHover&&sb["mouseenter"===a.type?"pause":"resume"](2)}function ob(a,b){if($b[a]){for(qb=$b[a].length,C.length=0,pb=0;qb>pb;pb++)C.push($b[a][pb]);for(pb=0;qb>pb;pb++)C[pb].call(sb,a,b)}}if(!(this instanceof d))return new d(b,p,q);var pb,qb,rb=a.extend({},d.defaults,p),sb=this,tb=i(b),ub=a(b),vb=rb.slidee?a(rb.slidee).eq(0):ub.children().eq(0),wb=0,xb=0,yb={start:0,center:0,end:0,cur:0,dest:0},zb=a(rb.scrollBar).eq(0),Ab=zb.children().eq(0),Bb=0,Cb=0,Db={start:0,end:0,cur:0},Eb=a(rb.pagesBar),Fb=0,Gb=[],Hb=0,Ib=[],Jb={firstItem:0,lastItem:0,centerItem:0,activeItem:null,activePage:0},Kb=new l(ub[0]),Lb=new l(vb[0]),Mb=new l(zb[0]),Nb=new l(Ab[0]),Ob="basic"===rb.itemNav,Pb="forceCentered"===rb.itemNav,Qb="centered"===rb.itemNav||Pb,Rb=!tb&&(Ob||Qb||Pb),Sb=rb.scrollSource?a(rb.scrollSource):ub,Tb=rb.dragSource?a(rb.dragSource):ub,Ub=a(rb.forward),Vb=a(rb.backward),Wb=a(rb.prev),Xb=a(rb.next),Yb=a(rb.prevPage),Zb=a(rb.nextPage),$b={},_b={},ac={},bc={},cc={released:1},dc={last:0,delta:0,resetTime:200},ec=0,fc=0,gc=0,hc=0;tb||(b=ub[0]),sb.initialized=0,sb.frame=b,sb.slidee=vb[0],sb.pos=yb,sb.rel=Jb,sb.items=Ib,sb.pages=Gb,sb.isPaused=0,sb.options=rb,sb.dragging=cc,sb.reload=function(){K()},sb.getPos=function(a){if(Rb){var b=R(a);return-1!==b?Ib[b]:!1}var c=vb.find(a).eq(0);if(c[0]){var d=rb.horizontal?c.offset().left-vb.offset().left:c.offset().top-vb.offset().top,e=c[rb.horizontal?"outerWidth":"outerHeight"]();return{start:d,center:d-wb/2+e/2,end:d-wb+e,size:e}}return!1},sb.moveBy=function(a){bc.speed=a,!cc.init&&bc.speed&&yb.cur!==(bc.speed>0?yb.end:yb.start)&&(bc.lastTime=+new Date,bc.startPos=yb.cur,ab("button"),cc.init=1,ob("moveStart"),s(hc),P())},sb.stop=function(){"button"===cc.source&&(cc.init=0,cc.released=1)},sb.prev=function(){sb.activate(null==Jb.activeItem?0:Jb.activeItem-1)},sb.next=function(){sb.activate(null==Jb.activeItem?0:Jb.activeItem+1)},sb.prevPage=function(){sb.activatePage(Jb.activePage-1)},sb.nextPage=function(){sb.activatePage(Jb.activePage+1)},sb.slideBy=function(a,b){a&&(Rb?sb[Qb?"toCenter":"toStart"](k((Qb?Jb.centerItem:Jb.firstItem)+rb.scrollBy*a,0,Ib.length)):L(yb.dest+a,b))},sb.slideTo=function(a,b){L(a,b)},sb.toStart=function(a,b){Q("start",a,b)},sb.toEnd=function(a,b){Q("end",a,b)},sb.toCenter=function(a,b){Q("center",a,b)},sb.getIndex=R,sb.activate=function(a,b){var c=T(a);rb.smart&&c!==!1&&(Qb?sb.toCenter(c,b):c>=Jb.lastItem?sb.toStart(c,b):c<=Jb.firstItem?sb.toEnd(c,b):Z())},sb.activatePage=function(a,b){i(a)&&L(Gb[k(a,0,Gb.length-1)],b)},sb.resume=function(a){rb.cycleBy&&rb.cycleInterval&&("items"!==rb.cycleBy||Ib[0]&&null!=Jb.activeItem)&&!(a<sb.isPaused)&&(sb.isPaused=0,gc?gc=clearTimeout(gc):ob("resume"),gc=setTimeout(function(){switch(ob("cycle"),rb.cycleBy){case"items":sb.activate(Jb.activeItem>=Ib.length-1?0:Jb.activeItem+1);break;case"pages":sb.activatePage(Jb.activePage>=Gb.length-1?0:Jb.activePage+1)}},rb.cycleInterval))},sb.pause=function(a){a<sb.isPaused||(sb.isPaused=a||100,gc&&(gc=clearTimeout(gc),ob("pause")))},sb.toggle=function(){sb[gc?"pause":"resume"]()},sb.set=function(b,c){a.isPlainObject(b)?a.extend(rb,b):rb.hasOwnProperty(b)&&(rb[b]=c)},sb.add=function(b,c){var d=a(b);Rb?(null==c||!Ib[0]||c>=Ib.length?d.appendTo(vb):Ib.length&&d.insertBefore(Ib[c].el),null!=Jb.activeItem&&c<=Jb.activeItem&&(_b.active=Jb.activeItem+=d.length)):vb.append(d),K()},sb.remove=function(b){if(Rb){var c=S(b);if(c>-1){Hb.eq(c).remove();var d=c===Jb.activeItem;null!=Jb.activeItem&&c<Jb.activeItem&&(_b.active=--Jb.activeItem),K(),d&&(_b.active=null,sb.activate(Jb.activeItem))}}else a(b).remove(),K()},sb.moveAfter=function(a,b){X(a,b,1)},sb.moveBefore=function(a,b){X(a,b)},sb.on=function(a,b){if("object"===e(a))for(var c in a)a.hasOwnProperty(c)&&sb.on(c,a[c]);else if("function"===e(b))for(var d=a.split(" "),f=0,g=d.length;g>f;f++)$b[d[f]]=$b[d[f]]||[],-1===Y(d[f],b)&&$b[d[f]].push(b);else if("array"===e(b))for(var h=0,i=b.length;i>h;h++)sb.on(a,b[h])},sb.one=function(a,b){function c(){b.apply(sb,arguments),sb.off(a,c)}sb.on(a,c)},sb.off=function(a,b){if(b instanceof Array)for(var c=0,d=b.length;d>c;c++)sb.off(a,b[c]);else for(var e=a.split(" "),f=0,g=e.length;g>f;f++)if($b[e[f]]=$b[e[f]]||[],null==b)$b[e[f]].length=0;else{var h=Y(e[f],b);-1!==h&&$b[e[f]].splice(h,1)}},sb.destroy=function(){return d.removeInstance(b),Sb.add(Ab).add(zb).add(Eb).add(Ub).add(Vb).add(Wb).add(Xb).add(Yb).add(Zb).off("."+r),u.off("keydown",kb),Wb.add(Xb).add(Yb).add(Zb).removeClass(rb.disabledClass),Hb&&null!=Jb.activeItem&&Hb.eq(Jb.activeItem).removeClass(rb.activeClass),Eb.empty(),tb||(ub.off("."+r),Kb.restore(),Lb.restore(),Mb.restore(),Nb.restore(),a.removeData(b,r)),Ib.length=Gb.length=0,_b={},sb.initialized=0,sb},sb.init=function(){if(!sb.initialized){if(d.getInstance(b))throw new Error("There is already a Sly instance on this element");d.storeInstance(b,sb),sb.on(q);var a=["overflow","position"],c=["position","webkitTransform","msTransform","transform","left","top","width","height"];Kb.save.apply(Kb,a),Mb.save.apply(Mb,a),Lb.save.apply(Lb,c),Nb.save.apply(Nb,c);var e=Ab;return tb||(e=e.add(vb),ub.css("overflow","hidden"),m||"static"!==ub.css("position")||ub.css("position","relative")),m?n&&e.css(m,n):("static"===zb.css("position")&&zb.css("position","relative"),e.css({position:"absolute"})),rb.forward&&Ub.on(A,gb),rb.backward&&Vb.on(A,gb),rb.prev&&Wb.on(z,gb),rb.next&&Xb.on(z,gb),rb.prevPage&&Yb.on(z,gb),rb.nextPage&&Zb.on(z,gb),Sb.on(y,ib),zb[0]&&zb.on(z,jb),Rb&&rb.activateOn&&ub.on(rb.activateOn+"."+r,"*",lb),Eb[0]&&rb.activatePageOn&&Eb.on(rb.activatePageOn+"."+r,"*",mb),Tb.on(v,{source:"slidee"},bb),Ab&&Ab.on(v,{source:"handle"},bb),u.on("keydown",kb),tb||(ub.on("mouseenter."+r+" mouseleave."+r,nb),ub.on("scroll."+r,h)),sb.initialized=1,K(!0),rb.cycleBy&&!tb&&sb[rb.startPaused?"pause":"resume"](),sb}}}function e(a){return null==a?String(a):"object"==typeof a||"function"==typeof a?Object.prototype.toString.call(a).match(/\s([a-z]+)/i)[1].toLowerCase()||"object":typeof a}function f(a,b){a.preventDefault(),b&&a.stopPropagation()}function g(b){f(b,1),a(this).off(b.type,g)}function h(){this.scrollLeft=0,this.scrollTop=0}function i(a){return!isNaN(parseFloat(a))&&isFinite(a)}function j(a,b){return 0|G(String(a.css(b)).replace(/[^\-0-9.]/g,""))}function k(a,b,c){return b>a?b:a>c?c:a}function l(a){var b={};return b.style={},b.save=function(){if(a&&a.nodeType){for(var c=0;c<arguments.length;c++)b.style[arguments[c]]=a.style[arguments[c]];return b}},b.restore=function(){if(a&&a.nodeType){for(var c in b.style)b.style.hasOwnProperty(c)&&(a.style[c]=b.style[c]);return b}},b}var m,n,o,p="sly",q="Sly",r=p,s=b.cancelAnimationFrame||b.cancelRequestAnimationFrame,t=b.requestAnimationFrame,u=a(document),v="touchstart."+r+" mousedown."+r,w="mousemove."+r+" mouseup."+r,x="touchmove."+r+" touchend."+r,y=(document.implementation.hasFeature("Event.wheel","3.0")?"wheel.":"mousewheel.")+r,z="click."+r,A="mousedown."+r,B=["INPUT","SELECT","BUTTON","TEXTAREA"],C=[],D=Math.abs,E=Math.sqrt,F=Math.pow,G=Math.round,H=Math.max,I=Math.min,J=0;u.on(y,function(a){var b=a.originalEvent[r],c=+new Date;(!b||b.options.scrollHijack<c-J)&&(J=c)}),d.getInstance=function(b){return a.data(b,r)},d.storeInstance=function(b,c){return a.data(b,r,c)},d.removeInstance=function(b){return a.removeData(b,r)},function(a){function b(a){var b=(new Date).getTime(),d=Math.max(0,16-(b-c)),e=setTimeout(a,d);return c=b,e}t=a.requestAnimationFrame||a.webkitRequestAnimationFrame||b;var c=(new Date).getTime(),d=a.cancelAnimationFrame||a.webkitCancelAnimationFrame||a.clearTimeout;s=function(b){d.call(a,b)}}(window),function(){function a(a){for(var d=0,e=b.length;e>d;d++){var f=b[d]?b[d]+a.charAt(0).toUpperCase()+a.slice(1):a;if(null!=c.style[f])return f}}var b=["","Webkit","Moz","ms","O"],c=document.createElement("div");m=a("transform"),n=a("perspective")?"translateZ(0) ":""}(),b[q]=d,a.fn[p]=function(b,c){var f,g;return a.isPlainObject(b)||(("string"===e(b)||b===!1)&&(f=b===!1?"destroy":b,g=Array.prototype.slice.call(arguments,1)),b={}),this.each(function(a,e){var h=d.getInstance(e);h||f?h&&f&&h[f]&&h[f].apply(h,g):h=new d(e,b,c).init()})},d.defaults={slidee:null,horizontal:!1,itemNav:null,itemSelector:null,smart:!1,activateOn:null,activateMiddle:!1,scrollSource:null,scrollBy:0,scrollHijack:300,scrollTrap:!1,dragSource:null,mouseDragging:!1,touchDragging:!1,releaseSwing:!1,swingSpeed:.2,elasticBounds:!1,dragThreshold:3,interactive:null,scrollBar:null,dragHandle:!1,dynamicHandle:!1,minHandleSize:50,clickBar:!1,syncSpeed:.5,pagesBar:null,activatePageOn:null,pageBuilder:function(a){return"<li>"+(a+1)+"</li>"},forward:null,backward:null,prev:null,next:null,prevPage:null,nextPage:null,cycleBy:null,cycleInterval:5e3,pauseOnHover:!1,startPaused:!1,moveBy:300,speed:0,easing:"swing",startAt:null,keyboardNavBy:null,draggedClass:"dragged",activeClass:"active",disabledClass:"disabled"}}(jQuery,window);

(function () {
    var $frame = $('#draggable-slider');
    var $wrap  = $frame.parent();

    // Call Sly on frame
    var options = {
        horizontal: 1,
        itemNav: 'basic',
        smart: 1,
        activateOn: 'click',
        mouseDragging: 1,
        touchDragging: 1,
        releaseSwing: 1,
        startAt: 0,
        scrollBar: $wrap.find('.scrollbar'),
        scrollBy: 1,
        speed: 300,
        elasticBounds: 1,
        easing: 'easeOutExpo',
        dragHandle: 1,
        dynamicHandle: 0,
        clickBar: 1,

        // Buttons
        prev: $wrap.find('.prev'),
        next: $wrap.find('.next')
    };
    var sly = new Sly('#draggable-slider', options).init();

    var startPos = sly.pos.cur;

    sly.on('move', function() {
        startPos = sly.pos.cur;
        if (sly.pos.cur >= sly.pos.end) {
            $($wrap.find('.next')).addClass('disabled').attr('disabled');
        } else {
            $($wrap.find('.next')).removeClass('disabled').removeAttr('disabled');
        }

        if (sly.pos.cur == sly.pos.start) {
            $($wrap.find('.prev')).addClass('disabled').attr('disabled');
        } else {
            $($wrap.find('.prev')).removeClass('disabled').removeAttr('disabled')
        }
    })

    $wrap.find('.next').click(function() {
        startPos += sly.items[0].size;
        $frame.sly('slideTo', startPos);

        if (sly.pos.cur >= sly.pos.end - sly.items[0].size) {
            $(this).addClass('disabled').attr('disabled');
        }
    });

    $wrap.find('.prev').click(function() {
        if (sly.pos.cur <= sly.pos.end) {
            $($wrap.find('.next')).removeClass('disabled').removeAttr('disabled');
        }

        startPos -= sly.items[0].size;
        $frame.sly('slideTo', startPos);
    });

    $( window ).resize(function() {
        sly.reload();
    });
}());

$("ul.menu_slide li").hover(function() { // Mouse over
  $(this).siblings().stop().fadeTo(300, 0.2);
  $(this).parent().siblings().stop().fadeTo(300, 0.3);
}, function() { // Mouse out
  $(this).siblings().stop().fadeTo(300, 1);
  $(this).parent().siblings().stop().fadeTo(300, 1);
});

//===================
//==========Click next part Home==========//
//===================


$('.case_souris').on('click', function() {
    WindowsH = $(window).height();
    offset = $('#Next_Part').offset().top;
    next = offset;

    speed = 600; // Durée de l'animation (en ms)
    $('html, body').animate({ scrollTop: next}, speed, 'swing' ); // Go
    return false;
});





//===================
//==========home effet de mouvement avec souris==========//
//===================

function move_with_mouse(class_mouse,sens) {
	class_mouse = class_mouse;
	class_mouse = $(class_mouse);

	class_mouse.each(function() {

		winWidth = $('html').width();
		winHeight = $(window).height();
		halfWidth = winWidth/2;
		halfHeight = winHeight/2;

		if(ie || (document.documentMode || /Edge/.test(navigator.userAgent))) {
			//class_mouse.css( 'transform', 'scale(2) translate(0,0');
			class_mouse.css( 'transform', 'scale(1.05) translate(0,0');
		}else{
		class_mouse.css( 'transform', 'scale(1.05) translate(0,0');
		}

		$('html').mousemove(function(e){
			//permet d'avoir ton x=0 et y=0 au centre de l'écran
			p = mousePosition(e);
			centerW = p.x - halfWidth;
			centerH = p.y - halfHeight;

			//objet
			xTranslate = Math.round(centerW/15);
			yTranslate = Math.round(centerH/15);
			xFinalTranslate = xTranslate/50*sens;
			yFinalTranslate = yTranslate/50*sens;
			if(ie || (document.documentMode || /Edge/.test(navigator.userAgent))) {
			//class_mouse.css( 'transform', 'scale(2) translate('+xFinalTranslate+'%,'+yFinalTranslate+'%)' );
			class_mouse.css( 'transform', 'scale(1.05) translate('+xFinalTranslate+'%,'+yFinalTranslate+'%)' );
		}else{
			class_mouse.css( 'transform', 'scale(1.05) translate('+xFinalTranslate+'%,'+yFinalTranslate+'%)' );
		}

		});

		function mousePosition(e) {
		  return {
		    'x': e.pageX,
		    'y': e.pageY
		  }
		}
	});

}//fin de la fonction move_with_mouse

/*--------*/
/*Appel de la fonction move_with_mouse*/
/*--------*/


if(ie || (document.documentMode || /Edge/.test(navigator.userAgent))) {
move_with_mouse('video.backgroundHome',1);
}else{
move_with_mouse('.backgroundHome',1);
}

//ajustement si modif de la taille de l'ecran
$(window).resize(function(){

if(ie || (document.documentMode || /Edge/.test(navigator.userAgent))) {
move_with_mouse('video.backgroundHome',1);
}else{
  move_with_mouse('.backgroundHome',1);
}

});
/*--------*/
/*FIN de l'appel de la fonction*/
/*--------*/

/*--------*/
/*Appel de la fonction move_with_mouse*/
/*--------*/
// move_with_mouse('HomePart1',-1);

// //ajustement si modif de la taille de l'ecran
// $(window).resize(function(){
//   move_with_mouse('HomePart1',-1);
// });



move_with_mouse('.marge_nav',-1);

//ajustement si modif de la taille de l'ecran
$(window).resize(function(){
  move_with_mouse('.marge_nav',-1);
});


/*--------*/
/*FIN de l'appel de la fonction*/
/*--------*/


/*--------*/
/*Appel de la fonction move_with_mouse*/
/*--------*/



if(ie || (document.documentMode || /Edge/.test(navigator.userAgent))) {
	move_with_mouse('video.img_bg_home5',-1);
}else{
	move_with_mouse('.img_bg_home5',-1);
}

//ajustement si modif de la taille de l'ecran
$(window).resize(function(){
	if(ie || (document.documentMode || /Edge/.test(navigator.userAgent))) {
		move_with_mouse('video.img_bg_home5',-1);
	}else{
		move_with_mouse('.img_bg_home5',-1);
	}
});



move_with_mouse('.img_bg_home5',-1);

//ajustement si modif de la taille de l'ecran
$(window).resize(function(){
  move_with_mouse('.img_bg_home5',-1);
});
/*--------*/
/*FIN de l'appel de la fonction*/
/*--------*/







//===================
//==========effet parralax==========//
//===================

//la fonction prends en compte l'action du scroll et le rezise
function scroll_parallax(My_element,vitesse){
	//récupération de la valeur du scroll
    windowScroll = $(window).scrollTop();
    //récupération de la hauteur de l'écran
    WindowsH = $(window).height();
    //récupération de la hauteur de la moitier l'écran
    WindowsHDiv2 =  WindowsH/2;
    //récupération de la position du bas de l'écran
    //bottom_screen = windowScroll+WindowsH;
    //récupération du centre de l'écran
    center_screen = windowScroll+WindowsHDiv2;
    //récupération de la distance entre le centre de l'écran et le centre de l'objet
    distance_center = center_screen-element_center;

	////alert(distance_center);
    //récupération de la vitesse de défillement.( plus le pourcentage est elevé plus l'objet défilera rapidement)
    vitesse_defil = distance_center*vitesse;


    My_element.css( "transform", "translateY("+vitesse_defil+"px)");

}

//la fontion prends en compte le resize
function scroll_parallax_go(the_element,vitesse){
	the_element2 = the_element;
	My_element = $('.'+the_element2);

	if(My_element.length >0 ){
			My_element.each(function() {

				//récupération de la position de l'élément par rapprt au haut de la page(Valeur qui doit varié juste pour un resize et non au scroll)
			    offset = $(this).offset().top;
			    //récupération de la hauteur de l'élément divisé par 2.
			    elementHDiv2 = $(this).height()/2;
			    //récupération de la position du centre de l'élément.
			    element_center= offset+elementHDiv2;


				//appel de la fonction
				scroll_parallax($(this),vitesse);
				//Dès que l'on scrool
			});
			$(window).scroll(function(event){

					the_element2 = the_element;
					My_element = $('.'+the_element2);

				My_element.each(function() {

					//récupération de la position de l'élément par rapprt au haut de la page(Valeur qui doit varié juste pour un resize et non au scroll)
				    offset = $(this).offset().top;
				    //récupération de la hauteur de l'élément divisé par 2.
				    elementHDiv2 = $(this).height()/2;
				    //récupération de la position du centre de l'élément.
				    element_center= offset+elementHDiv2;

						//appel de la fonction
						scroll_parallax($(this),vitesse)
				});
			});
	}


}


/*==APPEL DE LA FONCTION==*/
//définir l'élément avec sa class (ex: the_element= maclass)
//the_element = 'parallax';
//définir la vitesse de défilement (nombre positif: plus rapide, nombre négatif: moins rapide)
//vitesse = 0.6;


if(!ie11EstVraimentToutPourri){
var obj = {
  "block_content_part5": "0.2",
  "parallax": "-0.1"

}
}else{
var obj = {
  "parallax": "-0.1"

}
}






$.each( obj, function( class_element, the_vitesse ) {

	scroll_parallax_go(class_element,the_vitesse);

	$(window).resize(function(){
			scroll_parallax_go(class_element,the_vitesse);
	});
});

/*==APPEL DE LA FONCTION==*/








//===================
//==========Click full sceen==========//
//===================



$('.bouton_play_part5').on('click', function() {
	$('#full_screen').addClass( "active" );
});

$('.close_full_screen').on('click', function() {
	$('#full_screen').removeClass( "active" );
});










//===================
//==========Actualitées TWITTER ==========//
//===================

//si il n'y a pas d'iframe généré supression du block twitter et centrages des actus
if($.trim($(".block_twitter blockquote").html())==''){
 	$( ".block_twitter" ).remove();
 	$( ".container_home_actu .frame-default" ).css( "width", "100%" );
}












//===================
//==========BURGER MENU ==========//
//===================

// au click ajout de class


// au click ajout de transition

base=0.4;
	$( ".menu-collapsed li" ).each(function() {
		base=base+0.025;
		temps=base.toFixed(3);
		transition = "all ease-out 0.4s "+temps+"s";
	  $( this ).css('transition',transition);
	});

$('.hamburger').on('click', function() {
base=0.4;
	$( ".menu-collapsed li" ).each(function() {
		base=base+0.025;
		temps=base.toFixed(3);
		transition = "all ease-out 0.4s "+temps+"s";
	  $( this ).css('transition',transition);
	});
});

nbrLI= $('.menu-collapsed li').length;
maxTime= (nbrLI * 0.025) + 1;
transition_Back = "all ease-out 0.4s "+maxTime+"s";
$('.menu-collapsed').css('transition',transition);



$(".hamburger").click(function() {
  	$(".menu-collapsed").toggleClass("menu-expanded");
  	$(".hamburger").toggleClass("is-active");
    if ($(".menu-collapsed").hasClass('menu-expanded')) {
    	$('body').css('overflow','hidden');
    	$('.logo').hide();
    	$('.menu-header-right').addClass('open_menu');
    }
    else{
    	$('body').css('overflow','auto');
    	$('.logo').show();
    	$('.menu-header-right').removeClass('open_menu');
    }
});

$( ".frame-type-menu_principal .socialNetwork ul" ).hover(function() {
  $('.frame-type-menu_principal .socialNetwork ul li').css({"transition": "all ease-out 0.4s"});
});

$('.menu-collapsed.menu-expande .hamburger').on('click', function() {
	$('.frame-type-menu_principal .socialNetwork ul li').css({"opacity": 0});
});


$('.hamburger').on('click', function() {
	contentH = $(".frame-type-menu_principal nav").height();
	windowH = $(window).height();

	if( contentH <= windowH ){
		$(".menu-collapsed.menu-expanded .frame-type-menu_principal nav").toggleClass("marge_nav");
	}
});



//===================
//==========offre emploir==========//
//===================

// si la sidebar existe => le menu section
if($('.form_emploi').length >0 ){

	if($('.alert-success').length >0 ){
		$('.form_emploi').addClass('display_none');
	}
}






//===================
//========== Info bulle ==========//
//===================

if($('.block_bulle_info').length){
    if(!checkCookie('e_bulle_info') || !$('.cookieTime').length){
        $('.block_bulle_info').addClass('active');
        $('.block_bulle_info .case_bulle_info').addClass('active');
        $('.block_bulle_info .close_info_bulle').addClass('active');

        $('.block_bulle_info .close_info_bulle').click(function(){
            $('.block_bulle_info').removeClass('active');
            $('.case_bulle_info').removeClass('active');
            $('.case_bulle_info').addClass('hidden');
        });

        $('.block_bulle_info .case_bulle_info').click(function(e){
            e.stopPropagation();
        });
        // $('.block_bulle_info.active').click(function(){
        //     $('.block_bulle_info').removeClass('active');
        //     $('.case_bulle_info').removeClass('active');
        //     $('.case_bulle_info').addClass('hidden');
        // });
        if($('.cookieTime').length){
            var time = $('.cookieTime').val();
            setCookie('e_bulle_info', 'visite', time);
        }
    }




    //modif taille img
    size_content_bulle = $('.case_bulle_info').height();
    $('.case_bulle_info img').css("max-height", size_content_bulle);
    $('.case_bulle_info video').css("max-height", size_content_bulle);

    $(window).resize(function(){
	   	size_content_bulle = $('.case_bulle_info').height();
	    $('.case_bulle_info img').css("max-height", size_content_bulle);
	    $('.case_bulle_info video').css("max-height", size_content_bulle);
	});
}

//js cookie info bulle
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie(e) {
    var user = getCookie(e);
    if (user != "") {
        okCookie = true;
    } else {
        okCookie = false;
    }
    return okCookie;
}



//===================
//========== Proposition video ==========//
//===================



if($('.powermail_label').length >0 ){
	$(".powermail_label").each(function () {

		if($(this).attr('title')) {
		    title = $(this).attr('title');

			if (title !='') {
                $( '<i class="icon-Important icon_form_info"></i><p class="form_info_p">'+title+'</p>' ).insertAfter($(this));
			}
		}
	});

	if($('.icon_form_info').length >0 ){
		$( ".icon_form_info" ).hover(
		  function() {
		    $(this).parent().find(".form_info_p").addClass("hover");
		  }, function() {
		    $(this).parent().find(".form_info_p").removeClass("hover");
		  }
		);
	}
}



//===================
//========== dechet ==========//
//===================

if($('.bloc_ordure').length >0 ){

	function ajout_marg(){

		with_screen= $(window).width();

		//if(with_screen>1050){
			$( ".bloc_ordure" ).each(function() {

				img=$(this).find(".illustration_bac img");
				text=$(this).find(".details_collecte .content_case_collect");

				textH= text.height();
				imgH= img.height();
				new_margin= (textH-imgH)/2;

				if(new_margin>1){
					img.css("margin-top",new_margin+"px");
				}

			});
		//}
	}

	ajout_marg();
	$(window).resize(function(){
	    ajout_marg();
	});
}

//===================
//========== suppression underscore gestion doc ==========//
//===================
    if($('#tx_egestiondocs_document').length >0){
        $("#parcour_doc a, h2").each(function() {
            var text = $(this).text();
            text = text.replace(/\_/g, " ");
            $(this).text(text);
        });
    }

//===================
//========== Gestion doc ==========//
//===================
if($('.block_list_doc').length >0 ){

	//remplacer tout les "_" par un espace
	$(".block_list_doc h2").each(function () {
		base_text= $(this).text();
		new_text1= base_text.replace(/_/g," ").trim();
		new_text2= new_text1.replace(/-/g," ").trim();
		//alert(test3);
		$(this).empty();
		$(this).prepend(new_text2);
	});



	$(".the_name_doc").each(function () {
		base_name_doc= $(this).text();
		nbr=base_name_doc.length;
		if(nbr>26){
			shortText = base_name_doc.substr(0, 25) + "...";
			$(this).empty();
			$(this).prepend(shortText);
		}
	});

	// dossiers

	$("#parcour_doc li ul").each(function () {
		$(this).closest("li").prepend('<button type="button" class="btn_pli_depli"><span class="sr-only"></span></button>').addClass("content_li");
	});

}


//===================
//========== gestion doc plié déplié ==========//
//===================
if($('#parcour_doc').length >0 ){
	$('#parcour_doc').delay(100).fadeTo( "fast", 1 );

    $('#parcour_doc .btn_pli_depli').each(function() {
        $(this).find('span').text($(this).siblings('a').text());
        $(this).attr('aria-expanded', 'false')
    });

	$("#parcour_doc > ul > li > .btn_pli_depli").addClass("plie_doc").attr('aria-expanded', 'true');
	$("#parcour_doc > ul > li > ul > li").addClass("racine_doc");
	$('.racine_doc > .btn_pli_depli').attr('aria-expanded', 'false');

	$("#parcour_doc ul").slideDown();
	$("#parcour_doc li.racine_doc ul").slideUp(0);
	$("#parcour_doc li.search_inside").parents('ul').slideDown();

	if ($("#parcour_doc li").hasClass('search_inside')) {
	    $('ul[style*="display: block"]').each(function(){
	        $(this).parent().find('> button.btn_pli_depli').addClass('plie_doc').attr('aria-expanded', 'true');
        });
    }

	$("#parcour_doc li.content_li .btn_pli_depli").click(function(){
			$(this).toggleClass('plie_doc');
	        $(this).closest('li').find("ul:first").slideToggle();
            $(this).hasClass('plie_doc') ? $(this).attr('aria-expanded', 'true') : $(this).attr('aria-expanded', 'false');
	});



	$("li.search_inside > a").addClass('a_search_inside');


	// si tout seule ne pas afficher le sommaire et résulta

	if($('#parcour_doc > ul > li').length <2 ){

	}

	$( "#parcour_doc" ).each(function() {
		if($( this ).find('li').length <2 ){
			$( ".titre_sommaire" ).hide();
			$( "#parcour_doc" ).hide();
			$( ".nbr_resultats" ).hide();
		}
	});


}






//===================
//========== lazy load retour ==========//
//===================
if($('.list_agenda').length >0 ){
	$( document ).ready(function() {
	    speed = 600; // Durée de l'animation (en ms)
	    $('html, body').animate({ scrollTop: 0}, speed, 'swing' ); // Go
	    return false;
	});
}


//===================
//========== flux hover ==========//
//===================

if($('.tx-rssaggregator').length >0 ){

	$( ".tx-rssaggregator .title" ).each(function() {
		$( this ).hover(
		  function() {
		    $( this ).closest("li").find(".image img").addClass( "hover" );
		  }, function() {
		    $( this ).closest("li").find(".image img").removeClass( "hover" );
		  }
		);
	});

}





//===================
//========== formulaire légende ==========//
//===================

if($('#powermail_tabmenu').length >0 ){
	$( ".powermail_legend" ).css("display","none");
}



//===================
//========== Info bulle ==========//
//===================
if($('.home_part4 .frame-layout-6 a').length >0){
	$( ".home_part4 .frame-layout-6 a" ).each(function() {
		$( this ).closest(".frame-layout-6").addClass( "content_a" );
	});
}



//===================
//========== ajout target blank à tous les liens de telechargement==========//
//===================

if($('.icon-LinkText-telechargement').length >0){
		$('.icon-LinkText-telechargement').attr('target', '_blank');
}






//===================
//========== Ouvre le toggle si il y a une cible dans url==========//
//===================


if($('.openCloseTitle').length >0){
	url = window.location.href;

	if(url.indexOf('#')>-1){
		nbr=url.indexOf("#");
	 	id=url.substr(nbr);

         if (id.length > 1) {

            cible = $(id+' h2');

            $(id+' header').addClass('openTitle');
            $(id+' .ce-textpic').addClass('openBody open').show();
         }
	}
}



//===================
//Accessibilité
//===================

$('#go_menu').click(function() { // Au clic sur un élément
    $('.hamburger').trigger("click");
});

$('#go_recherche').click(function() { // Au clic sur un élément
    $('#search-icon').trigger("click");
});

// Disable animation on home page
$('#animation').click(function() {
    $('body').toggleClass('no-animation');
    $('body').hasClass('no-animation') ? $(this).text('Activer les animations') : $(this).text('Désactiver les animations');
});

// Hover/focus handler
function hoverFocusHandler(element) {
    $(element).each(function() {
        $(this).hover(function () {
            $(this).addClass('is-animated');
        }, function () {
            $(this).removeClass('is-animated');
        });

        $(this).focus(function() {
            $(this).addClass('is-animated');
        });

        $(this).blur(function() {
            $(this).removeClass('is-animated');
        });
    });

    $(document).keydown(function(e) {
        // ESCAPE key pressed
        if (e.keyCode == 27) {
            $(element).each(function() {
                $(this).removeClass('is-animated');
            });
        }
    });
}

hoverFocusHandler('.liste_actu_home > a');
hoverFocusHandler('.block_content_part5');
hoverFocusHandler('.content_left .frame ul li > a');
hoverFocusHandler('.results-entry a');
hoverFocusHandler('.frame-type-menu_categorized_pages ul li > a');
hoverFocusHandler('.frame-type-menu_categorized_pages ul li > a');
hoverFocusHandler('.fs-media-gallery .thumb');
hoverFocusHandler('.frame-type-menu_subpages ul li > a');

//===================
//========== slide by screen ==========//
//===================


// //si on est sur la home Page
// if($('.panel1').length >0 ){

// 	windowH= $(window).height;
// 	topPart2= $('.home_part2').offset().top;
// 	topPart3= $('.home_part3').offset().top;
// 	topPart4= $('.home_part4').offset().top;
// 	topPart5= $('.home_part5').offset().top;
// 	lastScrollTop = 0;
// 	speed = 900;
// 	startScroll=1;

// 	console.log('startScroll1 = '+ startScroll);

// 	    $(window).on('wheel',function(event) {
// 	    	if (startScroll!=0){
// 			// Valeur du scroll
// 			windowScroll = $(window).scrollTop();

// 			//scroll down
// 			if(event.originalEvent.deltaY > 0){

// 				if (windowScroll < topPart2){
// 				    next = topPart2 - 0;
// 				    $('html, body').animate({ scrollTop: next}, speed, 'swing' ); // Go
// 				    return false;
// 				}

// 				// console.log('sroll = '+windowScroll);
// 				// console.log('part2 = '+topPart2);




// 			}
// 			//scroll top
// 			else{
// 			  	if (windowScroll >= topPart2){
// 				    next = topPart2 - 0;
// 				    $('html, body').animate({ scrollTop: next}, speed, 'swing' ); // Go
// 				    return false;
// 				}
// 			}
// 			lastScrollTop = windowScroll;
// 			startScroll=0;
// 			 setTimeout(function(){
// 			   startScroll=1;
// 			 }, 900);


// 			}

// 	    });

// }

///////////////////////////////////////////  2Eme Solution /////////////////

// //si on est sur la home Page
// if($('.panel1').length >0 ){

// 	topPart2= $('.home_part2').offset().top;
// 	speed = 900;
// 	test=1;

// 	    $(window).on('wheel',function(event) {
// 	    	if (test == 1){

// 				windowScroll = $(window).scrollTop();

// 				if(event.originalEvent.deltaY < 0){


// 				}
// 				else{
// 					if (windowScroll < topPart2){
// 					    next = topPart2 - 0;
// 					    $('html, body').animate({ scrollTop: next}, speed, 'swing' ); // Go
// 					    return false;
// 					}
// 				}
// 				test=0;
// 				console.log(windowScroll);
// 			}
// 	    });

// }



// fin du fichier (ne pas suppr)
}); // fin du fichier (ne pas suppr)

























