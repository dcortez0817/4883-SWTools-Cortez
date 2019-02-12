from beautifulscraper import BeautifulScraper
from pprint import pprint #pretty print
import urllib #scrapes url from sites
import json #allows Javascript notation
import sys

scraper = BeautifulScraper()

for year in range(2009, 2019):
    for week in range(1, 18):

        if season == 'POST':
                url= "http://www.nfl.com/schedules/" + str(year) + season
        else:
                url= "http://www.nfl.com/schedules/" + str(year) + season + str(week)

        page = scraper.go(url) #takes you to the url

        divs = page.find_all('div',{'class': 'schedules-list-content'})
        
        for div in divs:
                gameid = div['data-gameid']
                print (gameid)
        #sys.exit()

        url2 = "http://www.nfl.com/liveupdate/game-center/%d/%d_gtd.json" % (gameid)
