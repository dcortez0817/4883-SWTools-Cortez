<?php
//contains the config information to allow you to connect to the server
require 'config.php';

//function to run sql query
require 'query_function.php';

echo "<pre>";   // so whitespace matters
echo "<h4>Name: Darien Cortez<br></h4>";
echo "<h4>Assignment: A04 - Nfl Stats<br></h4>";
echo "<h4>Date: 3/1/2019<br></h4>";
echo "<h4>===========================================================================================================================================
\n</h4>";

//*************************************************************************************************
//Top ten people that played for the most teams
//*************************************************************************************************
echo "1. Count the number of teams an individual played for\n\n";
echo str_pad("PlayerId", 25, ' '), str_pad("Name", 25, ' '), str_pad("# Seasons", 25, ' '), str_pad("# Teams", 25, ' ');
echo "\n";
$sql = "SELECT id, name, COUNT(DISTINCT(season)) as '# Seasons Played', COUNT(DISTINCT(club)) as '# Teams'
        FROM players
        GROUP BY id, name
        ORDER BY COUNT(DISTINCT(club)) DESC
        LIMIT 10";

//run function for sql query
$response = runQuery($mysqli, $sql);

if($response['success']){
    foreach($response['result'] as $row){
        echo str_pad("{$row['id']}", 25, ' '),
            str_pad("{$row['name']}", 25, ' '),
            str_pad("{$row['# seasons']}", 25, ' '),
            str_pad("{$row['# teams']}", 25, ' ');
        echo "\n";
    }
}
//*************************************************************************************************

//*************************************************************************************************
//Top five players with the highest total rushing yards per year
//*************************************************************************************************
echo "\n2. Players that rushed for the most yards per year\n\n";
echo str_pad("PlayerId", 25, ' '), str_pad("Name", 25, ' '), str_pad("Season", 25, ' '), str_pad("Total rushing yards", 25, ' ');
echo "\n";

$sql = "SELECT DISTINCT(ps.playerid), p.name, ps.season, ps.rush_yards
        FROM (SELECT playerid, season, SUM(yards) as 'rush_yards'
        FROM `players_stats`
        WHERE statid=10
        GROUP BY playerid, season) AS ps
        INNER JOIN players as p
        ON ps.playerid=p.id
        ORDER BY ps.rush_yards DESC
        LIMIT 5";

//run function for sql query
$response = runQuery($mysqli, $sql);

if($response['success']){
    foreach($response['result'] as $row){
        echo str_pad("{$row['playerid']}", 25, ' '),
            str_pad("{$row['name']}", 25, ' '),
            str_pad("{$row['season']}", 25, ' '),
            str_pad("{$row['rush_yards']}", 25, ' ');
        echo "\n";
    }
}
//*************************************************************************************************

//*************************************************************************************************
//Bottom 5 players with the total passing  per year
//*************************************************************************************************
echo "\n3. Bottom 5 players with the least total passing yards per year\n\n";
echo str_pad("PlayerId", 25, ' '), str_pad("Name", 25, ' '), str_pad("Season", 25, ' '), str_pad("Total passing yards", 25, ' ');
echo "\n";

$sql = "SELECT DISTINCT(ps.playerid), p.name, ps.season, ps.pass_yards
        FROM (SELECT playerid, season, SUM(yards) as 'pass_yards'
        FROM `players_stats`
        WHERE statid=15
        GROUP BY playerid, season) AS ps
        INNER JOIN players as p
        ON ps.playerid=p.id
        ORDER BY ps.pass_yards ASC
        LIMIT 5";

//run function for sql query
$response = runQuery($mysqli, $sql);

if($response['success']){
    foreach($response['result'] as $row){
        echo str_pad("{$row['playerid']}", 25, ' '),
            str_pad("{$row['name']}", 25, ' '),
            str_pad("{$row['season']}", 25, ' '),
            str_pad("{$row['pass_yards']}", 25, ' ');
        echo "\n";
    }
}
//*************************************************************************************************

