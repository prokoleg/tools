<?php

/*
API для создания QR-кода визитки VCARD

Формат запроса: http://test.site/qr/?size=РАЗМЕР&firstname=ИМЯ&lastname=ФАМИЛИЯ&phone=ТЕЛЕФОН&url=URL&email=EMAIL&api=API

Формат данных:
РАЗМЕР		- 50, 75, 100 (процентное соотношение качества картинки)
ИМЯ			- имя
ФАМИЛИЯ		- фамилия
ТЕЛЕФОН		- номер телефона в формате 79998887766
URL			- адрес сайта в формате site.ru
EMAIL		- адрес почты
API			- Ваш секретный ключ (по-умолчанию: bhTBYrt45vrb6vyrfDvg)

ВНИМАНИЕ! Все поля, кроме размера, адреса сайта и почты обязательны к заполнению
*/

require_once __DIR__ . '/phpqrcode/qrlib.php';
require_once __DIR__ . '/config.php';

$api = 'bhTBYrt45vrb6vyrfDvg';

/* Временный каталог для картинки*/
$tmpimagedir = '/tmp';
$host = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$output_true = 'Access not denied!';
$output_fail = 'Access denied!';

if ($_GET) {
/*Создание текста для QR-кода*/

$firstname = isset($_GET['firstname']) ? $_GET['firstname'] : '';
$lastname = isset($_GET['lastname']) ? $_GET['lastname'] : '';
$phone = isset($_GET['phone']) ? $_GET['phone'] : '';
$photo = 'https://vinil-spb.ru/image/catalog/avatars/qIR0igjmUv4111.jpg';
$photo1 = 'https://vinil-spb.ru/image/catalog/avatars/blogger.jpg';
$email = (isset($_GET['email']) ? $_GET['email'] : null);
$api_key = (isset($_GET['api'])) ? $_GET['api'] : null;
$img = '<img src="' . $photo . '">';
$img_1 = '<img src="' . $photo1 . '">';


if ($_GET['url'] == null) {
	$url_home = 'https://blanet.ru';
} else {
	$url_home = 'https://' . $_GET['url'];
}

$text  = 'BEGIN:VCARD' . "\n";
$text .= 'N: ' . $firstname . ';' .$lastname. "\n";
$text .= 'TEL;WORK;VOICE;CELL: +' . $phone . "\n";
$text .= 'URL: ' . $url_home . "\n";
$text .= 'EMAIL;TYPE=INTERNET: ' . $email . "\n";
$text .= 'PHOTO;URI:' . $photo . "\n";
$text .= 'LOGO;VALUE=uri:' . $photo . "\n";
$text .= 'END:VCARD';

} else {
	$text = ' Обязательные поля не заполены. Карточка контакта не загружена. Пожалуйста, заполните недостающие поля или создайте правильный запрос к нашему API'. "\n";
}

/* Проверяем введено-ли качество создаваемой картинки */
$size = isset($_GET['size']) ? $_GET['size'] : '25';
$size = ($size == 50) ? 'M' : (($size == 75) ? 'Q' : (($size == 100) ? 'H' : 'L'));

/* Генерация QR-кода во временный файл */
QRcode::png($text, __DIR__ . $tmpimagedir . '/'.$hashid->getHashImg().'.png', $size, 6, 2);
 
/* Замена белых пикселей на прозрачный */
$im = imagecreatefrompng(__DIR__ . $tmpimagedir . '/'.$hashid->getHashImg().'.png');
$width = imagesx($im);
$height = imagesy($im);
 
$bg_color = imageColorAllocate($im, 0, 0, 0);
imagecolortransparent ($im, $bg_color);
 
for ($x = 0; $x < $width; $x++) {
	for ($y = 0; $y < $height; $y++) {
		$color = imagecolorat($im, $x, $y);
		if ($color == 0) {
			imageSetPixel($im, $x, $y, $bg_color);
		}
	}
}

if (isset($api_key) && $api_key == $api) {

/* Если нет имени, фамилии и телефона, то выводим УПС */
if ($firstname == true && $lastname == true && $phone == true) {

/* Вывод в браузер */
header('Content-Type: image/x-png');
imagepng($im);

// Удаляем временный файл изображения
unlink('tmp/'.$hashid->getHashImg().'.png');
}
} else {
	echo ($host == $_SERVER['SERVER_NAME']) ? $output_true : ((isset($_GET['api_ver']) && $_GET['api_ver'] === '1') ? $img : (($_GET['api_ver'] === '2') ? $img_1 : $output_fail));
}
