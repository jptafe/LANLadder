function populateplayers(teamid) {
    var url = '../ws/ws.php?reqcode=playersinteam&teamid=' + teamid;
    var HTMLCode = '';
    var HTMLTemplate = player_entry.innerHTML;
    var id = 'players_in_team_' + teamid; 
    fetch(url, {
        method: 'GET',
        credentials: 'include'
    })
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
		if(data.result == 'false') {
		    document.getElementById(id).innerHTML = 'no players found';
		} else {
		    for(var loop = 0; loop<data.length;loop++) {
			HTMLCode += HTMLTemplate.replace(/{{playername}}/g, data[loop].name)
			    .replace(/{{playerid}}/g, data[loop].id);
		    }
		}
		document.getElementById(id).innerHTML = HTMLCode;
            });
        }
    )
}
function fetchteams() {
    var HTMLCode = '';
    var HTMLTemplate = team_head.innerHTML;
    fetch('../ws/ws.php?reqcode=allteams', {
        method: 'GET',
        credentials: 'include'
    })
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
		for(var loop = 0; loop<data.length;loop++) {
		    HTMLCode += HTMLTemplate.replace(/{{teamname}}/g, data[loop].team_name)
			.replace(/{{teamid}}/g, data[loop].id);
		}
		team_player_list.innerHTML = HTMLCode;
            });
        }
    )
}
