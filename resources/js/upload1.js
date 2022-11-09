window.onscroll = function() {myFunction()};

const navbar = document.querySelector(".topBar");
const sticky = navbar.offsetTop;
const container = document.querySelector(".container");
console.log(sticky);

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky");
    container.classList.add("moarpadding");
    
  } else {
    navbar.classList.remove("sticky");
    container.classList.remove("moarpadding");
  }
}