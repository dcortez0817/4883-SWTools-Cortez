"""
Course: CMPS 4883
Assignemt: A06
Date: 3/09/19
Github username: dcortez0817
Repo url: https://github.com/dcortez0817/4883-SWTools-Cortez
Name: Darien Cortez
Description: 
    This program scrapes 877 emojis from the https://www.webfx.com/tools/emoji-cheat-sheet/
    website and stores the images in the emojis folder.
"""
from beautifulscraper import BeautifulScraper
import urllib

scraper = BeautifulScraper() #variable for scraping data

url = 'https://www.webfx.com/tools/emoji-cheat-sheet/'

# Use beatiful soup to read the page
page = scraper.go(url)

#used to count emojis
cnt = 0

# then loop through the page with the following
for emoji in page.find_all("span",{"class":"emoji"}):
    image_path = emoji['data-src'].split("/")
    # save the image using requests library
    urllib.request.urlretrieve(url+emoji["data-src"], 'emojis/'+image_path[-1])
    cnt+=1

print("you scraped " + str(cnt) + " emojis.")