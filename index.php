<?php

require('../wp-load.php');

$limit = (!empty($_REQUEST['offset']) ? $_REQUEST['offset'] : null);

$file = 'http://makeprojects.com/api/0.1/guides/?limit=200&offset=' . $limit;
$contents = file_get_contents($file);
$projects = json_decode($contents);

header("Content-type: text/xml; charset=utf-8");

function make_dashed($str) {
	$dashed = str_replace(' ', '-', $str );
	return $dashed;
}
echo '<?xml version="1.0" encoding="UTF-8" ?>';

?>

<rss version="2.0"
	xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:wp="http://wordpress.org/export/1.2/"
>

<channel>
	<title>MAKE</title>
	<link>http://localhost:8888</link>
	<description>DIY projects, how-tos, and inspiration from the workshops and minds of geeks, makers, and hackers @ Make: magazine</description>
	<pubDate>Wed, 28 Nov 2012 18:12:25 +0000</pubDate>
	<language>en-US</language>
	<wp:wxr_version>1.2</wp:wxr_version>
	<wp:base_site_url>http://localhost:8888</wp:base_site_url>
	<wp:base_blog_url>http://localhost:8888</wp:base_blog_url>
	<wp:wxr_version>1.2</wp:wxr_version>


	<generator>http://wordpress.org/?v=3.5-RC1-22893</generator>

