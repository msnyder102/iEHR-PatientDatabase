<?php

// set up the database connection first

$serverName = "localhost";      // usually this is the default value
$userName = "root";				// usually this is the default value
$password = "";					// usually password is nothing, that is an empty string
$databaseName = "my_test";		// name of the database where you will insert values(records)


// now connect to the database to send commands later
$connection = new mysqli($serverName, $userName, $password, $databaseName);

// set up files that will be use to pick out values
// NOTE: text files need to be in the same directory where this file is located

$file_title = file("title.txt");
$file_m_names = file("first_m_names.txt");
$file_w_names = file("first_w_names.txt");
$file_last_names = file("last_names.txt");
$file_height = file("height.txt");
$file_address = file("address.txt");
$file_city = file("city.txt");
$file_zipcode = file("zip_code.txt");


// generate 100 random patients with their own personal info
// want more patients just refresh the page
for($i = 1; $i <= 100; $i++) {

	// generate random number for title
	$random = rand(0, 2);
	$title = trim($file_title[$random]);   // the trim function will remove any whitespace characters


	// next determine the sex type
	$sex = "";
	switch ($title) {
		case "Mr":
			$sex = "M";
		break;
		case "Mrs":
			$sex = "F";
		break;
		case "Miss":
			$sex = "F";
		break;
		default:
			$sex = "error";
		break;
	}

	
	// next pick a name depending on their sex type

	$name = "";
	if($sex == "M") {
		$random = rand(0, 95);
		$name = trim($file_m_names[$random]);

	}
	else {
		// look for female names
		$random = rand(0, 95);
		$name = trim($file_w_names[$random]);

	}

	// pick a random last name
	$random = rand(0, 95);
	$lastName = trim($file_last_names[$random]); 

	
	// generate a random DOB
	$dob_month = rand(1, 12);
	$dob_day = rand(1, 31);
	$dob_year = rand(1950, 2015);


	// pick a random address from file
	$random = rand(0, 50);
	$address = trim($file_address[$random]);

	
	// city and zipcode will share the same random number
	$random = rand(0, 4);
	$city = trim($file_city[$random]);
	$zipcode = trim($file_zipcode[$random]);


	// to see which patients were added uncomment the code below.

	
	echo $title . "<br>";
	echo $name . "<br>";
	echo $lastName . "<br>";
	echo $sex . "<br>";
	echo $dob_month . " " . $dob_day . " " .$dob_year . "<br>";
	echo $address . "<br>";
	echo $city . "<br>";
	echo "TX" . "<br>";
	echo $zipcode . "<br>" . "<br>";
	
	


	$sql = "INSERT INTO simple_pa1 (ID, Title, First, Last, Sex, DMonth, DDay, DYear, Address, City, State, Zip) VALUES (NULL, '$title', '$name', '$lastName', '$sex', '$dob_month', '$dob_day', '$dob_year', '$address', '$city', 'TX', '$zipcode')";
	$connection->query($sql);

	echo "Patients added to the database." . "<br>";





}




?>

