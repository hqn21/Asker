# Asker
English | [繁體中文](docs/README_zh-tw.md)
## About The Project
This is an online message box which allows users to create their own account and receive messages from anonymous visitors.
### Built With
* MySQL
* jQuery
* Bootstrap
* Font Awesome
* Flaticon
### Project Directory Structure
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
### MySQL Database Table Structure
user_details

|     Index     |     Type     |  Encoding   | Default |                 Meaning                 |
|---------------|--------------|-------------|---------|-----------------------------------------|
| account       | varchar(16)  | utf8mb4_bin | N/A     | User Account                            |
| nickname      | varchar(10)  | utf8mb4_bin | NULL    | User Nickname                           |
| statusMessage | varchar(20)  | utf8mb4_bin | NULL    | User Status Message                     |
| email         | varchar(255) | utf8mb4_bin | NULL    | User Email                              |
| password      | varchar(18)  | utf8mb4_bin | N/A     | User Password                           |
| accept        | int(1)       | N/A         | N/A     | Whether Accept for Receiving            |
| first_join    | int(10)      | N/A         | N/A     | The Timestamp When User Account Created |

user_receive

|    Index    |     Type     |  Encoding   | Default |               Meaning               |
|-------------|--------------|-------------|---------|-------------------------------------|
| account     | varchar(16)  | utf8mb4_bin | N/A     | User Account                        |
| mailContent | varchar(100) | utf8mb4_bin | N/A     | Message Content                     |
| timestamp   | int(10)      | N/A         | N/A     | The Timestamp When The Message Sent |
## Getting Started
Follow the instructions to set up the project locally.
### Prerequisites
* Apache
* PHP 7.2
* JavaScript ES6
### Installation
1. Clone the repo
   ```sh
   git clone https://github.com/hqn21/Asker.git
   ```
2. Create MySQL database tables with informations mentioned above
3. Enter your MySQL Server Information in `php/config.php`
   ```php
   $mysql_hostname = "";
   $mysql_username = "";
   $mysql_password = "";
   $mysql_database = "";
   ```
## Live Demo
[https://ask.haoquan.me](https://ask.haoquan.me)
## License
Distributed under the MIT License. See [LICENSE](LICENSE) for more information.
## Contact
劉顥權 Haoquan Liu - [contact@haoquan.me](mailto:contact@haoquan.me)

Project Link: [https://github.com/hqn21/Asker/](https://github.com/hqn21/Asker/)
