# selfoss - Webfront

This is newspaper style webfront for the [selfoss RSS reader](https://github.com/fossar/selfoss).

I never liked RSS readers very much as the user interface is just plain ugly. I wanted to have
a nice looking user interface that feels like a newspaper, and not like some technical list. 
And ideally, I wanted to have the full article, and not just a teaser. When I came across selfoss
that can fetch the full article (with some limits), I felt I want to use that as a base for my
personal "Morning Post".

- Website that looks like a newspaper
- Based on Bootstrap blog [example](https://getbootstrap.com/docs/4.5/examples/blog/)
- Fixed to 11 categories

## Features

- As it is based on a Bootstrap template, it is responsive and also works quite well on a mobile phone
- Content is mostly refreshed on regular intervals without a need to reload the page (on the main page and the list boxes on the other two pages)
- Articles that have been read are excluded from showing up again, unless the article is "starred". So you don't always see the same 10 news items that you have read already
- An article is automatically marked as read  when you scroll to the end of the article or if it's fully visible, after a set threshold in seconds
- Articles can be marked read (made disappear) with a click on the x in the list boxes
- Articles with the same title are combined and only shown once (based on lowest date). So if a source shows the same item in different feeds it will only be shown once on the page
- Links to the source are opened in a new tab
- The category page scrolls infinitely, at least until there are no more articles
- List boxes with headlines (except on the start page) feature a "Show more" link to append more headlines
- Info or error messages now show in toasts at the lower left of the screen
- You can search for keywords in titles or the content of the article (type words/search string or enclose them "with double quotes" to find the whole string)

## Limitations

- The content is displayed as it is in the database. So HTML code and images will be displayed as they are retrieved by selfoss and do "mess-up" the look to a certain extent
- The top lead article will show up again in one of the lower categories, but that is the only item showing up twice
- It currently is fixed to 11 categories or tags
- If a source has multiple tags, only the first is taken into account
- Similar articles from different sources are not combined. So the same topic will show up multiple times

## Screenshots

![](./screenshots/news.png)
This is the main page with the overview of the categories/tags. There is a lead article on top, followed by the latest article from the top 8 categories.
Below that follows a list of a number of headlines for these 8 categories. At the bottom follows a full article for the remaining three categories, next to a list of some headlines in that category.

![](./screenshots/tag.png)
The category page shows the two latest articles on top, followed by a list of headlines with teasers and a list of headlines from other categories.

![](./screenshots/article.png)
The article page shows a single article in the middle, while the left hand shows a list of headlines for that category, and the right shows a list of headlines from the same source.

## Installation

You need to have [selfoss](https://github.com/fossar/selfoss) installed first. Please revert to that installation instructions to get selfoss going first. Use a MySQL database as the backend to make sure it works out of the box. I have not tried it with Sqlite or PostgreSQL databases. It might work, but I haven't tested it.
Also when you setup your feeds in selfoss, make sure to use the "RSS Feed (with FullTextRss)" in Type. This should pull the full article to your database instead of just the teasers from the RSS feed itself.
![](./screenshots/fulltextrss.png)
In the Tags field, you can enter multiple values, but my website will only consider the first value.
When I installed selfoss, I first struggled with the setup of the database. My selfoss user didn't have full admin rights and struggled to install the necessary triggers. When I used the root user for the initial install, it worked. I then changed the settings back to a more restricted selfoss user and it seems to work just fine. So once you installed the files and stuff, go to <http://selfoss/cliupdate.php> and run that twice. The first time it showed an error, but the second time it seem to work. When you then go to the index.php it should be up and running and you can add your feeds.

Once selfoss is up and has some content downloaded, you can install this webfront.

1. To keep things clean(er), I suggest to create a separate virtual website/host on the same (or a different) machine. I have used an nginx webserver and this tutorial on Step 5 shows the [basics](https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-ubuntu-20-04). Set `index.php` as the index page so it defaults to that page. 
2. Clone the repository into the folder where you want to host the site 
   Create the directory `sudo mkdir /var/www/selfoss-webfront/`
   Go into that directory `cd /var/www/selfoss-webfront/'
   Clone this repository `sudo git clone https://github.com/MatthK/Selfoss-Webfront`
3. Adjust the settings/variables in the `/includes/constants.php` file. There are comments in the file. You have to define your database details and also add the 11 categories/tags in the array below. The first column is for the visible category names. These can include spaces, while the second column should avoid spaces or special characters.
4. You also have to create a function in the database. Simply run the `HTML_UnEncode.sql` in the MySQL database once to create the function
5. Enjoy
6. Optional: Add a reverse proxy in front (or open the port) to the virtual website to have access to the newspaper from outside your network. I am using a reverse proxy with personal certificate to secure the site.

## Configuration

1. Define the settings of your database (it's tested for MySql, not sure if other databases will work)
2. Define the name of your "newspaper" and choose the font
3. Define your categories (11 needed)

## Development

Please excuse the spaghetti code. But it does work, so...

## Credits

Thanks to awesome selfoss, as without that this wouldn't be possible. 
And thanks to Stackoverflow and countless other pages/forum to help me get my code done.
