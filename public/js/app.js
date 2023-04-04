$(document).ready(function () {
    $(".nav-link.active .sub-menu").slideDown();
    // $("p").slideUp();

    $("#sidebar-menu .arrow").click(function () {
        $(this).parents("li").children(".sub-menu").slideToggle();
        $(this).toggleClass("fa-angle-right fa-angle-down");
    });

    $("input[name='checkall']").click(function () {
        var checked = $(this).is(":checked");
        $(".table-checkall tbody tr td input:checkbox").prop(
            "checked",
            checked
        );
    });
    $(".checkbox_parent").click(function () {
        var checked = $(this).is(":checked");
        $(this)
            .parents(".card-checkbox")
            .find(".checkbox_child")
            .prop("checked", checked);
    });
    $("#check_all").click(function () {
        var checked = $(this).is(":checked");
        $(this)
            .parents(".card-body")
            .find(".checkbox_parent")
            .prop("checked", checked);
        $(this)
            .parents(".card-body")
            .find(".checkbox_child")
            .prop("checked", checked);
    });

    $(".btn-delete").click(function (e) {
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
                        } else {
                            _this.parent().parent().remove();
                            Swal.fire("Xoá!", "Xoá thành công", "success");
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
function ChangeToSlug($class1, $class2) {
    var slug;
    $class1 = "." + $class1;
    $class2 = "." + $class2;
    //Lấy text từ thẻ input title
    slug = document.querySelector($class1).value;
    slug = slug.toLowerCase();
    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, "a");
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, "e");
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, "i");
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, "o");
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, "u");
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, "y");
    slug = slug.replace(/đ/gi, "d");
    //Xóa các ký tự đặt biệt
    slug = slug.replace(
        /\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi,
        ""
    );
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, "-");
    slug = slug.replace(/\-\-\-\-/gi, "-");
    slug = slug.replace(/\-\-\-/gi, "-");
    slug = slug.replace(/\-\-/gi, "-");
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = "@" + slug + "@";
    slug = slug.replace(/\@\-|\-\@|\@/gi, "");
    //In slug ra textbox có id “slug”
    document.querySelector($class2).value = slug;
}
