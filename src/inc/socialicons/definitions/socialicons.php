<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_SocialIcons_ManagerInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_SocialIcons_ManagerInterface ) {
	return;
}

$this->add_icons( array(
	'500px.com'          => array( 'fa', 'fa-500px' ),
	'amazon.com'         => array( 'fa', 'fa-amazon' ),
	'angel.co'           => array( 'fa', 'fa-angellist' ),
	'app.net'            => array( 'fa', 'fa-adn' ),
	'behance.net'        => array( 'fa', 'fa-behance' ),
	'bitbucket.org'      => array( 'fa', 'fa-bitbucket' ),
	'codepen.io'         => array( 'fa', 'fa-codepen' ),
	'delicious.com'      => array( 'fa', 'fa-delicious' ),
	'deviantart.com'     => array( 'fa', 'fa-deviantart' ),
	'digg.com'           => array( 'fa', 'fa-digg' ),
	'dribbble.com'       => array( 'fa', 'fa-dribbble' ),
	'facebook.com'       => array( 'fa', 'fa-facebook-official' ),
	'flickr.com'         => array( 'fa', 'fa-flickr' ),
	'foursquare.com'     => array( 'fa', 'fa-foursquare' ),
	'github.com'         => array( 'fa', 'fa-github' ),
	'gittip.com'         => array( 'fa', 'fa-gittip' ),
	'google.com'         => array( 'fa', 'fa-google-plus-square' ),
	'houzz.com'          => array( 'fa', 'fa-houzz' ),
	'instagram.com'      => array( 'fa', 'fa-instagram' ),
	'jsfiddle.net'       => array( 'fa', 'fa-jsfiddle' ),
	'last.fm'            => array( 'fa', 'fa-lastfm' ),
	'leanpub.com'        => array( 'fa', 'fa-leanpub' ),
	'linkedin.com'       => array( 'fa', 'fa-linkedin' ),
	'medium.com'         => array( 'fa', 'fa-medium' ),
	'ok.ru'              => array( 'fa', 'fa-odnoklassniki' ),
	'pinterest.com'      => array( 'fa', 'fa-pinterest' ),
	'qzone.qq.com'       => array( 'fa', 'fa-qq' ),
	'reddit.com'         => array( 'fa', 'fa-reddit' ),
	'renren.com'         => array( 'fa', 'fa-renren' ),
	'slideshare.net'     => array( 'fa', 'fa-slideshare' ),
	'soundcloud.com'     => array( 'fa', 'fa-soundcloud' ),
	'spotify.com'        => array( 'fa', 'fa-spotify' ),
	'stackexchange.com'  => array( 'fa', 'fa-stack-exchange' ),
	'stackoverflow.com'  => array( 'fa', 'fa-stack-overflow' ),
	'steamcommunity.com' => array( 'fa', 'fa-steam' ),
	'stumbleupon.com'    => array( 'fa', 'fa-stumbleupon' ),
	't.qq.com'           => array( 'fa', 'fa-tencent-weibo' ),
	'trello.com'         => array( 'fa', 'fa-trello' ),
	'tumblr.com'         => array( 'fa', 'fa-tumblr' ),
	'twitch.tv'          => array( 'fa', 'fa-twitch' ),
	'twitter.com'        => array( 'fa', 'fa-twitter' ),
	'vimeo.com'          => array( 'fa', 'fa-vimeo-square' ),
	'vine.co'            => array( 'fa', 'fa-vine' ),
	'vk.com'             => array( 'fa', 'fa-vk' ),
	'weibo.com'          => array( 'fa', 'fa-weibo' ),
	'weixin.qq.com'      => array( 'fa', 'fa-weixin' ),
	'wordpress.com'      => array( 'fa', 'fa-wordpress' ),
	'xing.com'           => array( 'fa', 'fa-xing' ),
	'yahoo.com'          => array( 'fa', 'fa-yahoo' ),
	'yelp.com'           => array( 'fa', 'fa-yelp' ),
	'youtube.com'        => array( 'fa', 'fa-youtube' ),
) );