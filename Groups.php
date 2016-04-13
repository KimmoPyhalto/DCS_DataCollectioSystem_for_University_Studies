<?php 
	include 'header.php'; 
	include 'init_mysql.php';

	$rowcount = 0;
	$RemoveId = ($_REQUEST["RemoveId"]);
	$CaseGroupEdit = ($_REQUEST["CaseGroupEdit"]);
	$IdEdit = ($_REQUEST["IdEdit"]);
	
	if($RemoveId != ''){
		mysqli_query($cv,"DELETE FROM test.groups WHERE Id = '$RemoveId'");
		}

	if($IdEdit != '' && $CaseGroupEdit != ''){
		mysqli_query($cv,"UPDATE `test`.`groups` SET `Group`='$CaseGroupEdit' WHERE `Id`='$IdEdit'");
		} 

?>

<div>


	<h3>Groups</h3>
	<table class="CasesTable" >
		<tr>
			<td>Id</td>
			<td>Group</td>
			<td>Remove</td>
	<?php
	
		$CaseSources =	mysqli_query($cv,"SELECT * FROM test.groups ORDER BY `Group`");
		while ($abc = mysqli_fetch_row($CaseSources)) {
			$Id = $abc[0];
			$CaseGroup = $abc[1];
			
			print "<tr>";
			
				print "<td>".$Id."</td>";
				print "<td><form>
					<input type='text' name='CaseGroupEdit' value='".$CaseGroup."'>
					<input type='hidden' Name='IdEdit' value='".$Id."'>
					<input type='submit' value='Save'>
					</form></td>";
			
			$CSUBoolean = "false";
				$CaseGroupUsed =	mysqli_query($cv,"SELECT * FROM test.cases WHERE CaseGroup = $Id");
				while ($abc = mysqli_fetch_row($CaseGroupUsed)) {
					$CSUBoolean = "true";	
				}
				
				if($CSUBoolean != "true"){
				print "<td><a href='Groups.php?RemoveId=".$Id."'>Remove</a></td>";							
			}else{
				print "<td> In use</td>";
			}
			
			print "</tr>";
			
			
			}
	
	?>
	</table>

</div>

<?php include 'footer.php'; ?>