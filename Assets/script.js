// Image Preview
const preview = document.getElementById("imagePreview");
const image = document.getElementById("user_upload");
const label = document.getElementById("upload_label");

image.addEventListener("change", () => {
 let file = image.files[0];
 const filesize = 3 * 1024 * 1024;
 if(file['type'] == "image/jpeg" || file['type'] == "image/png" || file['type'] == "image/jpg") {
  if (file['size'] <= filesize) {
    const reader = new FileReader();
    reader.onload = () => {
      preview.src = reader.result;
    }
    reader.readAsDataURL(file);
    label.innerHTML = "<span class='text-success'>Upload Successfully</span>";
  }else {
    preview.src = "./users_pictures/avatar.jpg";
    image.value = "";
    label.innerHTML = "<span class='text-danger'>File size should not exceed 3MB</span>";
  }
 }

});