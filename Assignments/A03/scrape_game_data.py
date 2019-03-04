"""
Course: CMPS 4883
Assignemt: A03
Date: 2/06/19
Github username: dcortez0817
Repo url: https://github.com/dcortez0817/4883-SWTools-Cortez
Name: Darien Cortez
Description: 
    This file retrieves the game id from the gameid json file and
    goes to the url of the live game to retrieve the stats from each game.
"""

from beautifulscraper import BeautifulScraper
from pprint import pprint #pretty print
import urllib #scrapes url from sites
import json #allows Javascript notation
      
#retrieve game ids from g_IDs json file
with open('g_IDs.json') as file:
    stats = json.load(file)

for y in stats:
    for w in stats[y]:
        #Get the game id
        gameid = stats[y]
        #Get the game data for the game id
        '''
        try:
            #Setup the url
            url = "http://www.nfl.com/liveupdate/game-center/" + str(gameid) + "/" + str(gameid) + "_gtd.json"
            #Download the file
            urllib.request.urlretrieve(url, gameid + '.json')
            print(gameid)
        except:
print(gameid)
'''
print(gameid)