//*************************************************************************************************
//Top 5 players that had the most rushes for a loss
//*************************************************************************************************
echo "\n4. Top 5 players with the most rushes for loss\n\n";
echo str_pad("PlayerId", 25, ' '), str_pad("Name", 25, ' '), str_pad("# Seasons Played", 25, ' '), str_pad("Total rushing yards", 25, ' ');
echo "\n";

$sql = "SELECT DISTINCT(ps.playerid), p.name, ps.tot_seasons, ps.rush_yards
        FROM (SELECT playerid, COUNT(DISTINCT(season)) as tot_seasons, COUNT(yards) as 'rush_yards'
        FROM players_stats
        WHERE yards < 0 AND statid=10
        GROUP BY playerid) AS ps
        INNER JOIN players AS p
        ON ps.playerid=p.id
        ORDER BY rush_yards DESC
        LIMIT 5";

//run function for sql query
$response = runQuery($mysqli, $sql);

if($response['success']){
    foreach($response['result'] as $row){
        echo str_pad("{$row['playerid']}", 25, ' '),
            str_pad("{$row['name']}", 25, ' '),
            str_pad("{$row['tot_seasons']}", 25, ' '),
            str_pad("-{$row['rush_yards']}", 25, ' ');
        echo "\n";
    }
}
//*************************************************************************************************

//*************************************************************************************************
//Top 5 teams with the most penalties
//*************************************************************************************************
echo "\n5. Top 5 teams with the most penalties\n\n";
echo str_pad("Team", 25, ' '), str_pad("Total Penalties", 25, ' ');
echo "\n";

$sql = "SELECT club, SUM(pen)
        FROM game_totals
        GROUP BY club
        ORDER BY SUM(pen) DESC
        LIMIT 5";

//run function for sql query
$response = runQuery($mysqli, $sql);

if($response['success']){
    foreach($response['result'] as $row){
        echo str_pad("{$row['club']}", 25, ' '),
            str_pad("{$row['SUM(pen)']}", 25, ' ');
        echo "\n";
    }
}
//*************************************************************************************************

//*************************************************************************************************
//The average number of penalties per year (Top 10 seasons)
//*************************************************************************************************
echo "\n6. Average number of penalties per year\n\n";
echo str_pad("Season", 25, ' '), str_pad("Total Penalties", 25, ' '), str_pad("Avg Penalties", 25, ' ');
echo "\n";

$sql = "SELECT season, SUM(pen), SUM(pen) / COUNT(DISTINCT(gameid))
        FROM game_totals
        GROUP BY season
        ORDER BY SUM(pen) / COUNT(DISTINCT(gameid)) DESC
        LIMIT 10";

//run function for sql query
$response = runQuery($mysqli, $sql);

if($response['success']){
    foreach($response['result'] as $row){
        echo str_pad("{$row['season']}", 25, ' '),
            str_pad("{$row['SUM(pen)']}", 25, ' '),
            str_pad("{$row['SUM(pen) / COUNT(DISTINCT(gameid))']}", 25, ' ');
        echo "\n";
    }
}
//*************************************************************************************************

//*************************************************************************************************
//The Team with the least amount of average plays every year (Top 10 teams)
//*************************************************************************************************
echo "\n7. Bottom 10 teams with the average number of plays per year\n\n";
echo str_pad("Team", 25, ' '), str_pad("Season", 25, ' '), str_pad("# plays", 25, ' '), str_pad("# games", 25, ' '), str_pad("Avg Plays", 25, ' ');
echo "\n";

$sql = "SELECT club, season, COUNT(DISTINCT(playid)) AS num_plays, COUNT(DISTINCT(gameid)) AS num_games, COUNT(DISTINCT(playid))/ COUNT(DISTINCT(gameid)) AS AVG_plays
        FROM players_stats
        GROUP BY club, season
        ORDER BY AVG_plays ASC
        LIMIT 10";

//run function for sql query
$response = runQuery($mysqli, $sql);

if($response['success']){
    foreach($response['result'] as $row){
        echo str_pad("{$row['club']}", 25, ' '),
            str_pad("{$row['season']}", 25, ' '),
            str_pad("{$row['num_plays']}", 25, ' '),
            str_pad("{$row['num_games']}", 25, ' '),
            str_pad("{$row['AVG_plays']}", 25, ' ');
        echo "\n";
    }
}
//*************************************************************************************************


