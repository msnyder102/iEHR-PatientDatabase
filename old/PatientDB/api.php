<?php
class API
{
	public $db;
	function __construct()
	{
		$this->db = mysqli_connect('localhost','root','',"pdb"); 
	}
	function __destruct()
	{
		mysqli_close($this->db);
	}
	/**
	 * @url GET getPatientFromName/:first_name/:last_name
	 */
	function getPatientFromName($first_name, $last_name)
	{
		//not sure if we actually want to offer this function, first+last name is not unique unlike SSN/PatID
		//usage should be: like query on names then get patient from id
		$sql = <<<SQL
		SELECT *
		FROM `patients`
		WHERE `First_Name` = '$first_name'
		AND `Last_Name` = '$last_name'
SQL;
		if($result = $this->db->query($sql)){
			if($result->num_rows === 0)
				return json_encode(array('Error' => 'No Match'));
			else
				return $result->fetch_object();
		}
		else{
			return json_encode(array('Error' => 'Database Error [' . $this->db->error . ']'));
		}
	}
	
	/**
	 * @url GET getPatientFromID/:patID
	 */
	function getPatientFromID($patID)
	{
		$sql = <<<SQL
		SELECT *
		FROM `patients`
		WHERE `patient_ID` = '$patID'
SQL;
		if($result = $this->db->query($sql)){
			if($result->num_rows === 0)
				return json_encode(array('Error' => 'No Match'));
			else
				return $result->fetch_object();
		}
		else{
			return json_encode(array('Error' => 'Database Error [' . $this->db->error . ']'));
		}
	}
	
	/**
	 * @url GET getPatientFromSSN/:SSN
	 */
	function getPatientFromSSN($SSN)
	{
		$sql = <<<SQL
		SELECT *
		FROM `patients`
		WHERE `SSN` = '$SSN'
SQL;
		if($result = $this->db->query($sql)){
			if($result->num_rows === 0)
				return json_encode(array('Error' => 'No Match'));
			else
				return $result->fetch_object();
		}
		else{
			return json_encode(array('Error' => 'Database Error [' . $this->db->error . ']'));
		}
	}
	
	/**
	 * @url GET getPatientsLike/:first_name/:last_name
	 */
	function getPatientsLike($first_name, $last_name)
	{
		$sql = <<<SQL
		SELECT *
		FROM `patients`
		WHERE `First_Name` LIKE '$first_name%'
		AND `Last_Name` LIKE '$last_name%'
SQL;
		if($result = $this->db->query($sql)){
			
			if($result->num_rows === 0)
				return json_encode(array(['Error' => 'No Match']));
			else
			{
				$jsonArray = array();
				while ($patient = $result->fetch_array(MYSQL_ASSOC)) {
					$jsonArray[] = array('First_Name' => $patient['First_Name'], 'Last_Name' => $patient['Last_Name'], 'Patient_ID' => $patient['Patient_ID']);
				}	
				return json_encode($jsonArray);
			}
		}
		else{
			return json_encode(array('Error' => 'Database Error [' . $this->db->error . ']'));
		}
	}
	
	/**
	 * @url GET getPatientsLikeSSN/:SSN
	 */
	function getPatientsLikeSSN($SSN)
	{
		$sql = <<<SQL
		SELECT *
		FROM `patients`
		WHERE `SSN` LIKE '$SSN%'
SQL;
		if($result = $this->db->query($sql)){
			
			if($result->num_rows === 0)
				return json_encode(array(['Error' => 'No Match']));
			else
			{
				$jsonArray = array();
				while ($patient = $result->fetch_array(MYSQL_ASSOC)) {
					$jsonArray[] = array('First_Name' => $patient['First_Name'], 'Last_Name' => $patient['Last_Name'], 'Patient_ID' => $patient['Patient_ID']);
				}	
				return json_encode($jsonArray);
			}
		}
		else{
			return json_encode(array('Error' => 'Database Error [' . $this->db->error . ']'));
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
			if($result->num_rows === 0)
				return json_encode(array('Error' => 'No Match'));
			else
			{
				$jsonArray = array();
				while ($patient = $result->fetch_array(MYSQL_ASSOC)) {
					$jsonArray[] = array('First_Name' => $patient['First_Name'], 'Last_Name' => $patient['Last_Name'], 'Patient_ID' => $patient['Patient_ID']);
				}
				return json_encode($jsonArray);
			}
		}
		else{
			return json_encode(array('Error' => 'Database Error [' . $this->db->error . ']'));
		}
	}
	
	/**
	 * @url GET getRecordsForPatient/:patID
	 */
	function getRecordsForPatient($patID)
	{
		$sql = <<<SQL
		SELECT *
		FROM `visits`
		WHERE `Patient_ID` = $patID
SQL;
		if($result = $this->db->query($sql)){
			if($result->num_rows === 0)
				return json_encode(array('Error' => 'No Match'));
			else
			{
				$jsonArray = array();
				while ($record = $result->fetch_array(MYSQL_ASSOC)) {
					$jsonArray[] = $record;
				}
				return json_encode($jsonArray);
			}
		}
		else{
			return json_encode(array('Error' => 'Database Error [' . $this->db->error . ']'));
		}
	}
}
?>