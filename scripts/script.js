/* 
Execute theese functions after the page has finished loading
to create this table witht he default values in the form fields
 */
 
document.addEventListener("DOMContentLoaded", selectART);
document.addEventListener("DOMContentLoaded", changeATs);
document.addEventListener("DOMContentLoaded", generate);

/* Execute the generate() function when the "Generate" button is clicked */

document.getElementById("generate").addEventListener("click", generate);


function selectART() {
	var artSelectorHTML = '';
	artSelectorHTML += '<select id="artSelector" name="art" onchange="changeATs()">\n';
	ART.forEach(function(element) {
		if ( defaultArtID == element.team_id ) {
					artSelectorHTML += '<option value="' + element.team_id.trim() + '" selected="selected">' + element.team_name.trim() + '</option>\n';
		} else {
					artSelectorHTML += '<option value="' + element.team_id.trim() + '">' + element.team_name.trim() + '</option>\n';
		}		

		}
	);
	artSelectorHTML += '</select>';
	document.getElementById("divArtSelector").innerHTML = artSelectorHTML;
};

function changeATs() {
	var artTeamID = document.getElementById("artSelector").value;
	var childrenATs = [];
	AT.forEach(function(element) {
  if ( element.parent_name == artTeamID ) {
    childrenATs.push(element.team_name.trim());
  }
});
document.getElementById("namesOfTeams").value = childrenATs.join(', ');	
}

function generate() {
    var piid = document.getElementById("piid").value;
    var piterations = 6;
    var art = document.getElementById("artSelector").value;
    var teamNamesArray = document.getElementById("namesOfTeams").value.split(', ');
    var rowArray = [];

/*     Initialize header row of the rowArray 2D array */

    rowArray[0] = ['No', 'Team Name'];
    for (i = 1; i <= piterations; i++) {
        rowArray[0].push(piid.concat('-', i));
    }
    rowArray[0].push(piid.concat('-IP'));

/*     Create display records (rows) for each teamNamesArray record */

    for (i = 1; i <= teamNamesArray.length; i++) {
        rowArray[i] = [i, teamNamesArray[i - 1]];
        for (j = 1; j <= piterations; j++) {
            rowArray[i].push(piid.concat('-', j));
        }
        rowArray[i].push(piid.concat('-IP'));
    }

/*     Format an HTML table from the gathered data */

    var htmlTable = '<table id="output_table">';

/*     Table Headers Row (rowArray[0]) */
    
    htmlTable += '<tr>';
    for (i = 0; i <= rowArray[0].length - 1; i++) {
        htmlTable += '<th>' + rowArray[0][i] + '</th>';
    }
    htmlTable += '</tr>';

/* 
    Table Data Row (rowArray[1] through rowArray[n])
    Inner and Outer loops (i and j) iterate through a 2D array, row by row
    If-then-else applies a dynamically-generated URL as necessary
*/
    
    for (i = 1; i <= rowArray.length - 1; i++) {
        htmlTable += '<tr>';
        for (j = 0; j <= rowArray[0].length - 1; j++) {
            htmlTable += '<td>';
            if (j >= 2) {
            		var htmlURL = baseURL + '?=' + rowArray[i][j] + '_' + rowArray[i][1];
                htmlTable += '<a data-tooltip="' + htmlURL + '"' + 'href="' + htmlURL + '" target="_blank">' + rowArray[i][j] + '</a>';
            } else {
                htmlTable += rowArray[i][j];
            }
            htmlTable += '</td>';
        }
        htmlTable += '</tr>';
    }

    htmlTable += '</table>';

/* Place the generated HTML table into the HTML in the "table_content" div area. */

    document.getElementById("table_content").innerHTML = htmlTable;
}