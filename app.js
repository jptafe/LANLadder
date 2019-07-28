// localStorage Initialsation (we'll) need to update these lists, when we enact changes)
//
getAllTeams();
getAllLadders();
getAllPlayers();
getAllPlayedMatches();
getAllUnPlayedMatches();

// Event Registration
// 
document.getElementById('form_addteam').addEventListener('submit', function(e) {addTeamProcess(e)});
document.getElementById('form_addmatch').addEventListener('submit', function(e) {addMatchProcess(e)});
document.getElementById('form_regplayer').addEventListener('submit', function(e) {registerPlayerProcess(e)});
document.getElementById('form_addladder').addEventListener('submit', function(e) {addLadderProcess(e)});
document.getElementById('form_jointeam').addEventListener('submit', function(e) {joinTeamProcess(e)});
document.getElementById('form_login').addEventListener('submit', function(e) {loginProcess(e)});
document.getElementById('form_reportmatch').addEventListener('submit', function(e) {reportMatchProcess(e)});
document.getElementById('form_showplayers').addEventListener('submit', function(e) {showPlayersForm(e)});

function form_showplayers(evt) {
    // GIMPED 
    evt.preventDefault();
    console.log('showPlayersForm');
}

// User actuated functions
//
// Authenticted function
function addTeamProcess(evt) {
    evt.preventDefault();
    var name = evt.srcElement[0].value;
    var color = evt.srcElement[1].value.substr(1,6);
    var icon = evt.srcElement[2].value;
    var url = 'ws/ws.php?reqcode=createteam&playerid=1&teamname=' + name + '&teamcolor=' + color + '&imageurl=' + icon;
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
                getAllTeams();
            });
        }
    )
}
function registerPlayerProcess(evt) {
    evt.preventDefault();
    var playerName = evt.srcElement[0].value;
    var pass1 = evt.srcElement[1].value;
    var pass2 = evt.srcElement[2].value;
    var seated = evt.srcElement[3].value;
    var team_id = evt.srcElement[4].value;
    var url = 'ws/ws.php?reqcode=createplayer&teamid=' + team_id + '&playername=' + playerName + '&password=' + pass1 + '&location=' + seated;
    if(pass1 != pass2) { 
        alert('pass does not match');
    } else {
        if(team_id == 0) {
            team_id = 1;
        }
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
                    getAllPlayers();
            });
            }
        ) 
    } 
} 
// Admin function
function addMatchProcess(evt) {
    evt.preventDefault();
    var teamA = evt.srcElement[0].value;
    var teamB = evt.srcElement[1].value;
    var ladder = evt.srcElement[2].value;
    var starttime = new Date(evt.srcElement[3].value).toISOString();
    var starttime = starttime.replace('T', ' ');
    var starttime = starttime.replace(/-/g, '/');
    var starttime = starttime.split('Z');
    var starttime = starttime[0].split('.');
    var url = 'ws/ws.php?reqcode=creatematch&teamid=' + teamA + '&teambid=' + teamB + '&ladderid=' + ladder + '&starttime=' + starttime[0];
    if(teamA == teamB) {
        alert('teams should not match');
    } else {
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
                    getAllUnPlayedMatches();
                });
            }
        )
    }
}

