<?php
class API
{
	public $db;
	function __construct()
	{
		$this->db = mysqli_connect('localhost','root','',"patient_database"); 
	}
	function __destruct()
	{
		mysqli_close($this->db);
	}

	/**
	 * @url GET getPatient/:name
	 */
	function getPatient($name)
	{
		$sql = <<<SQL
		SELECT *
		FROM `patients`
		WHERE `Name` = '$name'
SQL;
		if($result = $this->db->query($sql)){
			return $result->fetch_object();
		}
		else{
			die('There was an error running the query [' . $this->db->error . ']');
		}
	}
	
	/**
	 * @url GET getPatientsLike/:name
	 */
	function getPatientsLike($name)
	{
		$sql = <<<SQL
		SELECT *
		FROM `patients`
		WHERE `Name` LIKE '%$name%'
SQL;
		if($result = $this->db->query($sql)){
			$jsonArray = array();
			while ($patient = $result->fetch_array(MYSQL_ASSOC)) {
				$jsonArray[] = $patient['Name'];
			}
			echo json_encode($jsonArray);
		}
		else{
			die('There was an error running the query [' . $this->db->error . ']');
		}
	}
	
	/**
	 * @url GET getAllPatients
	 */
	function getAllPatients()
	{
		$sql = <<<SQL
		SELECT *
		FROM `patients`
SQL;
		if($result = $this->db->query($sql)){
			$jsonArray = array();
			while ($patient = $result->fetch_array(MYSQL_ASSOC)) {
				$jsonArray[] = $patient['Name'];
			}
			echo json_encode($jsonArray);
		}
		else{
			die('There was an error running the query [' . $this->db->error . ']');
		}
	}
	
	/**
	 * @url GET getRecordsForPatient/:patID
	 */
	function getRecordsForPatient($patID)
	{
		$sql = <<<SQL
		SELECT *
		FROM `records`
		WHERE `Patient ID` = $patID
SQL;
		if($result = $this->db->query($sql)){
			$jsonArray = array();
			while ($record = $result->fetch_array(MYSQL_ASSOC)) {
				$jsonArray[] = $record;
			}
			echo json_encode($jsonArray);
		}
		else{
			die('There was an error running the query [' . $this->db->error . ']');
		}
	}
}
?>