var passwordShow = [0, 0, 0];

function logout() {
    // 將按鈕轉為不可用
    $("#logoutSubmit").addClass("disabled");
    $("#logoutSubmitMessage").html('　<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');       

    $.ajax({
        type: "POST",
        url: "php/main.php",
        dataType: "json",
        data: {
            mode: "logout"
        },
        success: function(data) {
            $("#settingData").text(data["message"]);
            $("#settingModal").modal("show");
            if(data["status"] == 1) {
                window.setTimeout((() => window.location = 'login'), 5000);
            }
        }
    });
}

function settingSave() {
    // 將按鈕轉為不可用
    $("#settingSubmit").addClass("disabled");
    $("#settingSubmitMessage").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');

    var nickname = $("#nickname").val();
    var statusMessage = $("#statusMessage").val();
    var accept;
    if($("#accept").prop("checked")) {
        accept = 1;
    }
    else {
        accept = 0;
    }
    if(nickname.length > 10) {
        $("#nickname").removeClass("is-valid");
        $("#nickname").addClass("is-invalid");
        $("#nickname-notice").css("display", "none");
    }
    else {
        $("#nickname").removeClass("is-invalid");
        $("#nickname").addClass("is-valid");
        $("#nickname-notice").css("display", "none");
    }
    if(statusMessage.length > 20) {
        $("#statusMessage").removeClass("is-valid");
        $("#statusMessage").addClass("is-invalid");
        $("#statusMessage-notice").css("display", "none");
    }
    else {
        $("#statusMessage").removeClass("is-invalid");
        $("#statusMessage").addClass("is-valid");
        $("#statusMessage-notice").css("display", "none");
    }
    if($("#nickname").hasClass("is-valid") && $("#statusMessage").hasClass("is-valid")) {
        $.ajax({
            type: "POST",
            url: "php/main.php",
            dataType: "json",
            data: {
                mode: "settingSave",
                nickname: nickname,
                statusMessage: statusMessage,
                accept: accept
            },
            success: function(data) {
                switch(data["id"]) {
                    case 0:
                        $("#nickname").val(data["nickname"]);
                        $("#statusMessage").val(data["statusMessage"]);
                        if(data["accept"] == 1) {
                            $("#accept").addClass("checked");
                        }
                        else {
                            $("#accept").removeClass("checked");
                        }
                        break;
                    case 2:
                        window.setTimeout((() => window.location = "login"), 5000)
                        break;

                }
                // Modal 部分
                $("#settingData").text(data["message"]);
                $("#settingModal").modal("show");
            }
        });
    }
    // 將按鈕轉為可用
    $("#settingSubmit").removeClass("disabled");
    $("#settingSubmitMessage").html("儲存變更");
}

function changePassword() {
    var oldPassword = $("#oldPassword").val();
    var password = $("#password").val();
    var password_recheck = $("#password-recheck").val();
    if(oldPassword.length > 18 || oldPassword.length < 6) {
        $("#oldPassword").removeClass("is-valid");
        $("#oldPassword").addClass("is-invalid");
        $("#oldPassword-notice").css("display", "none");
    }
    else {
        $("#oldPassword").removeClass("is-invalid");
        $("#oldPassword").addClass("is-valid");
        $("#oldPassword-notice").css("display", "none");
    }
    if(password.length > 18 || password.length < 6) {
        $("#password").removeClass("is-valid");
        $("#password").addClass("is-invalid");
        $("#password-notice").css("display", "none");
    }
    else {
        $("#password").removeClass("is-invalid");
        $("#password").addClass("is-valid");
        $("#password-notice").css("display", "none");
        if(password_recheck !== password) {
            $("#password-recheck").removeClass("is-valid");
            $("#password-recheck").addClass("is-invalid");
            $("#password-recheck-notice").css("display", "none");
        }
        else {
            $("#password-recheck").removeClass("is-invalid");
            $("#password-recheck").addClass("is-valid");
            $("#password-recheck-notice").css("display", "none");
        }
    }
    if($("#oldPassword").hasClass("is-valid") && $("#password").hasClass("is-valid") && $("#password-recheck").hasClass("is-valid")) {
        $.ajax({
            type: "POST",
            url: "php/main.php",
            dataType: "json",
            data: {
                mode: "changePassword",
                oldPassword: oldPassword,
                password: password
            },
            success: function(data) {
                // 隱藏 changePasswordModal 並展示出 changePasswordNotifyModal
                $("#changePasswordModal").modal("hide");
                $("#changePasswordNotifyData").text(data["message"]);
                $("#changePasswordNotifyModal").modal("show");
                // 將所有欄位的值清空
                $("#oldPassword").val("");
                $("#password").val("");
                $("#password-recheck").val("");
                // 將所有欄位的正確標示移除
                $("#oldPassword").removeClass("is-valid");
                $("#password").removeClass("is-valid");
                $("#password-recheck").removeClass("is-valid");
                // 顯示所有欄位的提示語
                $("#oldPassword-notice").css("display", "");
                $("#password-notice").css("display", "");
                $("#password-recheck-notice").css("display", "");
                // 成功
                if(data["status"] == 1) {
                    $("#changePasswordNotifyModalButton").attr("onclick", "$('#changePasswordNotifyModal').modal('hide');");
                }
                // 失敗
                else if(data["status"] == 0) {
                    $("#changePasswordNotifyModalButton").attr("onclick", "$('#changePasswordNotifyModal').modal('hide'); $('#changePasswordModal').modal('show');");
                }
            }
        });
    }
}
function togglePasswordShow(id) {
    switch(id) {
        case "oldPassword-show":
            if(passwordShow[0] == 0) {
                $("#oldPassword").attr("type", "text");
                $("#oldPassword-show").html('<i class="fa-solid fa-eye"></i>');
                passwordShow[0] = 1;
            }
            else {
                $("#oldPassword").attr("type", "password");
                $("#oldPassword-show").html('<i class="fa-solid fa-eye-slash"></i>');
                passwordShow[0] = 0;
            }
            break;
        case "password-show":
            if(passwordShow[1] == 0) {
                $("#password").attr("type", "text");
                $("#password-show").html('<i class="fa-solid fa-eye"></i>');
                passwordShow[1] = 1;
            }
            else {
                $("#password").attr("type", "password");
                $("#password-show").html('<i class="fa-solid fa-eye-slash"></i>');
                passwordShow[1] = 0;
            }
            break;
        case "password-recheck-show":
            if(passwordShow[2] == 0) {
                $("#password-recheck").attr("type", "text");
                $("#password-recheck-show").html('<i class="fa-solid fa-eye"></i>');
                passwordShow[2] = 1;
            }
            else {
                $("#password-recheck").attr("type", "password");
                $("#password-recheck-show").html('<i class="fa-solid fa-eye-slash"></i>');
                passwordShow[2] = 0;
            }
            break;
    }
}