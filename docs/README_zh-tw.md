# Asker
[English](https://github.com/hqn21/Asker/blob/main/README.md) | 繁體中文
## 關於專案
此專案是一個線上匿名信箱網站，提供用戶創建自己的帳戶接收來自匿名用戶的訊息。
### 使用資源
* MySQL
* jQuery
* Bootstrap
* Font Awesome
* Flaticon
### 檔案結構
```
Asker/
├── js/
│   ├── login.js
│   ├── register.js
│   ├── setting.js
│   ├── receive.js
│   └── user.js
├── php/
│   ├── config.php
│   └── main.php
├── index.php
├── login.php
├── register.php
├── setting.php
├── receive.php
└── user.php
```
### 資料表結構
user_details

|     名稱      |     類型      |  編碼       | 預設值   |                 意義                    |
|---------------|--------------|-------------|---------|-----------------------------------------|
| account       | varchar(16)  | utf8mb4_bin | N/A     | 用戶帳號                                 |
| nickname      | varchar(10)  | utf8mb4_bin | NULL    | 用戶暱稱                                 |
| statusMessage | varchar(20)  | utf8mb4_bin | NULL    | 用戶狀態消息                             |
| email         | varchar(255) | utf8mb4_bin | NULL    | 用戶電子郵件                             |
| password      | varchar(18)  | utf8mb4_bin | N/A     | 用戶密碼                                 |
| accept        | int(1)       | N/A         | N/A     | 是否接受接收信件                          |
| first_join    | int(10)      | N/A         | N/A     | 用戶創建帳號時的時間戳                     |

user_receive

|     名稱     |     類型     |  編碼       | 預設值   |                 意義                |
|-------------|--------------|-------------|---------|-------------------------------------|
| account     | varchar(16)  | utf8mb4_bin | N/A     | 用戶帳號                             |
| mailContent | varchar(100) | utf8mb4_bin | N/A     | 訊息內容                             |
| timestamp   | int(10)      | N/A         | N/A     | 訊息發送時的時間戳                    |
## 開始部屬
跟隨指示以在本地端部屬此專案。
### 事先準備
* Apache
* PHP 7.2
* JavaScript ES6
### 安裝步驟
1. 複製此 repo
   ```sh
   git clone https://github.com/hqn21/Asker.git
   ```
2. 利用上方提到的資訊創建資料表
3. 在 `php/config.php` 中輸入您的 MySQL 伺服器資訊
   ```php
   $mysql_hostname = "";
   $mysql_username = "";
   $mysql_password = "";
   $mysql_database = "";
   ```
## License
根據 MIT License 發布，查看 [LICENSE](LICENSE) 以獲得更多資訊。
## 聯絡我
劉顥權 Haoquan Liu - [contact@haoquan.me](mailto:contact@haoquan.me)

專案連結：[https://github.com/hqn21/Asker/](https://github.com/hqn21/Asker/)
