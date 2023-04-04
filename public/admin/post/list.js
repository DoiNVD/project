$(document).ready(function () {
    $(".action_edit").click(function (e) {
        e.preventDefault();
        $(".opacity").css("display", "block");
        $(".edit_ajax").css("display", "block");
        var url = $(this).attr("data-urlEdit");
        var urlUpdateTemporary = $("#form-edit").attr(
            "data-urlUpdateTemporary"
        );
        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
                //đưa dữ liệu controller gửi về điền vào input trong form edit.
                $("#name_ajax").val(response.data.name);
                $("#slug_ajax").val(response.data.slug);
                if (response.data.status == 0) {
                    $("#status_ajax1").prop("checked", true);
                } else {
                    $("#status_ajax2").prop("checked", true);
                }

                $("#form-edit").attr(
                    "data-urlUpdate",
                    urlUpdateTemporary + "/" + response.data.id
                );
            },
            error: function (error) {},
        });
    });

    ///Cập nhật danh mục ajax
    $("#form-edit").validate({
        onfocusout: false,
		onkeyup: false,
		onclick: false,
		rules: {
			"name_ajax": {
				required: true,
				
			},
			"slug_ajax": {
				required: true,
				// minlength: 8
			},
		},
		messages: {
			"name_ajax": {
				required: "Tên không được để trống",
				// maxlength: "Hãy nhập tối đa 15 ký tự"
			},
			"slug_ajax": {
				required: "slug không được để trống",
				// minlength: "Hãy nhập ít nhất 8 ký tự"
			},
		},
        submitHandler: function(form) {
            $("#form-edit").submit(function(e) {
                e.preventDefault();
                let url_update = $(this).attr("data-urlUpdate");
                var status_value;
                if ($("#status_ajax1").is(":checked")) {
                    status_value = 0;
                } else {
                    status_value = 1;
                }
        
                $.ajax({
                    type: "post",
                    url: url_update,
                    data: {
                        name: $("#name_ajax").val(),
                        slug: $("#slug_ajax").val(),
                        status: status_value,
                    },
                        success: function(response) {
                      
                            $(".opacity").css("display", "none");
                            $(".edit_ajax").css("display", "none");
                            var beforeName = "---".repeat(response.data.level);
                            $("#name-" + response.data.id).text(
                                beforeName + response.data.name
                            );
                            if (response.data.status == 1) {
                                $("#status-" + response.data.id).html(
                                    "<span class='badge badge-primary'>Công khai</span>"
                                );
                            } else {
                                $("#status-" + response.data.id).html(
                                    "<span class='badge badge-warning'>Chờ duyệt</span>"
                                );
                            }
                            $("#created_at-" + response.data.id).html(
                                response.data.created_at
                            );
                            Swal.fire({
                                position: "center-center",
                                icon: "success",
                                title: "Bạn đã cập nhật thành công",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            //  location.reload();
                        },
                        error: function() {},
                });
            });
          }
	});

    $("#btn-close").click(function (e) {
        e.preventDefault();
        $(".opacity").css("display", "none");
        $(".edit_ajax").css("display", "none");
    });


   
    
//  const { post } = require("jquery");
});

