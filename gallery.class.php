<?php
	
	class gallery {
		//@param $con - connection to database
		public function getallpicturename($con){
			$query = "SELECT name FROM pictures";
			$result = $con->query($query);
			return $result;
			
		}
		
		public function orderby($con, $order){
			$query = "SELECT * FROM pictures ORDER BY $order DESC";
			$row = $con->query($query);
			return $row;	
		}
		
		public function show_images(){
			//$dir can be of choosing
			$dir = '../pictures/';
			//checks if is an actual directory, opens it and reads each and returns filename.ext
			if (is_dir($dir)) {
			    if ($dh = opendir($dir)) {
			        while (($file = readdir($dh)) !== false) {
			        	if( $file == '.' || $file == '..'){//readdir returns ., .. before actual filenames
                    		continue;//they are ignored
						}
						
						//href value is to a include file showlarge.inc.php
						echo "<a href=?value=showlarge&value={$file}>";
						echo "<img class = 'picture' src='{$dir}{$file}'></a>";
			        }
			        closedir($dh);
			    }
			}
		}	
	}

?>