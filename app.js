// localStorage Initialsation (we'll) need to update these lists, when we enact changes)
//
getAllTeams();
getAllLadders();
getAllPlayers();

// Remove this call
getAllPlayedMatches();

getAllUnPlayedMatches();
isLoggedIn();

//
// Interface Pre-Render from localStorage Data
teamsWithPlayers();
laddersWithTeamsofUnplayedMatches();
lnadderListWithCompletedResults();
populateStatusPanel();

function populateStatusPanel() {
    var HTMLStatusValues;
    var JSONTeams = JSON.parse(localStorage.getItem('allTeams'));
    var JSONPlayers = JSON.parse(localStorage.getItem('allPlayers'));
    var JSONLadders = JSON.parse(localStorage.getItem('allLadders'));
    var JSONPlayedMatches = JSON.parse(localStorage.getItem('allPlayedMatches'));
    var JSONUnPlayedMatches = JSON.parse(localStorage.getItem('allUnPlayedMatches'));

    HTMLStatusValues = '<a href="#" title="players"><span uk-icon="icon: user"></span>:' + JSONPlayers.length + 
        '</a> - <a href="#" title="teams"><span uk-icon="icon: users"></span>:' + JSONTeams.length + 
        '</a> - <a href="#" title="Ladders"><span uk-icon="icon: calendar"></span>:' + JSONLadders.length +
        '</a> - <a href="#" title="played matches"><span uk-icon="icon: play-circle"></span>:' + JSONPlayedMatches.length + 
        '</a> - <a href="#" title="unplayed matches"><span uk-icon="icon: microphone"></span>:' + JSONUnPlayedMatches.length + '</a>';
    status_panel.innerHTML = HTMLStatusValues;
}

function teamsWithPlayers() {
    var HTMLTeamList = '<article>';
    var HTMLPlayerList = '';
    var JSONTeams = JSON.parse(localStorage.getItem('allTeams'));
    var JSONPlayers = JSON.parse(localStorage.getItem('allPlayers'));
    for(var loop = 0;loop<JSONTeams.length;loop++) {
        HTMLTeamList += '<aside style="background-color: #' + JSONTeams[loop].color + ';"><h1>' + JSONTeams[loop].team_name +
            '<img src="img/' + JSONTeams[loop].image + '" width="100%"></h1><input type="checkbox">';
        for(var loop2 = 0;loop2<JSONPlayers.length;loop2++) {
            if(JSONPlayers[loop2].team_id == JSONTeams[loop].id) {
                HTMLPlayerList += '<h5>' + JSONPlayers[loop2].name + ' - ' + JSONPlayers[loop2].seated_loc + '</h5>'; 
            }
        }
        if(HTMLPlayerList.length > 0) {
            HTMLTeamList += '<aside class="fixfloat">' + HTMLPlayerList + '</aside>';            
            HTMLPlayerList = '';
        }
        HTMLTeamList += '</aside>';
    }
    HTMLTeamList += '<p>Kill the checkbox if its the last child</p></article>';
    teams_with_players.innerHTML = HTMLTeamList; 
}
function laddersWithTeamsofUnplayedMatches() {
    var HTMLLadderList = '<article>';
    var JSONLadders = JSON.parse(localStorage.getItem('allLadders'));
    for(var loop = 0;loop<JSONLadders.length;loop++) {
        HTMLLadderList += '<aside style="background-color: #' + JSONLadders[loop].color + ';"><h3>' + 
            JSONLadders[loop].game +
            '<img src="img/' + JSONLadders[loop].image + '"></h3>';
        HTMLLadderList += '</aside>';
    }
    HTMLLadderList += '</article>';
    panel_ladder_team_report_form.innerHTML = HTMLLadderList; 
}

