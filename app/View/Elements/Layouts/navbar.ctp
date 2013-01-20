<div class="navbar-inner">
    <div class="container">
        <ul class="nav">
            <li class="active">
            	<?php echo $this->Html->link(
            		$this->Html->image('photoshine/photoshine 100x100.png', array('width' => '24', 'height' => '24')) . ' PhotoShine',
            		array('javascrip:void(0)'),
            		array('class' => 'brand', 'escape' => false)
				); ?>
            </li>
            <li>  
                <a href="javascript:void(0)" class="navbar-channels">
                    <i class="icon-th icon-black"></i> 
                    Channels  
                </a>  
                <ul class="dropdown-menu">  
                </ul>  
            </li>
            <li>
                <a class="" href="javascript:void(0)" id="nearby">
                    <i class="icon-map-marker icon-black"></i>
                    Nearby
                </a>
            </li>
            <li>
                <a class="" href="#">
                    <i class="icon-star icon-black"></i>
                    Popular
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon-thumbs-up icon-black"></i>
                    My Likes
                </a>
            </li>
            <li class="dropdown">  
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-search icon-black"></i> 
                    Search 
                    <b class="caret"></b>  
                </a>  
                <ul class="dropdown-menu">  
                    <li>
                        <form class="navbar-search pull-right input-append" method="post" action="#">
                             <div class="input-append" style="padding: 10px;">
                                <input class="span2" style="top: 6px;" name="search" placeholder="Search" autocomplete="off" id="inputString" size="16" type="text">
                                <button type="submit" class="btn">Go!</button>
                                <div id="suggestions"></div>
                                <label class="radio" style="margin-top: 5px;">
                                    <input type="radio" name="searchby" value="tag"  checked="checked"/>
                                    Tag
                                </label>
                                <label class="radio">
                                    <input type="radio" name="searchby" value="user" /> 
                                    Username
                                </label>     
                            </div>
                        </form>  
                    </li>
                </ul>  
            </li> 
        </ul>
        <ul class="nav pull-right">
            <li class="dropdown">
                <li class="divider-vertical"/>
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                </ul>
            </li>
            <li>
            </li>
        </ul>
    </div><!-- /container -->
</div><!--/navbar-inner  -->

<div class="channel-menu-html" style="display: none;">
	<div class="channel-menu">
		<?php
		$listChannels = array(
			array('class' => 'featured', 'text' => 'Featured User'),	
			array('class' => 'brands', 'text' => 'Brands'),
			array('class' => 'celebrities', 'text' => 'Celebrities'),
			array('class' => 'fashion', 'text' => 'Fashion'),
			array('class' => 'food', 'text' => 'Food'),
			array('class' => 'travel', 'text' => 'Travel'),
			array('class' => 'animals', 'text' => 'Animals'),
			array('class' => 'sports', 'text' => 'Sport'),
			array('class' => 'music', 'text' => 'Music'),
			array('class' => 'architecture', 'text' => 'Architecture'),
			array('class' => 'design', 'text' => 'Art/Design'),
			array('class' => 'tech', 'text' => 'Tech'),
		);
		?>
		<?php foreach ($listChannels as $channel): ?>
			<a class="tag" href="<?php echo $this->Html->url(array('controller' => 'ui', 'action' => 'channel', $channel['class'])) ?>">
				<i class="tag-<?php echo $channel['class'] ?>-icn tag-icn pull-left"></i>
				<span class="pull-left"></span><?php echo $channel['text'] ?>
			</a>
		<?php endforeach; ?>

	</div>
</div>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
	$(document).ready(function(){
		$('.navbar-channels').click(function(){
			var html = $('.channel-menu-html').html();
			
			$().slidebox({
				html: html
			});
		});
	});
<?php echo $this->Html->scriptEnd() ?>