<?php
	require_once('../../../../wp-load.php');
	require_once('../../../../wp-admin/includes/admin.php');
	do_action('admin_init');
	
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');

	$args = array( 'post_type' => 'lepopup', 'posts_per_page' => -1 );

	query_posts( $args );
	$popups = array();
	
	while ( have_posts() ) : the_post();
		$popups[] = array(
			"ID" => get_the_ID(),
			"post_title" => get_the_title()
		);
	endwhile;

	wp_reset_query();
?>
(function() {
	tinymce.create('tinymce.plugins.lepopup', {
		init : function(ed, url) {
			ed.addButton('lepopup', {
				title : 'LePopup',
				image : url+'/mioo.png',
				onclick : function() {
				}
			});
		},
		createControl : function(n, cm) {
			if(n=='lepopup'){
				var mlb = cm.createListBox('lepopup', {
					 title : 'LePopup',
					 onselect : function(v) {
						if(v){
							tinyMCE.activeEditor.selection.setContent('<a href="#lepopup-'+v+'">' + tinyMCE.activeEditor.selection.getContent() + '</a>');
						}
					 }
				});
				<?php foreach($popups as $sct):?>
					mlb.add('<?php echo (!empty($sct['post_title'])) ? ($sct['post_title']) : '(no title)'; ?>', '<?php echo $sct['ID']; ?>');
				<?php endforeach;?>
				return mlb;
			 }

			return null;
		},
		getInfo : function() {
			return {
				longname : 'Lepopup selector',
				author : 'mioo',
				authorurl : '',
				infourl : '',
				version : "1"
			};
		}
	});
	tinymce.PluginManager.add('lepopup', tinymce.plugins.lepopup);
})();