<?php foreach ($projects as $project) {
	echo '<item>';
		$project_url = 'http://makeprojects.com/api/0.1/guide/'.$project->guideid;
		$json = file_get_contents($project_url);
		//print_r($json);
		$proj = json_decode($json);
		$guide = $proj->guide;
		echo '<title>' . ent2ncr( esc_html( $guide->title ) ) . '</title>';
		echo '<link>' . ent2ncr( esc_url( $proj->url ) ) . '</link>';
		echo '<dc:creator>' . ent2ncr( $guide->author->text ) . '</dc:creator>';
		echo '<description>' . ent2ncr( esc_html( $guide->summary ) ) . '</description>';
		echo '<content:encoded><![CDATA[' . ent2ncr( $guide->introduction ) . ']]></content:encoded>';
		echo '<excerpt:encoded><![CDATA[' . ent2ncr( $guide->summary ) . ']]></excerpt:encoded>';
		echo '<wp:post_id>' . ent2ncr( $proj->guideid ) . '</wp:post_id>';
		echo '<wp:comment_status>open</wp:comment_status>';
		echo '<wp:ping_status>open</wp:ping_status>';
		//echo '<wp:post_name></wp:post_name>';
		echo '<wp:status>publish</wp:status>';
		echo '<wp:post_type>projects</wp:post_type>';
		echo '<wp:post_parent>0</wp:post_parent>';
		echo '<wp:menu_order>0</wp:menu_order>';
		echo '<wp:post_type>post</wp:post_type>';
		echo '<wp:post_password></wp:post_password>';
		echo '<wp:is_sticky>0</wp:is_sticky>';
		echo '<category domain="author" nicename="cap-' . ent2ncr( make_dashed( $guide->author->text ) ) . '"><![CDATA[' . ent2ncr( make_dashed( $guide->author->text ) ) . ']]></category>';
		echo '<category domain="difficulty" nicename="' . ent2ncr( make_dashed( $guide->difficulty ) ) . '"><![CDATA[' . ent2ncr( make_dashed( $guide->difficulty ) ) . ']]></category>';
		foreach ($guide->categories as $category ) {
			echo '<category domain="category" nicename="' .ent2ncr( make_dashed( $category ) ) . '"><![CDATA[' . ent2ncr( $category ) . ']]></category>';
		}
		foreach ($guide->tools as $tool ) {
			echo '<category domain="tools" nicename="' . ent2ncr( make_dashed( $tool->text ) ) . '"><![CDATA[' . ent2ncr( $tool->text ) . ']]></category>';
		}
		foreach ($guide->parts as $part ) {
			echo '<category domain="parts" nicename="' . ent2ncr( make_dashed( $part->text ) ) . '"><![CDATA[' . ent2ncr( $part->text ) . ']]></category>';
		}
		foreach ($guide->flags as $flag ) {
			echo '<category domain="flags" nicename="' . ent2ncr( make_dashed( $flag->title ) ) . '"><![CDATA[' . ent2ncr( $flag->title ) . ']]></category>';
		}
		
		echo '<category domain="types" nicename="' . ent2ncr( make_dashed( $guide->type ) ) . '"><![CDATA[' . ent2ncr( $guide->type ) . ']]></category>';
		echo '<wp:postmeta>';
			echo '<wp:meta_key>Steps</wp:meta_key>';
			echo '<wp:meta_value><![CDATA[' . serialize ( ent2ncr( $guide->steps ) ) . ']]></wp:meta_value>';
		echo '</wp:postmeta>';

		echo '<wp:postmeta>';
			echo '<wp:meta_key>Link</wp:meta_key>';
			echo '<wp:meta_value><![CDATA[' . ent2ncr( esc_url( $proj->url ) ) . ']]></wp:meta_value>';
		echo '</wp:postmeta>';

		echo '<wp:postmeta>';
			echo '<wp:meta_key>MakeProjectsGuideNumber</wp:meta_key>';
			echo '<wp:meta_value><![CDATA[' . $guide->guideid . ']]></wp:meta_value>';
		echo '</wp:postmeta>';

		echo '<wp:postmeta>';
			echo '<wp:meta_key>Tools</wp:meta_key>';
			echo '<wp:meta_value><![CDATA[' . serialize( ent2ncr( $guide->tools ) ) . ']]></wp:meta_value>';
		echo '</wp:postmeta>';

		echo '<wp:postmeta>';
			echo '<wp:meta_key>Documents</wp:meta_key>';
			echo '<wp:meta_value><![CDATA[' . serialize( ent2ncr( $guide->documents ) ) . ']]></wp:meta_value>';
		echo '</wp:postmeta>';

		echo '<wp:postmeta>';
			echo '<wp:meta_key>Flags</wp:meta_key>';
			echo '<wp:meta_value><![CDATA[' . serialize( ent2ncr( $guide->flags ) ) . ']]></wp:meta_value>';
		echo '</wp:postmeta>';

		echo '<wp:postmeta>';
			echo '<wp:meta_key>Type</wp:meta_key>';
			echo '<wp:meta_value><![CDATA[' . ent2ncr( $guide->type ) . ']]></wp:meta_value>';
		echo '</wp:postmeta>';

		echo '<wp:postmeta>';
			echo '<wp:meta_key>Conclusion</wp:meta_key>';
			echo '<wp:meta_value><![CDATA[' . ent2ncr( wp_kses_post( $guide->conclusion ) ) . ']]></wp:meta_value>';
		echo '</wp:postmeta>';

		echo '<wp:postmeta>';
			echo '<wp:meta_key>Image</wp:meta_key>';
			echo '<wp:meta_value><![CDATA[' . ent2ncr( $guide->image->text ) . ']]></wp:meta_value>';
		echo '</wp:postmeta>';

		echo '<wp:postmeta>';
			echo '<wp:meta_key>Description</wp:meta_key>';
			echo '<wp:meta_value><![CDATA[' . ent2ncr( $guide->summary ) . ']]></wp:meta_value>';
		echo '</wp:postmeta>';

		echo '<wp:postmeta>';
			echo '<wp:meta_key>TimeRequired</wp:meta_key>';
			echo '<wp:meta_value><![CDATA[' . ent2ncr( $guide->time_required ) . ']]></wp:meta_value>';
		echo '</wp:postmeta>';

	echo '</item>';
	
}	

?>
		
</channel>
</rss>
