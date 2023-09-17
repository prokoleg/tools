<?php
// script by Prokofiev Oleg info@blanet.ru ©2022
//
// Права на данный скрипт пренадлежает его автору.
// Модификация и использование данного скрипта разрешается только с разрешения
// его автора Прокофьева Олега (info@blanet.ru)
// Незаконное использование и распространение скрипта ЗАПРЕЩЕНО
// Скрипт распространяется по лицензии MIT

require_once __DIR__ . '/config.php';
?>

<!DOCTYPE html>
<html lang="" prefix="og: http://ogp.me/ns#">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">
    <meta http-equiv="Last-Modified" content="San, 11 Sen 2022 12:45:26 GMT">
<!-- OpenGraph -->
	<meta property="og:locale" content="ru_RU" />
	<meta property="og:image" content="" />
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="" />
	<meta property="og:title" content="" />
	<meta property="og:url" content="" />
	<meta property="og:description" content="" />
<!-- OpenGraph -->
	<link rel="alternate" media="only screen and (max-width: 991px)" href="" />
	<link rel="icon" href="../img/favicon.svg" sizes="any" type="image/svg+xml">
	<link rel="apple-touch-icon" href="../img/favicon.svg" type="image/svg+xml">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  	<link rel="stylesheet" href=""/>
	<link rel="stylesheet" href=""/>
	<link rel="canonical" href=""/>
	<title></title>
</head>
<body>
<div class="container">

<?php
if (!$_GET) {
?>
<h2>Введите данные</h2>
<form method="get">
<div class="input-group flex-wrap: wrap">
  <span class="input-group-text" id="addon-wrapping">Имя</span>
  <input type="text" class="form-control" placeholder="Имя пользователя" aria-label="Имя пользователя" aria-describedby="addon-wrapping" name="firstname" size="55">
</div>
<br />
<div class="input-group flex-wrap: wrap">
  <span class="input-group-text" id="addon-wrapping">Фамилия</span>
  <input type="text" class="form-control" placeholder="Имя пользователя" aria-label="Имя пользователя" aria-describedby="addon-wrapping" name="lastname">
</div>
<br />
<div class="input-group flex-nowrap">
  <span class="input-group-text" id="addon-wrapping">Телефон</span>
  <input type="text" class="form-control" placeholder="Имя пользователя" aria-label="Имя пользователя" aria-describedby="addon-wrapping" name="phone">
</div>
<br />
<div class="input-group flex-nowrap">
  <span class="input-group-text" id="addon-wrapping">Email</span>
  <input type="text" class="form-control" placeholder="Имя пользователя" aria-label="Имя пользователя" aria-describedby="addon-wrapping" name="email">
</div>
<br />
<div class="input-group flex-nowrap">
  <span class="input-group-text" id="addon-wrapping">Сайт</span>
  <input type="text" class="form-control" placeholder="Имя пользователя" aria-label="Имя пользователя" aria-describedby="addon-wrapping" name="url">
</div>
<br />
<button>Lets go!</button>
<code>ВНИМАНИЕ! Все поля, кроме адреса сайта и почты обязательны к заполнению</code>
</form>
<?php
} elseif ($_GET['firstname'] == null || $_GET['lastname'] == null) {
	echo '<code>ВНИМАНИЕ! Все поля, кроме адреса сайта и почты обязательны к заполнению</code><br /><a href="'.HOME.'">Повторить</a>';
} else {
?>
<h2>Ваш QR-код</h2>
<?php
echo '<img src="'.HOME.'qr.php?size=25&firstname='.$_GET['firstname'].'&lastname='.$_GET['lastname'].'&phone='.$_GET['phone'].'&url='.$_GET['url'].'&email='.$_GET['email'].'&api=bhTBYrt45vrb6vyrfDvg" width=150>';

echo '<br /><a href="'.HOME.'">Назад</a>';
}
?>
</div>
</body>
</html>
