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