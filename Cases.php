<?php 
	include 'header.php'; 

	include 'init_mysql.php';
	
	$rowcount = 0;

	$CaseGroup3 = ($_REQUEST["CaseGroup3"]);
	$FreeTextSearch = ($_REQUEST["FreeTextSearch"]);
	$RemoveId = ($_REQUEST["RemoveId"]);
	$TitleId = ($_REQUEST["TitleId"]); /* Comes from TitleIndex.php when selecting Title */
	if($TitleId != ''){
		$TitleName =	mysqli_query($cv,"SELECT * FROM test.index WHERE Id = '$TitleId'");
		while ($abc = mysqli_fetch_row($TitleName)) {
			$TitleNumber = $abc[1];
			$TitleName = $abc[2];
		}
	}
	$CaseType = ($_REQUEST["CaseType"]); /* Comes from TitleIndex.php when selecting Title with Type */
	if($CaseType != ''){
		if($CaseType == '0'){$CaseTypeName = "Book / Publication";}
		if($CaseType == '1'){$CaseTypeName = "Lecture";}
		if($CaseType == '2'){$CaseTypeName = "WWW";}
		if($CaseType == '3'){$CaseTypeName = "Workshop";}
		if($CaseType == '4'){$CaseTypeName = "Homework";}
		if($CaseType == '5'){$CaseTypeName = "Lecture diary";}
		}
		$CaseGroup = ($_REQUEST["CaseGroup"]); /* Comes from TitleIndex.php when selecting Group dropdown */
	if($CaseGroup != ''){
		$CaseGroupName =	mysqli_query($cv,"SELECT * FROM test.groups WHERE Id = '$CaseGroup'");
		while ($abc = mysqli_fetch_row($CaseGroupName)) {
			$CaseGroupName = $abc[1];
		
		}
	}
	$All = ($_REQUEST["All"]); /* Comes from headers link Cases.php?All=true */
	if($RemoveId != ''){
		mysqli_query($cv,"DELETE FROM test.cases WHERE Id = '$RemoveId'");
		}
		
?>

