<?php 
session_start();
$id_access=null;
$id_mns = null;
include 'connect.php';
include 'const.php';

//$_SESSION["HTTP_REFERER"] = 'update_fild.php';

if (isset ($_SESSION["id_access"])){
	$id_access = $_SESSION["id_access"];
}else{
	exit;
}

if (isset ($_POST["update"])){
	$update_query = "UPDATE `table_work` SET ";
	$update_query .= " `fild3` = '".mysqli_real_escape_string($link, $_POST['fild3'])."', ";
	$update_query .= " `fild4` = '".mysqli_real_escape_string($link, $_POST['fild4'])."', ";
	$update_query .= " `fild5` = '".mysqli_real_escape_string($link, $_POST['fild5'])."', ";
	$update_query .= " `fild6` = '".mysqli_real_escape_string($link, $_POST['fild6'])."', ";
	$update_query .= " `fild7` = '".mysqli_real_escape_string($link, $_POST['fild7'])."', ";
	$update_query .= " `fild8` = '".mysqli_real_escape_string($link, $_POST['fild8'])."', ";
	$update_query .= " `fild9` = '".mysqli_real_escape_string($link, $_POST['fild9'])."', ";
	$update_query .= " `fild10` = '".mysqli_real_escape_string($link, $_POST['fild10'])."', ";
	$update_query .= " `fild11` = '".mysqli_real_escape_string($link, $_POST['fild11'])."', ";
	$update_query .= " `fild12` = '".mysqli_real_escape_string($link, $_POST['fild12'])."', ";
	$update_query .= " `fild13` = '".mysqli_real_escape_string($link, $_POST['fild13'])."', ";
	$update_query .= " `fild14` = '".mysqli_real_escape_string($link, $_POST['fild14'])."', ";
	$update_query .= " `fild15` = '".mysqli_real_escape_string($link, $_POST['fild15'])."' ";
	$update_query .= " WHERE `table_work`.`id_work` = ".mysqli_real_escape_string($link, $_POST['id_work']).";";
	
	mysqli_query($link,$update_query) or die(mysqli_error($link));
	header("Location: ".$_SESSION["HTTP_REFERER"]);
}

?>

<html>

	<head>
		<title>«Задолженности по подоходному налогу» | Изменение</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="Задолженности по подоходному налогу. Витебская область" />
		<meta name="keywords" content="Задолженности по подоходному налогу. Витебская область" />
		<link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<link rel="stylesheet" href="styles/main.css" type="text/css" />
		<link rel="stylesheet" href="styles/jquery-ui.min.css" type="text/css" />
		<link rel="stylesheet" href="styles/jquery-ui.structure.min.css" type="text/css" />
		<link rel="stylesheet" href="styles/jquery-ui.theme.min.css" type="text/css" />
		<script type="text/javascript" src="js/functions.js"></script>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery1.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	</head>	
	
	<body>
		<div class ="body_div">
			<div class ="center_div">
				<form class="user_update_form" autocomplete="off" method="post" action="update_fild.php">
					<?php 
						
						if (isset ($_POST["id_fild"])){
							
							$query_work = "select * from `table_work`, `table_periud` where `table_work`.`id_periud`=`table_periud`.`id_periud` and `table_work`.`id_work`='".$_POST["id_fild"]."'";
							$result = mysqli_query($link,$query_work) or die(mysqli_error($link));
							$filds = [];
							for ($filds=[]; $row=mysqli_fetch_assoc($result); $filds[]=$row);
							echo '<table border="0" width="100%" cellpadding="0" cols="2">';
							foreach($filds as $elem){
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['2'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['2']."' title='".$fild_title['2']."' name='unp' value='".$elem['unp']."'></td></tr>";
								
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['3'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['3']."' title='".$fild_title['3']."' name='name' value='".$elem['name']."'></td></tr>";
								
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['4'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['4']."' title='".$fild_title['4']."' name='fild3' value='".$elem['fild3']."'></td></tr>";
								
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['18'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['18']."' title='".$fild_title['18']."' name='fild4' value='".$elem['fild4']."'></td></tr>";
								
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['5'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['5']."' title='".$fild_title['5']."' name='fild5' value='".$elem['fild5']."'></td></tr>";
								
								echo "<tr><td><br><label><H7>".$fild_title['0']."</label></td></tr>";
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['6'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['6']."' title='".$fild_title['6']."' name='fild6' value='".$elem['fild6']."'></td></tr>";
								
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['7'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['7']."' title='".$fild_title['7']."' name='fild7' value='".$elem['fild7']."'></td></tr>";
								
								echo "<tr><td><br><label><H7>".$fild_title['1']."</label></td></tr>";
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['8'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['8']."' title='".$fild_title['8']."' name='fild8' value='".$elem['fild8']."'></td></tr>";
								
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['9'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['9']."' title='".$fild_title['9']."' name='fild9' value='".$elem['fild9']."'></td></tr>";
								
								echo "<tr><td><br><label><H7>".$fild_title['16']."</label></td></tr>";
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['10'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['10']."' title='".$fild_title['10']."' name='fild10' value='".$elem['fild10']."'></td></tr>";
								
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['11'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['11']."' title='".$fild_title['11']."' name='fild11' value='".$elem['fild11']."'></td></tr>";
								
								echo '<tr><td> <br></td></tr>';
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['12'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['12']."' title='".$fild_title['12']."' name='fild12' value='".$elem['fild12']."'></td></tr>";
								
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['13'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['13']."' title='".$fild_title['13']."' name='fild13' value='".$elem['fild13']."'></td></tr>";
								
								echo "<tr><td><br><label><H7>".$fild_title['17']."</label></td></tr>";
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['14'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['14']."' title='".$fild_title['14']."' name='fild14' value='".$elem['fild14']."'></td></tr>";
								
								echo '<tr><td><label><H8 style="color:brown">'.$fild_title['15'].': </label></td>';
								echo "<td><input type='text' placeholder='".$fild_title['15']."' title='".$fild_title['15']."' name='fild15' value='".$elem['fild15']."'></td></tr>";
								
								echo "<tr><td><br><input type='text' name='id_work' style='display:none' value='".$elem['id_work']."'/></td></tr>";
							}
							echo "</table>";
							echo '<input type="submit" class="button" style="width:800px"  name="update" value="Сохранить" title="Сохранить в БД"/>';
						}
						

					?>
				</form>	
				<?php 
					$go = "go_to_main_click('".$_SESSION["HTTP_REFERER"]."')";
					echo '<button class="button"  onclick="'.$go.'" title="Выйти на главную страницу">Назад</button>';				
				?>
			</div>
			
		</div>
	</body>
	
</html>	