
document.getElementById('form_login').addEventListener('submit', function(e) {loginprocess(e)});
document.getElementById('form_addteam').addEventListener('submit', function(e) {addteamprocess(e)});
document.getElementById('form_regplayer').addEventListener('submit', function(e) {registerplayerprocess(e)});
document.getElementById('form_addmatch').addEventListener('submit', function(e) {addmatchprocess(e)});
document.getElementById('form_addladder').addEventListener('submit', function(e) {addladderprocess(e)});
document.getElementById('form_reportmatch').addEventListener('submit', function(e) {reportmatchprocess(e)});

function loginprocess(evt) {
    evt.preventDefault();
    console.log('ws/ws.php?reqcode=auth');
}

function addteamprocess(evt) {
    evt.preventDefault();
    console.log('add team process');
}

function registerplayerprocess(evt) {
    evt.preventDefault();
    console.log('register player process');
}

function addmatchprocess(evt) {
    evt.preventDefault();
    console.log('add match process');
}

function addladderprocess(evt) {
    evt.preventDefault();
    console.log('ws/ws.php?reqcode=createladder');
}

function reportmatchprocess(evt) {
    evt.preventDefault();
    console.log('ws/ws.php?reqcode=reportplayedmatch&playerid=1&matchid=2&winloss=win');
}
