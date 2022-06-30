<?php 
session_start();
$id_access=null;
$id_mns = null;
include 'connect.php';
include 'const.php';
include 'function.php';

$_SESSION["HTTP_REFERER"] = 'main.php';

if (isset ($_SESSION["id_access"])){
	$id_access = $_SESSION["id_access"];
}else{
	exit;
}

if (isset ($_POST["imns_id"])){
	$id_mns = $_POST["select_menu"];
	$_SESSION["id_mns"] = $id_mns;
}

$id_periud = "";
if (isset ($_POST["select_periud"])){
	$id_periud = $_POST["select_periud"];
	//echo $id_periud;
}

if (isset ($_SESSION["id_mns"])){
	$id_mns = $_SESSION["id_mns"];
}

if (isset ($_POST["load"])){
	//echo ($_FILES["file1"]["tmp_name"]);
	//echo ($_FILES["file2"]["tmp_name"]);
	$file1 = $_FILES["file1"]["tmp_name"];
	$file2 = $_FILES["file2"]["tmp_name"];
	//echo $file1;
	$out = parce_exel_file($file1);
	
	$i=0;
	$j=0;
	$rez = array();
	foreach ($out as $elem){
		if ($i>9){
			$buf = array();
			$buf["0"]=$elem["1"];
			$buf["1"]=$elem["2"];
			$buf["2"]=$elem["4"];
			$buf["3"]=$elem["7"];
			$rez[$j]=$buf;
			$j++;
		}
		$i++;
	}
	
	$out = parce_exel_file($file2);
	$i=0;
	$j=0;
	foreach ($out as $elem){
		if ($i>4){
			$rez[$j]["4"]=$elem["7"];
			$rez[$j]["5"]=$elem["8"];
			$j++;
		}
		$i++;
	}
		
	$insert_periud = "INSERT INTO `table_periud` (`id_periud`, `year`, `month`) VALUES (NULL, '".$_POST['year']."', '".$_POST['month']."');";
	mysqli_query($link,$insert_periud) or die(mysqli_error($link));
	
	$this_periud = "select * from `table_periud` where `year`='".$_POST['year']."' and `month`='".$_POST['month']."'";
	$result = mysqli_query($link,$this_periud) or die(mysqli_error($link));
	$per = [];
	for ($per=[]; $row=mysqli_fetch_assoc($result); $per[]=$row);
	$rid = 0;
	foreach($per as $elem){
		$rid = $elem['id_periud'];
	}
	
	foreach ($rez as $elem){
		//echo $imns_id[$elem['0']];
		if ($elem['5']<0){
			$insert_work = "INSERT INTO `table_work` (`id_work`, `id_periud`, `id_imns`, `unp`, `name`, `fild3`, `fild4`, `fild5`, `fild6`, `fild7`, `fild8`, `fild9`, `fild10`, `fild11`, `fild12`, `fild13`, `fild14`, `fild15`) VALUES (NULL, '".$rid."', '".$imns_id[$elem['0']]."',  '".$elem['1']."', '".$elem['2']."', '".$elem['4']."', '".$elem['3']."', '".$elem['5']."', '', '', '', '', '', '', '', '', '', '');";
			mysqli_query($link,$insert_work) or die(mysqli_error($link));
		}
	}
	//INSERT INTO `table_work` (`id_work`, `id_periud`, `id_imns`, `unp`, `name`, `fild3`, `fild4`, `fild5`, `fild6`, `fild7`, `fild8`, `fild9`, `fild10`, `fild11`, `fild12`, `fild13`, `fild14`) VALUES (NULL, '1', '1', 'wret', 'wert', 'wrt', '', '', '', '', '', '', '', '', '', '', '');
	//print_r($rez);
	//print_r($_FILES);
	header("Location: main.php");
}
?>