// Authenticted function
function joinTeamProcess(evt) {
    evt.preventDefault();
    var player_id = evt.srcElement[0].value;
    var team_id = evt.srcElement[1].value;
    var url = 'ws/ws.php?reqcode=jointeam&playerid=' + player_id + '&teamid=' + team_id; 
    if(team_id == 0) {
        team_id = 1;
    }
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
                getAllPlayers();
            });
        }
    )
}
// Admin function
function addLadderProcess(evt) {
    evt.preventDefault();
    console.log('ws/ws.php?reqcode=createladder');
}
// Authenticted function
function reportMatchProcess(evt) {
    evt.preventDefault();
    console.log('ws/ws.php?reqcode=reportplayedmatch&playerid=1&matchid=2&winloss=win');
}
function loginProcess(evt) {
    evt.preventDefault();
    console.log('ws/ws.php?reqcode=auth');
}
// Data Acquisition Functions
//
function getAllPlayers() {
    fetch('ws/ws.php?reqcode=allplayers', {
        method: 'GET',
        credentials: 'include'
    })
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                localStorage.setItem('allPlayers', JSON.stringify(data));
            });
        }
    )
}
function getAllTeams() {  
    fetch('ws/ws.php?reqcode=allteams', {
        method: 'GET',
        credentials: 'include'
    })
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                localStorage.setItem('allTeams', JSON.stringify(data));
            });
        }
    )
}
function getAllLadders() {  
    fetch('ws/ws.php?reqcode=allladders', {
        method: 'GET',
        credentials: 'include'
    })
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                localStorage.setItem('allLadders', JSON.stringify(data));
            });
        }
    )
}
function getAllPlayedMatches() {  
    fetch('ws/ws.php?reqcode=allplayedmatches', {
        method: 'GET',
        credentials: 'include'
    })
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                localStorage.setItem('allPlayedMatches', JSON.stringify(data));
            });
        }
    )
}
function getAllUnPlayedMatches() {  
    fetch('ws/ws.php?reqcode=allunreportedmatches', {
        method: 'GET',
        credentials: 'include'
    })
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                localStorage.setItem('allUnPlayedMatches', JSON.stringify(data));
            });
        }
    )
}
function populateAllTeamsInForm(elem) {
    var HTMLTeams = '';
    var JSONTeams = JSON.parse(localStorage.getItem('allTeams'));
    for(var loop = 0;loop<JSONTeams.length;loop++) {
        HTMLTeams += '<option value="' + JSONTeams[loop].id + '">' + JSONTeams[loop].team_name + '</option>';
    }
    elem.innerHTML = '<option value="">Choose One...</option>' + HTMLTeams;
}
function populateAllLaddersInForm(elem) {
    var HTMLLadders = '';
    var JSONLadders = JSON.parse(localStorage.getItem('allLadders'));
    for(var loop = 0;loop<JSONLadders.length;loop++) {
        HTMLLadders += '<option value="' + JSONLadders[loop].id + '">' + JSONLadders[loop].game + '</option>';
    }
    elem.innerHTML = '<option value="">Choose One...</option>' + HTMLLadders;
}
function populateTeamsInLadder(elem, ladder) {
    var HTMLTeams = '';
    var loopindex;
    var JSONTeams = JSON.parse(localStorage.getItem('allTeams'));
    var JSONUnPlayedMatches = JSON.parse(localStorage.getItem('allUnPlayedMatches'));
    var uniqueTeamResult = new Set;
    for(var loop = 0;loop<JSONUnPlayedMatches.length;loop++) {
        if(JSONUnPlayedMatches[loop].ladder_id == ladder) {
            uniqueTeamResult.add(JSONUnPlayedMatches[loop].team_a_id);
            uniqueTeamResult.add(JSONUnPlayedMatches[loop].team_b_id);
        }
    }
    uniqueTeamResult = Array.from(uniqueTeamResult); 
    console.log(uniqueTeamResult);
    for(var loop = 0;loop<JSONTeams.length;loop++) {
        if(uniqueTeamResult.indexOf(JSONTeams[loop].id) != -1) {
            HTMLTeams += '<option value="' + JSONTeams[loop].id + '">' + JSONTeams[loop].team_name + '</option>';
        }
    }
    if(HTMLTeams.length > 0) {
        elem.nextElementSibling.removeAttribute('disabled');
        elem.nextElementSibling.innerHTML = '<option value="">Choose Team...</option>' + HTMLTeams;
    } else {
        elem.nextElementSibling.setAttribute('disabled','');
        elem.nextElementSibling.innerHTML = '<option value="">Teams not Populated</option>';
    }
    // incomplete list unplayed matches...
}
function populatePlayersInATeam(elem, team) {
    var HTMLPlayers = '';
    var JSONPlayers = JSON.parse(localStorage.getItem('allPlayers'));
    for(var loop = 0;loop<JSONPlayers.length;loop++) {
        if(JSONPlayers[loop].team_id == team) {
            HTMLPlayers += '<option value="' + JSONPlayers[loop].id + '">' + JSONPlayers[loop].name + '</option>';
        }
    }
    if(HTMLPlayers.length > 0) {
        elem.nextElementSibling.removeAttribute('disabled');
        elem.nextElementSibling.innerHTML = HTMLPlayers;
    } else {
        elem.nextElementSibling.setAttribute('disabled','');
        elem.nextElementSibling.innerHTML = '<option value="">Players not Populated</option>';
    }
}
function populatePlayers(elem) {
    var HTMLPlayers = '';
    var JSONPlayers = JSON.parse(localStorage.getItem('allPlayers'));
    for(var loop = 0;loop<JSONPlayers.length;loop++) {
        HTMLPlayers += '<option value="' + JSONPlayers[loop].id + '">' + JSONPlayers[loop].name + '</option>';
    }
    elem.innerHTML = '<option value="">Choose One...</option>' + HTMLPlayers;
}
function populateTeamsInFormForLadder(elem, teamID) {
}
function getLadders() {
}
function getPlayers() {
}
