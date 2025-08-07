$(document).on("click",".pay",function (e) {
    e.preventDefault();
    var invoiceId = $(this).data("id");
    $.ajax({
        url: "/invoices/" + invoiceId,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            if(response.success){
                window.location.href = "https://dev.toyyibpay.com/" + response.billcode;
            }
        },
        error: function (xhr) {
            // Handle error
        }
    });
});
