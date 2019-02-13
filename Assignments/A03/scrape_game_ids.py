"""
Course: CMPS 4883
Assignemt: A03
Date: 2/05/19
Github username: dacortez0817
Repo url: https://github.com/dcortez0817/4883-SWTools-Cortez
Name: Darien Cortez
Description: 
    This program scrapes data from NFL.com 

"""

from beautifulscraper import BeautifulScraper
from pprint import pprint #pretty print
import urllib #scrapes url from sites
import json #allows Javascript notation
import sys

scraper = BeautifulScraper() #variable for scraping data

def season_point(season, year, week = "None"):
        if season == "/REG":
            url= "http://www.nfl.com/schedules/" + str(year) + season + str(week)
        else:
            url= "http://www.nfl.com/schedules/" + str(year) + season 
        
        #takes you to the url
        page = scraper.go(url) 

        divs = page.find_all('div',{'class': 'schedules-list-content'})

        for div in divs:
                gameid = div['data-gameid']
                print (gameid)
        #sys.exit()

        #url2 = "http://www.nfl.com/liveupdate/game-center/%d/%d_gtd.json" % (gameid)

for y in range(2009, 2019):
    for w in range(1, 18):
        season_point("/REG", y, w)
    season_point("/POST", y)
        