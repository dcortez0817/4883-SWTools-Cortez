# Project Overview
This project uses SQL and Php to query nfl stats from the cs2 mwsu phpmyadmin database

# Files
```query_function.php```
 * file that holds the function to query data from the cs2 phpmyadmin database
 
```stats.php```
 * requires the ```query_function.php``` file to find the following information:
   * The number of teams an individual player played for (Top 10)
   * The players with the highest total rushing yards by year(Top 5)
   * The bottom 5 passing players per year
   * The top 5 players that had the most rushes for a loss
   * The top 5 teams with the most penalties
   * The average number of penalties per year (Top 10 seasons)
   * The Team with the least amount of average plays every year (Top 10 teams)
   * The top 5 players that had field goals over 40 yards
   * The top 5 players with the shortest avg field goal length
   * Rank the NFL by win loss percentage (worst first)
   * The top 5 most common last names in the NFL
   
<strong>Files Ignored:</strong>

```sftp.json```
* holds the login information for the cs2 phpmyadmin database

```config.php```
 * holds my login information for the cs2 phpmyadmin database
   

# Instructions
 1. Save/ run the ```query_function.php``` & ```stats.php``` files
 2. Go to this website: http://cs2.mwsu.edu/~dcortez/software_tools/teams_games.php
