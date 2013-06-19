
If you are using the v1 Twitter API to pull in user feeds, you'll notice that it has stopped working. This is because Twitter has turned off the v1 API, which breaks RSS/ATOM feeds. Version 1.1 of the API doesn't support RSS at all.

api.twitter.com/1/statuses/user_timeline.rss?screen_name=XXXXXX <--- this no longer works

The solution isn't hard, but it will take a bit of work.

First, head to https://dev.twitter.com, sign in, and authorize the dev app for your account.
Once you are signed in, create a new app at https://dev.twitter.com/apps

The only thing you actually to do here, is fill out the required fields; App Name, App Description, and Website (I used the URL for my TT-RSS install). Then mark that you've read the TOS, fill in the annoying CAPTCHA, and hit the Create App button.

You'll now be at a page with OAuth settings. At the bottom of the page, there is a button for creating an access token. Do that, and the page will refresh with the access tokens at the bottom of the page. If they don't appear initially, you may have to refresh the page again. thanks cqrt!

The things you'll need from this page are Consumer key, Consumer secret, Access token, and Access token secret.

Now, fire up your favorite text editor, and paste the following code, placing your newly created token/key/secrets where appropriate, and a few lines below that, your twitter username as a fallback incase it isn't passed in for whatever reason. Save the file and upload it to your webhost or whereever you are running tt-rss from.

Now, in TT-RSS, edit the now broken twitter feeds, and replace the feed URL with the location you installed the twitter parser to, and pass it screen_name and count variables.

your_URL_here/path_to_twitter_parser?screen_name=XXXXXX&count=YYYYYY
your_URL_here/path_to_twitter_parser?list=XXXXXX&owner=YYYYYY

For example, I named my file index.php, and put it in a TWIT folder, so I access it
http://my_host/TWIT/?screen_name=Jalopnik&count=20

Valid options
-------------
User Status:
screen_name (required)
count (optional)
test (optional)
test=json (optional)

Lists:
list (required)
owner (required)
count (optional)
test (optional)
test=json (optional)