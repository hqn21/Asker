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

    <!-- Receive JS -->
    <script src="js/receive.js"></script>

    <!-- Other Settings -->
    <title>Asker｜信箱</title>

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
    date_default_timezone_set("Asia/Taipei"); // 設定時區
    // 已登入用戶跳轉
    session_start();
    if (isset($_SESSION["last_action"])) {
        if (((time() - $_SESSION["last_action"]) / (60 * 60)) >= 3) { // 登入無動作超過三小時
            unset($_SESSION["account"]);
            unset($_SESSION["last_action"]);
            header("Location: login");
        } else {
            $_SESSION["last_action"] = time(); // 修改最後執行動作的 timestamp 紀錄
            $account = $_SESSION["account"];
            $mysql = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_database);
            mysqli_query($mysql, "SET NAMES utf8mb4");
            $userDetails = mysqli_fetch_assoc(mysqli_query($mysql, "SELECT * FROM user_details WHERE account = '$account'"));
            $userReceiveSelect = mysqli_query($mysql, "SELECT * FROM user_receive WHERE account = '$account'");
            $receiveDetail = array(array());
            $i = 0;
            while($userReceive = mysqli_fetch_assoc($userReceiveSelect)) {
                $receiveDetail[$i]["mailContent"] = $userReceive["mailContent"];
                $receiveDetail[$i]["timestamp"] = $userReceive["timestamp"];
                $i++;
            }
            // Bubble Sort
            $temp = array();
            for($k = 0; $k < $i - 1; $k++) {
                for($j = 0; $j < $i - $k - 1; $j++) {
                    if($receiveDetail[$j]["timestamp"] < $receiveDetail[$j+1]["timestamp"]) {
                        $temp = $receiveDetail[$j];
                        $receiveDetail[$j] = $receiveDetail[$j+1];
                        $receiveDetail[$j+1] = $temp;
                    }
                }
            }
        }
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
                    <a class="nav-link active" href="#">信箱</a>
                    <a class="nav-link" href="setting">設定</a>
                </nav>
            </div>
        </header>

        <!-- deleteMailModal -->
        <div class="modal fade text-black text-start" style="text-shadow: none;" id="deleteMailModal" tabindex="-1" aria-labelledby="deleteMailModalLabel" aria-hidden="true">
            <input id="mailId" type="hidden">
            <input id="mailContent" type="hidden">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteMailModalLabel">信箱系統</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="deleteMailData">
                        無任何訊息。
                    </div>
                    <div class="modal-footer">
                        <button onclick="deleteMail()" type="button" id="deleteMailModalButton" class="btn btn-secondary text-white">確定刪除</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- deleteMailNotifyModal -->
        <div class="modal fade text-black text-start" style="text-shadow: none;" id="deleteMailNotifyModal" tabindex="-1" aria-labelledby="deleteMailNotifyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteMailNotifyModalLabel">信箱系統</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="deleteMailNotifyData">
                        無任何訊息。
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="deleteMailNotifyModalButton" class="btn btn-secondary text-white" data-bs-dismiss="modal">我明白了</button>
                    </div>
                </div>
            </div>
        </div>

        <main class="px-3 text-black" style="text-shadow: none;">
            <div class="row row-cols-1 row-cols-2 g-4">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            信件總數
                        </div>
                        <div class="card-body">
                            <p id="mailCount" class="card-text"><?php echo $i; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            加入天數
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo intval((time() - $userDetails["first_join"]) / (60*60*24)); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 text-start row row-cols-1 row-cols-md-3 g-4" style="position: relative; overflow-x: scroll; overflow-y: scroll; height: 300px">
                <?php
                    for($m = 0; $m < $i; $m++) {
                        $pastSeconds = time() - $receiveDetail[$m]["timestamp"];
                        $pastMinutes = intval($pastSeconds / 60);
                        $pastHours = intval($pastMinutes / 60);
                        $pastDays = intval($pastHours / 24);
                        $pastMonths = intval($pastDays / 30);
                        $pastYears = intval($pastMonths / 12);
                        if($pastYears > 0) {
                            $pastTime = $pastYears . "年前";
                        }
                        else if($pastMonths > 0) {
                            $pastTime = $pastMonths . "個月前";
                        }
                        else if($pastDays > 0) {
                            $pastTime = $pastDays . "天前";
                        }
                        else if($pastHours > 0) {
                            $pastTime = $pastHours . "小時前";
                        }
                        else if($pastMinutes > 0) {
                            $pastTime = $pastMinutes . "分鐘前";
                        }
                        else {
                            $pastTime = $pastSeconds . "秒鐘前";
                        }
                        echo '<div id="' . $receiveDetail[$m]["timestamp"] . '-card" class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <p id="' . $receiveDetail[$m]["timestamp"] . '-content" class="card-text">' . $receiveDetail[$m]["mailContent"] . '</p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col">
                                                <small class="text-muted">' . $pastTime . '</small>
                                            </div>
                                            <div class="col text-end">
                                                <small class="text-muted">
                                                    <a onclick="showDeleteMailModal(this.id)" id="' . $receiveDetail[$m]["timestamp"] . '"><i  class="fa-solid fa-trash-can"></i></a>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>';
                    }
                ?>
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