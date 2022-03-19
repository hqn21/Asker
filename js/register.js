var passwordShow = [0, 0];

function register() {
    // 按扭轉為不可用
    $("#registerSubmit").addClass("disabled");
    $("#registerSubmitMessage").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');

    var account = $("#account").val();
    // var email = $("#email").val();
    var password = $("#password").val();
    var password_recheck = $("#password-recheck").val();

    // var englishRule = /^[A-Za-z]+$/;
    // var numberRule = /^[0-9]+$/;
    var passwordRule = /^[A-Za-z0-9]+$/;
    var specialRule = /^[\d|a-zA-Z]+$/;
    // var emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;

    // 帳號名稱轉小寫
    account = account.toLowerCase();
    $("#account").val(account);

    // 帳號名稱驗證
    if(!specialRule.test(account) || account.length > 16 || account.length < 4) {
        $("#account").removeClass("is-valid");
        $("#account").addClass("is-invalid");
        $("#account-notice").css("display", "none");
    }
    else {
        $("#account").removeClass("is-invalid");
        $("#account").addClass("is-valid");
        $("#account-notice").css("display", "none");
    }

    // Email 驗證
    // if(!emailRule.test(email)) {
    //     $("#email").removeClass("is-valid");
    //     $("#email").addClass("is-invalid");
    //     $("#email-notice").css("display", "none");
    // }
    // else {
    //     $("#email").removeClass("is-invalid");
    //     $("#email").addClass("is-valid");
    //     $("#email-notice").css("display", "none");
    // }

    // 密碼驗證
    if(!passwordRule.test(password) || password.length > 18 || password.length < 6) {
        $("#password").removeClass("is-valid");
        $("#password").addClass("is-invalid");
        $("#password-notice").css("display", "none");
    }
    else {
        $("#password").removeClass("is-invalid");
        $("#password").addClass("is-valid");
        $("#password-notice").css("display", "none");

        // 再次輸入密碼驗證
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

    if($("#account").hasClass("is-valid") && $("#password").hasClass("is-valid") && $("#password-recheck").hasClass("is-valid")) { // $("#email").hasClass("is-valid")
        $.ajax({
            type: "POST",
            url: "php/main.php",
            dataType: "json",
            data: {
                mode: "register",
                account: account,
                // email: email,
                password: password
            },
            success: function(data) {
                $("#registerData").text(data["message"]);
                $("#registerModal").modal("show");
                if(data["status"] == 1) {
                    $("#registerSubmit").addClass("disabled");
                    $("#registerSubmitMessage").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');
                    window.setTimeout((() => window.location = "receive"), 5000);
                }
            }
        })
    }

    // 將按扭轉為可用
    $("#registerSubmit").removeClass("disabled");
    $("#registerSubmitMessage").html('註冊');
}

function togglePasswordShow(id) {
    switch(id) {
        case "password-show":
            if(passwordShow[0] == 0) {
                $("#password").attr("type", "text");
                $("#password-show").html('<i class="fa-solid fa-eye">');
                passwordShow[0] = 1;
            }
            else {
                $("#password").attr("type", "password");
                $("#password-show").html('<i class="fa-solid fa-eye-slash">');
                passwordShow[0] = 0;
            }
            break;
        case "password-recheck-show":
            if(passwordShow[1] == 0) {
                $("#password-recheck").attr("type", "text");
                $("#password-recheck-show").html('<i class="fa-solid fa-eye">');
                passwordShow[1] = 1;
            }
            else {
                $("#password-recheck").attr("type", "password");
                $("#password-recheck-show").html('<i class="fa-solid fa-eye-slash">');
                passwordShow[1] = 0;
            }
            break;
    }
}