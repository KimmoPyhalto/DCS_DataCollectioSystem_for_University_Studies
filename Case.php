<?php 
	include 'header.php'; 

	/* --- INIT MYSQL --- */
	include 'init_mysql.php';
	$rowcount = 0;
	/* --- / INIT MYSQL --- */	

	/* --- FUNCTIONS --- */

	function SelectionOptions($KeyIndex,$ValueIndex,$CompVariable,$q,$ExtraIndex){
		$stack = array();
		while ($abc = mysqli_fetch_row($q)) {
			$key_tmp = $abc[$KeyIndex];
			$value_tmp = $abc[$ValueIndex];
			if($ExtraIndex != ''){
				$extra_tmp = $abc[$ExtraIndex];
				}
			
			$selected = ($key_tmp == $CompVariable) ? 'selected="selected"' : '';
      print "<option value=\"{$key_tmp}\" {$selected}>{$extra_tmp} {$value_tmp}</option>\n";
			next($stack);
			}
		}
	
	function AddNewOption($Type,$Key,$CaseSourceNew){
		include 'init_mysql.php';
		$NewOptionId = microtime(true);
		mysqli_query($cv,"INSERT INTO test.$Type (`Id`, `$Key`) VALUES ('$NewOptionId', '$CaseSourceNew')");
		global $G_CaseOptionName;
		$G_CaseOptionName = $NewOptionId;
		}
		
	/* --- / FUNCTIONS --- */
	

	/* --- VARIABLES - COMMON --- */

	$Id = ($_REQUEST["Id"]);
	$NewCase = ($_REQUEST["NewCase"]);
	$EditCase = ($_REQUEST["EditCase"]);

	/* --- / VARIABLES - COMMON --- */
	
	/* --- VARIABLES - NEW/EDIT CASE --- */

	if ($NewCase == 'true' || $EditCase == 'true'){
		$Title = ($_REQUEST["Title_select"]);
		$CaseType = ($_REQUEST["CaseType_select"]);
		$CaseTextarea = ($_REQUEST["CaseTextarea"]);
		$CaseSourceNew = ($_REQUEST["CaseSourceNew"]);
		$CaseSource = ($_REQUEST["CaseSource_select"]);
		$CaseId = ($_REQUEST["CaseId"]);	
		$CaseGroupNew = ($_REQUEST["CaseGroupNew"]);
		$CaseGroup2New = ($_REQUEST["CaseGroup2New"]);
		$CaseGroup3New = ($_REQUEST["CaseGroup3New"]);
		$CaseGroup = ($_REQUEST["CaseGroup_select"]);
		$CaseGroup3 = ($_REQUEST["CaseGroup3_select"]);
		$CaseTime = ($_REQUEST["CaseTime"]);	
		$CaseTimeModified = strtotime($CaseTime); 
		$EditNewCaseTime = ($_REQUEST["EditNewCaseTime"]);
		$EditNewCaseTimeEpoch = strtotime($EditNewCaseTime);
			
		if($CaseSourceNew != '') {
			AddNewOption('sources','Source',$CaseSourceNew);
			$CaseSource = $G_CaseOptionName;
		  } else {
		  	$CaseSource = $CaseSource;
			}
		if($CaseGroupNew != '') {
			AddNewOption('groups','Group',$CaseGroupNew);
			$CaseGroup = $G_CaseOptionName;
		  } else {
		  $CaseGroup = $CaseGroup;
		  }
		if($CaseGroup3New != '') {
			AddNewOption('groups3','Group',$CaseGroup3New);
			$CaseGroup3 = $G_CaseOptionName;
		  } else {
		  $CaseGroup3 = $CaseGroup3;
		  }
		if ($NewCase == 'true'){
			$CaseTimeCreated = $CaseTimeModified;
			}
		}
	/* --- / VARIABLES - NEW CASE --- */
		
	/* --- SAVE NEW CASE --- */		
	if ($NewCase == 'true'){
		print "<br>Saving new case<br>";
		mysqli_query($cv,"INSERT INTO `test`.`cases` (`Id`, `Title`, `CaseType`, `CaseTextarea`, `CaseSource`, `CaseGroup`, `CaseTimeCreated`, `CaseTimeModified`, `CaseGroup2`, `CaseGroup3`) VALUES ('$CaseTimeCreated', '$Title', '$CaseType', '$CaseTextarea', '$CaseSource', '$CaseGroup', '$CaseTimeCreated', '$CaseTimeModified', '$CaseGroup2New', '$CaseGroup3')");
		$Id = $CaseTimeCreated;
		}
	/* --- / SAVE NEW CASE --- */
	
	/* --- UPDATE EXISTING CASE --- */
	if ($EditCase == 'true'){
		//print "<div style='padding:7px 0px 10px 0px;'>Editing case: ".$Id."</div>";
		mysqli_query($cv,"UPDATE test.cases SET Title='$Title',CaseType='$CaseType',CaseTextarea='$CaseTextarea',CaseSource='$CaseSource',CaseGroup='$CaseGroup',CaseTimeModified='$CaseTimeModified',CaseTimeCreated='$EditNewCaseTimeEpoch',CaseGroup2='$CaseGroup2New',CaseGroup3='$CaseGroup3' WHERE Id='$Id'");
		}
	/* --- / UPDATE EXISTING CASE --- */
	
			
	/* --- VARIABLES - EXISTING CASE --- */	
	
	if ($Id != ''){
		$Case =	mysqli_query($cv,"SELECT * FROM test.cases WHERE Id = $Id");
		while ($abc = mysqli_fetch_row($Case)) {
			$Title = $abc[1];
			$CaseType = $abc[2];
			$CaseTextarea = $abc[3];
			$CaseSource = $abc[4];
			$CaseGroup = $abc[5];
			$CaseTimeCreated = $abc[6];
			$CaseTimeModified = $abc[7];
			$CaseGroup2New = $abc[8];
			$CaseGroup3 = $abc[9];
			
			$rowcount++;
			}
		}
		
	/* --- / VARIABLES - EXISTING CASE --- */	
		
		
	/* --- EDIT EXISTING CASE --- */
	if ($EditCase == 'true'){
		print "<div style='padding:7px 0px 10px 0px;'>Editing case: ".$Id."</div>";
		}
	/* --- / EDIT EXISTING CASE --- */
	
		
