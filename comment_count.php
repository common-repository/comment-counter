<?php
/*
Plugin Name: Comment Counter
Plugin URI: http://ocean90.wphelper.de/wordpress/plugin-comment-counter/
Description: Shows the number of comments from a commentator. <strong>Attention: With version 0.4 I changed the handling of the parameters. Please check the new documentation!</strong>
Version: 0.4
Author: ocean90
Author URI: http://wphelper.de

License:
 ==============================================================================
 Copyright 2009 Dominik Schilling  (email : admin@wphelper.de)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if (!function_exists('add_action')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}


function comment_counter($args = '') {
    $defaults = array(
        'routine' => 'email',
        'exclude' => array(),
        'cc_comment_id' => '',
        'echo' => 1,
        'format' =>  '<small>%s</small>',
        'german_plural' => 1,
        'access' => ''
	);
    
    $args = wp_parse_args($args, $defaults);
    extract($args);

    if (!empty($access) && current_user_can($access) === false)
        return;
    
    if(empty($cc_comment_id))
        $cc_comment_id = intval($GLOBALS['comment']->comment_ID);

    $cc_comment = get_comment($cc_comment_id);
    $cc_comment_author = $cc_comment->comment_author;
    $cc_comment_url = $cc_comment->comment_author_url;
    $cc_comment_email = $cc_comment->comment_author_email;
    $cc_comment_ip = $cc_comment->comment_author_IP;
    $cc_comment_user_id = $cc_comment->user_id;
    $cc_comment_type = $cc_comment->comment_type;
    $cc_comment_data = array($cc_comment_author, $cc_comment_url, $cc_comment_ip, $cc_comment_id, $cc_comment_email);
    
    $result = array_intersect(explode(',', $exclude), $cc_comment_data);
    if (!empty($result))
        return;

    if (!empty($cc_comment_type))
        return;
                       
    if ($routine == 'author') {
        $cache = wp_cache_get($cc_comment_author);
        if ($cache == false) {
            $count = "SELECT COUNT(comment_author) FROM " .$GLOBALS['wpdb']->comments. " WHERE comment_author = '$cc_comment_author'";
            $cc_count = intval($GLOBALS['wpdb']->get_var($count));
            wp_cache_set($cc_comment_author, $cc_count);
        } else {
            $cc_count = $cache;
        }
    } elseif ($routine == 'url') {
        $cache = wp_cache_get($cc_comment_url);
        if ($cache == false) {
            $count = "SELECT COUNT(comment_author_url) FROM " .$GLOBALS['wpdb']->comments. " WHERE comment_author_url = '$cc_comment_url'";
            $cc_count = intval($GLOBALS['wpdb']->get_var($count));
            wp_cache_set($cc_comment_url, $cc_count);
        } else {
            $cc_count = $cache;
        }
    } elseif ($routine == 'email') {
        $cache = wp_cache_get($cc_comment_email);
        if ($cache == false) {
            $count = "SELECT COUNT(comment_author_email) FROM " .$GLOBALS['wpdb']->comments. " WHERE comment_author_email = '$cc_comment_email'";               
            $cc_count = $GLOBALS['wpdb']->get_var($count);
            wp_cache_set($cc_comment_email, $cc_count);
        } else {
            $cc_count = $cache;
        }
    } elseif ($routine == 'ip') {
        $cache = wp_cache_get($cc_comment_ip);
        if ($cache == false) {
            $count = "SELECT COUNT(comment_author_IP) FROM " .$GLOBALS['wpdb']->comments. " WHERE comment_author_IP = '$cc_comment_ip'";
            $cc_count = intval($GLOBALS['wpdb']->get_var($count));
            wp_cache_set($cc_comment_ip, $cc_count);
        } else {
            $cc_count = $cache;
        }
    } elseif ($routine == 'id') {
        $cache = wp_cache_get($cc_comment_id);
        if ($cache == false) {
            $count = "SELECT COUNT(user_id) FROM " .$GLOBALS['wpdb']->comments. " WHERE user_id = '$cc_comment_user_id'";
            $cc_count = intval($GLOBALS['wpdb']->get_var($count));
            wp_cache_set($cc_comment_id, $cc_count);
        } else {
            $cc_count = $cache;
        }
    } else {
        return;
    }
            
    /* Percent of total comments - BETA */
    $cache = wp_cache_get('cc_total_comments');
    if ($cache == false) {
        $total_comments = wp_count_comments();
        $total_comments = $total_comments->approved;
        wp_cache_set('cc_total_comments', $total_comments);
    } else {
        $total_comments = $cache;
    }
    $percent = ($cc_count * 100) / $total_comments;
    /* Percent of total comments - BETA - END*/
  
    $output = sprintf(
                        $format,
                        $german_plural ? (sprintf( __ngettext('%s Kommentar', '%s Kommentare', $cc_count), number_format_i18n($cc_count))) : number_format_i18n($cc_count), 
                        number_format_i18n($percent, 2) . '%',
                        $german_plural ? (sprintf( __ngettext('%s Kommentar', '%s Kommentare', $total_comments), number_format_i18n($total_comments))) : number_format_i18n($total_comments)
                    );
    
    if ($echo)
        echo $output;
    else
        return $output;
}
?>