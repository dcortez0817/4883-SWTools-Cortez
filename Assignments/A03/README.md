# Files

* ```scrape_game_ids.py```

  * scrapes all regular season and post season game ids from ```NFL.com/schedules``` from 2009 to 2019 and places them in a g_IDs.json file

* ```scrape_game_data.py```

  * retrieves the game ids from the json file and places them in the ```NFL.com/liveupdate/game-center/(gameid)/(gameid)_gtd.json``` url 
in order to scrape all regular season and post season game stats from 2009 to 2019

# Instructions
<strong>Run the files in this order:</strong>

 1. If you don't have game ids, run ```scrape_game_ids.py```
 2. If you already have game ids, run ```scrape_game_data.py```
