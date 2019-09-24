isLoggedIn();
populateForms();

//Interface manipulation
function loggedOutMenu() {
    menu_logout.setAttribute('hidden','hidden');
    menu_login.removeAttribute('hidden');
    menu_register.removeAttribute('hidden');
    menu_addteam.setAttribute('hidden','hidden');
    menu_addladder.setAttribute('hidden','hidden');
    menu_creatematch.setAttribute('hidden','hidden');
    menu_matchreport.setAttribute('hidden','hidden');
    menu_teamlist.removeAttribute('hidden');
    menu_joinkickteam.setAttribute('hidden','hidden');
    UIkit.tab(nav_content_tabs).show(0);
}
function loggedInMenu() {
    menu_logout.removeAttribute('hidden');
    menu_login.setAttribute('hidden','hidden');
    menu_register.setAttribute('hidden','hidden');
    menu_addteam.removeAttribute('hidden');
    menu_addladder.removeAttribute('hidden');
    menu_creatematch.removeAttribute('hidden');
    menu_matchreport.removeAttribute('hidden');
    menu_teamlist.setAttribute('hidden', 'hidden');
    menu_joinkickteam.removeAttribute('hidden');
    UIkit.tab(nav_content_tabs).show(8);
}
function populateForms() {
    var datetimes = document.getElementsByTagName('input');
    for(var loop = 0; loop < datetimes.length;loop++) {
        if(datetimes[loop].type == 'datetime-local') {
            var startTime = new Date();
            var startOffset = new Date().getTimezoneOffset() * 60 * 1000;
            var localTime = startTime - startOffset;
            newTime = new Date(localTime).toISOString();
            datetimes[loop].value = newTime.substr(0, 17) + '00';
        }
    }
}
function teamsWithPlayersEdit() { // Need to edit this so that it uses a template better...
    var JSONTeams = JSON.parse(localStorage.getItem('allTeams'));
    var JSONPlayers = JSON.parse(localStorage.getItem('allPlayers'));
    var templateEditTeamsHead = document.getElementById('template_edit_team_member_list').innerHTML;
    var renderedHTML = '<ul uk-accordion>';
    var playerHTML = '';

    var renderedHTML = '<ul uk-accordion>';
 
    for(var loop = 0;loop<JSONTeams.length;loop++) {
        renderedHTML += '<li>';
        renderedHTML += templateEditTeamsHead.replace(/{{teamTitle}}/g, JSONTeams[loop].team_name)
                .replace(/{{teamImage}}/g, JSONTeams[loop].image)
                .replace(/{{teamColor}}/g, JSONTeams[loop].color);
        renderedHTML += '<div class="uk-accordion-content">';

        for(var loop2 = 0;loop2<JSONPlayers.length;loop2++) {
            if(JSONPlayers[loop2].team_id == JSONTeams[loop].id) {
                playerHTML += '<tr><td><i class="ra ' + JSONPlayers[loop2].image + '"></i></td><td>' + JSONPlayers[loop2].name + '</td><td>' + JSONPlayers[loop2].seated_loc + '</td></tr>';
            }
        }
        if(playerHTML.length == 0) {
            renderedHTML += '<p>No Players</p>';
        } else {
            renderedHTML += '<table class="uk-table uk-table-small"><thead><tr><th>icon</th><th>name</th><th>location</th></tr></thead>' + playerHTML + '</table>';
        }
        playerHTML = '';
        renderedHTML += '</div>';
    }
    renderedHTML += '</ul>';
    edit_teams_with_players.innerHTML = renderedHTML;   
}
function teamsWithPlayers() {
    var JSONTeams = JSON.parse(localStorage.getItem('allTeams'));
    var JSONPlayers = JSON.parse(localStorage.getItem('allPlayers'));

    var templateLadderHeadHTML = document.getElementById('template_team_member_list').innerHTML;
    var renderedHTML = '<ul uk-accordion>';
    var playerHTML = '';

    for(var loop = 0;loop<JSONTeams.length;loop++) {
        renderedHTML += '<li>';
        renderedHTML += templateLadderHeadHTML.replace(/{{teamTitle}}/g, JSONTeams[loop].team_name)
                .replace(/{{teamImage}}/g, JSONTeams[loop].image)
                .replace(/{{teamColor}}/g, JSONTeams[loop].color);
        renderedHTML += '<div class="uk-accordion-content">';

        for(var loop2 = 0;loop2<JSONPlayers.length;loop2++) {
            if(JSONPlayers[loop2].team_id == JSONTeams[loop].id) {
                playerHTML += '<tr><td><i class="ra ' + JSONPlayers[loop2].image + '"></i></td><td>' + JSONPlayers[loop2].name + '</td><td>' + JSONPlayers[loop2].seated_loc + '</td></tr>';
            }
        }
        if(playerHTML.length == 0) {
            renderedHTML += '<p>No Players</p>';
        } else {
            renderedHTML += '<table class="uk-table uk-table-small"><thead><tr><th>icon</th><th>name</th><th>location</th></tr></thead>' + playerHTML + '</table>';
        }
        playerHTML = '';
        renderedHTML += '</div>';
    }
    renderedHTML += '</ul>';
    teams_with_players.innerHTML = renderedHTML;
}
function laddersWithUnplayedMatches() {
    var JSONLadders = JSON.parse(localStorage.getItem('allLadders'));

    var templateLadderHeadHTML = document.getElementById('template_ladder_head_unplayed').innerHTML;
    var renderedHTML = '<ul uk-accordion>';

    for(var loop = 0;loop < JSONLadders.length;loop++) {
        renderedHTML += '<li>';
        renderedHTML += templateLadderHeadHTML.replace(/{{ladderTitle}}/g, JSONLadders[loop].game)
                .replace(/{{ladderImage}}/g, JSONLadders[loop].image)
                .replace(/{{ladderColor}}/g, JSONLadders[loop].color)
                .replace(/{{ladderID}}/g, JSONLadders[loop].id);
        renderedHTML += '<div class="uk-accordion-content" id="reported_ladder_list_' + JSONLadders[loop].id + '" uk-grid>';
        renderedHTML += '<p uk-spinner></p>';
        renderedHTML += '</div>';
        renderedHTML += '</li>';
    }
    panel_ladder_team_report_form.innerHTML = renderedHTML + '</ul>';
}
function ladderListWithCompletedResults() {
    var JSONLadders = JSON.parse(localStorage.getItem('allLadders'));

    var templateLadderHeadHTML = document.getElementById('template_ladder_head_played').innerHTML;
    var renderedHTML = '<ul uk-accordion>';

    for(var loop = 0;loop < JSONLadders.length;loop++) {
        renderedHTML += '<li>';
        renderedHTML += templateLadderHeadHTML.replace(/{{ladderTitle}}/g, JSONLadders[loop].game)
                .replace(/{{ladderImage}}/g, JSONLadders[loop].image)
                .replace(/{{ladderColor}}/g, JSONLadders[loop].color)
                .replace(/{{ladderID}}/g, JSONLadders[loop].id); 
        renderedHTML += '<div class="uk-accordion-content" id="ladder_list_' + JSONLadders[loop].id + '">';
        renderedHTML += '<div uk-spinner></div>';
        renderedHTML += '</div>';
        renderedHTML += '</li>';
    }
    panel_ladder_results.innerHTML = renderedHTML + '</ul>';
}
function populateStatusPanel() {
    var JSONHash = JSON.parse(localStorage.getItem('statushash'));
    if(localStorage.getItem('authcode') != 'null') {
        var userStatus = JSON.parse(localStorage.getItem('authcode'));
    } else {
        var userStatus = { teamicon: null, authicon: null };
    }
    var HTMLStatusValues = '<a href="#" title="player icon"><i class="ra ' + userStatus.authicon + '"></i></a>' +
    '<a href="#" title="team icon"><i class="ra ' + userStatus.teamicon + '"></i></a>' +
        '<a href="#" title="players"><b><span uk-icon="icon: user"></span></b>:' + JSONHash.players.size + 
        '</a><a href="#" title="teams"><span uk-icon="icon: users"></span>:' + JSONHash.teams.size + 
        '</a><a href="#" title="Ladders"><span uk-icon="icon: list"></span>:' + JSONHash.ladders.size +
        '</a><a href="#" title="played matches"><span uk-icon="icon: play-circle"></span>:' + JSONHash.playedmatches.size + 
        '</a><a href="#" title="unplayed matches"><span uk-icon="icon: microphone"></span>:' + JSONHash.unplayedmatches.size + 
        '</a>';
    status_panel.innerHTML = HTMLStatusValues;
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
        if(evt.srcElement[loop].type == 'color') {
            evt.srcElement[loop].value = '#000000';
        }
    }
    ra_player_icon.removeAttribute('class');
    ra_icon.removeAttribute('class');
}
function passCheck(evt) {
    if(pass.checkValidity() == false || pass2.checkValidity() == false) {
        if(pass.value.length > 0 && pass2.value.length > 0 ) {
            if(pass.value != pass2.value) {
                pass.setCustomValidity("passwords do not match");
                pass2.setCustomValidity("passwords do not match");
            } else {
                pass.setCustomValidity("");
                pass2.setCustomValidity("");
            } 
        } else {
            pass.setCustomValidity("");
            pass2.setCustomValidity("");
        }
    }
}
function checkSameTeam(elem) {
    if(teamainladder.value == teambinladder.value) {
        teamainladder.setCustomValidity("Team can't comete with itself");
        teambinladder.setCustomValidity("Team can't comete with itself");
    } else {
        teamainladder.setCustomValidity("");
        teambinladder.setCustomValidity("");
    }
}
function setMsg(message) {
    alert_msg_msg.innerHTML = message;
    alert_msg.removeAttribute('hidden');
    setTimeout(function () { alert_msg.setAttribute('hidden', 'hidden')}, 10000);
}
function setWrn(warning) {
    alert_msg_wrn.innerHTML = warning;
    alert_wrn.removeAttribute('hidden');
    setTimeout(function () { alert_wrn.setAttribute('hidden', 'hidden')}, 10000);
}
function setDng(danger) {
    alert_msg_dng.innerHTML = danger;
    alert_dng.removeAttribute('hidden');
    setTimeout(function () { alert_dng.setAttribute('hidden', 'hidden')}, 10000);
}
document.getElementById('form_login').addEventListener('submit', function(e) {loginProcess(e)});
document.getElementById('form_addteam').addEventListener('submit', function(e) {addTeamProcess(e)});
document.getElementById('form_addmatch').addEventListener('submit', function(e) {addMatchProcess(e)});
document.getElementById('form_regplayer').addEventListener('submit', function(e) {registerPlayerProcess(e)});
document.getElementById('form_addladder').addEventListener('submit', function(e) {addLadderProcess(e)});
document.getElementById('teamainladder').addEventListener('change', function(e) {checkSameTeam(e)});
document.getElementById('teambinladder').addEventListener('change', function(e) {checkSameTeam(e)});
document.getElementById('alert_msg').addEventListener('click', function(e) {alert_msg.setAttribute('hidden', 'hidden')});
document.getElementById('alert_wrn').addEventListener('click', function(e) {alert_wrn.setAttribute('hidden', 'hidden')});
document.getElementById('alert_dng').addEventListener('click', function(e) {alert_dng.setAttribute('hidden', 'hidden')});
document.getElementById('pass').addEventListener('change', function(e) {passCheck(e)});
document.getElementById('pass2').addEventListener('change', function(e) {passCheck(e)});
/*
function showPlayersForm(evt) {
    // GIMPED FORM so it does not submit
    evt.preventDefault();
    console.log('showPlayersForm');
}
*/
// Authenticted functions
function addTeamProcess(evt) {
    evt.preventDefault();
    var name = evt.srcElement[0].value;
    var color = evt.srcElement[1].value.substr(1,6);
    var icon = evt.srcElement[2].value;
    var url = 'api/ws.php?reqcode=createteam&playerid=1&teamname=' + name + '&color=' + color + '&imageurl=' + icon;
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
                    if(data.request == 'created new team') {
                        getAllTeams();  
                        setMsg('Team Created');
                        clearForm(evt);
                        checkForUpdates();
                    }
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
    var image = evt.srcElement[5].value;
    var url = 'api/ws.php?reqcode=createplayer';
    if(pass1 != pass2) { 
        evt.srcElement[1].setCustomValidity("passwords do not match");
        evt.srcElement[2].setCustomValidity("passwords do not match");
    } else {
        evt.srcElement[1].setCustomValidity("");
        evt.srcElement[2].setCustomValidity("");
        if(team_id == 0) {
            team_id = 1;
        }
        var fd = new FormData();
        fd.append('teamid', team_id);
        fd.append('username', playerName);
        fd.append('imageurl', image);
        fd.append('password', pass1);
        fd.append('location', seated);
        fetch(url, {
            method: 'POST',
            body: fd,
            cache: 'no-cache',
            credentials: 'include'
        })
        .then(
            function(response) {
                if (response.status !== 200) {
                    console.log('Looks like there was a problem. Status Code: ' + response.status);
                }
                response.json().then(function(data) {
                    getAllPlayers();
                    setMsg('Player Created');
                    populateStatusPanel();
                    clearForm(evt);
                    UIkit.tab(nav_content_tabs).show(0);
                });
            }
        )
    } 
}
function logoutNow(evt) {
    UIkit.offcanvas(main_nav).hide();
    fetch('api/ws.php?reqcode=deauth', {
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
                loggedOutMenu();
            });
        }
    )
}
function reportMatchProcess(evt) {
    evt.preventDefault();
    var matchid = evt.srcElement[0].value;
    var win = evt.srcElement[1].value;
    var loss = evt.srcElement[2].value;
    var url = 'api/ws.php?reqcode=reportplayedmatch&matchid=' + matchid + '&winner=' + win + '&loser=' + loss;
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
                if(data.matchreport == 'fail') {
                    setWrn('Report Error');
                } else {
                    setMsg('Match reported');
                    evt.srcElement.style = 'display: none';
                    checkForUpdates();
                }
            });
        }
    )    
}
function joinTeamProcess(evt) {
    evt.preventDefault();
    var player_id = evt.srcElement[0].value;
    var team_id = evt.srcElement[1].value;
    var url = 'api/ws.php?reqcode=jointeam&playerid=' + player_id + '&teamid=' + team_id; 
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
    var ladder = evt.srcElement[0].value;
    var teamA = evt.srcElement[1].value;
    var teamB = evt.srcElement[2].value;
    var starttime = new Date(evt.srcElement[3].value).toISOString();
    var starttime = starttime.replace('T', ' ');
    var starttime = starttime.replace(/-/g, '/');
    var starttime = starttime.split('Z');
    var starttime = starttime[0].split('.');
    var url = 'api/ws.php?reqcode=creatematch&teamid=' + teamA + '&teambid=' + teamB + '&ladderid=' + 
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
                    checkForUpdates();
                    setMsg('Match Created');
                    clearForm(evt);
                });
            }
        )
    }
}

