$(document).ready(function () {
    $(".num-order").change(function () {
        var qty = $(this).val();
        var url = $(this).attr("data-url");
      
        $.ajax({
            url: url,
            type: "POST",
            data: {
                qty: qty,
            },
            success: function (response) {
                // alert(qty);
                $(".sub_total-" + response.rowId).text(response.sub_total);
                $("span.total_price").text(response.total);
                $("span.qty_header-"+ response.rowId).text(qty);
            },
            error: function (jqXHR, textStatus, errorThrown) {},
        });
    });

 
  
});
