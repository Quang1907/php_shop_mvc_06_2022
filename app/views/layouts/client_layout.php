<html>
<header>
    <title><?= (!empty($page_title)) ? $page_title : 'Trang chu' ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?= _WEB_ROOT ?>/public/assets/client/css/style.css">
</header>

<body>
    <?php
    $this->render('blocks/header');
    $this->render($content, $sub_content);
    $this->render('blocks/footer');
    ?>
    <script src="<?= _WEB_ROOT ?>/public/assets/client/js/main.js"></script>
</body>

</html>