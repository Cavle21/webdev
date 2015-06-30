<?php 
//paginator - sets a limit to the returned queryies per page. After surpassing that limit another page is made
//for issues - check method dependencies. 


class paginator{
	private $recordsperpage = 16;
	private $thispage = 1;
	private $totrecords;
	private $totalpages;
	private $offset;
	private $query;
	
	
	public function showtotrecords (){
		return $this->totrecords;
	}
	
	public function showtotpages(){
		return $this->totalpages;
	}
	
	//@param $query - user query to database for number of entries $query SELECT count(limiters) FROM*
	public function numberofrecords ($con, $query){
		if($result=$con->query($query)){
			$row = $result->fetch_array();
			//development watch
			var_dump($row);
			
			$totrecords = $row[0];
			
			$this-> totrecords =  $totrecords;
		}else {
			echo "unable to query database";
		}
	}
	
	public function numberpages(){
		
		if(is_int($this->recordsperpage)){
		
			$totalpages = ceil($this->totrecords / $this->recordsperpage);
		    $this->totalpages = $totalpages;
		}else{
			return false;
		}
	}
	
	//@param $thispage - $_GET value from user clicking an href
	public function findoffset(){
		$offset = ($this->thispage - 1) * $this->recordsperpage;
		
		$this->offset =  $offset;
	}
	
	public function getpagenumber ($getarr){
		if(isset($getarr['page'])){
			if(is_int($getarr['page'])){
				$this->$thispage = $getarr['page'];
			}else{$this->thispage = 1;}
		}else{
			$this->thispage = 1;
		}
	}
	
	
	//@params $what(NULL) - default *, table column from table
	//$from(NOT NULL) - table name from db
	//$where(NULL) - limiters in search
	//$orderby(NULL) - column name end with DESC or ASC
	public function setlimitquery($from, $what = '*', $where = '', $orderby = ''){
		$query = "SELECT $what FROM $from WHERE $where ORDER BY $orderby LIMIT $this->offset, $this->recordsperpage";
		
		$this->query = $query;
	}
	
	
}


?>
