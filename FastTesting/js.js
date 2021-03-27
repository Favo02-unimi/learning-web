function scrolla(elem) {  
    if (document.URL.includes("login.html")) {
        window.location = "index.html";
    }
    else {
        switch (elem.id) {
            case ("gotoHome"):
                window.scrollTo(0, 0);
                break;
            case ("gotoChisiamo"):
                console.log("aisjd");
                window.scrollTo(0, ($('#chisiamo').position().top)-90);
                break;
            case ("gotoOfferte"):
                window.scrollTo(0, ($('#offerte').position().top)-80);
                break;
            case ("gotoListino"):
                window.scrollTo(0, ($('#listino').position().top)-80);
            break;
        }
    }
}

$(document).on('scroll', function() {
    var scrollTOP = $(document).scrollTop();
    
    //faccio salire in alto il logo
    if (scrollTOP >= 350) {
        $("h1.titoloLogo").addClass("scroll");
        $("#descrizione").addClass("scroll");
    }
    else {
        $("h1.titoloLogo").removeClass("scroll");
        $("#descrizione").removeClass("scroll");
    }

    //cambio colore al menu
    if (scrollTOP >= 900) {
        $("ul.navmenu").addClass("superScroll");
        $("h1.titoloLogo").addClass("superScroll");
    }
    else {
        $("ul.navmenu").removeClass("superScroll");
        $("h1.titoloLogo").removeClass("superScroll");
    }

    //cambio elemento attivo
    if ((scrollTOP + 100) >= $('#chisiamo').position().top) {
        $("#gotoChisiamo").addClass("active");
        
        $("#gotoHome").removeClass('active');
        $("#gotoOfferte").removeClass('active');
        $("#gotoListino").removeClass('active');
    }
    else if ((scrollTOP + 100)  >= $('#listino').position().top) {
        $("#gotoListino").addClass('active');
        
        $("#gotoHome").removeClass('active');
        $("#gotoChisiamo").removeClass("active");
        $("#gotoOfferte").removeClass('active');
    }
    else if ((scrollTOP + 100)  >= $('#offerte').position().top) {
        $("#gotoOfferte").addClass('active');
        
        $("#gotoHome").removeClass('active');
        $("#gotoChisiamo").removeClass("active");
        $("#gotoListino").removeClass('active');
    }
    else {
        $("#gotoHome").addClass('active');
        
        $("#gotoChisiamo").removeClass("active");
        $("#gotoOfferte").removeClass('active');
        $("#gotoListino").removeClass('active');
    }
});