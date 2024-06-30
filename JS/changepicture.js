function triggerFileInput() {
  // Trigger the hidden file input
  document.getElementById("fileInput").click();
}

function displaySelectedImage() {
  // Preview Gambar sebelum submit dalam profile picture punya space
  var input = document.getElementById("fileInput");
  var img = document.getElementById("profileImage");

  var reader = new FileReader();
  reader.onload = function (e) {
    img.src = e.target.result;
  };

  reader.readAsDataURL(input.files[0]);
}
