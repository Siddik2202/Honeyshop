const header = document.querySelector('.header');

function FixNavbar() {
    header.classList.toggle('scrolled', window.pageYOffset > 0);
}

// Now invoking the function when needed
FixNavbar();
window.addEventListener('scroll',FixNavbar);


let menu = document.querySelector('#menu-btn');
let  userbtn = document.querySelector('#user-btn');


menu.addEventListener('click',function(){
    let nav = document.querySelector('.navbar');
    nav.classList.toggle('active')
})

userbtn.addEventListener('click',function(){
    let userbox = document.querySelector('.user-box');
    userbox.classList.toggle('active');
})

let closeBtn = document.querySelector('#close-form');
    closeBtn.addEventListener('click',() => {
        document.querySelector('.update-container').style.display ='none';
})