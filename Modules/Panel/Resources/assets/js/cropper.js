import Cropper from "cropperjs";
import "cropperjs/dist/cropper.min.css";

window.Cropper = Cropper;

window.addEventListener("avatarChanged", function (e) {
    const avatar = document.querySelector("#user-avatar");
    avatar.src = e.detail[0].url;
});
