# Kappa-Instagram-Feed-App
Directory structure
css
js
img
src (contains instagram api SDK)
templates (templates for app backend)
vendor (Shopify API SDK)
Root directory (contains all logic)
App files:
config.php = contains all config variables
get_access_token.php = file that executes right after install.php when the app is installed for the first time. Its responsible for generating the access token, which we are not using at the moment (app was installed) so this file can be deleted and we can redirect to the shopify store url where we installed the app instead of redirecting to get access token file. The redirection logic can be added in install.php
index.php = main file for app backend
init.php = initializes all database tables
insta_feed.php = This file is use to render
install.php = installation file
privacy policy & user data deletion = empty files that were created since they are mandatory by Facebook and URL's must be included in order to get the required keys.
sync.php = responsible for re-syncing
Shopify theme files:
Sections/instagram-feed.liquid = responsible for rendering frontend widget