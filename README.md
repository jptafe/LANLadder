      +'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''+
     /                                                                 /
    /   /   /\   /|  / /   /\   /--/ /--/ /-- /--/                    /
   /   /   ---  / | / /   ---  /  / /  / /-  /--/                    /
  /   /___/   \/  |/ /___/   \/__/ /__/ /__ /   \    LAN-Only       /
 /                                                                 /
+.................................................................+


A LAN Party ladder Management System to show the state of play in LAN games between teams

ENTITIES: player, ladder, team & match
USERS: ANONYMOUS, PLAYER, ADMIN

Business Rules:
* Anonymous Users will be able to view ladders only
* One must be authenticated and be in a team to view their team's ladders and play info
* Teams will be allocated to a ladder by admin when admin creates the requisite matches for the ladder, that team will not be added to the ladder unless they have the requisite number of players
* Admin also creates ladders, which consists of the name of the game and the maximum players in a team
* A player can't join a team that is full, if they are successful their current team is overwritten, and if that team then has zero players it too will be deleted
* Played matches will only appear on the ladder if both the winning team and losing team have reported the outcome correctly. That outcome will be reported in the Team view, by any team member.
* Once a result has been fully reported it can't be changed except by admin
* The number of games played for a valid ladder must be equal to the number of teams in the ladder 
* The authenticated player must return a user token to the API supplied by the server during auth to access secure API functions 
* Teams will choose from a library of approved iconagraphy (to avoid ugly or unsavoury icons)  
* Team ID 1 = Unset, Team ID 2 = Forefit

Technologies:
* Web Service will support the activities of a user, but users must authenticate in order to participate
* A web app will be developed using a client-side framework (ui-kit?) to speed the development process with mobile components.
* If the username is the steamid, user icons will be pulled from Steam API
* Administration panel will be developed using either Angular and API or Symfony

RoadMap
 team ID link to user icons & Screen Names
 Password Reset via email post deployment online

Current Status
 Frontend - Not Started
 Backend - Web Service in Test phase
 Admin End - Not Started

Priorities:
 Make auth robust (research is necessary)
