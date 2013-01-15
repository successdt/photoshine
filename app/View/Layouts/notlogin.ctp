<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8"/>
	<link rel="shortcut icon" href="<?php echo $this->Html->url('/img/favicon.ico') ?>" type="image/x-icon">
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content=""/>
	<meta name="author" content=""/>
	
	<?php echo $this->Html->css(array('bootstrap/css/bootstrap.min', 'colorbox/colorbox', 'imgareaselect/imgareaselect-default', 'select2/select2', 'app', 'post', 'notlogin'), 'stylesheet') ?>
	<?php echo $this->fetch('css'); ?>
</head>

<body>

	<div id="header" class="navbar-fixed-top">
	
		<div id="header-upper" class="row-fluid">
			<?php 
				echo $this->Html->link(
					$this->Html->image('meshtiles/logo_top.png'),
					'#',
					array('id' => 'logo', 'escape' => false)
				)
			?>
			<div class="pull-right">
				<a href="#" class="signup intro-btn"></a>
				<a href="#" class="login intro-btn"></a>
			</div>
		</div>
		
	</div><!-- // END HEADER -->
	
	<div class="welcome">
		<div class="content">
			<p class="title">Let’s join and mesh the world!</p>
			<p>A serendipity will happen by sharing photo.</p>
			<div class="cta">
				<a href="#" class="fb pull-left"></a>
				<a href="#" class="tw pull-right"></a>
			</div>
			<p class="smaller">No Facebook or Twitter account? <a href="#">Sign up here.</a> it’s still easy.</p>
		</div>
	</div>
	
	<div id="sidebar">
		<?php echo $this->element('Layouts' . DS. 'sidebar') ?>
	</div><!-- // END SIDEBAR -->
	
	<div id="content">
		<?php
			echo $this->element('Layouts' . DS . 'title');
			echo $this->fetch('content'); 
		?>
	</div><!-- // END CONTENT -->

	<div id="footer">

	</div><!-- // END FOOTER -->
	
	<!-- javascript
	================================================== -->
	<?php echo $this->Html->script(array(
		'jquery.min', 
		'bootstrap.min', 
		'jquery.colorbox',
		'select2.min',
		'modernizr',
		'common'
	)) ?>
	
	<script type="text/javascript">
	var ias;
	var favourist = <?php echo AuthComponent::user('others.favourite_tag') ? AuthComponent::user('others.favourite_tag') : '[]' ?>;
	var frequent = <?php echo AuthComponent::user('others.frequent_tag') ? AuthComponent::user('others.frequent_tag') : '[]' ?>;

	$(document).ready(function(){
		
		$('#upload-btn').colorbox({iframe: true, innerWidth: '619px', innerHeight: typeof(window.FileReader) != 'undefined' ? '560px' : '300px', href: '<?php echo $this->Html->url(array('controller' => 'post', 'action' => 'index')) ?>'});
		
		$('#edit-you-element').click(function(e){
			e.preventDefault();
			$.colorbox({iframe:true, innerWidth: '650px', innerHeight: '1410px', close: '', href: '<?php echo $this->Html->url(array('controller' => 'ui', 'action' => 'u03')) ?>', transition: "none"});
		});
		$('#edit-profile-link').click(function(e){
			e.preventDefault();
			$.colorbox({iframe:true, innerWidth: '650px', innerHeight: '980px', close: '', href: '<?php echo $this->Html->url(array('controller' => 'ui', 'action' => 'u04')) ?>'});
		});

		$('#support-menu-link').click(function(e){
			e.preventDefault();
			$.colorbox({iframe:true, innerWidth: '480px', innerHeight: '278px', close: '', href: '<?php echo $this->Html->url(array('controller' => 'ui', 'action' => 'u14')) ?>'});
		});


		$('#search-by-tag').select2({
			width: 'copy',
			formatNoMatches: function() {return "<?php echo __('No result found.') ?>"},
			multiple: true,
			maximumSelectionSize: 1,
			query: function(query) {
				var term = $.trim(query.term);
				var recommentTag = new Array();
				var fav = new Array();
				var fre = new Array();
				
				$.each(favourist, function(index, value){
					if (value != undefined && value.id.indexOf(term) != -1) {
						fav.push(value);
					}
				});
				
				$.each(frequent, function(index, value){
					if (value != undefined && value.id.indexOf(term) != -1) {
						fre.push(value);
					}
				});
				
				
				if (term != '') {
					$.ajax({
						url: '<?php echo $this->Html->url(array('controller' => 'ajax', 'action' => 'callApi', 'getListTagsRecommend')) ?>' + '?keyword=' + term + '&access_token=<?php echo AuthComponent::user('credentials.access_token') ?>',
						type: 'GET',
						async: false,
						success: function(response) {
							response = $.parseJSON(response);
							$.each(response.tag, function(index, tag) {
								if (tag.tag_name.indexOf(term) != -1) {
									recommentTag.push({id: tag.tag_name, text: tag.tag_name, number: tag.number_post});
								}
							});
						}
					});
				}

				query.callback({results: [
						{text: '<?php echo __('favourite') ?>', children: fav},
					{text: '<?php echo __('frequent') ?>', children: fre},
					{text: '<?php echo __('recommend') ?>', children: recommentTag}
				]});
			},
			formatResult: function(object) {
				if (!object.id) {
					return object.text;
				}
				
				return '<div class="row-fluid"><div class="pull-left">' + '# ' + object.text + '</div><div class="pull-right">' + object.number + '</div></div>';
			},
			formatSelection: function(object, container) {
				$(container).css('padding-right', '0').find('a').remove();
				return '<div style="margin-left: -20px; width: 55px;" class="ellipsis">' + object.text + '</div>';
			}
		}).change(function(e){
			var tag = e.val[0];
			e.preventDefault();
			window.location = '<?php echo $this->Html->url(array('controller' => 'trend', 'action' => 'tag')) ?>' + '/' + tag;
			return false;
		});
		
		var fixadent = $("#sidebar"),
	    pos = fixadent.offset();
		$(window).scroll(function () {
		    if ($(this).scrollTop() > 183 && fixadent.css('position') == 'static') {
			    console.log('need fix');
		        fixadent.addClass('fix-sidebar');
		    } else if ($(this).scrollTop() <= 183 && fixadent.hasClass('fix-sidebar')) {
		        fixadent.removeClass('fix-sidebar');
		    }
		});
	});
	</script>
	
	<?php echo $this->fetch('script'); ?>
</body>
</html>