$(document).ready(function () {
    
    $('.nav-link.active .sub-menu').slideDown();
    // $("p").slideUp();

    $('#sidebar-menu .arrow').click(function () {
        $(this).parents('li').children('.sub-menu').slideToggle();
        $(this).toggleClass('fa-angle-right fa-angle-down');
    });

   //xử lý poup thông báo
    $("a.btn-delete").click(function (e) {
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
    // $("input[name='checkall']").click(function() {
    //     var checked = $(this).is(':checked');
    //     $('.table-checkall tbody tr td input:checkbox').prop('checked', checked);
    // });

    $("input[name='checkall']").click(function () {
        // alert('ok')
        var checked = $(this).is(":checked");
        $(".table-checkall tbody tr td input:checkbox").prop("checked", checked);
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

    //chọn quyền
    $('.select2_init').select2({
        'placeholder': 'Chọn quyền'
    });




});


//Javascript



