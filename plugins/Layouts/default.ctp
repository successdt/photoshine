<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8"/>
	<link rel="shortcut icon" href="<?php echo $this->Html->url('/img/favicon.ico') ?>" type="image/x-icon">
	<title>
		<?php echo isset($title_description) ? $title_description :  $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content=""/>
	<meta name="author" content=""/>
	<?php echo $this->fetch('meta'); ?>
	
	<?php echo $this->Html->css(array('bootstrap/css/bootstrap.min', 'colorbox/colorbox', 'select2/select2', 'app'), 'stylesheet') ?>
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
				<?php
					echo $this->Html->link(
						$this->Html->image('meshtiles/main_post_btn.png'),
						array('controller' => 'post', 'action' => 'index'),
						array('id' => 'upload-btn', 'class' => 'iframe cboxElement', 'escape' => false)
					)
				?>
			</div>
		</div>
		
		<div id="header-lower" class="row-fluid">
			<div class="navbar bar-left pull-left">
				<?php echo $this->Element('Layouts' . DS . 'user') ?>
			</div>
			<div class="bar-center">
				<?php
					$thisUrl = Router::url(array_merge($this->request->params['pass'], array('?' => $this->request->query)), true);
					
					if (isset($tabActive)) {
						switch ($tabActive) {
							default:
							case 'popular':
							case 'you':
								echo $this->Html->link(
									'Popular',
									isset($tabPopularLink) ? $tabPopularLink : $thisUrl,
									array('class' => 'head-tab-link popular-tab-link' . ($tabActive == 'popular' ? ' active': ''), 'escape' => false)
								);
						
								echo $this->Html->link(
									'You',
									isset($tabYouLink) ? $tabYouLink : $thisUrl,
									array('class' => 'head-tab-link you-tab-link'. ($tabActive == 'you' ? ' active': ''), 'escape' => false)
								);
								
								break;
							
							case 'hot':
							case 'weekly':
								echo $this->Html->link(
									'Hot',
									isset($tabHotLink) ? $tabHotLink : $thisUrl,
									array('class' => 'head-tab-link hot-tab-link' . ($tabActive == 'hot' ? ' active': ''), 'escape' => false)
								);
							
								echo $this->Html->link(
									'Weekly',
									isset($tabWeeklyLink) ? $tabWeeklyLink : $thisUrl,
									array('class' => 'head-tab-link weekly-tab-link'. ($tabActive == 'weekly' ? ' active': ''), 'escape' => false)
								);
							
								break;
						}
					}
				?>
			</div>
			<div class="bar-right pull-right">
				<?php echo $this->Element('Layouts' . DS . 'search') ?>
			</div>
		</div>
		
	</div><!-- // END HEADER -->
	
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
	var favourist = <?php echo AuthComponent::user('others.favourite_tag') ? AuthComponent::user('others.favourite_tag') : '[]' ?>;
	var frequent = <?php echo AuthComponent::user('others.frequent_tag') ? AuthComponent::user('others.frequent_tag') : '[]' ?>;
	
	function closeColorbox(q){
		$.colorbox.close(q);
	}
	
	$(document).ready(function(){
		
		$('#upload-btn').colorbox({iframe: true, innerWidth: '619px', innerHeight: typeof(window.FileReader) != 'undefined' ? '560px' : '300px', href: '<?php echo $this->Html->url(array('controller' => 'post', 'action' => 'index')) ?>', backButton: false});
		
		$('#edit-you-element').click(function(e){
			e.preventDefault();
			$.colorbox({iframe:true, innerWidth: '650px', innerHeight: '1410px', close: '', href: '<?php echo $this->Html->url(array('controller' => 'ui', 'action' => 'u03')) ?>', transition: "none"});
		});
		$('#edit-profile-link').click(function(e){			
			e.preventDefault();
			$.colorbox({iframe:true, innerWidth: '750px', innerHeight: '900px', close: '', href: '<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'editUserProfile')) ?>'});
		});

		$('#support-menu-link').click(function(e){
			e.preventDefault();
			var html = 
				'<?php echo $this->Html->css('popup') ?>' +
				'<div class="support-menu">' +
				'<h1><?php echo __('Support menu') ?></h1>' +
				'<div class="btn compose-email"><?php echo __('Email to support') ?></div>' +
				'<div class="btn change-pwd"><?php echo __('Change password') ?></div>' +
				'<div class="btn manager-acc"><?php echo __('Manage account') ?></div>' +
				'</div>';
			$.colorbox({innerWidth: '480px', innerHeight: '278px', close: '', html: html});
			$('.compose-email').live('click', function(){
				window.location.href = "mailto:support@meshtil.es";
			});
			
			$('.manager-acc').live('click', function(){
				$.colorbox({iframe:true, innerWidth: '660px', innerHeight: '310px', close: '', href: '<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'manageAccount')) ?>'});
			});
			
			$('.change-pwd').live('click', function(){
				$.colorbox({iframe:true, innerWidth: '650px', innerHeight: '980px', close: '', href: '<?php echo $this->Html->url(array('controller' => 'ui', 'action' => 'u04')) ?>'});
			});
		});
		
		$('#notification-setting').click(function(e){
			e.preventDefault();
			$.colorbox({iframe:true, innerWidth: '600px', innerHeight: '1200px', close: '', href: $(this).attr('href')});	
		});
		
		$('#edit-sharing').click(function(e){
			e.preventDefault();
			$.colorbox({iframe:true, innerWidth: '650px', innerHeight: '445px', close: '', href: '<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'sharingSetting')) ?>'});	
		});

		$('#view-notices').click(function(e){
			e.preventDefault();
			$.colorbox({iframe:true, innerWidth: '640px', innerHeight: '310px', scrolling: false, close: '', href: '<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'notices')) ?>'});	
		});
		
		var recentTerm = '';
		$('#search-by-tag').select2({
			width: 'copy',
			formatNoMatches: function() {return "<?php echo __('No result found.') ?>"},
			multiple: true,
			maximumSelectionSize: 1,
			
			ajax: {
				url: '<?php echo $this->Html->url(array('controller' => 'ajax', 'action' => 'callApi', 'getListTagsRecommend')) ?>',
				type: 'GET',
				dataType: 'json',
				quietMillis: 200,
				defaultResults: function() {
					var results = new Array();
					if (favourist && favourist.length) {
						results.push({text: '<?php echo __('favourite') ?>', children: favourist});
					}
					if (frequent && frequent.length) {
						results.push({text: '<?php echo __('frequent') ?>', children: frequent});
					}
					if (results.length == 0) {
						results.push({text: "<?php echo __('Not have any favourite or frequent tag') ?>", children: []});
					}
					
					return {results: results};
				},
				data: function (term, page) {
					recentTerm = term;
					return {
						keyword: term,
						access_token: '<?php echo AuthComponent::user('credentials.access_token') ?>'
					};
				},
				
				results: function (data) {
					var recommentTag = new Array();
					
					$.each(data.tag, function(index, tag) {
						recommentTag.push({id: tag.tag_name, text: tag.tag_name, number: toNumberSize(tag.number_post)});
					});
					
					return {results: recommentTag};
				}
			},
			formatResult: function(object) {
				if (!object.id) {
					return object.text;
				}
				
				return '<div class="row-fluid"><div class="pull-left">' + '# ' + object.text + '</div><div class="pull-right">' + object.number + '</div></div>';
			},
			formatSelection: function(object, container) {
				$(container).css('padding', '0').css('margin-left', '0').find('a').remove();
				return '<div style="max-width: 120px; line-height: 24px;" class="ellipsis">' + object.text + '</div>';
			}
		}).change(function(e){
			$('#header-lower .select2-input').css('width', '1px');
		});

		$('#header-lower .select2-input').keypress(function(e){
			var value = $('#search-by-tag').select2('val');
			if (e.keyCode == 13 && value.length > 0) {
				window.location = '<?php echo $this->Html->url(array('controller' => 'trend', 'action' => 'tag')) ?>' + '/' + value[0];
			}
		});

		$('#search-by-tag-btn').click(function(){
			var value = $('#search-by-tag').select2('val');
			if (value.length > 0) {
				window.location = '<?php echo $this->Html->url(array('controller' => 'trend', 'action' => 'tag')) ?>' + '/' + value[0];
			}
		});
	});
	</script>
	
	<?php echo $this->fetch('script'); ?>
</body>
</html>