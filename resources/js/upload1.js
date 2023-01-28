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
  });
  console.log(id);
}
const deleteAlbumButton = document.getElementById('deleteAlbumButton');
if(deleteAlbumButton) {
  deleteAlbumButton.addEventListener('click', deleteAlbum);
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
  axios.put('/upload/albums/photo-edit', {
    photoid: id,
    action: action
  }).then(function (response) {
    if(response.data.test) {
      console.log("response: ", response.data);
      return;
    }
    if(response.data.error) {
      console.log(response.data.error);
      return;
    }
    if(response.data.success) {
      updateImageDisplay(document.getElementById('bigDisplay').src);
      console.log(response.data);
      return;
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

function updateImageDisplay(src) {
  src = src.split(".jpg")[0] + ".jpg";
  let imgs = document.querySelectorAll("img");
  for(let i = 0; i < imgs.length; i++) {
    if(imgs[i].src.startsWith(src)) {
      imgs[i].src = src + "?t=" + new Date().getTime();
    }
  }
}

const alertBox = document.getElementById('alertBox');
if(alertBox) {
  setTimeout(destroyAlertBox, 10000);
}

function destroyAlertBox() {
  document.getElementById('alertBox').remove();
}

const deleteButtons = document.querySelectorAll('.deleteBtn');
if(deleteButtons) {
  for(let i = 0; i < deleteButtons.length; i++) {
    deleteButtons[i].addEventListener('click', function() {
      deleteImage(deleteButtons[i].dataset.photoid)
    })
  }
}

function deleteImage(imageid) {
  const url = "/upload/photos/" + imageid;
  axios.delete(url).then(function (response) {
    if(response.data.error) {
      console.log(response.data);
      return;
    }
    if(response.data.success) {
      console.log(response.data.success);
      const photoDivs = document.querySelectorAll('.photoListItem');
      for(let i = 0; i < photoDivs.length; i++) {
        if(photoDivs[i].dataset.photoid == imageid){
          photoDivs[i].remove();
          return;
        }
      }
      console.error("div niet gevonden");
    }
  });
}

function clickPhotosButton() {
  document.getElementById('photos').click();
}

const photosButton = document.getElementById('photosButton');
if(photosButton) {
  photosButton.addEventListener('click', clickPhotosButton);
}

const photosInput = document.getElementById('photos');
if(photosInput) {
  photosInput.addEventListener('change', uploadButtonAction);
}

function uploadButtonAction() {
  //change label on change
  const amount = photosInput.files.length;
  const fotos = amount > 1 || amount == 0 ? "foto's" : "foto";
  const label = document.getElementById('photosButtonLabel');
  const labelStr = amount + " " + fotos + " geselecteerd.";
  label.innerText = labelStr;
  //enable uploadbutton 
  const uploadSubmit = document.getElementById('uploadSubmit');
  if(amount > 0) {
    uploadSubmit.disabled = false;
  }
}

const linkInput = document.getElementById("photoPageLink");
if(linkInput) {
  linkInput.value = pageLink;
}

const linkButton = document.getElementById("photoPageLinkButton");
if(linkButton) {
  linkButton.addEventListener('click', updateClipboard);
}

function updateClipboard() {
  const newClip = linkInput.value;
  navigator.clipboard.writeText(newClip).then(() => {
    linkButton.classList.add("copied");
    linkButton.innerText = "gekopieerd";
  }, (err) => {
    console.error("copying failed with error: ", err);
  });
}
