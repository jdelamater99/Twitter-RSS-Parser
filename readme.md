If you are using the v1 Twitter API to pull in user feeds, you'll notice that it has stopped working. This is because Twitter has turned off the v1 API, which breaks RSS/ATOM feeds. Version 1.1 of the API doesn't support RSS at all.

api.twitter.com/1/statuses/user_timeline.rss?screen_name=XXXXXX <--- this no longer works

The solution isn't hard, but it will take a bit of work.

TWITTER API Setup
-------------
First, head to https://dev.twitter.com, sign in, and authorize the dev app for your account.
Once you are signed in, create a new app at https://dev.twitter.com/apps

The only thing you actually to do here, is fill out the required fields; App Name, App Description, and Website (I used the URL for my TT-RSS install). Then mark that you've read the TOS, fill in the annoying CAPTCHA, and hit the Create App button.

You'll now be at a page with OAuth settings. At the bottom of the page, there is a button for creating an access token. Do that, and the page will refresh with the access tokens at the bottom of the page. If they don't appear initially, you may have to refresh the page again. thanks cqrt!

The things you'll need from this page are Consumer key, Consumer secret, Access token, and Access token secret.

TWITTER API Limitations
-------------
The Twitter API limits to 15 calls per 15 minute time period. If you exceed this threshold, the Twitter returns a "Too Many Requests" error.
This is a Twitter imposed limitation that I have no control over.
https://dev.twitter.com/docs/rate-limiting/1.1

PHP Setup
-------------
Rename config.php-dist to config.php. 

Next, open config.php in the text editor of your choice, and place your newly created token/key/secrets where appropriate, and a few lines below that, your twitter username as a fallback incase it isn't passed in for whatever reason. Save the file and upload all the files to your webhost or whereever you are running tt-rss from.

Now, in TT-RSS, edit the now broken twitter feeds, and replace the feed URL with the location you installed the twitter parser to, and pass it screen_name and count variables.

- http://domain.com/Twitter-RSS-Parser?home
- http://domain.com/Twitter-RSS-Parser?screen_name=stephenfry&count=100
- http://domain.com/Twitter-RSS-Parser?list=kittens&owner=stephenfry
- http://domain.com/Twitter-RSS-Parser?q=kittens

For example, I named my file index.php, and put it in a TWIT folder, so I access it
- http://domain.com/TWIT/?home
- http://domain.com/TWIT/?screen_name=Jalopnik&count=20
- http://domain.com/TWIT/?list=kittens&owner=stephenfry
- http://domain.com/TWIT/?q=foobar

If you want to search a hashtag and not just a keyword, then you need to change the # to %23 
- http://domain.com/TWIT/?q=#foobar <---- this does not work
- http://domain.com/TWIT/?q=%23foobar <---- this works


Valid options
-------------
Home Timeline:
- home (required)
- count (optional)

User Status:
- screen_name (required)
- count (optional)
- test (optional)
- test=json (optional)

Lists:
- list (required)
- owner (required)
- count (optional)
- test (optional)
- test=json (optional)

Search:
- q (required)
