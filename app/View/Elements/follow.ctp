<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
var root = '<?php echo $this->webroot ?>';
$(document).ready(function(){
	$('.follow-btn').live('click', function(){
		var id = $(this).attr('data-user-id');
		
		if ($(this).hasClass('active')){
			var url = root + 'ajax/callApi/unfollowUser';
			$('.u' + id).removeClass('active');
			$('.u' + id).html('Follow');
		}
		else{
			var url = root + 'ajax/callApi/followUser';
			$('.u' + id).addClass('active');
			$('.u' + id).html('Unfollow');
		}
		$.ajax({
			url : url,
			type : 'POST',
			data : {'id' : id},
			complete : function(response){
			}
		});		
	});
});
<?php echo $this->Html->scriptEnd() ?>
