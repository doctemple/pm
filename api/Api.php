<?php

class API
{
	private $connect = '';
	public $tb_name = '';
	public $tb_field = array();
	public $tb_primary = '';

	function __construct($tb_name)
	{
		$this->database_connection();
		$this->tb_name = $tb_name;
		$this->tb_primary = $this->getPrimaryKey();
		$this->tb_field = $this->getFields();
	}

	function database_connection($db_type="mysql")
	{         
		if($db_type=="mysql"){
			$this->connect = new PDO("mysql:host=".host.";dbname=".dbname,user_admin, user_pwd,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
		    //$this->connect = new PDO("mysql:host=localhost;dbname=qkscom_quiz", "qkscom_admin", "@Qk15881920");

		}elseif($db=="mssql"){

					try {
						$this->connect = new PDO(
							"sqlsrv:server=".host.";Database=".dbname,
							user_admin,
							user_pwd,
							array(
								PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
							)
						);
					}
					catch(PDOException $e) {
						die("Error connecting to SQL Server: " . $e->getMessage());
					}

		}
		
	}
	
	function getPrimaryKey(){
				$tb_name = $this->tb_name;
				$tb_primary = $this->tb_primary;
				$statement = $this->connect->prepare("SHOW KEYS FROM {$tb_name} WHERE Key_name = 'PRIMARY' ");
				$data=array();

				if($statement->execute())
				{
					while($row = $statement->fetch(PDO::FETCH_ASSOC))
					{
						$data = $row['Column_name']; 
					}
					return $data;
				}
	}

	function getFields(){
				$tb_name = $this->tb_name;
				$tb_primary = $this->tb_primary;
				$statement = $this->connect->prepare("SHOW COLUMNS FROM {$tb_name}");
				$data=array();

				if($statement->execute())
				{
					while($row = $statement->fetch(PDO::FETCH_ASSOC))
					{
						if($row['Field']!=$tb_primary){ $data[] = $row['Field']; }
					}
					return $data;
				}
	}

	function getFieldTypes(){
				$tb_name = $this->tb_name;
				$tb_primary = $this->tb_primary;
				$statement = $this->connect->prepare("SHOW COLUMNS FROM {$tb_name}");
				$data=array();

				if($statement->execute())
				{
					while($row = $statement->fetch(PDO::FETCH_ASSOC))
					{
						if($row['Field']!=$tb_primary){  $data[] = $row['Type']; }
					}
					return $data;
				}
	}

	function getTable(){
				$tb_name = $this->tb_name;
				$tb_primary = $this->tb_primary;
				$statement = $this->connect->prepare("SHOW COLUMNS FROM {$tb_name}");
				$data=array();

				if($statement->execute())
				{
					while($row = $statement->fetch(PDO::FETCH_ASSOC))
					{
						$data[] = $row; 
					}
					return $data;
				}
	}

	function fetch_all()
	{
		$tb_name = $this->tb_name;
		$tb_primary = $this->tb_primary;
		$query = "SELECT * FROM {$tb_name} ORDER BY {$tb_primary}";
		$statement = $this->connect->prepare($query);
		$data=array();

		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	function insert()
	{
		$tb_name = $this->tb_name;
		$tb_primary = $this->tb_primary;
		$tb_field = $this->tb_field;

		if(isset($_POST[$tb_field[0]]))
		{

			$data_comma='';
			$data_colon='';
			$size = sizeof($tb_field);
			for($i=0;$i<$size;$i++){
				$form_data[':'.$tb_field[$i]] = $_POST[$tb_field[$i]];

				if($i==($size-1)){
				$data_comma .= $tb_field[$i];
				$data_colon .= ':'.$tb_field[$i];				
				}else{
				$data_comma .= $tb_field[$i].', ';		
				$data_colon .= ':'.$tb_field[$i].', ';		
				}

			}

			$query = "
			INSERT INTO {$tb_name} 
			({$data_comma}) VALUES 
			({$data_colon})
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}

	function fetch_single($id)
	{
		$tb_name = $this->tb_name;
		$tb_primary = $this->tb_primary;
		$tb_field = $this->tb_field;

		$query = "SELECT * FROM {$tb_name} WHERE {$tb_primary}='".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{

			$size = sizeof($tb_field);
			for($i=0;$i<$size;$i++){
				$data[$tb_field[$i]] = $row[$tb_field[$i]];
			}

			}
			return $data;
		}
	}

	function resetWork()
	{

		$tb_name = $this->tb_name;

			$query = "UPDATE `$tb_name` SET `work` = '0', `leave` = '0', `aDate` = '0000-00-00 00:00:00' ";

			$statement = $this->connect->prepare($query);
			if($statement->execute())
			{
				return true;
			}
			else
			{
				return false;
			}

	}

	function update_single($id,$work,$aDate)
	{

		$tb_name = $this->tb_name;
		$tb_primary = $this->tb_primary;
		$tb_field = $this->tb_field;

		if(isset($id))
		{

			$query = "UPDATE `$tb_name` SET `work` = '$work', `leave` = '0', `aDate` = '$aDate' WHERE `emp`.`id` = $id; ";

			$statement = $this->connect->prepare($query);
			if($statement->execute())
			{
				$data = 'success';
			}
			else
			{
				$data='No Update : '.$query;
			}
		}
		else
		{
			$data = 'No Data Set';
		}

		return $data;
	}

	function update_leave($id,$leave)
	{

		$tb_name = $this->tb_name;
		$tb_primary = $this->tb_primary;
		$tb_field = $this->tb_field;

		if(isset($id))
		{

			$query = "UPDATE `$tb_name` SET `work` = '0', `leave` = '$leave', `aDate` = '0000-00-00 00:00:00' WHERE `emp`.`id` = $id; ";

			$statement = $this->connect->prepare($query);
			if($statement->execute())
			{
				$data = 'success';
			}
			else
			{
				$data='No Update : '.$query;
			}
		}
		else
		{
			$data = 'No Data Set';
		}

		return $data;
	}


	function update()
	{

		$tb_name = $this->tb_name;
		$tb_primary = $this->tb_primary;
		$tb_field = $this->tb_field;

		if(isset($_POST[$tb_field[0]]))
		{

			$data_comma='';
			$size = sizeof($tb_field);
			for($i=0;$i<$size;$i++){
	
					$form_data[':'.$tb_field[$i]] = $_POST[$tb_field[$i]];

				if($i==($size-1)){
				$data_comma .= $tb_field[$i].' = :'.$tb_field[$i];	
				}else{
				$data_comma .= $tb_field[$i].' = :'.$tb_field[$i].', ';		
				}

			}

			$query = "
			UPDATE {$tb_name} 
			SET 
			{$data_comma}
			WHERE {$tb_primary} = ".$_POST[$tb_primary];

			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}

		return $data;
	}


	function delete($id)
	{
		$tb_name = $this->tb_name;
		$tb_primary = $this->tb_primary;
		$tb_field = $this->tb_field;

		$query = "DELETE FROM {$tb_name} WHERE {$tb_primary} = '".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			$data[] = array(
				'success'	=>	'1'
			);
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
}

?>