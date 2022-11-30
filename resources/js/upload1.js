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
const saveAlbumButton = document.getElementById('saveAlbumButton');
if(saveAlbumButton) {
  saveAlbumButton.addEventListener('click', saveAlbum);
}

function deleteAlbum() {
  const id = document.getElementById('albumSelect').value;
  const url = 'upload/albums/' + id;
  axios.delete(url).then(function (response) {
    if(response.data.error) {
      console.log(response.data.error);
      return;
    }
    if(response.data.success) {
      // console.log(response.data.success);
      location.reload(true);
    }
  })
  console.log(id);
}
const deleteAlbumButton = document.getElementById('deleteAlbumButton');
if(deleteAlbumButton) {
  deleteAlbumButton.addEventListener('click', deleteAlbum);
}
const photos = document.getElementById('photos');
if(photos) {
  photos.addEventListener('change', logthat);
}

function logthat() {
  const files = document.getElementById('photos').value;
  console.log(files);
}