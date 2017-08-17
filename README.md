# Greta CDMA - [https://cdma.greta.fr](https://cdma.greta.fr)

## Install

This installation guide assumes you have either Ngnix or Apache as well as MySQL installed, with a Vhosts set correctly.

1.  Clone the repo in the appropriate Vhost folder : `git clone https://happy-dev@bitbucket.org/sylvia_graphisme/greta-cdma.git`
2.  `cd` into the cloned repository, and set the `wp-config.php` file as follows : 
`cp wp-config-sample.php wp-config.php`
3.  Edit the `wp-config.php` file so the database and Vhost configs matches yours : 
    -  define('WP_HOME',     'http://greta-cdma.dev');
    -  define('WP_SITEURL',  'http://greta-cdma.dev');
    -  define('DB_NAME',     'gretacdma');
    -  define('DB_HOST',     'localhost');
    -  define('DB_PASSWORD', 'gretacdma');
    -  define('DB_HOST',     'localhost');
3.  Install [NodeJS](https://nodejs.org/en/)
4.  Install NPM : `npm install -g npm`
5.  Install Bower : `npm install -g bower`
6.  `cd` into the Sage theme folder : `cd wp-content/themes/sage`
7.  Install Node modules dependencies : `npm install`
8.  Install Bower components dependencies : `bower install`
9.  Compile SCSS into CSS and concatenate JS files : `gulp watch`


## Warning
*  The Wordfence plugin requires the `.user.ini` at the root of the repository. Here is an example of what its content might be : 
```
; Wordfence WAF
auto_prepend_file = '/var/www/html/cdma_greta/wordfence-waf.php'
; END Wordfence WAF
```

*  The back office login page is at https://some.ndd/greta-cdma-login


## Team
- __Design__
Pauline Khun [pauline@happy-dev.fr](mailto:pauline@happy-dev.fr)
- __Dev__  
Sylvia Krafczyk [sylvia@happy-dev.fr](mailto:sylvia@happy-dev.fr)
- __Lead Dev__  
Alexandre Bourlier [alexandre@happy-dev.fr](mailto:alexandre@happy-dev.fr)