function lnadderListWithCompletedResults() {
    var JSONLadders = JSON.parse(localStorage.getItem('allLadders'));

    var templateLadderHeadHTML = document.getElementById('template_ladder_head').innerHTML;
    var renderedHTML = '<ul uk-accordion>';

    for(var loop = 0;loop < JSONLadders.length;loop++) {
        renderedHTML += '<li onclick="getLadderPlayedMatches(' + JSONLadders[loop].id + ')">';
        renderedHTML += templateLadderHeadHTML.replace(/{{ladderTitle}}/g, JSONLadders[loop].game);
        renderedHTML += '<div class="uk-accordion-content" id="ladder_list_' + JSONLadders[loop].id + '">';
        renderedHTML += '<div uk-spinner></div>';
        renderedHTML += '</div>';
        renderedHTML += '</li>';
    }
    

    panel_ladder_results.innerHTML = renderedHTML + '</ul>';
}

//Interface manipulation
function disableAllForms() {
    var allForms = document.getElementsByTagName('form');
    for(var loop = 0;loop<allForms.length;loop++) {
        if(allForms[loop].children[0].innerHTML == 'Login' ||
               allForms[loop].children[0].innerHTML == 'Create Player') {
            var formElements = allForms[loop].children;
            for(var loop2 = 0;loop2<formElements.length;loop2++) {
                if(formElements[loop2].localName == 'input' || formElements[loop2].localName == 'select') {
                    formElements[loop2].removeAttribute('disabled');
                }
            }
        } else {
            var formElements = allForms[loop].children;
            for(var loop2 = 0;loop2<formElements.length;loop2++) {
                if(formElements[loop2].localName == 'input' || formElements[loop2].localName == 'select') {
                    formElements[loop2].setAttribute('disabled','');
                }
            }
        }
    }
}
function enableAllForms() {
    var allForms = document.getElementsByTagName('form');
    for(var loop = 0;loop<allForms.length;loop++) {
        var formElements = allForms[loop].children;
        if(allForms[loop].children[0].innerHTML == 'Login' ||
               allForms[loop].children[0].innerHTML == 'Create Player') {
            for(var loop2 = 0;loop2<formElements.length;loop2++) {
                if(formElements[loop2].localName == 'input' || formElements[loop2].localName == 'select') {
                    formElements[loop2].setAttribute('disabled', '');
                }
            }
        } else {
            for(var loop2 = 0;loop2<formElements.length;loop2++) {
                if(formElements[loop2].localName == 'input' || formElements[loop2].localName == 'select') {
                    formElements[loop2].removeAttribute('disabled');
                }
            }
        }
    }
}
function clearForm(evt) {
    for(var loop = 0;loop < evt.srcElement.length;loop++) {
        if(evt.srcElement[loop].type == 'text' || 
                evt.srcElement[loop].type == 'password') {
            evt.srcElement[loop].value = '';
        }
        if(evt.srcElement[loop].type == 'number') {
            evt.srcElement[loop].value = '0';
        }
        if(evt.srcElement[loop].localName == 'select') {
            evt.srcElement[loop].value = '0';
        }
    }
}

// Events
// Submit:
document.getElementById('form_addteam').addEventListener('submit', function(e) {addTeamProcess(e)});
document.getElementById('form_addmatch').addEventListener('submit', function(e) {addMatchProcess(e)});
document.getElementById('form_regplayer').addEventListener('submit', function(e) {registerPlayerProcess(e)});
document.getElementById('form_addladder').addEventListener('submit', function(e) {addLadderProcess(e)});
document.getElementById('form_jointeam').addEventListener('submit', function(e) {joinTeamProcess(e)});
document.getElementById('form_login').addEventListener('submit', function(e) {loginProcess(e)});
document.getElementById('form_reportmatch').addEventListener('submit', function(e) {reportMatchProcess(e)});
document.getElementById('form_showplayers').addEventListener('submit', function(e) {showPlayersForm(e)});
document.getElementById('form_logout').addEventListener('submit', function(e) {logoutNowForm(e)});

