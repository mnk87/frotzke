import axios from "axios";

window.onscroll = function() {myFunction()};

const navbar = document.querySelector(".topBar");
const sticky = navbar.offsetTop;
const container = document.querySelector(".containerDiv");

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky");
    container.classList.add("moarpadding");
    
  } else {
    navbar.classList.remove("sticky");
    container.classList.remove("moarpadding");
  }
}

function saveAlbum() {
  const name = document.getElementById('nameInput').value;
  const folderName = document.getElementById('folderNameInput').value;
  axios.post('/upload/albums', {
    name: name,
    foldername: folderName
  }).then(function (response) {
    console.log(response);
    if(response.data.error) {
      console.log(response.data.error);
      document.getElementById('saveAlbumError').innerText = response.data.error;
      return;
    }
    location.reload(true);
  });
}

document.getElementById('saveAlbumButton').addEventListener('click', saveAlbum);