?>

<!-- --- PRINT CASE --- -->	

<div>
	
	<?php
	/*
		if ($EditCase == 'true'){
			print $Id;
			print "<form action='upload_file.php' method='post' enctype='multipart/form-data'>";
				print "<label for='file'>Filename:</label>";
				print "<input type='file' name='file' id='file' />";
				print "<input type='hidden' name='SavePath' value='C:/KimmoTyot/htdocs/upload/".$Id."'>";
				print "<input type='hidden' name='SaveFolder' value='"$Id"'>";
				print "<input type='submit' name='submit' value='Submit' />";
			print "</form>";
		}
		*/
	?>
	
	<form action="Case.php" method="POST">
				
		<div style="width:500px;">
			
			<script type="text/javascript" src="js/nicEdit.js"></script>
			<script type="text/javascript">
				bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
			</script>
			
			<!-- CASETEXTAREA -->
			<textarea name="CaseTextarea" class="CaseTextarea" style="width:1000px;"><?php print $CaseTextarea;?></textarea>
			<!-- / CASETEXTAREA -->
		</div>

		<div>
			<input type="submit" value="Save">
		</div>

		<div>Case Title: 
	
		<?php 

			print "<input type='hidden' name='EditCase' value='true'>";
			print "<input type='hidden' name='Id' value='".$Id."'>";

			if ($Id == ''){
				print "Add New Case Info";
				print "<input type='hidden' name='NewCase' value='true'>";
			}else{
				print "<input type='hidden' name='NewCase' value=''>";
				}

			/* --- TITLE --- */	
			include 'init_mysql.php';
			print "<select name='Title_select'>";
	  	$q = mysqli_query($cv,"SELECT * FROM test.index");
			SelectionOptions('0','2',$Title,$q,'1');
			print "</select>";
			print "&nbsp;&nbsp;<a href='Cases.php?CaseGroup=".$CaseGroup."'>Cases</a>";
			/* --- / TITLE --- */	
			
		?>
					
		</div>
	
		<div>Case type: 
			
			<!-- CASETYPE -->
					
			<select name="CaseType_select">
				<option value="0" <?php echo ($CaseType == "0")?' selected="selected"':''; ?>>Book / Publication</option>	
				<option value="1" <?php echo ($CaseType == "1")?' selected="selected"':''; ?>>Lecture</option>	
				<option value="2" <?php echo ($CaseType == "2")?' selected="selected"':''; ?>>WWW</option>
				<option value="3" <?php echo ($CaseType == "3")?' selected="selected"':''; ?>>Workshop</option>
				<option value="4" <?php echo ($CaseType == "4")?' selected="selected"':''; ?>>Homework</option>
				<option value="5" <?php echo ($CaseType == "5")?' selected="selected"':''; ?>>Lecture diary</option>
			</select>
			
			<!-- / CASETYPE -->
		</div>

		<!--<div>
			Place for picture
		</div>-->

		<!-- CASE SOURCE -->
		<div>Case Source:
			<input type="text" name="CaseSourceNew">			
			<?php 
			
			include 'init_mysql.php';
			print "<select name='CaseSource_select'>";
	  	$q = mysqli_query($cv,"SELECT * FROM test.sources ORDER BY Source");
			SelectionOptions('0','1',$CaseSource,$q);
			print "</select>";
				
			?>
		</div>
		<!-- / CASE SOURCE -->
		
		<!-- CASE GROUP -->
		<div>Case Group:
			<input type="text" name="CaseGroupNew">
			<?php 
				print "<select name='CaseGroup_select'>";
	  		$q = mysqli_query($cv,"SELECT * FROM test.groups ORDER BY `Group`");
				SelectionOptions('0','1',$CaseGroup,$q);
				print "</select>";			
			?>
		</div>
		<!-- / CASE GROUP -->
		
		<!-- CASE GROUP 2 -->
		<div>Case Group 2:
			<input type="text" name="CaseGroup2New" value="<?php print $CaseGroup2New;?>">
									
		</div>
		<!-- / CASE GROUP 2 -->
		
			<!-- CASE GROUP 3 -->
		<div>Case Group 3:
			<input type="text" name="CaseGroup3New">
			
				<?php
				
				print "<select name='CaseGroup3_select'>";
	  		$q = mysqli_query($cv,"SELECT * FROM test.groups3 ORDER BY `Group`");
				SelectionOptions('0','1',$CaseGroup3,$q);
				print "</select>";			
			?>
		</div>
		<!-- / CASE GROUP -->
		
		<!-- CASE TIME MODIFIED -->
		<div>Case Time (dd.mm.yyyy hh:mm:ss):
			<input type="text" name="CaseTime" value="<?php print date('d.m.Y H:i:s');?>">
		</div>
		<!-- / CASE TIME MODIFIED -->
		
		<!-- CASE TIME CREATED -->
		<?php
			if ($EditCase == 'true'){
				$DateCreated = date('d.m.Y G:i:s', $CaseTimeCreated);
				print "<div>Case Time Created (dd.mm.yyyy hh:mm:ss):";
				print "<input type='text' name='EditNewCaseTime' value='".$DateCreated."'>";
				
			
				print "</div>";
		 	}
		?>
		<!-- / CASE TIME CREATED -->
	
	</form>
</div>

<?php include 'footer.php'; ?>