/* jshint esversion: 6 */
//Navbar
window.addEventListener('scroll', function(){
    let navbar = document.getElementById("navbar");
    //Toggles Fixed Class In Navbar On Scroll 
    navbar.classList.toggle('fixed', this.window.scrollY > 0);
});

//Nav Buttons
let searchBtn = document.querySelector('.searchbtn');
let darkBtn = document.querySelector('.darkbtn');

searchBtn.onclick = function(){
    //Toggles Active Class In Search Form On Click
    document.getElementById("search-form").classList.toggle('active');

    //Changes Icon on Click
    if(document.getElementById("search-form").classList.contains('active')){
        searchBtn.classList.remove("bx-search-alt-2");
        searchBtn.classList.add("bx-x");
    }
    else{
        searchBtn.classList.remove("bx-x");
        searchBtn.classList.add("bx-search-alt-2");
    }
};

darkBtn.onclick = function(){
    //Toggles Dark Mode Class to Body On Click
    document.body.classList.toggle('dark-mode');

    //Changes Icon on Click
    if(document.body.classList.contains('dark-mode')){
        darkBtn.classList.remove("bx-moon");
        darkBtn.classList.add("bx-sun");
    }
    else{
        darkBtn.classList.remove("bx-sun");
        darkBtn.classList.add("bx-moon");
    }
};


