<?php

require("config.php"); // 引入配置檔

date_default_timezone_set("Asia/Taipei");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysql = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_database);
    mysqli_query($mysql, "SET NAMES utf8mb4");
    $mode = $_POST["mode"];
    switch($mode) {
        // 註冊系統
        case "register":
            $account = $_POST["account"];
            // $email = $_POST["email"];
            $password = $_POST["password"];
            $first_join = time();

            $passwordRule = "/^[a-zA-Z0-9]+$/";
            $specialRule = "/^[\d|a-zA-Z]+$/";
            $emailRule = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/";

            if(!preg_match($specialRule, $account) || strlen($account) > 16 || strlen($account) < 4) {
                echo json_encode(array(
                    "status" => 0, 
                    "message" => "不好意思，請檢查「帳號名稱」是否含有特殊字元或為空白。"
                ) , JSON_UNESCAPED_UNICODE);
                break;
            }
            // if(!preg_match($emailRule, $email)) {
            //     echo json_encode(array(
            //         "status" => 0, 
            //         "message" => "不好意思，請確認「電子郵件」是否真實或為空白。"
            //     ) , JSON_UNESCAPED_UNICODE);
            //     break;
            // }
            if(!preg_match($passwordRule, $password) || strlen($password) > 18 || strlen($password) < 6) {
                echo json_encode(array(
                    "status" => 0, 
                    "message" => "不好意思，請確認「設定密碼」是否由數字和英文組成，且字數在6至18的範圍內。"
                ) , JSON_UNESCAPED_UNICODE);
                break;
            }
            if(mysqli_fetch_assoc(mysqli_query($mysql, "SELECT * FROM user_details WHERE account = '$account'"))) {
                echo json_encode(array(
                    "status" => 0, 
                    "message" => "很抱歉，帳號名稱已存在，請嘗試使用其它帳號名稱註冊。"
                ) , JSON_UNESCAPED_UNICODE);
                break;
            }
            mysqli_query($mysql, "INSERT INTO user_details (account, nickname, email, password, accept, first_join) VALUES ('$account', null, null, '$password', 1, '$first_join')");
            session_start();
            $_SESSION["account"] = $account;
            $_SESSION["last_action"] = time();
            echo json_encode(array(
                "status" => 1, 
                "message" => "恭喜，註冊帳號成功，您的帳號名稱為「" . $account . "」，您將會在 5 秒後進行跳轉。" // 電子郵件為「" . $email . "」
            ) , JSON_UNESCAPED_UNICODE);
            break;
        // 登入系統
        case "login":
            $account = $_POST["account"];
            $password = $_POST["password"];
            $accountDetails = mysqli_fetch_assoc(mysqli_query($mysql, "SELECT * FROM user_details WHERE account = '$account'"));
            if(!$accountDetails || $accountDetails["password"] !== $password) {
                echo json_encode(array(
                    "status" => 0,
                    "message" => "登入失敗，登入資訊有誤。"
                ), JSON_UNESCAPED_UNICODE);
                break;
            }
            session_start();
            $_SESSION["account"] = $account;
            $_SESSION["last_action"] = time();
            echo json_encode(array(
                "status" => 1,
                "message" => "登入成功，您將會在 5 秒後進行跳轉。"
            ), JSON_UNESCAPED_UNICODE);
            break;
        // 登出系統
        case "logout":
            session_start();
            unset($_SESSION["account"]);
            unset($_SESSION["last_action"]);
            echo json_encode(array(
                "status" => 1,
                "message" => "登出成功，您將會在 5 秒後進行跳轉。"
            ), JSON_UNESCAPED_UNICODE);
            break;
        // 設定儲存
        case "settingSave":
            session_start();
            $account = $_SESSION["account"];
            $nickname = $_POST["nickname"];
            $statusMessage = $_POST["statusMessage"];
            $accept = $_POST["accept"];
            $acceptDescription = $accept == 1 ? "開啟" : "關閉";
            $accountDetails = mysqli_fetch_assoc(mysqli_query($mysql, "SELECT * FROM user_details WHERE account = '$account'"));
            if(!$accountDetails) {
                echo json_encode(array(
                    "status" => 0,
                    "id" => 2,
                    "message" => "儲存失敗，找不到用戶資料，將在 5 秒後自動登出以修正此項錯誤。",
                ), JSON_UNESCAPED_UNICODE);
                break;
            }
            if(!mysqli_query($mysql, "UPDATE user_details SET nickname = '$nickname', statusMessage = '$statusMessage', accept = '$accept' WHERE account = '$account'")) {
                echo json_encode(array(
                    "status" => 0,
                    "id" => 1,
                    "message" => "儲存失敗，連線資料庫時發生了錯誤。",
                ), JSON_UNESCAPED_UNICODE);
                break;
            }
            echo json_encode(array(
                "status" => 1,
                "id" => 0,
                "message" => "儲存成功，您的帳號暱稱已設為「" . $nickname . "」、狀態消息已設為「" . $statusMessage . "」、接受匿名者來信已設為「" . $acceptDescription . "」。",
                "nickname" => $nickname,
                "statusMessage" => $statusMessage,
                "accept" => $accept
            ), JSON_UNESCAPED_UNICODE);
            break;
        // 匿名寄件
        case "mailSend":
            $account = $_POST["account"];
            $mailContent = $_POST["mailContent"];
            $timestamp = time();
            $accountDetails = mysqli_fetch_assoc(mysqli_query($mysql, "SELECT * FROM user_details WHERE account = '$account'"));
            if(!$accountDetails) {
                echo json_encode(array(
                    "status" => 0,
                    "message" => "寄件失敗，找不到收信者的帳號資料。"
                ), JSON_UNESCAPED_UNICODE);
                break;
            }
            if($accountDetails["accept"] == 0) {
                echo json_encode(array(
                    "status" => 0,
                    "message" => "寄件失敗，收信者已把收信功能關閉。"
                ), JSON_UNESCAPED_UNICODE);
                break;
            }
            if(mb_strlen($mailContent, "utf-8") > 100 || mb_strlen($mailContent, "utf-8") < 1) {
                echo json_encode(array(
                    "status" => 0,
                    "message" => "寄件失敗，信件內容字數超過100或為空。"
                ), JSON_UNESCAPED_UNICODE);
                break;
            }
            if(!mysqli_query($mysql, "INSERT INTO user_receive (account, mailContent, timestamp) VALUES ('$account', '$mailContent', '$timestamp')")) {
                echo json_encode(array(
                    "status" => 0,
                    "message" => "寄件失敗，連線資料庫時發生了錯誤。"
                ), JSON_UNESCAPED_UNICODE);
                break;
            }
            echo json_encode(array(
                "status" => 1,
                "message" => "寄件成功，您的信件「" . $mailContent . "」已寄入 @" . $account . " 的信箱中。"
            ), JSON_UNESCAPED_UNICODE);
            break;
        // 刪除信件
        case "deleteMail":
            session_start();
            $account = $_SESSION["account"];
            $mailId = $_POST["mailId"];
            $mailContent = $_POST["mailContent"];
            if(!mysqli_query($mysql, "DELETE FROM user_receive WHERE account = '$account' AND mailContent = '$mailContent' AND timestamp = '$mailId'")) {
                echo json_encode(array(
                    "status" => 0,
                    "message" => "刪除失敗，連線資料庫時發生了錯誤。"
                ), JSON_UNESCAPED_UNICODE);
                break;
            }
            echo json_encode(array(
                "status" => 1,
                "message" => "刪除成功。"
            ), JSON_UNESCAPED_UNICODE);
            break;
        // 變更密碼
        case "changePassword":
            session_start();
            $account = $_SESSION["account"];
            $oldPassword = $_POST["oldPassword"];
            $password = $_POST["password"];
            $accountDetails = mysqli_fetch_assoc(mysqli_query($mysql, "SELECT * FROM user_details WHERE account = '$account'"));
            if(!$accountDetails) {
                echo json_encode(array(
                    "status" => 0,
                    "message" => "變更失敗，找不到用戶資料。"
                ), JSON_UNESCAPED_UNICODE);
                break;
            }
            if($oldPassword !== $accountDetails["password"]) {
                echo json_encode(array(
                    "status" => 0,
                    "message" => "變更失敗，原始密碼與實際密碼不相同。"
                ), JSON_UNESCAPED_UNICODE);
                break;
            }
            if(mb_strlen($password, "utf-8") > 18 || mb_strlen($password, "utf-8") < 6) {
                echo json_encode(array(
                    "status" => 0,
                    "message" => "變更失敗，密碼字數超過18或小於6。"
                ), JSON_UNESCAPED_UNICODE);
                break;
            }
            if(!mysqli_query($mysql, "UPDATE user_details SET password = '$password' WHERE account = '$account'")) {
                echo json_encode(array(
                    "status" => 0,
                    "message" => "變更失敗，連線資料庫時發生了錯誤。"
                ), JSON_UNESCAPED_UNICODE);
                break;
            }
            echo json_encode(array(
                "status" => 1,
                "message" => "變更成功。"
            ), JSON_UNESCAPED_UNICODE);
            break;
        // 預設
        default:
            http_response_code(403);
            die("You have no permission to access this page!");
            break;
    }
}
else {
    http_response_code(403);
    die("You have no permission to access this page!");
}