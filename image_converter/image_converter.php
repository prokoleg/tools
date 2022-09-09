<?php 

class Image_converter{
	
	//конвертер изображений
	function convert_image($convert_type, $target_dir, $image_name, $image_quality=100){
		$target_dir = "$target_dir/";
		
		$image = $target_dir.$image_name;
		
		//удаляем расширение из изображения;
		$img_name = $this->remove_extension_from_image($image);
		
		//to png
		if($convert_type == 'png'){
			$binary = imagecreatefromstring(file_get_contents($image));
			//третий параметр для ImagePng ограничен значениями от 0 до 9
			//0 - несжатый, 9 - сжатый
			//итак, преобразуем 100 в 2-значное число, разделив его на 10 и минус на 10
			$image_quality = floor(10 - ($image_quality / 10));
			ImagePNG($binary, $target_dir.$img_name.'.'.$convert_type, $image_quality);
			return $img_name.'.'.$convert_type;
		}
		
		//to jpg
		if($convert_type == 'jpg'){
			$binary = imagecreatefromstring(file_get_contents($image));
			imageJpeg($binary, $target_dir.$img_name.'.'.$convert_type, $image_quality);
			return $img_name.'.'.$convert_type;
		}		
		//to gif
		if($convert_type == 'gif'){
			$binary = imagecreatefromstring(file_get_contents($image));
			imageGif($binary, $target_dir.$img_name.'.'.$convert_type);
			return $img_name.'.'.$convert_type;
		}
		//to webp
		if($convert_type == 'webp'){
			$binary = imagecreatefromstring(file_get_contents($image));
			imageWebp($binary, $target_dir.$img_name.'.'.$convert_type, $image_quality);
			return $img_name.'.'.$convert_type;
		}
		//to bmp
		if($convert_type == 'bmp'){
			$binary = imagecreatefromstring(file_get_contents($image));
			imageBmp($binary, $target_dir.$img_name.'.'.$convert_type, $image_quality);
			return $img_name.'.'.$convert_type;
		}
		return false; 
	}
	
	//обработчик загрузки изображений
	public function upload_image($files, $target_dir, $input_name){
		
		$target_dir = "$target_dir/";
		
		//получаем базовое имя загруженного файла
		$base_name = basename($files[$input_name]["name"]);

		//получаем тип изображения из загруженного изображения
		$imageFileType = $this->get_image_type($base_name);
		
		//задаем динамическое имя для загружаемого файла
		$new_name = $this->get_dynamic_name($base_name, $imageFileType);
		
		//устанавливаем целевой файл для загрузки
		$target_file = $target_dir . $new_name;
	
		//Проверяем, является ли загруженное изображение действительным
		$validate = $this->validate_image($files[$input_name]["tmp_name"]);
		if(!$validate){
			echo "Не похоже на файл изображения :(";
			return false;
		}
		
		// Проверяем размер файла - если он превышает 1 МБ, отклоняем 
		$file_size = $this->check_file_size($files[$input_name]["size"], 10000000);
		if(!$file_size){
			echo "Вы не можете загружать файлы размером более 10 МБ";
			return false;
		}

		// Разрешаем определенные форматы файлов, а ткуже приводим расширение файла к прописному формату
		$file_type = $this->check_only_allowed_image_types(mb_strtolower($imageFileType));
		if(!$file_type){
			echo "Вы не можете загружать файлы, кроме JPG, JPEG, GIF, BMP, WEBP и PNG";
			return false;
		}
		
		if (move_uploaded_file($files[$input_name]["tmp_name"], $target_file)) {
			//возвращаем новое имя изображения и тип файла изображения;
			return array($new_name, $imageFileType);
		} else {
			echo "Извините, произошла ошибка при загрузке файла. <a href='index.php'>Поробуйте снова</a>";
		}

	}
	
	protected function get_image_type($target_file){
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		return $imageFileType;
	}
	
	protected function validate_image($file){
		$check = getimagesize($file);
		if($check !== false) {
			return true;
		} 
		return false;
	}
	
	protected function check_file_size($file, $size_limit){
		if ($file > $size_limit) {
			return false;
		}
		return true;
	}
	
	protected function check_only_allowed_image_types($imagetype){
		if($imagetype != "jpg" && $imagetype != "png" && $imagetype != "jpeg" && $imagetype != "gif" && $imagetype != "webp" && $imagetype != "bmp") {
			return false;
		}
		return true;
	}
	
	protected function get_dynamic_name($basename, $imagetype){
		$only_name = basename($basename, '.'.$imagetype); // удаляем расширение файла
		$combine_time = $only_name.'_'.time();
		$new_name = $combine_time.'.'.$imagetype;
		return $new_name;
	}
	
	protected function remove_extension_from_image($image){
		$extension = $this->get_image_type($image); //добавляем расширение файла
		$only_name = basename($image, '.'.$extension); // удаляем расширение файла
		return $only_name;
	}
}
?>