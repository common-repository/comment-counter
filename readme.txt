=== Comment Counter ===
Contributors: ocean90
Tags: comment, count, commentator, email, url, author, ip, statics
Requires at least: 2.6
Tested up to: 3.0-alpha
Stable tag: trunk

Comment Counter -  Count comments by a commentator.

== Description ==

Comment Counter is a plugin which count the comments by a commentator.
You can define different parameters for the count:

* the URL
* the authorname
* the email address
* the userid
* the author IP


= Usage =
`<?php comment_counter($args); ?>`
.

= Links =
* [Plugin documentation in German](http://ocean90.wphelper.de/wordpress/plugin-comment-counter/ "Comment Counter")
* [Follow me on Twitter for support, news and updates](http://twitter.com/ocean90 "ocean90 on Twitter")
* [My other plugins](http://wordpress.org/extend/plugins/profile/ocean90 "Other plugins")
* [Take also a look at these plugins](http://wordpress.org/extend/plugins/profile/stalkerx "Other plugins")

== Installation ==
1. Download *Comment Counter* plugin
1. Unzip the archive
1. Upload the folder *comment_count* into *../wp-content/plugins/*
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php comment_counter();?>` in your template
1. Have fun!

Info: If you use `<?php wp_list_comments(); ?>` in your template you should read [this article](http://ottodestruct.com/blog/2008/09/29/wordpress-27-comments-enhancements/ "Information for wp_list_comments()").

Bitte besuch die [Comment Counter Seite](http://blog.ocean90.ath.cx/wordpress/wp-plugin-comment-counter/ "Comment Counter Seite") fuer eine deutsche Anleitung.

= Default Usage =
`<?php $args = array(
        'routine' => 'email',
        'exclude' => '',
        'cc_comment_id' => '',
        'echo' => 1,
        'format' =>  '<small>%s</small>',
        'german_plural' => 1,
        'access' => ''
		);
?>`
.		

= Parameters =

**routine**
*(string)* The count parameter.
Valid values:

* `'email'` (default) the commentator e-mail adress
* `'author'` the commentator name
* `'url'` the commentator url
* `'id'` the user ID of the commentator
* `'ip'` the commentator IP

**exclude**
*(string)* Define which e-mail, name, url, id or ip shouldn't be count. Valid values:

* `'email@email.de,spam@cvo.de'`
* `'max,anna,lukas'`

**cc_comment_id**
*(int)* Define an ID of a comment. It will display the count from the commentator of this comment. Valid values:

* `'4355435'`

**echo**
*(boolean)* If you want to save the number in a variable, you should use echo=0. Valid values:

* `'1'` (true) output via echo
* `'0'` (false) output via return

**format**
*(string)* Style the output
Valid values:

* `'%s comments (that are %s of %s comments'` first %s for comment count. Optional: second %s for percentage and the last %s for total comments.

**access**
*(string)* Who should see the comment count. Values are [capabilities](http://codex.wordpress.org/Roles_and_Capabilities#Capabilities "Capabilities"). Valid values:

* `''` (default) All user can see the number
* `'manage_options'` Only users who can change options can see the number (Admins)

== Upgrade Notice ==
If you upgrade from version < 0.4, you should read the new documentation. The handling of parameters is changed!

== Changelog ==

= 0.4 =
* code style cleanups
* new handling of parameters, please read the new documentation!
* add parameter echo for echo or return
* add parameter access, who is allowed to see the numbers
* add parameter format, so you can easier style the output
* add parameter german_plural for german plural (x Kommentar, x Kommentare)
* add option, to display the percentage of the total comments, please read the new documentation!
* remove parameter before and after because of new parameter format
* add security check
* add parameter cc_comment_id, set a comment id and you will get the number of the comments from the commentator of the comment

= 0.3 =
* works now with WordPress cache, no duplicate queries anymore

= 0.22 =
* fix bug with trackbacks; now pingbacks and trackbacks are excluded

= 0.21 =
* add exclude option

= 0.2 =
* add parameter for count: id, ip, email, author, userid
* add parameter before and after for styling
* add check for pingbacks and comments

= 0.1 =
* release