
$(document).ready(function () {
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 3,
            },
            1000: {
                items:4,
            },
        },
    });

});
var images = document.querySelectorAll(".img_small li img");
var img_big = document.querySelector(".img_big img");
var gallery = document.querySelector(".gallery");
var galleryImg = document.querySelector(".gallery .inner img");
var closeButton = document.querySelector(".gallery .close");
var prevButton = document.querySelector(".gallery .prev");
var nextButton = document.querySelector(".gallery .next");
var content = document.querySelector("#site");
img_big.addEventListener("click", function () {
    var attr_img_big = this.getAttribute("src");
    galleryImg.setAttribute("src", attr_img_big);
    gallery.classList.add("show");
    prevButton.style.display = "none";
    nextButton.style.display = "none";
    content.style.display = "none";
});
closeButton.addEventListener("click", function () {
    gallery.classList.remove("show");
    content.style.display = "block";
});

// js
document.addEventListener('keydown',function(e){
    if (e.keyCode === 27) {
        gallery.classList.remove("show");
        content.style.display = "block";
    }
})

var current_index = 0;
images.forEach(function (item, index) {
    item.addEventListener("click", function () {
        current_index = index;
        showImg();
        var attr_img = this.getAttribute("src");
        galleryImg.setAttribute("src", attr_img);
        gallery.classList.add("show");
        content.style.display = "none";
    });
});
function showImg(){
    if (current_index <= 0){
        prevButton.style.display = "none";
        if(images.length>1){
            nextButton.style.display = "block";
        }else{
            nextButton.style.display = "none";
        }
    }
    else if(current_index >= images.length - 1) {
        nextButton.style.display = "none";
        prevButton.style.display = "block";
    } else {
        prevButton.style.display = "block";
        nextButton.style.display = "block";
    }
}
prevButton.addEventListener("click", function () {
    current_index--;
    showImg();
    var attr_img = images[current_index].getAttribute("src");
        galleryImg.setAttribute("src", attr_img);
});
nextButton.addEventListener("click", function () {
    current_index++;
    showImg();
    var attr_img = images[current_index].getAttribute("src");
        galleryImg.setAttribute("src", attr_img);
});


document.querySelector('#post-product-wp .product_desc').style.height="auto";
var heightProductDesc=document.querySelector('#post-product-wp .product_desc').offsetHeight;
document.querySelector('#post-product-wp .product_desc').style.height="450px";
if(heightProductDesc<=450){
    document.querySelector('.see-next').style.display='none';
}else{
    document.querySelector('.see-next').style.display='block';
}

// button xem them
document.querySelector('.see-next span').addEventListener('click',function(){
    document.querySelector('#post-product-wp .product_desc').style.height='auto';
    document.querySelector('#post-product-wp .product_desc').style.overflow='auto';
    this.parentElement.style.display='none';
});



function tab() {
    var tab_menu = $('#tab-menu li');
    tab_menu.stop().click(function () {
        $('#tab-menu li').removeClass('show');
        $(this).addClass('show');
        var id = $(this).find('a').attr('href');
        $('.tabItem').hide();
        $(id).show();
        return false;
    });
    $('#tab-menu li:first-child').addClass('show');
    $('.tabItem:first-child').show();
}

// const { countBy } = require("lodash");
