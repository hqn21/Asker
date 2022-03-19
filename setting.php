<!doctype html>
<html lang="zh-TW" class="h-100">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">

    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Setting JS -->
    <script src="js/setting.js"></script>

    <!-- Other Settings -->
    <title>Asker｜設定</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/b3258fe523.js" crossorigin="anonymous"></script>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="bootstrap/css/cover.css" rel="stylesheet">
</head>

<body class="d-flex h-100 text-center text-white bg-dark">

    <?php 
    require("php/config.php");
    // 已登入用戶跳轉
    session_start();
    if(isset($_SESSION["last_action"])) {
        if(((time() - $_SESSION["last_action"]) / (60*60)) >= 3) { // 登入無動作超過三小時
            unset($_SESSION["account"]);
            unset($_SESSION["last_action"]);
            header("Location: login");
        }
        else {
            $account = $_SESSION["account"];
            $mysql = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_database);
            mysqli_query($mysql, "SET NAMES utf8mb4");
            $userDetails = mysqli_fetch_assoc(mysqli_query($mysql, "SELECT * FROM user_details WHERE account = '$account'"));
            if(!$userDetails) {
                http_response_code(404);
                die("找不到用戶資料。");
            }
            else {
                $_SESSION["last_action"] = time(); // 修改最後執行動作的 timestamp 紀錄
                $email = $userDetails["email"];
                $nickname = $userDetails["nickname"];
                $statusMessage = $userDetails["statusMessage"];
                $accept = $userDetails["accept"];
            }
        }
    }
    else {
        header("Location: login");
    }
    ?>

    <div class="cover-container d-flex w-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div>
                <?php echo '<a class="text-white text-decoration-none" href="https://' . $_SERVER['HTTP_HOST'] . '">'; ?>
                <h3 class="float-md-start mb-0">
                    < Asker >
                </h3>
                </a>
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    <a class="nav-link" href="index">首頁</a>
                    <a class="nav-link" href="receive">信箱</a>
                    <a class="nav-link active" href="#">設定</a>
                </nav>
            </div>
        </header>

        <!-- settingModal -->
        <div class="modal fade text-black text-start" style="text-shadow: none;" id="settingModal" tabindex="-1" aria-labelledby="settingModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="settingModalLabel">設定系統</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="settingData">
                    無任何訊息。
                </div>
                <div class="modal-footer">
                    <button onclick="document.getElementById('nickname').classList.remove('is-invalid'); document.getElementById('nickname').classList.remove('is-valid'); $('#nickname-notice').css('display', ''); document.getElementById('statusMessage').classList.remove('is-invalid'); document.getElementById('statusMessage').classList.remove('is-valid'); $('#statusMessage-notice').css('display', '');" type="button" id="settingModalButton" class="btn btn-secondary text-white" data-bs-dismiss="modal">我明白了</button>
                </div>
                </div>
            </div>
        </div>

        <!-- changePasswordModal -->
        <div class="modal fade text-black text-start" style="text-shadow: none;" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">更改密碼</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="oldPassword" class="form-label">原始密碼 <a id="oldPassword-show" onclick="togglePasswordShow(this.id)"><i class="fa-solid fa-eye-slash"></i></a></label>
                    <input onclick="this.classList.remove('is-invalid'); this.classList.remove('is-valid'); $('#oldPassword-notice').css('display', '');" type="password" class="form-control" id="oldPassword" aria-describedby="oldPassword-notice" maxlength="18">
                    <div id="oldPassword-notice" class="form-text">不可含有特殊字元，字數須在6至18。</div>
                    <div class="invalid-feedback">
                        請檢查是否含有特殊字元，或字數不在6至18。
                    </div>
                    <div class="valid-feedback">
                        看起來很棒！
                    </div>
                </div>
                <div class="modal-body">
                    <label for="password" class="form-label">新的密碼 <a id="password-show" onclick="togglePasswordShow(this.id)"><i class="fa-solid fa-eye-slash"></i></a></label>
                    <input onclick="this.classList.remove('is-invalid'); this.classList.remove('is-valid'); $('#password-notice').css('display', '');" type="password" class="form-control" id="password" aria-describedby="password-notice" maxlength="18">
                    <div id="password-notice" class="form-text">不可含有特殊字元，字數須在6至18。</div>
                    <div class="invalid-feedback">
                        請檢查是否含有特殊字元，或字數不在6至18。
                    </div>
                    <div class="valid-feedback">
                        看起來很棒！
                    </div>
                </div>
                <div class="modal-body">
                    <label for="password-recheck" class="form-label">再次輸入新的密碼 <a id="password-recheck-show" onclick="togglePasswordShow(this.id)"><i class="fa-solid fa-eye-slash"></i></a></label>
                    <input onclick="this.classList.remove('is-invalid'); this.classList.remove('is-valid'); $('#password-recheck-notice').css('display', '');" type="password" class="form-control" id="password-recheck" aria-describedby="password-recheck-notice" maxlength="18">
                    <div id="password-recheck-notice" class="form-text">需與上一欄完全相同，有大小寫之分。</div>
                    <div class="invalid-feedback">
                        請檢查此欄位是否與上一欄的密碼數入相同。
                    </div>
                    <div class="valid-feedback">
                        看起來很棒！
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="changePassword()" type="button" id="changePasswordModalButton" class="btn btn-secondary text-white">確認更改</button>
                </div>
                </div>
            </div>
        </div>

        <!-- changePasswordNotifyModal -->
        <div class="modal fade text-black text-start" style="text-shadow: none;" id="changePasswordNotifyModal" tabindex="-1" aria-labelledby="changePasswordNotifyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordNotifyModalLabel">變更密碼</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="changePasswordNotifyData">
                    無任何訊息。
                </div>
                <div class="modal-footer">
                    <button type="button" id="changePasswordNotifyModalButton" class="btn btn-secondary text-white">我明白了</button>
                </div>
                </div>
            </div>
        </div>

        <main class="px-3">
            <form class="text-start" style="position: relative; overflow-x: scroll; overflow-y: scroll; height: 400px">
                <div class="mb-3">
                    <label for="account" class="form-label">帳號名稱</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="account" aria-describedby="account-notice" value="<?php echo $account; ?>" disabled>
                        <div class="invalid-feedback">
                            請檢查是否含有特殊字元，或字數不在4至16。
                        </div>
                        <div class="valid-feedback">
                            看起來很棒！
                        </div>
                        <button onclick="logout()" id="logoutSubmit" type="button" class="btn btn-secondary text-white"><div id="logoutSubmitMessage">登出</div></button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">電子郵件</label>
                    <div class="input-group"  aria-describedby="email-notice">
                        <input type="text" class="form-control" id="email" value="尚未開放使用" disabled>
                        <div class="invalid-feedback">
                            請檢查是否含有特殊字元，或字數不在6至18。
                        </div>
                        <div class="valid-feedback">
                            看起來很棒！
                        </div>
                        <button type="button" class="btn btn-secondary text-white">驗證</button>
                    </div>
                    <div id="email-notice" class="form-text">用以找回密碼或通知等事務。</div>
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label">詢問頁面</label>
                    <textarea id="urlContent" style="opacity: .01; height: 0; position: absolute; z-index: -1;">https://ask.haoquan.me/user/<?php echo $account; ?></textarea>
                    <div class="d-grid gap-2">
                        <button onclick="copyUrl()" id="url" type="button" class="btn btn-secondary text-white">複製連結</button>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">密碼設定</label>
                    <div class="d-grid gap-2">
                        <button onclick="$('#changePasswordModal').modal('show');" type="button" class="btn btn-secondary text-white">更改密碼</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="nickname" class="form-label">帳號暱稱</label>
                    <input onclick="this.classList.remove('is-invalid'); this.classList.remove('is-valid'); $('#nickname-notice').css('display', '');" type="text" class="form-control" id="nickname" aria-describedby="nickname-notice" maxlength="10" value="<?php echo $nickname; ?>">
                    <div id="nickname-notice" class="form-text">字數須在10以下。</div>
                    <div class="invalid-feedback">
                        請檢查字數是否超過10。
                    </div>
                    <div class="valid-feedback">
                        看起來很棒！
                    </div>
                </div>
                <div class="mb-3">
                    <label for="statusMessage" class="form-label">狀態訊息</label>
                    <input onclick="this.classList.remove('is-invalid'); this.classList.remove('is-valid'); $('#statusMessage-notice').css('display', '');" type="text" class="form-control" id="statusMessage" aria-describedby="statusMessage-notice" maxlength="20" value="<?php echo $statusMessage; ?>">
                    <div id="statusMessage-notice" class="form-text">字數須在20以下。</div>
                    <div class="invalid-feedback">
                        請檢查字數是否超過20。
                    </div>
                    <div class="valid-feedback">
                        看起來很棒！
                    </div>
                </div>
                <div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="accept" <?php echo $accept == 1 ? "checked" : "";?>>
                        <label class="form-check-label" for="accept">接受匿名者來信</label>
                    </div>
                </div>
            </form>
            <div class="mt-3 d-grid gap-2">
                <button onclick="settingSave()" id="settingSubmit" type="button" class="btn btn-primary"><div id="settingSubmitMessage">儲存變更</div></button>
            </div>
        </main>

        <footer class="mt-auto text-white-50">
            <p>&copy; 2022 Haoquan Liu <br>
                Cover template for <a href="https://getbootstrap.com/" class="text-white text-decoration-none" target="_blank">Bootstrap</a>,
                by <a href="https://twitter.com/mdo" class="text-white text-decoration-none" target="_blank">@mdo</a>.</p>
        </footer>
    </div>
    <!-- BootStrap JS -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>