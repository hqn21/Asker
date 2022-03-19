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

    <!-- Register JS -->
    <script src="js/register.js"></script>

    <!-- Other Settings -->
    <title>Asker｜註冊</title>

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
    // 已登入用戶跳轉
    session_start();
    if(isset($_SESSION["last_action"])) {
        if(((time() - $_SESSION["last_action"]) / (60*60)) >= 3) { // 登入無動作超過三小時
            unset($_SESSION["account"]);
            unset($_SESSION["last_action"]);
            header("Location: receive");
        }
        else {
            $_SESSION["last_action"] = time(); // 修改最後執行動作的 timestamp 紀錄
            header("Location: receive");
        }
    }
    ?>

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div>
                <?php echo '<a class="text-white text-decoration-none" href="https://' . $_SERVER['HTTP_HOST'] . '">'; ?>
                <h3 class="float-md-start mb-0">
                    < Asker >
                </h3>
                </a>
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    <a class="nav-link" href="index">首頁</a>
                    <a class="nav-link" href="login">登入</a>
                    <a class="nav-link active" href="">註冊</a>
                </nav>
            </div>
        </header>

        <!-- Modal -->
        <div class="modal fade text-black text-start" style="text-shadow: none;" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">註冊系統</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="registerData">
                    無任何訊息。
                </div>
                <div class="modal-footer">
                    <button type="button" id="registerModalButton" class="btn btn-secondary text-white" data-bs-dismiss="modal">我明白了</button>
                </div>
                </div>
            </div>
        </div>

        <main class="px-3">
            <form class="text-start">
                <div class="mb-3">
                    <label for="account" class="form-label">帳號名稱</label>
                    <input onclick="this.classList.remove('is-invalid'); this.classList.remove('is-valid'); $('#account-notice').css('display', '');" type="text" class="form-control" id="account" aria-describedby="account-notice" maxlength="16">
                    <div id="account-notice" class="form-text">不可含有特殊字元，無大小寫之分。</div>
                    <div class="invalid-feedback">
                        請檢查是否含有特殊字元，或字數不在4至16。
                    </div>
                    <div class="valid-feedback">
                        看起來很棒！
                    </div>
                </div>
                <!-- <div class="mb-3">
                    <label for="email" class="form-label">電子郵件</label>
                    <input onclick="this.classList.remove('is-invalid'); this.classList.remove('is-valid'); $('#email-notice').css('display', '');" type="email" class="form-control" id="email" aria-describedby="email-notice">
                    <div id="email-notice" class="form-text">用以找回密碼或通知等事務。</div>
                    <div class="invalid-feedback">
                        請檢查電子郵件是否真實或為空白。
                    </div>
                    <div class="valid-feedback">
                        看起來很棒！
                    </div>
                </div> -->
                <div class="mb-3">
                    <label for="password" class="form-label">設定密碼 <a id="password-show" onclick="togglePasswordShow(this.id)"><i class="fa-solid fa-eye-slash"></i></a></label>
                    <input onclick="this.classList.remove('is-invalid'); this.classList.remove('is-valid'); $('#password-notice').css('display', '');" type="password" class="form-control" id="password" aria-describedby="password-notice" maxlength="18">
                    <div id="password-notice" class="form-text">不可含有特殊字元，字數須在6至18。</div>
                    <div class="invalid-feedback">
                        請檢查是否含有特殊字元，或字數不在6至18。
                    </div>
                    <div class="valid-feedback">
                        看起來很棒！
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password-recheck" class="form-label">再次輸入密碼 <a id="password-recheck-show" onclick="togglePasswordShow(this.id)"><i class="fa-solid fa-eye-slash"></i></a></label>
                    <input onclick="this.classList.remove('is-invalid'); this.classList.remove('is-valid'); $('#password-recheck-notice').css('display', '');" type="password" class="form-control" id="password-recheck">
                    <div id="password-recheck-notice" class="form-text">需與上一欄完全相同，有大小寫之分。</div>
                    <div class="invalid-feedback">
                        請檢查此欄位是否與上一欄的密碼數入相同。
                    </div>
                    <div class="valid-feedback">
                        看起來很棒！
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button onclick="register()" id="registerSubmit" type="button" class="btn btn-primary"><div id="registerSubmitMessage">註冊</div></button>
                </div>
            </form>
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