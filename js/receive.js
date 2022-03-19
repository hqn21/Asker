function showDeleteMailModal(mailId) {
    var mailContent = $("#" + mailId + "-content").text();
    $("#mailId").val(mailId);
    $("#mailContent").val(mailContent);
    $("#deleteMailData").text("您確認要刪除信件「" + mailContent + "」嗎？");
    $("#deleteMailModal").modal("show");
}

function deleteMail() {
    var mailId = $("#mailId").val();
    var mailContent = $("#mailContent").val();
    $.ajax({
        type: "POST",
        url: "php/main.php",
        dataType: "json",
        data: {
            mode: "deleteMail",
            mailId: mailId,
            mailContent: mailContent
        },
        success: function(data) {
            $("#deleteMailModal").modal("hide");
            $("#deleteMailNotifyData").text(data["message"]);
            $("#deleteMailNotifyModal").modal("show");
            if(data["status"] == 1) {
                $("#" + mailId + "-card").remove();
                $("#mailCount").text(parseInt($("#mailCount").text())- 1);
            }
        }
    });
}