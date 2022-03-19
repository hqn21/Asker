function mailSend() {
    var account = $("#account").val();
    var mailContent = $("#mailContent").val();
    if(mailContent.length > 100 || mailContent.length < 1) {
        $("#mailContent").removeClass("is-valid");
        $("#mailContent").addClass("is-invalid");
        $("#mailContent-notice").css("display", "none");
    }
    else {
        $("#mailContent").removeClass("is-invalid");
        $("#mailContent").addClass("is-valid");
        $("#mailContent-notice").css("display", "none");
    }
    if($("#mailContent").hasClass("is-valid")) {
        $.ajax({
            type: "POST",
            url: "https://ask.haoquan.me/php/main.php",
            dataType: "json",
            data: {
                mode: "mailSend",
                account: account,
                mailContent: mailContent
            },
            success: function(data) {
                if(data["status"] == 1) {
                    $("#mailContent").val("");
                }
                $("#mailContent").removeClass("is-valid");
                $("#mailContent").removeClass("is-invalid");
                $("#mailContent-notice").css("display", "");
                $("#askModal").modal("hide");
                $("#askNotifyData").text(data["message"]);
                $("#askNotifyModal").modal("show");
            }
        });
    }
}