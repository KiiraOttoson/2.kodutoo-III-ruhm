<?php

require_once("../../config.php");
$database = "if15_kiira_3";

//1.loome ühenduse
$mysqli = new mysqli($servername, $username, $password, $database);

	//ühenduse kontrollimine
	if($mysqli->connect_error){
		die("connect error ".mysqli_connect_error());
		}
	echo "Ühenduse loomine õnnestus. ";


// muutujad errorite jaoks
	$email_error = "";
	$password_error = "";


// muutujad väärtuste jaoks
	$email = "";
	$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
	
	if(isset($_POST["login"])){ 
	
	if(empty($_POST["email"])){
					$email_error = " *Palun sisesta E-post!"; 
				}else{
		$email = test_input($_POST["email"]);	
		}
		
	if(empty($_POST["password"])){
					$password_error = " *Palun sisesta salasõna!";
				}else{
				if(strlen($_POST["password"]) < 6 ){ 
				$password_error = " *Salasõna pikkus peab olema vähemalt 6 sümbolit!";
				}else{
				$password = test_input($_POST["password"]);
		}
		}
	  
		if($password_error == "" && $email_error == "" ){ 
					
			//3. käsklus, et saada sisestatud emailile ja passwordile vastavad  andmed abst kätte	
			$stmt = $mysqli->prepare("SELECT id, email, eesnimi, perekonnanimi FROM users WHERE email=? AND password=?");		
				
			//4. abst tulnud muutujad, muutujatesse pannakse andmed samas järjekorras kui SELECT lauses
			$stmt->bind_result($id_from_db, $email_from_db, $eesnimi_from_db, $perekonnanimi_from_db);
			
			//2. Asendab SELECT lauses küsimärgid sisestatud emaili ja passwordiga.
			$stmt->bind_param("ss", $email, $password);
			$stmt->execute();

			//5. kontrollib kas andmebaasis olid samad väärtused mis sisestati. Fetch täidab bind result käsklusega määratud muutujad andmebaasist tulnud andmetega.
			if($stmt->fetch()){
					//kasutaja email ja parool on õiged
					echo "Tere ".$eesnimi_from_db." ".$perekonnanimi_from_db."! Oled sisse logitud!";
				}else{
					echo "Teie poolt sisestatud andmed ei ole õiged!";
					  }
					  
					  // ühenduse sulgemine. Mõne aja pärast sulgeb ennast ise kuid vabade andmebaasiühenduste lemiit võib selle aja jooksul otsa saada. 
					  $stmt->close();
				
				
		}
				
				
} //if isset login ends


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
$page_title = "Kasutaja logimise leht";

//faili nimi
$page_file_name = "login.php";


?>


<?php require_once("../header.php"); 


// 8. Kui jätta siia faili html , body jm märgendid alles, siis ei tööta (menüü kaob ära ja lehe nimesse näitab footer failis olevaid märgendeid). Kas ainuke võimalus on html siit ära kustutada?
?>



<h2>Sisselogimine</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

	<input type="email" name="email" placeholder="E-post" value="<?php echo $email; ?>"><?php echo $email_error; ?><br><br>
	<input type="password" name="password" placeholder="Parool"><?php echo $password_error; ?><br><br>
	<input type="submit" name="login" value="Sisene">

</form>



	<h4><a href="create_user.php">Registreeru</a></h4>
	

	
	<?php require_once("../footer.php"); ?>  





