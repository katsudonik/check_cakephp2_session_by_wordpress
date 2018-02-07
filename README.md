# check_cakephp2_session_by_wordpress

# for example on these domains
* cakephp: cake.dev.jp (/www/cakephp2)
* wordpress: wp.dev.jp (/www/wordpress)

## configure cakephp session
* domain: .dev.jp
* session handler: database session  
```
/www/cakephp2/app/Config/core.php
            
    Configure::write('Session', array(
//         'defaults' => 'php'
        'defaults' => 'database', // <--
        'timeout' => 1440,  // 1days
    //     'autoRegenerate' => true, // Cookieを再作成する(セッションの延長)
        'ini' => array(
            'session.cookie_lifetime' => 0,  // ブラウザを閉じた時にセッションを破棄
            'session.gc_maxlifetime'  => 86400,  // 1days
            'session.gc_probability'  => 1,
            'session.gc_divisor'      => 50000,
            'session.cookie_domain' => '.dev.jp', //<--
        ),
    ));
```

※ reference these:
* lib/Cake/Model/Datasource/CakeSession::_configureSession
* lib/Cake/Model/Datasource/Session/DatabaseSession.php

```
lib/Cake/Model/Datasource/CakeSession::_configureSession

		if (!empty($sessionConfig['handler']['engine'])) {
			$handler = static::_getHandler($sessionConfig['handler']['engine']);
			session_set_save_handler(
				array($handler, 'open'),
				array($handler, 'close'),
				array($handler, 'read'),
				array($handler, 'write'),
				array($handler, 'destroy'),
				array($handler, 'gc')
			);
		}
```


## place these files onto wordpress document root:
* MysqlSessionHandler.php
* check_cake_session.php

## edit index.php

```
/www/wordpress/index.php

<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

require 'check_cake_session.php'; // <-- add

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
```



origin:http://www.ielove-group.jp/blog/23
