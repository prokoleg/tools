<?php 

//импортируем класс конвертера
require('image_converter.php');

$imageType = '';
$download = false;

//обработываем метод get, когда страница перенаправляется
if($_GET){	
	$imageType = urldecode($_GET['imageType']);
	$imageName = urldecode($_GET['imageName']);
}else{
	header('Location:index.php');
}

//обрабатываем метод post при отправке формы
if($_POST){
	
	$convert_type = $_POST['convert_type'];
	
	//создаем объект класса image_converter
	$obj = new Image_converter();
	$target_dir = 'uploads';
	//convert image to the specified type
	$image = $obj->convert_image($convert_type, $target_dir, $imageName);
	
	//если преобразовано удачно, то активируем ссылку для скачивания
	if($image){
		$download = true;
	}
}


//массив с типами файлов
$types = array(
	'png' => 'PNG',
	'jpg' => 'JPG',
	'gif' => 'GIF',
	'webp' => 'WEBP',
	'bmp' => 'BMP',
);
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
img{
	max-width: 360px;
}
body{
	background: lightgray;
}
 
</style>
</head>
<body>
	<?php if(!$download) {?>
		<form method="post" action="">
			<table width="500" align="center">
				<tr>
					<td align="center">
						Файл успешно загружен, выберите нижеприведенный вариант для конвертации!<br />
						<img src="uploads/<?=$imageName;?>"  />
					</td>
				</tr>
				<tr>
					<td align="center">
						Convert To: 
							<select class="form-select" aria-label="Default select example" name="convert_type">
								<?php foreach($types as $key=>$type) {?>
									<?php if($key != $imageType){?>
									<option value="<?=$key;?>"><?=$type;?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<br /><br />
					</td>
				</tr>
				<tr>
				<tr>
					<td align="center"><button class="btn btn-secondary">Конвертировать</button></td>
				</tr>
			</table>
		</form>
	<?php } ?>
	<?php if($download) {?>
		<table width="500" align="center">
				<tr>
					<td align="center">
						Изображение сконвертировано в <?php echo ucwords($convert_type); ?>
						<img src="<?=$target_dir.'/'.$image;?>"  />
					</td>
				</tr>
				<td align="center">
				
					<a href="download.php?filepath=<?php echo $target_dir.'/'.$image; ?>" />Скачать преобразованное изображение</a>
				</td>
			</tr>
			<tr>
				<td align="center"><a href="index.php">Конвертировать снова</a></td>
			</tr>
		</table>
	<?php } ?>
</body>
</html>