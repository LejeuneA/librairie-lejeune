/* -------------------------------------------------------
                 Adding components in Html
---------------------------------------------------------*/
document.addEventListener("DOMContentLoaded", function () {
    var includes = document.querySelectorAll('[data-include]');

    includes.forEach(function (element) {
        var file = '../components/' + element.getAttribute('data-include') + '.html';

        // Fetch the HTML content
        fetch(file)
            .then(response => response.text())
            .then(data => {
                // Insert the HTML content into the element
                element.innerHTML = data;
            })
            .catch(error => console.error('Error fetching ' + file, error));
    });
});



/* -------------------------------------------------------
                    Offcanvas menu
---------------------------------------------------------*/
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}


/* -------------------------------------------------------
                 Initialize Swiper
---------------------------------------------------------*/
var swiper = new Swiper(".mySwiper", {
    slidesPerView: 6,
    spaceBetween: 3,
    // centeredSlides: true,
    loop: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    // Responsive breakpoints
    breakpoints: {
        0: {
            slidesPerView: 1,
            spaceBetween: 20
        },
        // when window width is >= 320px
        320: {
            slidesPerView: 2,
            spaceBetween: 20
        },
        // when window width is >= 480px
        480: {
            slidesPerView: 2,
            spaceBetween: 30
        },
        // when window width is >= 640px
        640: {
            slidesPerView: 3,
            spaceBetween: 40
        },
        // when window width is >= 768px
        768: {
            slidesPerView: 4,
            spaceBetween: 40
        },
        // when window width is >= 1024px
        1024: {
            slidesPerView: 5,
            spaceBetween: 50
        }
    }
});

/* -------------------------------------------------------
                 mage preview
---------------------------------------------------------*/
function previewImage(input) {
    var preview = document.getElementById('image_preview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}