// change events
document.getElementById('teamainladder').addEventListener('change', function(e) {checkSameTeamNextForm(e)});
document.getElementById('teambinladder').addEventListener('change', function(e) {checkSameTeamPreviousForm(e)});

// Window events
//window.onfocus = function() {isLoggedIn();};

function showPlayersForm(evt) {
    // GIMPED FORM that does not submit
    evt.preventDefault();
    console.log('showPlayersForm');
}
// Authenticted functions
function addTeamProcess(evt) {
    evt.preventDefault();
    var name = evt.srcElement[0].value;
    var color = evt.srcElement[1].value.substr(1,6);
    var icon = evt.srcElement[2].value;
    var url = 'ws/ws.php?reqcode=createteam&playerid=1&name=' + name + '&color=' + color + '&imageurl=' + icon;
    if(icon == '0') {
        evt.srcElement[2].setCustomValidity("Choose an Icon");
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
                    getAllTeams();
                });
            }
        )
    }
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
function logoutNowForm(evt) {
    evt.preventDefault(evt);
    fetch('ws/ws.php?reqcode=deauth', {
        method: 'GET',
        credentials: 'include'
    })
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                localStorage.setItem('authcode', null);
                disableAllForms();
            });
        }
    )
}
function reportMatchProcess(evt) {
    evt.preventDefault();
    console.log('ws/ws.php?reqcode=reportplayedmatch&playerid=1&matchid=2&winloss=win');
}
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

