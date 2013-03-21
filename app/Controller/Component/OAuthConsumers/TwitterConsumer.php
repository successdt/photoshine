<?php
class TwitterConsumer extends AbstractConsumer {
    public function __construct() {
    	$twitterConfig = Configure::read('Twitter.config');
        parent::__construct($twitterConfig['appKey'], $twitterConfig['appSecret']);
    }
} 
?>