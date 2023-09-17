<?php
// script by Prokofiev Oleg info@blanet.ru ©2022
//
// Права на данный скрипт пренадлежает его автору.
// Модификация и использование данного скрипта разрешается только с разрешения
// его автора Прокофьева Олега (info@blanet.ru)
// Незаконное использование и распространение скрипта ЗАПРЕЩЕНО
// Скрипт распространяется по лицензии MIT

class TmpImg
{
	function getHashImg()
	{
		$string = $_GET['firstname'].$_GET['lastname'];
		return hash('md2', $string);
	}
}

$hashid = new TmpImg;
