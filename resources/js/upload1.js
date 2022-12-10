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

const photoList = document.getElementById('photoListDiv');

if(photoList) {
  let photoItems = photoList.querySelectorAll(".photoListItem");
  for(let i = 0; i < photoItems.length; i++) {
    photoItems[i].addEventListener('click', function() {
      displayBig(photoItems[i].dataset.filename, photoItems[i].dataset.photoid);
      });
  }
}

function displayBig(filename, photoid) {
  
  const photoSrc = folder + "/" + filename;
  let disp = document.getElementById("bigDisplay");
  disp.src = photoSrc;
  disp.dataset.photoid = photoid;
}

function editImage(action) {
  const id = +document.getElementById('bigDisplay').dataset.photoid;
  console.log(id);
  axios.put('/upload/albums/photo-edit', {
    photoid: id,
    action: action
  }).then(function (response) {
    console.log(response);
    if(response.data.test) {
      console.log("response: ", response.data);
      // console.log(response.data.test);
      return;
    }
    if(response.data.error) {
      console.log(response.data.error);
      return;
    }
    if(response.data.success) {
      console.log("response: ", response);
      location.reload(true);
    }
  });
}

const bottomLeft = document.getElementById('brleft');
if(bottomLeft) {
  bottomLeft.addEventListener('click', function () {
    editImage("rotateLeft");
  });
}

const bottomRight = document.getElementById('brright');
if(bottomRight) {
  bottomRight.addEventListener('click', function () {
    editImage("rotateRight");
  });
}