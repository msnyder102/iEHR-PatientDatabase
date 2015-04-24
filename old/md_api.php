// insert this code inside the API class



	/**
	 * @url GET getRecordForVisit/:visitID
	 */
	function getRecordForVisit($visitID)
	{
		$sql = <<<SQL
		SELECT *
		FROM `visits`
		WHERE `Visit_ID` = $visitID
SQL;

		// the output should look like this
		//	{visits : [38,39,195,231,394]}
		//
		//

		if($result = $this->db->query($sql)){
			if($result->num_rows === 0)
				return json_encode(array('Error' => 'No Match'));
			else
				return $result->fetch_object();
		}
		else{
			return json_encode(array('Error' => 'Database Error [' . $this->db->error . ']'), JSON_UNESCAPED_SLASHES);
		}
	}


	/**
	 * @url GET getVisitsByDate/:date
	 */
	function getVisitsByDate($date)
	{
		$sql = <<<SQL
		SELECT *
		FROM `visits`
		WHERE `Visit_Date` = '$date'
SQL;
		if($result = $this->db->query($sql)){
			if($result->num_rows === 0)
				return json_encode(array('Error' => 'No Match'));
			else
			{
				$jsonArray = array();
				while ($record = $result->fetch_array(MYSQL_ASSOC)) {
					$jsonArray[] = array('Visit_ID' => $record['Visit_ID']);
				}
				return json_encode($jsonArray);
			}
		}
		else{
			return json_encode(array('Error' => 'Database Error [' . $this->db->error . ']'));
		}
	}

	