UIkit.upload('.js-upload', {
    url: 'api/ws.php?reqcode=imageupload',
    method: 'POST',
    name: 'file_upload',
    multiple: false,
    error: function () { setWrn('file uplaod error'); },
    loadStart: function (e) {
        uikitprogressbar.removeAttribute('hidden');
        uikitprogressbar.max = e.total;
        uikitprogressbar.value = e.loaded;
    },
    progress: function (e) {
        uikitprogressbar.max = e.total;
        uikitprogressbar.value = e.loaded;
    },
    loadEnd: function (e) {
        uikitprogressbar.max = e.total;
        uikitprogressbar.value = e.loaded;
    },
    completeAll: function (e) {
        setTimeout(function () {
            uikitprogressbar.setAttribute('hidden', 'hidden');
        }, 1000);
        
        var resp = JSON.parse(arguments[0].response);
        console.log(resp);
        ladder_image_filename.value = resp.upload;
        imageoutput_thumb.innerHTML = '<img src="./img/' + resp.upload + '" width="200" height="200" style="text-align: center">';
        setMsg('file upload complete');
    }
});
function addLadderProcess(evt) {
    evt.preventDefault();
    var gameName = evt.srcElement[0].value;
    var description = evt.srcElement[1].value;
    var memberNo = evt.srcElement[2].value;
    var teamColor = evt.srcElement[3].value.substr(1,6);
    var teamTime = new Date(evt.srcElement[4].value).toISOString();
    var teamTime = teamTime.replace('T', ' ');
    var teamTime = teamTime.replace(/-/g, '/');
    var teamTime = teamTime.split('Z');
    var teamTime = teamTime[0].split('.');
    var teamImage = evt.srcElement[5].value; // the hidden field as a result of directly uplaoding the image
    var url = 'api/ws.php?reqcode=createladder';
    var fd = new FormData();
    fd.append('laddername', gameName);
    fd.append('desc', description);
    fd.append('members', memberNo);
    fd.append('color', teamColor);
    fd.append('imageurl', teamImage);
    fd.append('starttime', teamTime[0]);
    fetch(url, {
        method: 'POST',
        body: fd,
        cache: 'no-cache',
        credentials: 'include'
    })
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                checkForUpdates();
                setMsg('Ladder Created');
                clearForm(evt);
            });
        }
    )
}
// Anonymous Functions
function checkForUpdates() {
    fetch('api/ws.php?reqcode=statushashes', {
        method: 'GET',
        credentials: 'include'
    })
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                if(localStorage.getItem('statushash') === null) {
                    localStorage.setItem('statushash', JSON.stringify(data));
                    getAllPlayers();
                    getAllTeams();
                    getAllLadders();
                    //getAllPlayedMatches();
                    //getAllUnPlayedMatches();
                } else {
                    var oldHash = JSON.parse(localStorage.getItem('statushash'));
                    if(oldHash.players.hash != data.players.hash) {
                        getAllPlayers();
                    }
                    if(oldHash.ladders.hash != data.ladders.hash) {
                        getAllLadders();
                    }
                    if(oldHash.teams.hash != data.teams.hash) {
                        getAllTeams();
                    }
                    localStorage.setItem('statushash', JSON.stringify(data));
                }
                populateStatusPanel();
                teamsWithPlayers();
                teamsWithPlayersEdit();
                ladderListWithCompletedResults();
                laddersWithUnplayedMatches();
            });
        }
    )
}
function isLoggedIn() {
    var url = 'api/ws.php?reqcode=isauth';
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
                if(data.auth != -1) {
                    localStorage.setItem('authcode', JSON.stringify(data));
                    loggedInMenu();
                } else {
                    localStorage.setItem('authcode', null);
                    loggedOutMenu();
                }
                checkForUpdates();
            });
        }
    )
}
function checkExistingUser(elem) {
    var username = elem.value;
    var url = 'api/ws.php?reqcode=userexists&username=' + username;
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
function checkExistingTeam(elem) {
    var teamname = elem.value;
    var url = 'api/ws.php?reqcode=teamexists&teamname=' + teamname;
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
                if(data.team == "notfound") {
                    elem.setCustomValidity("");
                } else {
                    elem.setCustomValidity("Team Exists");
                }
            });
        }
    )
}
function checkExistingLadder(elem) {
    var laddername = elem.value;
    var url = 'api/ws.php?reqcode=ladderexists&laddername=' + laddername;
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
                if(data.ladder == "notfound") {
                    elem.setCustomValidity("");
                } else {
                    elem.setCustomValidity("Ladder Exists");
                }
            });
        }
    )
}
function loginProcess(evt) {
    evt.preventDefault();
    var fd = new FormData();
    fd.append('username', evt.srcElement[0].value);
    fd.append('password', evt.srcElement[1].value);
    var url = 'api/ws.php?reqcode=auth';
    fetch(url, {
        method: 'POST',
        body: fd,
        cache: 'no-cache',
        credentials: 'include'
    })
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                if(data.name == -1) {
                    localStorage.setItem('authcode', null);
                    setWrn('Authentication failure');
                    loggedOutMenu();
                    clearForm(evt);
                } else {
                    localStorage.setItem('authcode', JSON.stringify(data));
                    setMsg('Authentication success');
                    loggedInMenu();
                    clearForm(evt);
                    populateStatusPanel();
                }
            });
        }
    )
}

