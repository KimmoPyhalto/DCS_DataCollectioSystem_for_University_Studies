<?php 
	include 'header.php'; 
	include 'init_mysql.php';
	$rowcount = 0;
	$RemoveId = ($_REQUEST["RemoveId"]);
	$CaseSourceEdit = ($_REQUEST["CaseSourceEdit"]);
	$IdEdit = ($_REQUEST["IdEdit"]);
	
	if($RemoveId != ''){
		mysqli_query($cv,"DELETE FROM test.sources WHERE Id = '$RemoveId'");
		}

	if($IdEdit != '' && $CaseSourceEdit != ''){
		mysqli_query($cv,"UPDATE test.sources SET Source='$CaseSourceEdit' WHERE Id='$IdEdit'");
		} 

?>

<div>

	<h3>Sources</h3>
	<table class="CasesTable" >
		<tr>
			<td>Id</td>
			<td>Source</td>
			<td>Remove</td>
	<?php
	
		$CaseSources =	mysqli_query($cv,"SELECT * FROM test.sources ORDER BY Source");
		while ($abc = mysqli_fetch_row($CaseSources)) {
			$Id = $abc[0];
			$CaseSource = $abc[1];
			
			print "<tr>";
			
				print "<td>".$Id."</td>";
				print "<td><form><input type='text' name='CaseSourceEdit' value='".$CaseSource."'><input type='hidden' Name='IdEdit' value='".$Id."'><input type='submit' value='Save'></form></td>";
			
			$CSUBoolean = "false";
				$CaseSourceUsed =	mysqli_query($cv,"SELECT * FROM test.cases WHERE CaseSource = $Id");
				while ($abc = mysqli_fetch_row($CaseSourceUsed)) {
					$CSUBoolean = "true";	
				}
				
				if($CSUBoolean != "true"){
				print "<td><a href='Sources.php?RemoveId=".$Id."'>Remove</a></td>";							
			}else{
				print "<td> In use</td>";
			}
			
			print "</tr>";
		
			}
	
	?>
	</table>

</div>

<?php include 'footer.php'; ?>