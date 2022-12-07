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
  const yearFolder = document.getElementById('yearFolderInput').value;
  const bgimgfile = document.getElementById('bgImgInput').files[0];
  axios.post('/upload/albums', {
    name: name,
    foldername: folderName,
    yearfolder: yearFolder,
    bgimg: bgimgfile
  },
  {
    headers: {
        'Content-Type': 'multipart/form-data'
    }
  }).then(function (response) {
    if(response.data.test) {
      console.log("response: ", response);
      // console.log(response.data.test);
      return;
    }
    if(response.data.error) {
      console.log(response.data.error);
      document.getElementById('saveAlbumError').innerText = response.data.error;
      return;
    }
    if(response.data.success) {
      console.log("response: ", response);
      location.reload(true);
    }
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