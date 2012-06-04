<?php

/*
Plugin Name: Memcached
Description: Memcached backend for the WP Object Cache.
Version: 2.0.1
Plugin URI: http://wordpress.org/extend/plugins/memcached/
Author: Ryan Boren, Denis de Bernardy, Matt Martz

Install this file to wp-content/object-cache.php
*/

function wp_cache_add($key, $data, $flag = '', $expire = 0) {
	global $wp_object_cache;

	return $wp_object_cache->add($key, $data, $flag, $expire);
}

function wp_cache_incr($key, $n = 1, $flag = '') {
	global $wp_object_cache;

	return $wp_object_cache->incr($key, $n, $flag);
}

function wp_cache_decr($key, $n = 1, $flag = '') {
	global $wp_object_cache;

	return $wp_object_cache->decr($key, $n, $flag);
}

function wp_cache_close() {
	global $wp_object_cache;

	return $wp_object_cache->close();
}

function wp_cache_delete($id, $flag = '') {
	global $wp_object_cache;

	return $wp_object_cache->delete($id, $flag);
}

function wp_cache_flush() {
	global $wp_object_cache;

	return $wp_object_cache->flush();
}

function wp_cache_get($id, $flag = '') {
	global $wp_object_cache;

	return $wp_object_cache->get($id, $flag);
}

function wp_cache_init() {
	global $wp_object_cache;

	$wp_object_cache = new WP_Object_Cache();
}

function wp_cache_replace($key, $data, $flag = '', $expire = 0) {
	global $wp_object_cache;

	return $wp_object_cache->replace($key, $data, $flag, $expire);
}

function wp_cache_set($key, $data, $flag = '', $expire = 0) {
	global $wp_object_cache;

	if ( defined('WP_INSTALLING') == false )
		return $wp_object_cache->set($key, $data, $flag, $expire);
	else
		return $wp_object_cache->delete($key, $flag);
}

function wp_cache_add_global_groups( $groups ) {
	global $wp_object_cache;

	$wp_object_cache->add_global_groups($groups);
}

function wp_cache_add_non_persistent_groups( $groups ) {
	global $wp_object_cache;

	$wp_object_cache->add_non_persistent_groups($groups);
}

class WP_Object_Cache {
	var $global_groups = array ('users', 'userlogins', 'usermeta', 'site-options', 'site-lookup', 'blog-lookup', 'blog-details', 'rss');

	var $no_mc_groups = array( 'comment', 'counts' );

	var $autoload_groups = array ('options');

	var $cache = array();
	var $mc = array();
	var $stats = array();
	var $group_ops = array();

	var $cache_enabled = true;
	var $default_expiration = 0;

	function add($id, $data, $group = 'default', $expire = 0) {
		$key = $this->key($id, $group);

		if ( in_array($group, $this->no_mc_groups) ) {
			$this->cache[$key] = $data;
			return true;
		} elseif ( isset($this->cache[$key]) && $this->cache[$key] !== false ) {
			return false;
		}

		$mc =& $this->get_mc($group);
		$expire = ($expire == 0) ? $this->default_expiration : $expire;
		$result = $mc->add($key, $data, false, $expire);

		if ( false !== $result ) {
			@ ++$this->stats['add'];
			$this->group_ops[$group][] = "add $id";
			$this->cache[$key] = $data;
		}

		return $result;
	}

	function add_global_groups($groups) {
		if ( ! is_array($groups) )
			$groups = (array) $groups;

		$this->global_groups = array_merge($this->global_groups, $groups);
		$this->global_groups = array_unique($this->global_groups);
	}

	function add_non_persistent_groups($groups) {
		if ( ! is_array($groups) )
			$groups = (array) $groups;

		$this->no_mc_groups = array_merge($this->no_mc_groups, $groups);
		$this->no_mc_groups = array_unique($this->no_mc_groups);
	}

	function incr($id, $n, $group) {
		$key = $this->key($id, $group);
		$mc =& $this->get_mc($group);

		return $mc->increment($key, $n);
	}

	function decr($id, $n, $group) {
		$key = $this->key($id, $group);
		$mc =& $this->get_mc($group);

		return $mc->decrement($key, $n);
	}

	function close() {

		foreach ( $this->mc as $bucket => $mc )
			$mc->close();
	}

	function delete($id, $group = 'default') {
		$key = $this->key($id, $group);

		if ( in_array($group, $this->no_mc_groups) ) {
			unset($this->cache[$key]);
			return true;
		}

		$mc =& $this->get_mc($group);

		$result = $mc->delete($key);

		@ ++$this->stats['delete'];
		$this->group_ops[$group][] = "delete $id";

		if ( false !== $result )
			unset($this->cache[$key]);

		return $result; 
	}

	function flush() {
		// Don't flush if multi-blog.
		if ( function_exists('is_site_admin') || defined('CUSTOM_USER_TABLE') && defined('CUSTOM_USER_META_TABLE') )
			return true;

		$ret = true;
		foreach ( array_keys($this->mc) as $group )
			$ret &= $this->mc[$group]->flush();
		return $ret;
	}

