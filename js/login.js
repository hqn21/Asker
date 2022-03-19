var passwordShow = 0;

function login() {
    // 將按鈕轉為不可用
    $("#loginSubmit").addClass("disabled");
    $("#loginSubmitMessage").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');

    var account = $("#account").val();
    var password = $("#password").val();

    var passwordRule = /^[A-Za-z0-9]+$/;
    var specialRule = /^[\d|a-zA-Z]+$/;

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
    }

    if($("#account").hasClass("is-valid") && $("#password").hasClass("is-valid")) {
        $.ajax({
            type: "POST",
            url: "php/main.php",
            dataType: 'json',
            data: {
                mode: "login",
                account: account,
                password: password
            },
            success: function(data) {
                $("#loginData").text(data["message"]);
                $("#loginModal").modal("show");
                if(data["status"] == 1) {
                    $("#loginSubmit").addClass("disabled");
                    $("#loginSubmitMessage").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');
                    window.setTimeout((() => window.location = "receive"), 5000);
                }
            }
        })
    }

    // 將按扭轉為可用
    $("#loginSubmit").removeClass("disabled");
    $("#loginSubmitMessage").html('登入');
}

function togglePasswordShow() {
    if(passwordShow == 0) {
        $("#password").attr("type", "text");
        $("#passwordShowIcon").html('<i class="fa-solid fa-eye"></i>');
        passwordShow = 1;
    }
    else {
        $("#password").attr("type", "password");
        $("#passwordShowIcon").html('<i class="fa-solid fa-eye-slash"></i>');
        passwordShow = 0;
    }
}