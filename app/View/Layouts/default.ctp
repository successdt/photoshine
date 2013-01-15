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
	
	<?php echo $this->Html->css(array('bootstrap.min', 'app', 'slidebox'), 'stylesheet') ?>
	<?php echo $this->fetch('css'); ?>
</head>

<body>
	<div id="header" class="navbar navbar-fixed-top">
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
		            <li class="dropdown">  
		                <a href="javascript:void(0)" class="dropdown-toggle category-btn" data-toggle="dropdown">
		                    <i class="icon-th icon-black"></i> 
		                    Categories  
		                    <b class="caret"></b>  
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
		                    <i class="icon-user icon-black"></i>
		                    Popular
		                </a>
		            </li>
		            <li>
		                <a href="#">
		                    <i class="icon-picture icon-black"></i>
		                    My photos
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
	</div><!-- // END HEADER -->
	
	<div id="sidebar">
	</div><!-- // END SIDEBAR -->
	
	<div id="content">
		
		<?php echo $this->fetch('content') ?>
	</div><!-- // END CONTENT -->

	<div id="footer">

	</div><!-- // END FOOTER -->
	
	<!-- javascript
	================================================== -->
	<?php echo $this->Html->script(array(
//		'live',
		'jquery.min',
		'slidebox',
		'bootstrap.min',
		'common'
	)) ?>
	<?php echo $this->fetch('script'); ?>
</body>
</html>