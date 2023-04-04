$(document).ready(function () {
    //  SLIDER
    var slider = $("#slider-wp .section-detail");
    slider.owlCarousel({
        autoPlay: 4500,
        navigation: false,
        navigationText: false,
        paginationNumbers: false,
        pagination: true,
        items: 1, //10 items above 1000px browser width
        itemsDesktop: [1000, 1], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 1], // betweem 900px and 601px
        itemsTablet: [600, 1], //2 items between 600 and 0
        itemsMobile: true, // itemsMobile disabled - inherit from itemsTablet option
    });

    //  LIST THUMB
    var list_thumb = $("#list-thumb");
    list_thumb.owlCarousel({
        navigation: true,
        navigationText: false,
        paginationNumbers: false,
        pagination: false,
        stopOnHover: true,
        items: 5, //10 items above 1000px browser width
        itemsDesktop: [1000, 5], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 5], // betweem 900px and 601px
        itemsTablet: [768, 5], //2 items between 600 and 0
        itemsMobile: true, // itemsMobile disabled - inherit from itemsTablet option
    });

    //  FEATURE PRODUCT
    var feature_product = $("#feature-product-wp .list-item");
    feature_product.owlCarousel({
        autoPlay: true,
        navigation: true,
        navigationText: false,
        paginationNumbers: false,
        pagination: false,
        stopOnHover: true,
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 4], //5 items between 1000px and 901px
        itemsDesktopSmall: [800, 3], // betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0
        itemsMobile: [375, 1], // itemsMobile disabled - inherit from itemsTablet option
    });

    //  SAME CATEGORY
    var same_category = $("#same-category-wp .list-item");
    same_category.owlCarousel({
        autoPlay: true,
        navigation: true,
        navigationText: false,
        paginationNumbers: false,
        pagination: false,
        stopOnHover: true,
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 4], //5 items between 1000px and 901px
        itemsDesktopSmall: [800, 3], // betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0
        itemsMobile: [375, 1], // itemsMobile disabled - inherit from itemsTablet option
    });

    //  SCROLL TOP
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $("#btn-top").stop().fadeIn(150);
        } else {
            $("#btn-top").stop().fadeOut(150);
        }
    });
    $("#btn-top").click(function () {
        $("body,html").stop().animate({ scrollTop: 0 }, 800);
    });

    // CHOOSE NUMBER ORDER
    var value = parseInt($("#num-order").attr("value"));
    $("#plus").click(function () {
        var url = $("#num-order").attr("data-url");
        value++;
        url = url + "/" + value;
        $(".add-cart-detail").attr("href", url);
         $("#num-order").attr("value", value);
    });
    $("#minus").click(function () {
        if (value > 1) {
            var url = $("#num-order").attr("data-url");
            value--;
            url = url + "/" + value;
            $(".add-cart").attr("href", url);
            $("#num-order").attr("value", value);
        }
    });

    //  MAIN MENU
    $("#category-product-wp .list-item > li")
        .find(".sub-menu")
        .after('<i class="fa fa-angle-right arrow" aria-hidden="true"></i>');

    //  TAB
    tab();

    //  EVEN MENU RESPON
    $("html").on("click", function (event) {
        var target = $(event.target);
        var site = $("#site");

        if (target.is("#btn-respon i")) {
            if (!site.hasClass("show-respon-menu")) {
                site.addClass("show-respon-menu");
            } else {
                site.removeClass("show-respon-menu");
            }
        } else {
            $("#container").click(function () {
                if (site.hasClass("show-respon-menu")) {
                    site.removeClass("show-respon-menu");
                    return false;
                }
            });
        }
    });

    //  MENU RESPON
    $("#main-menu-respon li .sub-menu").after(
        '<span class="fa fa-angle-right arrow"></span>'
    );
    $("#main-menu-respon li .arrow").click(function () {
        if ($(this).parent("li").hasClass("open")) {
            $(this).parent("li").removeClass("open");
        } else {
            //            $('.sub-menu').slideUp();
            //            $('#main-menu-respon li').removeClass('open');
            $(this).parent("li").addClass("open");
            //            $(this).parent('li').find('.sub-menu').slideDown();
        }
    });

    // search ajax
    $("#s").keyup(function () {
        $(".result-ajax-search").show();
        var search = $(this).val();
        var urlOrigin = "https://vsmart.com/Vsmart";
        var url = $(this).attr("data-url");
        var html = "";
        $url_detail = $(this).attr("data-detail");

        if (search != "") {
            $.ajax({
                type: "GET",
                url: url + "?key_search=" + search,
                success: function (response) {
                    response.data.forEach((product) => {
                        html += "<div class='item'>";
                        html +=
                            "<a href='" +
                            $url_detail +
                            "/" +
                            product.slug +
                            ".html'>";
                        html +=
                            "<img src='" +
                            urlOrigin +
                            product.product_thumb +
                            "'>";
                        html += "</a>";
                        html +=
                            " <a href='" +
                            $url_detail +
                            "/" +
                            product.slug +
                            ".html' title='' class='product-name'>" +
                            product.name +
                            "</a>";
                        html += "</div>";
                    });
                    $(".result-ajax-search").html(html);
                },
                error: function (jqXHR, textStatus, errorThrown) {},
            });
        } else {
            $(".result-ajax-search").hide();
        }
    });

    // add-cart
    $(".add-cart").click(function (e) {
        e.preventDefault();
        var url = $(this).attr("data-url");
        var that = $(this);
        Swal.fire({
            title: '<span style="font-size:20px;">Đã thêm sản phẩm vào giỏ hàng</span>',
            icon: "success",
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: "Xem giỏ hàng và thanh toán",
            cancelButtonText: "Tiếp tuc mua sắm",
        }).then((result) => {
            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                    if (result.isConfirmed) {
                        window.location = that.attr("href");
                    } else {
                        var url = $("#dropdown").attr("data-asset");
                        var urlShowCat = $("#dropdown").attr("data-showCat");
                        var urlCheckOut = $("#dropdown").attr("data-checkout");
                        $("span#num").text(Object.keys(response.data).length);
                        var html = "";
                        html +=
                            '<p class="desc">Có <span class="num_header">' +
                            Object.keys(response.data).length +
                            " sản phẩm</span> trong giỏ hàng</p>";
                        html += '<ul class="list-cart">';
                        $.each(response.data, function (key, value) {
                            var name;
                            if (value.name.length > 20) {
                                name = value.name.substr(0, 20) + "...";
                            } else {
                                name = value.name;
                            }
                            html += '<li class="clearfix">';
                            html +=
                                ' <a href="" title="" class="thumb fl-left">';
                            html +=
                                '<img src="' +
                                url +
                                "/" +
                                value.options.product_thumb +
                                '" alt="">';
                            html += "</a>";
                            html += ' <div class="info fl-right">';
                            html +=
                                '<a href="" title="" class="product-name">' +
                                name +
                                "</a>";
                            html +=
                                '<p class="price">' +
                                value.price
                                    .toFixed(0)
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",") +
                                "đ</p>";
                            html += ' <p class="qty">Số lượng: ';
                            html +=
                                '<span class="qty_header-' +
                                value.rowId +
                                '">' +
                                value.qty +
                                "</span>";
                            html += "</p>";
                            html += "</div>";
                            html += "</li>";
                        });
                        html += "</ul>";
                        html += '<div class="total-price clearfix">';
                        html += '<p class="title fl-left">Tổng:</p>';
                        html +=
                            '<p class="price fl-right">' +
                            response.total +
                            "đ</p>";
                        html += "</div>";
                        html += '<div class="action-cart clearfix">';
                        html +=
                            ' <a href="' +
                            urlShowCat +
                            '" title="Giỏ hàng" class="view-cart fl-left">Giỏ hàng</a>';
                        html +=
                            ' <a href="' +
                            urlCheckOut +
                            '" title="Thanh toán" class="checkout fl-right">Thanh toán</a>';
                        html += "</div>";

                        $("#dropdown").html(html);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {},
            });
        });
    });
    $(".btn-delete").click(function (e) {
        e.preventDefault();
        var url = $(this).attr("data-url");
        var _this = $(this);
        Swal.fire({
            title: "Bạn có chắc chắn muốn xóa không?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ok",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({    
                    type: "get",
                    url: url,
                    success: function (response) {
                        if (response.data == "error") {
                            Swal.fire({
                                icon: "error",
                                text: response.message,
                            });
                        } else if (response.data == "destroy") {
                            Swal.fire("Xoá!", "Xoá thành công", "success").then(
                                (result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                }
                            );
                        } else {
                            var x = _this.parent().parent().parent();
                            _this.parent().parent().remove();
                            if (x.children("tr") == true) {
                                Swal.fire("Xoá!", "Xoá thành công", "success");
                            } else {
                                Swal.fire(
                                    "Xoá!",
                                    "Xoá thành công",
                                    "success"
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        //xử lý lỗi tại đây
                    },
                });
            }
        });
    });
});
  
function tab() {
    var tab_menu = $("#tab-menu li");
    tab_menu.stop().click(function () {
        $("#tab-menu li").removeClass("show");
        $(this).addClass("show");
        var id = $(this).find("a").attr("href");
        $(".tabItem").hide();
        $(id).show();
        return false;
    });
    $("#tab-menu li:first-child").addClass("show");
    $(".tabItem:first-child").show();
}
