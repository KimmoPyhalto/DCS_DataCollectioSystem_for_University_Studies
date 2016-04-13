		<?php include 'header.php';
		 ?>

			<div id="IndexDiv">
				<a href="javascript:toggle_visibility('EditClass');">Edit</a> 	
				<div class="IndexRow IndexRowIdTitle EditClass"><h3>ID</h3></div>
			  <div class="IndexRow IndexRowNumberTitle"><h3>Title Number</h3></div>
			  <div class="IndexRow IndexRowTitleTitle"><h3>Abstraction Title</h3></div>
			  <div class="IndexRow IndexRowDeleteTitle EditClass"><h3>Save/Remove</h3></div>
				
				<?php
	
				$rowcount = 0;
			 	$NewRowNumber = ($_REQUEST["NewRowNumber"]);
				$NewTitleNumber = ($_REQUEST["NewTitleNumber"]);
				$NewTitle = ($_REQUEST["NewTitle"]);
				$RemoveRow = ($_REQUEST["RemoveRow"]);
				$EditIndexRowId = ($_REQUEST["EditIndexRowId"]);
				$EditIndexRowNumber = ($_REQUEST["EditIndexRowNumber"]);
				$EditIndexRowTitle = ($_REQUEST["EditIndexRowTitle"]);
				$id = ($_REQUEST["id"]);
					
				if ($NewRowNumber!=''&&$NewTitleNumber!=''&&$NewTitle!=''){
						mysqli_query($cv,"INSERT INTO test.index (Id, TitleNumber, Title)VALUES ('$NewRowNumber', '$NewTitleNumber','$NewTitle')");
			 			}
				if ($EditIndexRowNumber!=''){
						mysqli_query($cv,"UPDATE test.index SET TitleNumber='$EditIndexRowNumber' WHERE Id='$id'");
				 		}
				if ($EditIndexRowTitle!=''){
						mysqli_query($cv,"UPDATE test.index SET Title='$EditIndexRowTitle' WHERE Id='$id'");
				 		}
			 	if ($EditIndexRowId!=''){
						mysqli_query($cv,"UPDATE test.index SET Id='$EditIndexRowId' WHERE Id='$id'");
				 		}
			 	if ($RemoveRow!=''){
			 			mysqli_query($cv,"DELETE FROM test.index WHERE Id = '$RemoveRow'");
			 			}
			 
				$q = mysqli_query($cv,"SELECT * FROM test.index ORDER BY Id");
				while ($abc = mysqli_fetch_row($q)) {
			  	$rowcount++;
											
					$IndexRowTitleCount = substr_count($abc[1], '.');
										
					if($IndexRowTitleCount == "0"){
						$IndexRowTitleClass = "IndexRowTitle0";
						$IndexRowTitleTag = "h4";
						}
					
					if($IndexRowTitleCount == "1"){
						$IndexRowTitleClass = "IndexRowTitle1";
						$IndexRowTitleTag = "h5";
						}
					
					if($IndexRowTitleCount == "2"){
						$IndexRowTitleClass = "IndexRowTitle2";
						$IndexRowTitleTag = "h6";
						}
					
					$InclBook = "";
					$InclLecture = "";
					$InclWWW = "";
					$InclWorkshop = "";
					$InclHomework = "";
					$InclLecturediary = "";
					$q2 = mysqli_query($cv,"SELECT * FROM test.cases WHERE Title = $abc[0];");
					while ($abc2 = mysqli_fetch_row($q2)) {
					
						$CaseType = $abc2[2];
						if($CaseType == '0'){$InclBook = "<u><a class='TOC TOC_Book' href='Cases.php?TitleId=".$abc[0]."&CaseType=0'>Bo</a></u>";}
						if($CaseType == '1'){$InclLecture = "<u><a class='TOC TOC_Lecture' href='Cases.php?TitleId=".$abc[0]."&CaseType=1'>Le</a></u>";}
						if($CaseType == '2'){$InclWWW = "<u><a class='TOC TOC_WWW' href='Cases.php?TitleId=".$abc[0]."&CaseType=2'>WWW</a></u>";}
						if($CaseType == '3'){$InclWorkshop = "<u><a class='TOC TOC_Workshop' href='Cases.php?TitleId=".$abc[0]."&CaseType=3'>Ws</a></u>";}
						if($CaseType == '4'){$InclHomework = "<u><a class='TOC TOC_Homework' href='Cases.php?TitleId=".$abc[0]."&CaseType=4'>Hw</a></u>";}
						if($CaseType == '5'){$InclLecturediary = "<u><a class='TOC TOC_Lecturediary' href='Cases.php?TitleId=".$abc[0]."&CaseType=5'>Ld</a></u>";}
					}
						
					print "<form action='' method='POST'>";
			   
			 			print "<input type='hidden' name='id' value='";
			  		print htmlspecialchars($abc[0]);
			   		print "'>";
			   		print "<div class='clearer' style='clear:both;'>";
			    	print "<div class='IndexRow IndexRowId EditClass'>".
			    					htmlspecialchars($abc[0]).
			    					"<input class='EditClass' type='text' name='EditIndexRowId'>
			    				</div>";
			    	print "<div class='IndexRow IndexRowNumber ".$IndexRowTitleClass."'><".$IndexRowTitleTag.">".
			    					htmlspecialchars($abc[1])."</".$IndexRowTitleTag.">".
			    					"<input class='EditClass' type='text' name='EditIndexRowNumber'>
			    	    	</div>";
			    	print "<div class='IndexRow IndexRowTitle'>";
			    	print "<".$IndexRowTitleTag."><a class='IndexRowLink' style='color:#060390;' href='Cases.php?TitleId=".$abc[0]."'>".htmlspecialchars($abc[2])."</a> ";
			    	print $InclBook.$InclLecture.$InclWWW.$InclWorkshop.$InclHomework.$InclLecturediary;
			    	print " </".$IndexRowTitleTag.">";
			    	
			    	
			    	print	"<input class='EditClass' type='text' name='EditIndexRowTitle'>";
			    	print "</div>";
			    	print "<div class='IndexRow IndexRowDelete EditClass'>
			    					<input type='submit' value='Save'>
			    				</form>
			    		    	<a href='TitleIndex.php?RemoveRow=".
			    					($abc[0]).
			    					"'><img src='images/icon_delete.png'></a>
			    				</div>";
					print "</div>";
					
					
					}
			           
				?>     
				
			</div>
		
		<?php include 'footer.php'; ?>
		
	