<!doctype html>
<html lang="zh-TW" class="h-100">
<head>
    <?php 
    require("php/config.php");
    $account = $_GET["account"];
    if(isset($account)) {
        $mysql = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_database);
        mysqli_query($mysql, "SET NAMES utf8mb4");
        $userDetails = mysqli_fetch_assoc(mysqli_query($mysql, "SELECT * FROM user_details WHERE account = '$account'"));
        if($userDetails) {
            $nickname = $userDetails["nickname"];
            $statusMessage = $userDetails["statusMessage"];
            $accept = $userDetails["accept"];
        }
        else {
            header("Location: https://" . $_SERVER["HTTP_HOST"] . "/index");
        }
    }
    else {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . "/index");
    }
    ?>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">

    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- User JS -->
    <script src="https://ask.haoquan.me/js/user.js"></script>

    <!-- Other Setting -->
    <title>Asker｜<?php echo $nickname ? $nickname . " (@" . $account . ")" : "@" . $account;?></title>

    <!-- Bootstrap core CSS -->
    <link href="https://ask.haoquan.me/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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
    <link href="https://ask.haoquan.me/bootstrap/css/cover.css" rel="stylesheet">
</head>

<body class="d-flex h-100 text-center text-white bg-dark">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div>
                <?php echo '<a class="text-white text-decoration-none" href="https://' . $_SERVER['HTTP_HOST'] . '">'; ?>
                <h3 class="float-md-start mb-0">
                    < Asker >
                </h3>
                </a>
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    <a class="nav-link" href="index">加入我們</a>
                </nav>
            </div>
        </header>

        <!-- askModal -->
        <div class="modal fade text-black text-start" style="text-shadow: none;" id="askModal" tabindex="-1" aria-labelledby="askModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="askModalLabel">發送匿名信件給<?php echo $nickname ? $nickname . " (@" . $account . ")" : " @" . $account;?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="askData">
                    <div class="mb-3">
                        <input id="account" type="hidden" value="<?php echo $account; ?>">
                        <label for="mailContent" class="form-label">信件內容</label>
                        <textarea onclick="this.classList.remove('is-invalid'); this.classList.remove('is-valid'); $('#mailContent-notice').css('display', '');" class="form-control" id="mailContent" rows="5" maxlength="100" placeholder="您可以在此區域輸入您想輸入的內容。" aria-describedby="mailContent-notice"></textarea>
                        <div id="mailContent-notice" class="form-text">字數須在100以下。</div>
                        <div class="invalid-feedback">
                            請檢查字數是否超過100或為空。
                        </div>
                        <div class="valid-feedback">
                            看起來很棒！
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="mailSend()" type="button" id="askModalButton" class="btn btn-secondary text-white">確認寄出</button>
                </div>
                </div>
            </div>
        </div>

        <!-- askNotifyModal -->
        <div class="modal fade text-black text-start" style="text-shadow: none;" id="askNotifyModal" tabindex="-1" aria-labelledby="askNotifyLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="askNotifyLabel">設定系統</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="askNotifyData">
                    無任何訊息。
                </div>
                <div class="modal-footer">
                    <button type="button" id="askNotifyModalButton" class="btn btn-secondary text-white" data-bs-dismiss="modal">我明白了</button>
                </div>
                </div>
            </div>
        </div>

        <main class="px-3">
            <img src="https://ask.haoquan.me/img/user.png" class="rounded-circle" style="width: 50%;">
            <h1 class="mt-3 mb-0"><?php echo $nickname; ?></h1>
            <small>@<?php echo $account; ?></small>
            <p class="lead"><?php echo $statusMessage; ?></p>
            <p class="lead">
                <button onclick="$('#askModal').modal('show');" class="btn btn-md btn-secondary fw-bold border-white bg-white text-black" <?php echo $accept == 0 ? "disabled" : ""; ?>>發送信件</button>
            </p>
        </main>

        <footer class="mt-auto text-white-50">
            <p>&copy; 2022 Haoquan Liu <br>
                Cover template for <a href="https://getbootstrap.com/" class="text-white text-decoration-none" target="_blank">Bootstrap</a>, by <a href="https://twitter.com/mdo" class="text-white text-decoration-none" target="_blank">@mdo</a>.</p>
        </footer>
    </div>
    <!-- BootStrap JS -->
    <script src="https://ask.haoquan.me/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>