	function get($id, $group = 'default') {
		$key = $this->key($id, $group);
		$mc =& $this->get_mc($group);

		if ( isset($this->cache[$key]) )
			$value = $this->cache[$key];
		else if ( in_array($group, $this->no_mc_groups) )
			$value = false;
		else
			$value = $mc->get($key);

		@ ++$this->stats['get'];
		$this->group_ops[$group][] = "get $id";

		if ( NULL === $value )
			$value = false;
			
		$this->cache[$key] = $value;

		if ( 'checkthedatabaseplease' == $value )
			$value = false;

		return $value;
	}

	function get_multi( $groups ) {
		/*
		format: $get['group-name'] = array( 'key1', 'key2' );
		*/
		$return = array();
		foreach ( $groups as $group => $ids ) {
			$mc =& $this->get_mc($group);
			foreach ( $ids as $id ) {
				$key = $this->key($id, $group);
				if ( isset($this->cache[$key]) ) {
					$return[$key] = $this->cache[$key];
					continue;
				} else if ( in_array($group, $this->no_mc_groups) ) {
					$return[$key] = false;
					continue;
				} else {
					$return[$key] = $mc->get($key);
				}
			}
			if ( $to_get ) {
				$vals = $mc->get_multi( $to_get );
				$return = array_merge( $return, $vals );
			}
		}
		@ ++$this->stats['get_multi'];
		$this->group_ops[$group][] = "get_multi $id";
		$this->cache = array_merge( $this->cache, $return );
		return $return;
	}

	function key($key, $group) {	
		if ( empty($group) )
			$group = 'default';

		if ( false !== array_search($group, $this->global_groups) )
			$prefix = $this->global_prefix;
		else
			$prefix = $this->blog_prefix;

		return preg_replace('/\s+/', '', "$prefix$group:$key");
	}

	function replace($id, $data, $group = 'default', $expire = 0) {
		$key = $this->key($id, $group);
		$expire = ($expire == 0) ? $this->default_expiration : $expire;
		$mc =& $this->get_mc($group);
		$result = $mc->replace($key, $data, false, $expire);
		if ( false !== $result )
			$this->cache[$key] = $data;
		return $result;
	}

	function set($id, $data, $group = 'default', $expire = 0) {
		$key = $this->key($id, $group);
		if ( isset($this->cache[$key]) && ('checkthedatabaseplease' == $this->cache[$key]) )
			return false;
		$this->cache[$key] = $data;

		if ( in_array($group, $this->no_mc_groups) )
			return true;

		$expire = ($expire == 0) ? $this->default_expiration : $expire;
		$mc =& $this->get_mc($group);
		$result = $mc->set($key, $data, false, $expire);

		return $result;
	}

	function colorize_debug_line($line) {
		$colors = array(
			'get' => 'green',
			'set' => 'purple',
			'add' => 'blue',
			'delete' => 'red');

		$cmd = substr($line, 0, strpos($line, ' '));

		$cmd2 = "<span style='color:{$colors[$cmd]}'>$cmd</span>";

		return $cmd2 . substr($line, strlen($cmd)) . "\n";
	}

	function stats() {
		echo "<p>\n";
		foreach ( $this->stats as $stat => $n ) {
			echo "<strong>$stat</strong> $n";
			echo "<br/>\n";
		}
		echo "</p>\n";
		echo "<h3>Memcached:</h3>";
		foreach ( $this->group_ops as $group => $ops ) {
			if ( !isset($_GET['debug_queries']) && 500 < count($ops) ) { 
				$ops = array_slice( $ops, 0, 500 ); 
				echo "<big>Too many to show! <a href='" . add_query_arg( 'debug_queries', 'true' ) . "'>Show them anyway</a>.</big>\n";
			} 
			echo "<h4>$group commands</h4>";
			echo "<pre>\n";
			$lines = array();
			foreach ( $ops as $op ) {
				$lines[] = $this->colorize_debug_line($op); 
			}
			print_r($lines);
			echo "</pre>\n";
		}

		if ( $this->debug )
			var_dump($this->memcache_debug);
	}

	function &get_mc($group) {
		if ( isset($this->mc[$group]) )
			return $this->mc[$group];
		return $this->mc['default'];
	}

	function failure_callback($host, $port) {
		//error_log("Connection failure for $host:$port\n", 3, '/tmp/memcached.txt');
	}

	function WP_Object_Cache() {
		global $memcached_servers;

		if ( isset($memcached_servers) )
			$buckets = $memcached_servers;
		else
			$buckets = array('127.0.0.1');

		reset($buckets);
		if ( is_int(key($buckets)) )
			$buckets = array('default' => $buckets);

		foreach ( $buckets as $bucket => $servers) {
			$this->mc[$bucket] = new Memcache();
			foreach ( $servers as $server  ) {
				list ( $node, $port ) = explode(':', $server);
				if ( !$port )
					$port = ini_get('memcache.default_port');
				$port = intval($port);
				if ( !$port )
					$port = 11211;
				$this->mc[$bucket]->addServer($node, $port, true, 1, 1, 15, true, array($this, 'failure_callback'));
				$this->mc[$bucket]->setCompressThreshold(20000, 0.2);
			}
		}

		global $blog_id, $table_prefix;
		$this->global_prefix = ( is_multisite() || defined('CUSTOM_USER_TABLE') && defined('CUSTOM_USER_META_TABLE') ) ? '' : $table_prefix;
		$this->blog_prefix = ( is_multisite() ? $blog_id : $table_prefix ) . ':';

		$this->cache_hits =& $this->stats['get'];
		$this->cache_misses =& $this->stats['add'];
	}
}
?>
