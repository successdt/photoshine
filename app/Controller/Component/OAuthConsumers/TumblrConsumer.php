<?php
class TumblrConsumer extends AbstractConsumer {
    public function __construct() {
    	$tumblrConfig = Configure::read('Tumblr.config');
        parent::__construct($tumblrConfig['appKey'], $tumblrConfig['appSecret']);
    }
} 
?>