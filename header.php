<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang=en-us>
	<head>
		<title>Data Collection System Ver. 1.0</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link rel=StyleSheet href="css/screen.css" type="text/css" media=screen>
		<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
		<link rel="icon" href="images/favicon.png" type="image/x-icon" />
		<script type="text/javascript">
		  function toggle_visibility(className) {
		  	elements = document.getElementsByClassName(className);
		  	n = elements.length;
		  	for (var i = 0; i < n; i++) {
		    	var e = elements[i];
		    	if(e.style.display == 'none' || e.style.display == '') {
		      	e.style.display = 'block';
		       	} else {
		       		e.style.display = 'none';
		       	}
		     	}
		  	}
		</script>
		<meta name="author" content="Kimmo Pyhalto">
		<meta name="description" content="System for collecting study data from books, web, lectures etc.">
		<meta name="keywords" content="learning, data collecting">
	</head>
	<body bgcolor="#ffffff" text="#000000" link="#0000ff" vlink="#800080" alink="#000080">
	
		<!-- OPINTOTALLENNUSJÄRJESTELMÄ - OMINAISUUSLISTAUS
		
		- Sisällysluettelon automaattinen listaaminen otsikkonumeroinnin mukaan
		- Sisällysluettelossa värikoodein, minkä tyyppisiä asioita sisältää (vihreä, sininen, punainen)
		- Otsikoiden/Otsikkonumeroiden lisäys
		- Otsikoiden/Otsikkonumeroiden poisto
		- Otsikoiden/Otsikkonumeroiden muokkaus
		- Asioiden (Otsikoiden alla) lisäys
		- Asioiden poisto
		- Asioiden muokkaus
		- Asiassa on: 
		1. Otsikko (edellämainittu) 
		2. Tyyppi (Luento, Kirja, WWW) 
		3. Tekstikenttä 
		4. Paikka kuvalle 
		5. Asian lähde
		6. pvm (autotäyttö?)
		- Asialistaus defaulttina kaikki pvm:n mukaan
		- Asialistaus vain halutuista tyypeistä ja/tai lähteistä
		- Tallennuspuoli ja tulostuspuoli? Tallennus/Edit-nappi?
				----------------------------------------------
		-->
			
		<div id="main">
			
			<div style="background:#e6e6e6; padding:10px 25px 0px 4px; margin:0px 0px 10px 0px;">  <!-- top right bottom left -->
			<div style="float:right;">
			<h1 style="text-align:right;">DCS 1.0</h1>
			<p>Data Collection System</p>
		</div>
			<div class="mainMenu">
				<a href="TitleIndex.php">Table of Contents</a>
					
				<a href="Case.php">New Case</a>	
				<a href="Cases.php?All=true">Cases</a>	
				<a href="Sources.php">Sources</a>
				<a href="Groups.php">Groups</a>
				
				<span style="font-family: 'Open Sans',verdana; font-size: 14px;">Open Sans</span>
				
			</div>
			
			<div id="AddNewRowDialog" class="EditClass">
				<div>
					<form action="" method="POST">
						New Row Number: <input type="text" name="NewRowNumber">
						New Title Number: <input type="text" name="NewTitleNumber">
						New Title: <input type="text" name="NewTitle">
						<input type="submit" value="Save">
					</form>
				</div>
			</div>
			
			
			
			
			
			
			
			<?php 
			
			include 'init_mysql.php';
			?>
				<div class="SearchDialog"> 
				<form action="Cases.php">
					
					<table style="border:none;">
					<tr><td style="border:none;">
					<p>Cases by Abstraction Title:</p>
					</td>
					<td style="border:none;">
						<?php 
					$TitleId = ($_REQUEST["TitleId"]);
					 ?>
						<select name="TitleId">
							<option value=""><i>select</i></option>
							<?php
								$q = mysqli_query($cv,"SELECT * FROM test.index");
								while ($abc = mysqli_fetch_row($q)) {
									
									print "<option value='".$abc[0]."'";
									if($TitleId==$abc[0]){print "selected";}
									print ">".$abc[1]." ".$abc[2]."</option>";
									
									}
							?>
						</select>
					</td></tr>
					
					<tr><td style="border:none;">
					<p>Cases by Case Type:</p>
					</td>
					<td style="border:none;">
						<?php 
					$CaseType = ($_REQUEST["CaseType"]);
					 ?>
						<select name="CaseType">
							<option value=""><i>select</i></option>
							<option value="0" <?php echo ($CaseType == "0")?' selected="selected"':''; ?>>Book / Publication</option>	
							<option value="1" <?php echo ($CaseType == "1")?' selected="selected"':''; ?>>Lecture</option>	
							<option value="2" <?php echo ($CaseType == "2")?' selected="selected"':''; ?>>WWW</option>
							<option value="3" <?php echo ($CaseType == "3")?' selected="selected"':''; ?>>Workshop</option>
							<option value="4" <?php echo ($CaseType == "4")?' selected="selected"':''; ?>>Homework</option>
							<option value="5" <?php echo ($CaseType == "5")?' selected="selected"':''; ?>>Lecture diary</option>
						</select>
					</td></tr>
					
					<tr><td style="border:none;">
					<p>Cases by Case Group 1 (usually course):</p>
					</td><td style="border:none;">
						<?php 
					$CaseGroup1 = ($_REQUEST["CaseGroup"]);
					 ?>
						<select name="CaseGroup">
							<option value=""><i>select</i></option>
							<?php
								$q = mysqli_query($cv,"SELECT * FROM test.groups");
								while ($abc = mysqli_fetch_row($q)) {
									print "<option value='".$abc[0]."'";
									if($CaseGroup1==$abc[0]){print "selected";}
									print ">".$abc[1]."</option>";
									
									}
							?>
						</select>
					</td></tr>
					
					<tr><td style="border:none;">
					<p>Cases by Case Group 3:</p>
					</td><td style="border:none;">
					<?php 
					$CaseGroup3 = ($_REQUEST["CaseGroup3"]);
					 ?>
						<select name="CaseGroup3">
							<option value=""><i>select</i></option>
							<?php
					
					
								$q = mysqli_query($cv,"SELECT * FROM test.groups3");
								while ($abc = mysqli_fetch_row($q)) {
									print "<option value='".$abc[0]."'";
									if($CaseGroup3==$abc[0]){print "selected";}
									print ">".$abc[1]."</option>";
									}
							?>
						</select>
					</td></tr>
					
					<tr><td style="border:none;">
					<p>Text search (textarea and CaseGroup2):</p>
					</td><td style="border:none;">
						<?php 
					$FreeTextSearch = ($_REQUEST["FreeTextSearch"]);
					 ?>
						<input type="text" name="FreeTextSearch" value="<?php print $FreeTextSearch; ?>">
					</td></tr>
				</table>
					<input type="submit" value="Go">
				</form>
			</div>
		</div>