// Data Acquisition Functions
//
function getAllPlayers() {
    fetch('api/ws.php?reqcode=allplayers', {
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
                teamsWithPlayers(); 
            });
        }
    )
}
function getAllTeams() {  
    fetch('api/ws.php?reqcode=allteams', {
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
                teamsWithPlayers(); 
            });
        }
    )
}
function getAllLadders() {  
    fetch('api/ws.php?reqcode=allladders', {
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
                teamsWithPlayers(); 
            });
        }
    )
}
function getAllPlayedMatches() {  
    fetch('api/ws.php?reqcode=allplayedmatches', {
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
                teamsWithPlayers(); 
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
    var url = 'api/ws.php?reqcode=ladderlist&ladderid=' + ladder; 
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
                if(data.result == false) {
                    document.getElementById(ladderId).innerHTML = 'No Ladder Found';
                } else {
                    for(var loop = 0;loop < data.length;loop++) {
                        for(var loop2 = 0;loop2<JSONTeams.length;loop2++) {
                            if(data[loop].teama == JSONTeams[loop2].id) {
                                ladderHTML += '<tr><td><span style="color: ' + JSONTeams[loop2].color + ';"><i class="ra ' + JSONTeams[loop2].image + '"></i>&nbsp;</span>' + JSONTeams[loop2].team_name + '</td><td>' + 
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
function getALadderofUnlayedMatches(ladderID) {
    var HTMLladderID = 'reported_ladder_list_' + ladderID;
    var HTMLLadderReport = '';
    var HTMLLadderTemplate = template_match_report_form.innerHTML;
    var url = 'api/ws.php?reqcode=incompletematchesbyladder&ladderid=' + ladderID;
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
                    document.getElementById(HTMLladderID).innerHTML = 'No matches to Report';
                } else { 
                    for(var loop = 0;loop < data.length;loop++) {
                        HTMLLadderReport += HTMLLadderTemplate.replace(/{{matchID}}/g, data[loop].id)
                            .replace(/{{team_a_name}}/g, data[loop].team_a_name)
                            .replace(/{{team_b_name}}/g, data[loop].team_b_name)
                            .replace(/{{team_a_id}}/g, data[loop].team_a_id)
                            .replace(/{{team_b_id}}/g, data[loop].team_b_id)
                            .replace(/{{team_b_id}}/g, data[loop].team_b_id);
                    }
                    var HTMLLadderReportHead = '<div class="uk-grid uk-width-1-1"><div class="uk-width-1-6">Match ID</div><div class="uk-width-1-3">Winner</div>' +
                                '<div class="uk-width-1-3">Loser</div><div class="uk-width-1-6">Report</div></div>';
                    document.getElementById(HTMLladderID).innerHTML = HTMLLadderReportHead + HTMLLadderReport; 
                    for(var loop = 0;loop < data.length;loop++) {
                        var eventid = 'match_report_form_' + data[loop].id;
                        document.getElementById(eventid).addEventListener('submit', function(e) {reportMatchProcess(e)});
                    }
                }
            });
        }
    )
}
function getAllUnPlayedMatches() { // defunct 
    fetch('api/ws.php?reqcode=allunreportedmatches', {
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
/*
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
*/
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
