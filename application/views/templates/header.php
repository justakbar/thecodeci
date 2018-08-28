<!DOCTYPE html>
    <html lang="ru">

    <head>
        <title>TheCode</title>
        <meta charset="utf-8">
        <script src="/resource/js/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/resource/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/resource/css/style.css">
        <link rel="stylesheet" type="text/css" href="/resource/css/fontawesome.css">
        <link rel="stylesheet" type="text/css" href="/resource/css/fa-solid.css">
        <script src="/resource/js/js.js"></script>
        <style type="text/css" media="all">
          @import "/resource/css/widgEditor.css";
        </style>
        <script type="text/javascript" src="/resource/js/widgEditor.js"></script>
        <link media="all" rel="stylesheet" type="text/css" href="/resource/editor/site/assets/styles/simditor.css" />
            <!-- <link media="all" rel="stylesheet" type="text/css" href="/resource/editor/site/assets/styles/app.css" /> -->
            <script src="/resource/editor/site/assets/scripts/mobilecheck.js"></script>
            <script>
                if (mobilecheck()) {
                    $('<link/>', {
                        media: 'all',
                        rel: 'stylesheet',
                        type: 'text/css',
                        href: '/resource/editor/site/assets/styles/mobile.css'
                    }).appendTo('head')
                }
            </script>
    </head>

    <body>
        <nav class="navbar navhead navbar-expand-lg navbar-dark bg-dark fixed-top">
          <div class="container">
            <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="/resource/img/thecode.png" height="20px;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarText">
              <ul class="navbar-nav mr-auto">
                <li class = "nav-item"><a class = "nav-link" href="<?php echo base_url(); ?>question">Вопросы</a></li>
                <li class = "nav-item"><a class = "nav-link" href="<?php echo base_url(); ?>ordvac/page">Заказы</a></li>
                <?php if(isset($_COOKIE['hash']) && isset($_COOKIE['cookie']) && isset($_SESSION['logged_in'])) { ?>

                    <li class = "nav-item"><a class = "nav-link" href="<?php echo base_url() ?>/profile">Профиль</a></li>

                <?php } ?>
              </ul>


              <form class="form-inline my-2 my-lg-0 mx-auto" action = '<?php echo base_url(); ?>search/' method="get">
                <input class="form-control mr-sm-2" type="search" name = "qu" value = "<?php echo isset($_GET['qu'])?$_GET['qu']:''; ?>" placeholder="Search" aria-label="Search">
              </form>



              <?php if(!isset($_COOKIE['hash']) || !isset($_COOKIE['cookie']) || !isset($_SESSION['logged_in'])) { ?>
              <div class="navbar-text">
                  <a class="btn btn-info" href="<?php echo base_url() ?>login">Войти</a>
                  <a class="btn btn-success" href="<?php echo base_url() ?>/registration">Регистрация</a>
              </div>
              <?php } else if(isset($_COOKIE['hash']) && isset($_COOKIE['cookie']) &&
                $_COOKIE['hash'] == $_SESSION['hash'] && $_COOKIE['cookie'] == $_SESSION['code']) { ?>
                  <div class="navbar-text">
                      <a class="btn btn-secondary" href="<?php echo base_url() ?>/ask">Задать вопрос</a>
                  </div>
                  <?php } ?>
            </div>
          </div>

        </nav>
        <div class="all">