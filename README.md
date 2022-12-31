# Kappa-Instagram-Feed-App
1. Directory structure
    1. css
    2. js
    3. img
    4. src (contains instagram api SDK)
    5. templates (templates for app backend)
    6. vendor (Shopify API SDK)
    7. Root directory (contains all logic)
2. App files:
    1. config.php = contains all config variables
    2. get_access_token.php = file that executes right after install.php when the app is installed for the first time. Its responsible for generating the access token, which we are not using at the moment (app was installed) so this file can be deleted and we can redirect to the shopify store url where we installed the app instead of redirecting to get access token file. The redirection logic can be added in install.php
    3. index.php = main file for app backend
    4. init.php = initializes all database tables
    5. insta_feed.php = This file is use to render
    6. install.php = installation file
    7. privacy policy & user data deletion = empty files that were created since they are mandatory by Facebook and URL's must be included in order to get the required keys.
    8. sync.php = responsible for re-syncing
3. Shopify theme files:
    1. Sections/instagram-feed.liquid = responsible for rendering frontend widget
