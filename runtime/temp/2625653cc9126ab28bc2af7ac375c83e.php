<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:50:"E:\git\TpStage/apps/backend\view\widget\image.html";i:1531466503;}*/ ?>
<?php 
	$u_index = mt_rand(0,99).mt_rand(0,99).mt_rand(0,99).mt_rand(0,99);
?>
<div class='select-image-<?=$u_index?>'><?php echo $title; ?></div>


<?php if($one){ ?>
<script type="text/javascript" src="/static/hui/lib/webuploader/0.1.5/webuploader.min.js"></script> 
<?php } ?>

<script type="text/javascript">
$(function(){
	
	<?php echo 'var uploader_'.$u_index.' = WebUploader.create({'; ?>
	
		auto: true,
		swf: 'lib/webuploader/0.1.5/Uploader.swf',
	
		// 文件接收服务端。
		server: '<?=url("Upload/webUpload")?>',
	
		// 选择文件的按钮。可选。
		// 内部根据当前运行是创建，可能是input元素，也可能是flash.
		pick: '.select-image-<?=$u_index?>',
	
		// 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
		resize: false,
		// 只允许选择图片文件。
		accept: {
			title: 'Images',
			extensions: 'gif,jpg,jpeg,bmp,png',
			mimeTypes: 'image/*'
		}
	});
	<?php echo "uploader_".$u_index.".on( 'fileQueued', function( file ) {" ?>
	
		var $li = $(
			'<div id="' + file.id + '" class="item" style="margin-top:8px;margin-bottom:8px;">' +
				'<div class="pic-box"><img style="width:50%;height:50%"></div>'+
				'<div class="info">' + file.name + '</div>' +
				'<p><font class="state">等待上传...</font>&nbsp; <a onClick="$(this).parent().parent().remove()">删除</a></p>'+
			'</div>'
		);

		var uploaderId = '#rt_'+file.source.ruid;

		$(uploaderId).parent().parent().append( $li );

	
	});
	// 文件上传过程中创建进度条实时显示。
	<?php echo "uploader_".$u_index.".on( 'uploadProgress', function( file, percentage ) {" ?>
		var $li = $( '#'+file.id ),
			$percent = $li.find('.progress-box .sr-only');
	
		// 避免重复创建
		if ( !$percent.length ) {
			$percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo( $li ).find('.sr-only');
		}
		$li.find(".state").text("上传中");
		$percent.css( 'width', percentage * 100 + '%' );
	});
	
	// 文件上传成功，给item添加成功class, 用样式标记上传成功。
	<?php echo "uploader_".$u_index.".on( 'uploadSuccess', function( file ,data) {" ?>
		$( '#'+file.id ).addClass('upload-state-success').find(".state").text("已上传");
		$( '#'+file.id ).find("img").attr('src',data.path);
		$( '#'+file.id ).find(".info").html(data.path);
		var ss = $( "input[name='<?=$name?>']" ).val();
		if(ss==''){
			$( "input[name='<?=$name?>']" ).val(data.path);
		}else{
			$( "input[name='<?=$name?>']" ).val(ss+','+data.path);
		}
	});
	
	// 文件上传失败，显示上传出错。
	<?php echo "uploader_".$u_index.".on( 'uploadError', function( file ) {" ?>
		$( '#'+file.id ).addClass('upload-state-error').find(".state").text("上传出错");
	});
	
	// 完成上传完了，成功或者失败，先删除进度条。
	<?php echo "uploader_".$u_index.".on( 'uploadComplete', function( file ) {" ?>
		$( '#'+file.id ).find('.progress-box').fadeOut();
	});
});
</script>
