<?php
// Очищаем от старых файлов
  $path = dirname(__FILE__).'/uploads';
  if ($handle = opendir($path)) {

    while (false !== ($file = readdir($handle))) {
        if ((time()-filectime($path.'/'.$file)) < 86400) {  // 86400 = 60*60*24 Удаление через сутки
          if (strripos($file, '.(.*)') !== false) {
            unlink($path.'/'.$file);
          }
        }
    }
  }

// Импортируем класс конвектора
require('image_converter.php');

if($_FILES){
	$obj = new Image_converter();
	
	//call upload function and send the $_FILES, target folder and input name
	$upload = $obj->upload_image($_FILES, 'uploads', 'fileToUpload');
	if($upload){
		$imageName = urlencode($upload[0]);
		$imageType = urlencode($upload[1]);
		
		if($imageType == 'jpeg'){
			$imageType = 'jpg';
		}
		header('Location: convert.php?imageName='.$imageName.'&imageType='.$imageType);
	}
}	
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<title></title>
<style>
	body{
		background: lightgray;
		background-image: url('screen.webp');
		opacity: 0.9;
	}
	table{
		margin-top: 100px;
		background: white;
		border-radius: 10px;
	}
	td {
		padding: 15px;
	}
</style>
<script>
	function checkEmpty(){
		var img = document.getElementById('fileToUpload').value;
		if(img == ''){
			alert('Вы не выбрали файл');
			return false;
		}
		return true;
	}
</script>
</head>
<body>
	<table width="500" align="center">
		<tr><td align="center">	<h2 align="center">Загрузите и конвертируйте изображения вместе с Blanet.Ru</h2></td></tr>
		<tr><td align="center"><code>Поддерживаемые форматы JPG, PNG, GIF, WEBP, BMP</code></td></th>
		<tr>
			<td align="center">
				<form action="" enctype="multipart/form-data" method="post" onsubmit="return checkEmpty()" />
				<div class="mb-3">
  <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" />
</div>
					<input type="submit" value="Загрузить" class="btn btn-secondary" />
				</form>
			</td>
		</tr>
	</table>
</body>
</html>