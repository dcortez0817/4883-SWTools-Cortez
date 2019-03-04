<?php

//contains the config information to allow you to connect to the server
require 'config.php';

//function to run sql query
require 'query_function.php';

echo "<pre>";   // so whitespace matters
echo "<h4>Name: Darien Cortez<br></h4>";
echo "<h4>Assignment: A04 - Nfl Stats<br></h4>";
echo "<h4>Date: 3/1/2019<br></h4>";
echo "<h4>===================================================================================<br></h4>";

//Top ten people that played for the most teams
//*************************************************************************************************
echo "1. Count the number of teams an individual played for<br>";
$sql = "SELECT id, name, COUNT(DISTINCT(season)) as '# seasons', COUNT(DISTINCT(club)) as '# teams'
        FROM players
        GROUP BY id, name
        ORDER BY COUNT(DISTINCT(club)) DESC
        LIMIT 10"

//run function for sql query
$response = runQuery($mysqli, $sql);

if($response['success']){
    foreach($response['result'] as $row){
        echo "{$row['id']} {$row['name']} {$row['# seasons']} {$row['# teams']}\n";
    }
}
//*************************************************************************************************

//Top five players with the highest total rushing yards per year
//*************************************************************************************************
echo "2. Players that rushed for the most yards per year<br>";
$sql = "SELECT players_stats.playerid, players.name, players.season,sum(players_stats.yards) as 'total rushing yards'
        FROM players_stats
        INNER JOIN players
        ON players_stats.playerid=players.id
        WHERE statid=10 or statid=75 or statid=76
        GROUP BY players_stats.playerid, players.season
        ORDER BY sum(players_stats.yards) DESC
        LIMIT 5"
//*************************************************************************************************

//Bottom 5 players with the total passing  per year

//Top 5 players that had the most rushes for a loss

//Top 5 teams with the most penalties

//The average number of penalties per year (Top 10 seasons)
   
//The Team with the least amount of average plays every year (Top 10 teams)
   
//The top 5 players that had field goals over 40 yards
   
//The top 5 players with the shortest avg field goal length
    
//Rank the NFL by win loss percentage (worst first)
    
//The top 5 most common last names in the NFL
