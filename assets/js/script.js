console.log("Welcome to JC Barley Business Website!");

/*
|--------------------------------------------------------------------------
| Gallery Preview
|--------------------------------------------------------------------------
*/

const galleryImages = document.querySelectorAll(".gallery-container img");

const modal = document.getElementById("galleryModal");
const preview = document.getElementById("galleryPreview");
const close = document.getElementById("closeGallery");

if (modal && preview && close && galleryImages.length > 0) {

    galleryImages.forEach(function(img){

        img.onclick = function(){

            modal.style.display = "flex";
            preview.src = this.src;

        };

    });

    close.onclick = function(){

        modal.style.display = "none";

    };

    modal.onclick = function(e){

        if(e.target === modal){

            modal.style.display = "none";

        }

    };

}