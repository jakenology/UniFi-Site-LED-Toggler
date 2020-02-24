# UniFi-Site-LED-Toggler
Help your your family members (and you, the admin) sleep at night!

# Configuration
- You will need composer and PHP 7 to install the dependencies for this project
- Here is what an example config file could look like:
```php
<?php
// UniFi Controller Information
define('controller_url', 'https://unifi.mydomain.com:8443');
define('controller_version', '5.12.35');

// Unifi Controller Authentication
define('controller_user', 'ubnt');
define('controller_password','ubnt');

// Your preferred site
define('site_id', 'abc0d1e2');

// User pin for safety
define('PIN', 1234);
```

# Screenshot
<img src="screenshot.png">

# Support
Let me know if you have any questions!