<html>

	<head>
		<title>«Задолженности по подоходному налогу» | Главная</title>
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
		<form id="imns_label" method="post" autocomplete="off" action="main.php">
			<select name="select_menu">
				<?php 
					$mns_buf="";
					if ($id_access == 2 || $id_access == 1 ){
						$mns_buf ="";
						echo "<option value='0'>All</option>";
					}else {
						$mns_buf= "where `id_imns`= ".mysqli_real_escape_string($link, $id_mns);
					}
					$mns_query = 'select * from `table_imns` '.$mns_buf;
					$result = mysqli_query($link,$mns_query) or die(mysqli_error($link));
					$imns=[];
					for ($imns=[]; $row=mysqli_fetch_assoc($result); $imns[]=$row);
					foreach($imns as $elem){
						//echo $elem['name'];
						$select="";
						if ($elem['id_imns']==$id_mns){
							$select='selected="selected"';
						}
						echo "<option ".$select." value='".$elem["id_imns"]."'>".$elem['shot_name']."</option>";
					}
				?>
			</select>
			<?php 
				if ($id_access == 2 || $id_access == 1 ){
					echo "<input type='submit' value='применить' name='imns_id'> ";
				}
			?>
			<select name="select_periud">
			<?php 
				$query_periud = "select * from `table_periud` ORDER BY `id_periud` DESC";
				$result = mysqli_query($link,$query_periud) or die(mysqli_error($link));
				$periud = [];
				$i = 0;
				for ($periud=[]; $row=mysqli_fetch_assoc($result); $periud[]=$row);
					foreach($periud as $elem){
						$sel = "";
						if ($id_periud=="" && $i==0){
							$id_periud = $elem['id_periud'];
						}
						
						if ( $id_periud == $elem['id_periud']){
							$sel='selected="selected"';
						}
						echo "<option value='".$elem['id_periud']."' ".$sel.">".$elem['month']." ".$elem['year']."</option>";
					}
			?>
			</select>
			
			<?php 
				echo "<input type='submit' value='применить' name='id_periud'> ";
				
			?>
		</form>
		<?php 
			if ($id_access == 2 || $id_access == 1 ){
				echo "<button id='pop' onclick='add_click();'>Добавить</button>";
			}
		?>
			
		
		<div id="log_out">
			<H9>«Задолженности по подоходному налогу»</H9>
			<a href="index.php" id="log_out" class="button">ВЫЙТИ</a>
		</div>	
		
		<div id="work">
			<table border="1" width="100%" cellpadding="1" cols="17" class="sortable" >
				
				<thead>
					<tr>
						<td rowspan="2" width="2%">ИМНС</td>
						<td rowspan="2" width="6%">УНП</td>
						<td rowspan="2" width="10%">наименование организации</td>
						<td rowspan="2" width="7%">сумма задолженности по налоговой декларации (расчету), рублей</td>
						<td rowspan="2" width="7%">по налоговой декларации и (расчету) за период</td>
						<td rowspan="2" width="7%">сумма задолженности по карточке по подоходному налогу, рублей</td>						
						<td colspan="2">запрос о движении денежных средств</td>
						<td colspan="2">наличие платежных инструкций в АИС  ИДО на уплату подоходного налога</td>
						<td colspan="2">выдано разрешение на выплату заработной платы</td>
						<td rowspan="2" width="7%">информация банка о наличии справки об исполенении обязательства по подоходному налогу</td>
						<td rowspan="2" width="7%">направлено плательщику сообщение о представлении пояснений, дата от...</td>
						<td colspan="2">направлена информация в райисполком</td>
						<td rowspan="2" width="%"> </td>
					</tr>
					<tr>
						<td width="%">дата от...</td>
						<td width="%">за период с ... по...</td>
						<td width="%">дата от...</td>
						<td width="%">на сумму, руб.</td>
						<td width="%">дата от...</td>
						<td width="%">на сумму подоходного налога, рублей</td>
						<td width="%">о наличии задолженности, дата от...</td>
						<td width="%">о фактах установленных нарушений при перечислении подоходного налога в бюджет, дата от...</td>
					</tr>
				</thead>
				
				<tbody>
				
					<?php 
						$imns = "";
						if ($id_access != 2 && $id_access != 1 ){
							$imns = " and `table_imns`.`id_imns`=".mysqli_real_escape_string($link,$id_mns)." ";
						}
						
						$query_work = "select * from `table_work`, `table_periud`, `table_imns` where `table_work`.`id_periud`=`table_periud`.`id_periud` and `table_work`.`id_imns`=`table_imns`.`id_imns` ".$imns." and `table_periud`.`id_periud`='".$id_periud."'";
						$result = mysqli_query($link,$query_work) or die(mysqli_error($link));
						$filds = [];
						for ($filds=[]; $row=mysqli_fetch_assoc($result); $filds[]=$row);
						foreach($filds as $elem){
							echo "<tr>";
							
							echo "<td>".$elem["number"]."</td>";
							echo "<td>".$elem["unp"]."</td>";
							echo "<td>".$elem["name"]."</td>";
							echo "<td>".$elem["fild3"]."</td>";
							echo "<td>".$elem["fild4"]."</td>";
							echo "<td>".$elem["fild5"]."</td>";
							echo "<td>".$elem["fild6"]."</td>";
							echo "<td>".$elem["fild7"]."</td>";
							echo "<td>".$elem["fild8"]."</td>";
							echo "<td>".$elem["fild9"]."</td>";
							echo "<td>".$elem["fild10"]."</td>";
							echo "<td>".$elem["fild11"]."</td>";
							echo "<td>".$elem["fild12"]."</td>";
							echo "<td>".$elem["fild13"]."</td>";
							echo "<td>".$elem["fild14"]."</td>";
							echo "<td>".$elem["fild15"]."</td>";
							echo '<td><input class="button" type="button" onclick="edit_fild('.$elem["id_work"].')" value="✎" title="Изменить доступ"></td>';
							
							echo "</tr>";
						}
					?>
					
				</tbody>
			</table>
		</div>
	
		<form id="hides" method="post" autocomplete="off" target="_self" style="display:none" action="update_fild.php">
			<input type="text" id='id_fild' name="id_fild">
			<input type="submit" name='sub_id_fild'>
		</form>	
		
		<div id="add_dialog" style="display:none;" title="Добавление">
			<form id="add_fild" enctype="multipart/form-data" autocomplete="off" method="POST" action="main.php">
				<input type='text' placeholder='Год' required title='Год' name='year'>
				<select name='month'>
					<?php
						foreach($period as $elem){
							echo '<option value="'.$elem.'">'.$elem.'</option>';
						}
					?>
				</select>
				<p><input type="file" required name="file1" id="file1"></p>
				<p><input type="file" required name="file2" id="file2"></p>
				<p><input type="submit" value="Загрузить" name="load"></p>
			</form>
		</div>
		
		<script type="text/javascript" src="js/functions.js"></script>
		<script type="text/javascript" src="js/sort.js"></script>
		<script>
			$( "#add_dialog" ).dialog({
				autoOpen: false,
				width: 500
			})
		</script>
	</body>
	
</html>	