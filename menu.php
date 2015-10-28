<h3> Menüü</h3>
<ul>
	
	<?php 
		if($page_file_name != "home.php") {
			echo '<li><a href="home.php">Avaleht</a></li>';
		} else { 
			echo '<li>Avaleht</li>';
		}
	?>
	<?php 
		if($page_file_name != "login.php") {
			echo '<li><a href="login.php">Logi sisse</a></li>';
		} else { 
			echo '<li>Logi sisse</li>';
		}
	?>
	
	
	
</ul>