//*************************************************************************************************
//The top 5 players that had field goals over 40 yards
//*************************************************************************************************
echo "\n8. Top 5 players that had field goals over 40 yards\n\n";
echo str_pad("PlayerId", 25, ' '), str_pad("Name", 25, ' '), str_pad("# Seasons Played", 25, ' '), str_pad("Total field goals over 40 yds", 25, ' ');
echo "\n";

$sql = "SELECT DISTINCT(ps.playerid), p.name, ps.tot_seasons, ps.kick_yards
        FROM (SELECT playerid, COUNT(DISTINCT(season)) as tot_seasons, COUNT(yards) as 'kick_yards'
              FROM players_stats
              WHERE yards > 40 AND statid=70
              GROUP BY playerid) AS ps
              INNER JOIN players AS p
              ON ps.playerid=p.id
              ORDER BY kick_yards DESC
              LIMIT 5";

//run function for sql query
$response = runQuery($mysqli, $sql);

if($response['success']){
    foreach($response['result'] as $row){
        echo str_pad("{$row['playerid']}", 25, ' '),
            str_pad("{$row['name']}", 25, ' '),
            str_pad("{$row['tot_seasons']}", 25, ' '),
            str_pad("-{$row['kick_yards']}", 25, ' ');
        echo "\n";
    }
}
//*************************************************************************************************

//*************************************************************************************************
//The top 5 players with the shortest avg field goal length
//*************************************************************************************************
echo "\n9. Bottom 5 players average field goal length\n\n";
echo str_pad("PlayerId", 25, ' '), str_pad("Name", 25, ' '), str_pad("# Seasons Played", 25, ' '), str_pad("Total kicking yards", 25, ' '), 
        str_pad("Total field goals", 25, ' '), str_pad("Avg kicking yards", 25, ' ');
echo "\n";

$sql = "SELECT DISTINCT(ps.playerid), p.name, ps.tot_seasons, ps.tot_kick_yards, ps.num_field_goals, ps.avg_kick_yards
        FROM (SELECT playerid, COUNT(DISTINCT(season)) as tot_seasons, SUM(yards) AS tot_kick_yards, COUNT(yards) AS num_field_goals, SUM(yards)/COUNT(yards) AS 'avg_kick_yards'
              FROM players_stats
              WHERE statid=70
              GROUP BY playerid) AS ps
              INNER JOIN players AS p
              ON ps.playerid=p.id
              ORDER BY avg_kick_yards ASC
              LIMIT 5";

//run function for sql query
$response = runQuery($mysqli, $sql);

if($response['success']){
    foreach($response['result'] as $row){
        echo str_pad("{$row['playerid']}", 25, ' '),
            str_pad("{$row['name']}", 25, ' '),
            str_pad("{$row['tot_seasons']}", 25, ' '),
            str_pad("-{$row['tot_kick_yards']}", 25, ' '),
            str_pad("-{$row['num_field_goals']}", 25, ' ')
            str_pad("-{$row['avg_kick_yards']}", 25, ' ');
        echo "\n";
    }
}
//*************************************************************************************************

//*************************************************************************************************
//Rank the NFL by win loss percentage (worst first)
//*************************************************************************************************
echo "\n10. Rank the NFL by win loss percentage (worst first)\n\n";
echo str_pad("Team", 25, ' '), str_pad("Win/Loss %", 25, ' ');
echo "\n";

$sql = "SELECT DISTINCT(club), SUM(wonloss='won')/ SUM(wonloss='loss') * 100 as win_loss
        FROM game_totals
        GROUP BY club
        ORDER BY win_loss ASC";

//run function for sql query
$response = runQuery($mysqli, $sql);

if($response['success']){
    foreach($response['result'] as $row){
        echo str_pad("{$row['club']}", 25, ' '),
            str_pad("{$row['win_loss']}", 25, ' ');
        echo "\n";
    }
}
//*************************************************************************************************

//*************************************************************************************************    
//The top 5 most common last names in the NFL
//*************************************************************************************************
//*************************************************************************************************
