<?php

//picture class is responsible for moving a file to the server after validating it. Then it saves picture details to dabase
//for grabbing later on. At this time, picture must be jpeg.

	class picture {
		private $name;
		private $description;
		private $date;
		private $picture;
		
		
		public function display_picture (){
			return $this->picture;
		}
		
		//@params addpicture() $con - connection to server
		//$arrpost = array() from $_POST
		//$arrfiles = array() from $_FILES['image']*
		public function addpicture($con, $arrpost, $arrfiles){
			//replaces spaces in  $_POST[name] with underscores
			$postname = preg_replace('/[\s]/', "_" , $arrpost['name']);
			
			$uploaddir = '../pictures/galpics/';
			$uploadfile = $uploaddir . basename($postname . '.jpg');
			
			
		//check for duplicates	
		$query = "SELECT * FROM pictures WHERE name ='" . $arrpost['name'] . "'";
		
		$result = $con->queup($query);
		
		$row_cnt = $result->num_rows;
		
		if($row_cnt == NULL){		//if no dupe: continue
			if ($_FILES['image']['type'] === 'image/jpeg'){//type check
				if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {//movement check				
					if ($_FILES['image']['error'] === UPLOAD_ERR_OK) { //error check
						echo "Success on moving file to server!";
						$name 			= $arrpost['name'];
						$description 	= $arrpost['description'];
						$date 			= $arrpost['date'];
						//check to see if IDE/browser auto-escapes slashes
							if(get_magic_quotes_gpc()){
								$description   = stripslashes($this->description);
								$name 		   = stripslashes($this->name);
							}
			
						$description 	 	 = $con->real_escape_string($description);
						$name 		 	 	 = $con->real_escape_string($name);
						//replaced spaces with underscore
						$name				 = $postname;
						
						$query = "INSERT INTO pictures (name, description) " .
						"VALUES ('$name', '$description')";
			
						$insert = $con->queup($query) or die ("Unable to connect to database.");
			
						if ($insert){
							echo "<h2>New picture added</h2>\n";
							echo "<a href = 'adminhome.php?value=newpicture'>Add Another</a><br>";
							echo "<a href = 'adminhome.php'>View Gallery</a>";
						}else{//query failed
							echo "<h2>Problem adding new picture</h2>\n";
							echo "<a href = 'adminhome.php?value=newpicture'>Try again</a><br>";
							echo "<a href = 'adminhome.php'>View Gallery</a>";
						}				
					} else { //exception class in file
						throw new UploadException($_FILES['image']['error']); 
					} 
				} else {//failed to move picture to server
   					echo "Failed to upload picture to server";
				}
			}else{//picture failed type test
				echo "Failed to validate picture. You may be trying to upload a picture that isn't a jpeg. \n";
			}
		}else {//failed dupe test
			echo "That name is already taken see if you've already added that picture";
		}
	}
}
							
?>










