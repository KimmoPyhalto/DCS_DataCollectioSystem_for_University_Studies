<?php 
	include 'header.php'; 
	$cv = mysqli_connect("127.0.0.1","admin","root");
	mysqli_select_db($cv,"test");
	$rowcount = 0;
?>

<div>

	<form action="Case.php" method="POST">

		<div>Case Title:
			<select name="Title">
				<?php 
					$q = mysqli_query($cv,"select * from Indeksi");
						while ($abc = mysqli_fetch_row($q)) {
					  	$rowcount++;
					 		print "<option value='".htmlspecialchars($abc[0])."'>".htmlspecialchars($abc[2])."</option>";
						}
				?>
			</select> 
		</div>
	
		<div>Case type: 
			<select name="CaseType">
				<option value="0">Book / Publication</option>	
				<option value="1">Lecture</option>	
				<option value="2">WWW</option>
				<option value="3">Workshop</option>
				<option value="4">Homework</option>
				<option value="5">Lecture diary</option>
			</select>
		</div>
			
		<div>
			<textarea name="CaseTextarea"></textarea>
		</div>

		<div>
			Place for picture
		</div>
		
		<div>Case Source:
			<input type="text" name="CaseSourceNew">			
			<select name="CaseSource">
			<?php 
					$q = mysqli_query($cv,"select * from Sources");
						while ($abc = mysqli_fetch_row($q)) {
					  	$rowcount++;
					 		print "<option value='".htmlspecialchars($abc[0])."'>".htmlspecialchars($abc[1])."</option>";
						}
				?>
			</select>
		</div>
		
		<div>Case Group:
			<input type="text" name="CaseGroupNew">
			<select name="CaseGroup">
			<?php 
					$q = mysqli_query($cv,"select * from Groups");
						while ($abc = mysqli_fetch_row($q)) {
					  	$rowcount++;
					 		print "<option value='".htmlspecialchars($abc[0])."'>".htmlspecialchars($abc[1])."</option>";
						}
				?>
			</select>
		</div>
		
		<div>Case time:
			<input type="text" name="CaseTime" value="<?php print date('d.m.Y');?>">
		</div>

		<div>
			<input type="hidden" name="NewCase" value="true">
			<input type="submit" value="Save">
		</div>

	</form>
</div>

<?php include 'footer.php'; ?>