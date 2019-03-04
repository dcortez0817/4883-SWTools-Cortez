"""
Course: CMPS 4883
Assignemt: A03
Date: 2/06/19
Github username: dcortez0817
Repo url: https://github.com/dcortez0817/4883-SWTools-Cortez
Name: Darien Cortez
Description: 
    This program scrapes the game ids from NFL.com using the beautiful
    scraper tool to scrape the data from the website. It then places
    the game ids in a json file to allow us to scrape all individual game
    stats from 2009 to 2019 and places those stats in a json file.
"""

from beautifulscraper import BeautifulScraper
from pprint import pprint #pretty print
import urllib #scrapes url from sites
import json #allows Javascript notation

scraper = BeautifulScraper() #variable for scraping data
f = open("g_IDs.json", 'w') # file to hold the game ids

gameids = {
    'REG': [], 
    'POST': []
}

"""
season_point(season, year, week = "None"):

This function checks which point of the season users are in,
puts that information in the url, scrapes the game ids from
that season, places the data in a file, and prints the 
completion of that task

Params: 
   season [string] : tells the point you are in the season 
   year [int] : the year you are in
   week [int] : equal to none because the weeks are only needed
                during the regular season
Returns: 
   gameid
   prints game id and places it in a file
"""
def season_point(season, year, week = "None"):
        if season == 'REG':
            url= "http://www.nfl.com/schedules/" + str(year) + "/" + season + str(week)
        else:
            url= "http://www.nfl.com/schedules/" + str(year) + "/" + season 
        
        #takes you to the url
        page = scraper.go(url) 

        #finds all the div elements in the html markup in the classes labeled 'schedules-list-content'
        divs = page.find_all('div',{'class': 'schedules-list-content'}) 

        for div in divs:
            gameids[season].append(div['data-gameid']) # variable to hold the game ids
                
for y in range(2009, 2019):
    season_point('POST', y)
    for w in range(1, 18):
        season_point('REG', y, w)
    

f.write(json.dumps(gameids, sort_keys = True, indent=4)) # places game ids in json file
pprint(gameids)
print ("The game ids were succesfully placed in the g_IDs json file.")