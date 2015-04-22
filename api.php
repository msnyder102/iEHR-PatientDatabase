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
				return (array('Error' => 'No Match'));
			else{
				$patient = $result->fetch_array(MYSQL_ASSOC);
				$patient['Drug_Allergies'] = array($patient['Drug_Allergies']);
				$patient['Major_Surgeries'] = array($patient['Major_Surgeries']);
				$patient['Immunization_History'] = array($patient['Immunization_History']);
				$patient['Chronic_Conditions'] = array($patient['Chronic_Conditions']);
				$patient['Family_History'] = array($patient['Family_History']);
				return $patient;
			}
				
		}
		else{
			return (array('Error' => 'Database Error [' . $this->db->error . ']'));
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
				return (array('Error' => 'No Match'));
			else{
				$patient = $result->fetch_array(MYSQL_ASSOC);
				$patient['Drug_Allergies'] = array($patient['Drug_Allergies']);
				$patient['Major_Surgeries'] = array($patient['Major_Surgeries']);
				$patient['Immunization_History'] = array($patient['Immunization_History']);
				$patient['Chronic_Conditions'] = array($patient['Chronic_Conditions']);
				$patient['Family_History'] = array($patient['Family_History']);
				return $patient;
			}
		}
		else{
			return (array('Error' => 'Database Error [' . $this->db->error . ']'));
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
				return (array('Error' => 'No Match'));
			else{
				$patient = $result->fetch_array(MYSQL_ASSOC);
				$patient['Drug_Allergies'] = array($patient['Drug_Allergies']);
				$patient['Major_Surgeries'] = array($patient['Major_Surgeries']);
				$patient['Immunization_History'] = array($patient['Immunization_History']);
				$patient['Chronic_Conditions'] = array($patient['Chronic_Conditions']);
				$patient['Family_History'] = array($patient['Family_History']);
				return $patient;
			}
		}
		else{
			return (array('Error' => 'Database Error [' . $this->db->error . ']'));
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
				return (array(['Error' => 'No Match']));
			else
			{
				$jsonArray = array();
				while ($patient = $result->fetch_array(MYSQL_ASSOC)) {
					$jsonArray[] = array('First_Name' => $patient['First_Name'],
										 'Last_Name' => $patient['Last_Name'], 
										 'Patient_ID' => $patient['Patient_ID'], 
										 'Age' => $patient['Age'], 
										 'Gender' => $patient['Gender'], 
										 'Race' => $patient['Race'],
										 'SSN' => $patient['SSN']);
				}	
				return ($jsonArray);
			}
		}
		else{
			return (array('Error' => 'Database Error [' . $this->db->error . ']'));
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
				return (array(['Error' => 'No Match']));
			else
			{
				$jsonArray = array();
				while ($patient = $result->fetch_array(MYSQL_ASSOC)) {
					$jsonArray[] = array('First_Name' => $patient['First_Name'],
										 'Last_Name' => $patient['Last_Name'], 
										 'Patient_ID' => $patient['Patient_ID'], 
										 'Age' => $patient['Age'], 
										 'Gender' => $patient['Gender'], 
										 'Race' => $patient['Race'],
										 'SSN' => $patient['SSN']);
				}	
				return ($jsonArray);
			}
		}
		else{
			return (array('Error' => 'Database Error [' . $this->db->error . ']'));
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
				return (array('Error' => 'No Match'));
			else
			{
				$jsonArray = array();
				while ($patient = $result->fetch_array(MYSQL_ASSOC)) {
					$jsonArray[] = array('First_Name' => $patient['First_Name'],
										 'Last_Name' => $patient['Last_Name'], 
										 'Patient_ID' => $patient['Patient_ID'], 
										 'Age' => $patient['Age'], 
										 'Gender' => $patient['Gender'], 
										 'Race' => $patient['Race'],
										 'SSN' => $patient['SSN']);
				}
				return ($jsonArray);
			}
		}
		else{
			return (array('Error' => 'Database Error [' . $this->db->error . ']'));
		}
	}
	
	/**
	 * @url GET getRecordsForPatient/:patID
	 * @url GET getRecordsForPatient/:patID/:filterParam
	 */
	function getRecordsForPatient($patID, $filterParam = '::')
	{
		/*filterParam Guidelines:
			ChiefComplaint(string):ICD9Range(#-#):Time(#)
			Supported Types:
				[Complaint]
				[LowerRange-UpperRange]
				[# = Last # months]
		*/
		
		$filter = explode(':',$filterParam);
		$ccFilter = "";
		$icd9Filter = "";
		$timeFilter = "";
		if(!empty($filter[0])){
			$complaint = str_replace('_',' ',$filter[0]);
			$ccFilter = "AND `Chief_Complaint` = \"$complaint\"";
		}
		if(!empty($filter[1])){
			$range = explode('-',$filter[1]);
			$icd9Filter = "AND (`ICD9_Procedures` BETWEEN \"$range[0]\" AND \"$range[1]\" 
							OR `ICD9_Diagnoses` BETWEEN \"$range[0]\" AND \"$range[1]\")";
		}
		if(!empty($filter[2])){
			//get current date
			$today = explode('-',date("Y-m-d"));
			$lastYear = intval($today[0])-floor(intval($filter[2])/12);
			$lastMonth = intval($today[1])-intval($filter[2])%12;
			if($lastMonth <= 0){
				$lastMonth += 12;
				$lastYear -= 1;
			}
			$lastDate = "$lastYear-$lastMonth-$today[2]";
			$timeFilter = "AND DATE(`Visit_Date`) >= \"$lastDate\"";
		}
		$sql = <<<SQL
		SELECT *
		FROM `visits`
		WHERE `Patient_ID` = $patID
		$ccFilter
		$icd9Filter
		$timeFilter
SQL;
		if($result = $this->db->query($sql)){
			if($result->num_rows === 0)
				return (array('Error' => 'No Match'));
			else
			{
				$jsonArray = array();
				while ($record = $result->fetch_array(MYSQL_ASSOC)) {
					$record['Current_Medications'] = array($record['Current_Medications']);
					$record['ICD9_Diagnoses'] = array($record['ICD9_Diagnoses']);
					$record['ICD9_Procedures'] = array($record['ICD9_Procedures']);
					$record['Test_Results'] = array($record['Test_Results']);
					$jsonArray[] = $record;
				}
				return ($jsonArray);
			}
		}
		else{
			return (array('Error' => 'Database Error [' . $this->db->error . ']'));
		}
	}
}
?>