<div>

	<!-- KEYWORDS LISTING -->
	<div style="float:right; width:300px;">
	<b>Keywords</b><br><br>
	<?php
		$Keywords =	mysqli_query($cv,"SELECT * FROM test.cases WHERE CaseGroup2 != '' ORDER BY CaseGroup2");
		while ($abc = mysqli_fetch_row($Keywords)) {
			if (strlen($abc[8])>2){  //If no more than 2 digits, no print
				
				if (strcspn($abc[8], '0123456789') != strlen($abc[8])){ //If numbers, no print
  			/*echo "true";*/ }
					else {
  					/*echo "false";*/
				
			print $abc[8]."<br>";
			}
		}
	}
	?>
	</div>
	<!-- / KEYWORDS LISTING -->		
	
	<?php
	
		/* PAGE TITLES + MAIN STYLE */
			
		if($CaseGroup!=''){
			print "<div class='CasesTableTitle'><h3>".$CaseGroupName."</h3></div>";
			print "<table class='CasesTable TitleSelected' style='width:1000px;'>";
			print "<tr>";
			}
			
		if($TitleId!='' && $CaseType==''){
			print "<div class='CasesTableTitle'><h3>".$TitleNumber." ".$TitleName."</h3></div>";
			print "<table class='CasesTable TitleSelected'>";
			print "<tr>";
			}
			
		if($TitleId!='' && $CaseType!=''){
			print "<div class='CasesTableTitle'><h3>".$TitleNumber." ".$TitleName." <span class='TOC TOC_".$CaseTypeName."'>".$CaseTypeName."</span></h3></div>";
			print "<table class='CasesTable TitleSelected'>";
			print "<tr>";
			}	
			
		if($TitleId=='' && $CaseType=='' && $CaseGroup=='' && $FreeTextSearch=='' && $CaseGroup3==''){
			print "<div class='CasesTableTitle'><h3>All cases</h3></div>";
			print "<table class='CasesTable'>";
			print "<tr>";
			print "<td>Id</td>";
			print "<td>Index Number and Title</td>";
			print "<td>CaseType</td>";
			print "<td>CaseTextarea</td>";
			print "<td>Source</td>";
			print "<td>CaseGroup</td>";
			print "<td>Created</td>";
			print "<td>Modified</td>";
			print "<td>Remove</td>";
			}
	
	/* / PAGE TITLES + MAIN STYLE */
	
	/* MAIN SEARCH FROM MYSQL */
	
	if($CaseGroup!=''){
		$CaseGrouptmp =	"AND CaseGroup = ".$CaseGroup;
		} else {
			$CaseGrouptmp =	"AND CaseGroup > 0";
			}
			
	if($CaseGroup3!=''){
		$CaseGroup3tmp =	"AND CaseGroup3 = ".$CaseGroup3;
		} 
	
	if($TitleId!=''){
		$TitleIdtmp =	"Title = ".$TitleId;
		} else {
			$TitleIdtmp =	"Title > 0";
			}
		
	if($CaseType!=''){
		$CaseTypetmp =	"AND CaseType = ".$CaseType;
		}	else {
			$CaseTypetmp =	"AND CaseType < 999";
			}
		
		
		
		if($FreeTextSearch!=''){
		$FreeTextSearchtmp =	"AND CaseTextarea LIKE '%".$FreeTextSearch."%' OR CaseGroup2 LIKE '%".$FreeTextSearch."%'";
		}
	
	/*	
		print $TitleIdtmp." ".$CaseTypetmp." ".$CaseGrouptmp." ".$FreeTextSearchtmp;
		*/
		
		
	$Cases =	mysqli_query($cv,"SELECT * FROM test.cases WHERE $TitleIdtmp $CaseTypetmp $CaseGrouptmp $CaseGroup3tmp $FreeTextSearchtmp ORDER BY CaseGroup2, CaseTimeCreated DESC");
	
		
		if($TitleId=='' && $CaseType=='' && $CaseGroup=='' && $FreeTextSearch=='' && $CaseGroup3tmp==''){
				$Cases =	mysqli_query($cv,"SELECT * FROM test.cases ORDER BY Title");
				}
	
	/* / MAIN SEARCH FROM MYSQL */
	
	
	/* MAIN SEARCH - VARIABLES */
		
		while ($abc = mysqli_fetch_row($Cases)) {
			$Id = $abc[0];
			$Title = $abc[1];
			$CaseType = $abc[2];
			$CaseTextarea = $abc[3];
			$CaseSource = $abc[4];
			$CaseGroup = $abc[5];
			$CaseTimeCreated = $abc[6];
			$CaseTimeModified = $abc[7];
			$CaseGroup2 = $abc[8];
			
			$TitleName =	mysqli_query($cv,"SELECT * FROM test.index WHERE Id = $Title");
			while ($abc = mysqli_fetch_row($TitleName)) {
				$TitleNumber = $abc[1];
				$TitleName = $abc[2];
				}
		
			if($CaseType == "0"){$CaseTypeName = "Book / Publication";}
			if($CaseType == "1"){$CaseTypeName = "Lecture";}
			if($CaseType == "2"){$CaseTypeName = "WWW";}
			if($CaseType == "3"){$CaseTypeName = "Workshop";}
			if($CaseType == "4"){$CaseTypeName = "Homework";}
			if($CaseType == "5"){$CaseTypeName = "Lecture diary";}
			
			$CaseSourceName =	mysqli_query($cv,"SELECT * FROM test.sources WHERE Id = $CaseSource");
			while ($abc = mysqli_fetch_row($CaseSourceName)) {
				$CaseSourceName = $abc[1];
				}
			
			$CaseGroupName =	mysqli_query($cv,"SELECT * FROM test.groups WHERE Id = $CaseGroup");
			while ($abc = mysqli_fetch_row($CaseGroupName)) {
				$CaseGroupName = $abc[1];
				}
			
			/* / MAIN SEARCH - VARIABLES */
			
			/* PRINTING MAIN SEARCH */
			print "<tr>";
			
		
		
			
			if($All == 'true'){
				print "<td><a href='Case.php?Id=".$Id."&EditCase=true'>".$Id."</a></td>";
				print "<td>".$TitleNumber." ".$TitleName."</td>";
				print "<td>".$CaseTypeName."</td>";
				print "<td>".$CaseTextarea."</td>";
				print "<td>".$CaseSourceName."</td>";
				print "<td>".$CaseGroupName."</td>";
				print "<td>".date('d.m.Y H:i:s', $CaseTimeCreated)."</td>";
				print "<td>".date('d.m.Y H:i:s', $CaseTimeModified)."</td>";
				print "<td><a href='Cases.php?RemoveId=".$Id."&All=true'>Remove case</a></td>";							
			}else{
				
						print "<td><hr><h4>".$TitleNumber.". ".$TitleName." <span class='TOC TOC_".$CaseTypeName."'>".$CaseTypeName."</span> <br> ".$CaseSourceName
				."<br>".$CaseGroupName."
				
				<br><a href='Case.php?Id=".$Id."&EditCase=true'>Edit</a>
				</h4><p>".date('d.m.Y H:i:s', $CaseTimeCreated)
				." ".$CaseGroup2." / ".date('d.m.Y H:i:s', $CaseTimeModified)."</p><p>".nl2br($CaseTextarea)."
				
				
				</p></td>";
		
			}
			
			print "</tr>";
			
			/* / PRINTING MAIN SEARCH */
			
			}
			print "</table>";
	
	?>


</div>

<?php include 'footer.php'; ?>