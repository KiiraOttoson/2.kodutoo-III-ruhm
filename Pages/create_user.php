<?php

require_once("../../config.php");
$database = "if15_kiira_3";

//loome ühenduse
$mysqli = new mysqli($servername, $username, $password, $database);

	//ühenduse kontrollimine
	if($mysqli->connect_error){
		die("connect error ".mysqli_connect_error());
		}
	echo "Ühenduse loomine õnnestus. ";



// muutujad errorite jaoks

	$create_email_error = "";
	$create_password_error = "";
	$create_s_name_error ="";
	$create_f_name_error="";

// muutujad väärtuste jaoks

	$create_email = "";
	$create_password = "";
	$create_s_name ="";
	$create_f_name="";
	
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
	


if(isset($_POST["create"])){ 

	if(empty($_POST["create_s_name"])){
	  $create_s_name_error = " *Palun sisesta eesnimi!";
	}else{
	  $create_s_name = test_input($_POST["create_s_name"]);
	  }
	
	
	if(empty($_POST["create_f_name"])){
	  $create_f_name_error = " *Palun sisesta perekonnanimi!";
	}else{
	  $create_f_name = test_input($_POST["create_f_name"]);
	  }
	
	
	if(empty($_POST["create_email"])){
	  $create_email_error = " *Palun sisesta E-post!";
	}else{
	  $create_email = test_input($_POST["create_email"]);
	  }
  
	if(empty($_POST["create_password"])){
	  $create_password_error = "*Palun sisesta parool!";
    }else{
	  if(strlen($_POST["create_password"]) < 6 ){
	  $create_password_error = " *Parooli pikkus peab olema vähemalt 6 sümbolit!";
	}else{
	 $create_password = test_input($_POST["create_password"]);
	  }
	  }
	  
		
		if($create_password_error == "" && $create_email_error == "" && $create_s_name_error == "" && $create_f_name_error == ""){
					
					$stmt = $mysqli->prepare("INSERT INTO users (email, password, eesnimi, perekonnanimi) VALUES(?,?,?,?)");
					$stmt->bind_param("ssss", $create_email, $create_password, $create_s_name, $create_f_name);
					$stmt->execute();	
					
					
				echo "Tere ".$create_s_name."! Oled registreerunud! Sinu E-post on ".$create_email." ja parool on ".$create_password;
				
				$stmt->close();	
					
					
					
		}
				
} //if isset create ends
}// if server request ends

function test_input($data) { 
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<?php

//lehe nimi
$page_title = "Kasutaja loomine";

//faili nimi
$page_file_name = "create_user.php";


?>


<?php require_once("../header.php"); ?> 





	<h2>Registreerumine</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
		Eesnimi:<br><input type="text" name="create_s_name" value="<?php echo $create_s_name; ?>"><?php echo $create_s_name_error; ?><br><br>
		Perekonnanimi:<br><input type="text" name="create_f_name" value="<?php echo $create_f_name; ?>"><?php echo $create_f_name_error; ?><br><br>
		E-post:<br><input type= "email" name="create_email" value="<?php echo $create_email; ?>"><?php echo $create_email_error; ?><br><br>
		Valige parool:<br><input type= "password" name="create_password"><?php echo $create_password_error; ?><br><br>
		<input type="submit" name="create" value= "Loo kasutaja">
</form>

	
	

	
	<?php require_once("../footer.php"); ?>  