// Admin functions
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
    var url = 'ws/ws.php?reqcode=creatematch&teamid=' + teamA + '&teambid=' + teamB + '&ladderid=' + 
                ladder + '&starttime=' + starttime[0];
    var allGood = true;
    if(teamA == '0') {
        evt.srcElement[0].setCustomValidity("team A must be entered");
        allGood = false;
    } 
    if(teamB == '0') {
        evt.srcElement[1].setCustomValidity("team A must be entered");
        allGood = false;
    } 
    if(ladder == '0') {
        evt.srcElement[2].setCustomValidity("team A must be entered");
        allGood = false;
    } 
    if(teamA == teamB) {
        evt.srcElement[0].setCustomValidity("teams should not match");
        evt.srcElement[1].setCustomValidity("teams should not match");
        allGood = false;
    } 
    if(allGood) {
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
function addLadderProcess(evt) {
    evt.preventDefault();
    var gameName = evt.srcElement[0].value;
    var description = evt.srcElement[1].value;
    var memberNo = evt.srcElement[2].value;
    var teamColor = evt.srcElement[3].value.substr(1,6);
    var teamImage = evt.srcElement[4].value;
    var teamTime = new Date(evt.srcElement[5].value).toISOString();
    var teamTime = teamTime.replace('T', ' ');
    var teamTime = teamTime.replace(/-/g, '/');
    var teamTime = teamTime.split('Z');
    var teamTime = teamTime[0].split('.');
    var url = 'ws/ws.php?reqcode=createladder&name=' + gameName + '&desc=' + description + '&members=' + memberNo + 
        '&color=' + teamColor + '&imageurl=' + teamImage + '&starttime=' + teamTime[0];
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
                getAllLadders();
            });
        }
    )
}
// Anonymous Functions
function isLoggedIn() {
    var url = 'ws/ws.php?reqcode=isauth';
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
                if(data.auth != 'false') {
                    localStorage.setItem('authcode', data.auth);
                    enableAllForms();
                } else {
                    localStorage.setItem('authcode', null);
                    disableAllForms();
                }
            });
        }
    )
}
function checkExistingUser(elem) {
    var username = elem.value;
    var url = 'ws/ws.php?reqcode=userexists&name=' + username;
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
                if(data.user == "notfound") {
                    elem.setCustomValidity("");
                } else {
                    elem.setCustomValidity("User Exists");
                }
            });
        }
    )
}
function checkSameTeamNextForm(elem) {
    if(elem.srcElement.nextElementSibling.value == elem.srcElement.value) {
        elem.srcElement.nextElementSibling.setCustomValidity("Team can't comete with itself");
        elem.srcElement.setCustomValidity("Team can't comete with itself");
    } else {
        elem.srcElement.nextElementSibling.setCustomValidity("");
        elem.srcElement.setCustomValidity("");
    }
}
function checkSameTeamPreviousForm(elem) {
    if(elem.srcElement.previousElementSibling.value == elem.srcElement.value) {
        elem.srcElement.previousElementSibling.setCustomValidity("Team can't comete with itself");
        elem.srcElement.setCustomValidity("Team can't comete with itself");
    } else {
        elem.srcElement.previousElementSibling.setCustomValidity("");
        elem.srcElement.setCustomValidity("");
    }
}
function loginProcess(evt) {
    evt.preventDefault();
    var fd = new FormData();
    fd.append('username', evt.srcElement[0].value);
    fd.append('password', evt.srcElement[1].value);
    var url = 'ws/ws.php?reqcode=auth';
    fetch(url, {
        method: 'POST',
        body: fd,
        mode: 'cors',
        credentials: 'include'
    })
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                if(data.user == -1) {
                    localStorage.setItem('authcode', null);
                } else {
                    localStorage.setItem('authcode', data.user);
                    clearForm(evt);
                    enableAllForms();
                }
            });
        }
    )
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
function getLadderPlayedMatches(ladder) {
    var ladderId = 'ladder_list_' + ladder;
    var JSONTeams = JSON.parse(localStorage.getItem('allTeams'));
    var team
    var ladderHTML = '<table class="uk-table uk-table-small">';
    ladderHTML += '<thead><tr><th>Team</th><th>Wins</th><th>Losses</th></tr></thead><tbody>';
    var url = 'ws/ws.php?reqcode=ladderlist&ladderid=' + ladder; 
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
                console.log(data);
                console.log(JSONTeams);
                if(data.result == false) {
                    document.getElementById(ladderId).innerHTML = 'No Ladder Found';
                } else {
                    for(var loop = 0;loop < data.length;loop++) {
                        for(var loop2 = 0;loop2<JSONTeams.length;loop2++) {
                            if(data[loop].teama == JSONTeams[loop2].id) {
                                ladderHTML += '<tr><td>' + JSONTeams[loop2].team_name + '</td><td>' + 
                                    data[loop].wins + '</td><td>' + data[loop].losses + '</td></tr>'; 
                            }
                        }
                    }
                    document.getElementById(ladderId).innerHTML = ladderHTML + '</tbody></table>'; 
                }
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
    elem.innerHTML = '<option value="0" disabled>Choose One...</option>' + HTMLTeams;
}
function populateAllLaddersInForm(elem) {
    var HTMLLadders = '';
    var JSONLadders = JSON.parse(localStorage.getItem('allLadders'));
    for(var loop = 0;loop<JSONLadders.length;loop++) {
        HTMLLadders += '<option value="' + JSONLadders[loop].id + '">' + JSONLadders[loop].game + '</option>';
    }
    elem.innerHTML = '<option value="0" disabled>Choose One...</option>' + HTMLLadders;
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
    for(var loop = 0;loop<JSONTeams.length;loop++) {
        if(uniqueTeamResult.indexOf(JSONTeams[loop].id) != -1) {
            HTMLTeams += '<option value="' + JSONTeams[loop].id + '">' + JSONTeams[loop].team_name + '</option>';
        }
    }
    if(HTMLTeams.length > 0) {
        elem.nextElementSibling.removeAttribute('disabled');
        elem.nextElementSibling.innerHTML = '<option value="0" disabled>Choose Team...</option>' + HTMLTeams;
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
    elem.innerHTML = '<option value="" disabled>Choose One...</option>' + HTMLPlayers;
}
function populateTeamsInFormForLadder(elem, teamID) {
}
function getLadders() {
}
function getPlayers() {
}
