<!doctype html>
<html lang="zh-TW" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.88.1">
  <title>Asker｜首頁</title>

  <!-- Bootstrap core CSS -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

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

  <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto">
      <div>
        <?php echo '<a class="text-white text-decoration-none" href="https://' . $_SERVER['HTTP_HOST'] . '">'; ?>
        <h3 class="float-md-start mb-0">
          < Asker > 
        </h3>
        </a>
        <nav class="nav nav-masthead justify-content-center float-md-end">
          <?php
          session_start();
          if (isset($_SESSION["last_action"])) {
            if (((time() - $_SESSION["last_action"]) / (60 * 60)) >= 3) { // 登入無動作超過三小時
              unset($_SESSION["account"]);
              unset($_SESSION["last_action"]);
              echo '<a class="nav-link active" aria-current="page" href="#">首頁</a><a class="nav-link" href="login">登入</a><a class="nav-link" href="register">註冊</a>';
            } else {
              $_SESSION["last_action"] = time(); // 修改最後執行動作的 timestamp 紀錄
              echo '<a class="nav-link active" aria-current="page" href="#">首頁</a><a class="nav-link" href="receive">信箱</a><a class="nav-link" href="setting">設定</a>';
            }
          }
          else {
            echo '<a class="nav-link active" aria-current="page" href="#">首頁</a><a class="nav-link" href="login">登入</a><a class="nav-link" href="register">註冊</a>';
          }
          ?>
        </nav>
      </div>
    </header>

    <main class="px-3">
      <h1>匿名信箱</h1>
      <p class="lead">創建你的帳號，開始收集來自匿名者的來信。</p>
      <p class="lead">
        <a href="register" class="btn btn-lg btn-secondary fw-bold border-white bg-white">馬上註冊</a>
      </p>
    </main>

    <footer class="mt-auto text-white-50">
      <p>&copy; 2022 Haoquan Liu <br>
        Cover template for <a href="https://getbootstrap.com/" class="text-white text-decoration-none" target="_blank">Bootstrap</a>, by <a href="https://twitter.com/mdo" class="text-white text-decoration-none" target="_blank">@mdo</a>.</p>
    </footer>
  </div>



</body>

</html>