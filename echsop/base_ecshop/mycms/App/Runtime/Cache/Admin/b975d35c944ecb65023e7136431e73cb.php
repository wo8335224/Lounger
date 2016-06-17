<?php if (!defined('THINK_PATH')) exit();?><?php 
	$subdirs = getSubDirs(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/Public/images/");
	
	if(empty($_GET['imgPath'])){
		$lastPath = "/Public/images/".$subdirs[0]."/";
		
	}else{
		$lastPath = "/Public/images/".$_GET['imgPath']."/";
	}
	$dir=  dirname(dirname(dirname(dirname(dirname(__FILE__))))).$lastPath;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理图片</title>
<style type="text/css">
<!--
body,td,th {
font-family: Arial, Helvetica, sans-serif;
font-size: 12px;
color: #6D7070;
font-weight: bold;
}
body {
margin-left: 5px;
margin-top: 10px;
margin-right: 0px;
margin-bottom: 0px;
}
.inner{
border:1px solid #fff;
float:left;
margin:5px;
text-align:center;
position: relative;
}
.moveDiv .delectImg{
	display:block;
	width:16px;
	height:16px;
	background: url(__ADMIN__/Public/imgs/49828.jpg) no-repeat left;
	position: absolute;
	left: 157px;
	top:0px;
}
.moveDiv{
border:1px solid #FF0000;
float:left;
margin:5px;
/*
cursor:pointer;*/
text-align:center;
position: relative;
}
.selectImg{
	cursor:pointer;
}
-->
</style>
<script language="javascript" src="__PUBLIC__/js/jquery-1.7.1.min.js"></script>
<script language="javascript">
function update_page(json){
	if(json != 1){
		alert('删除失败，请刷新重试');
	}
	//alert('sss');
}
$(document).ready(function(){
	$(".inner").hover(function(){
			$(this).removeClass('inner').addClass('moveDiv');
		},function(){
			$(this).removeClass('moveDiv').addClass('inner');
	})
	$(".delectImg").click(function(){
		if(confirm('确认删除图片吗？删除后无法恢复！')) {
				var img = $(this).attr('imgs');
				var path = $(this).attr('path');
				 $.ajax({  
		                url:'__APP__/Admin/Index/delectImgs', //后台处理程序  
		                type:'post',       //数据传送方式  
		                dataType:'json',   //接受数据格式  
		                data:{
		                		'imgs':img,
		                		'path':path
		                	 },       //要传送的数据  
		                success:update_page//回传函数(这里是函数名字)  
		         });
		         $(this).parent('.inner,.moveDiv').hide(500);
			//	window.location.href="__APP__/Admin/Index/delectImgs?imgs="+ img +"&path="+path;
			} else {
				return false;
			}
	})
	$("#selectPath").change(function(){
		var now = $(this).val();
		window.location.href="__APP__/Admin/System/index/cid/img/imgPath/"+now+"";
	})
	$(".selectImg").click(function(){
		var img = $(this).attr('imgs');
		var imgP = $(this).find('img').attr('src');
		//alert(imgP);
		//return false;
		//self.opener.document.getElementById('ren').src='".__ROOT__.'/'.$uploaddir.$_POST['file']."';
		self.opener.document.getElementById('<?php echo $_GET['save']; ?>').value= img;
		self.opener.document.getElementById('<?php echo $_GET['save'].'1'; ?>').src= '__ROOT__<?php echo $lastPath; ?>'+img;
		window.close();
	})
})

</script>
</head>
<?php if(($_GET['is_only'])  !=  "1"): ?><div style="width:100%;">
<strong>请选择文件夹</strong>
<select id="selectPath">
<?php if(is_array($subdirs)): $i = 0; $__LIST__ = $subdirs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value ="<?php echo ($vo); ?>" <?php if(($_GET['imgPath'])  ==  $vo): ?>selected="true"<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>

</div><?php endif; ?>
<?php
$dir_res=opendir($dir);
$fileFormat=array(0=>".jpg",1=>".gif",2=>".png",3=>".bmp");
while($filen=readdir($dir_res))
{
for($i=0;$i<count($fileFormat);$i++)
{
   if(substr($filen,strpos($filen,"."))==$fileFormat[$i])
   {
		if(empty($_GET['is_only'])){
    		echo '<div class="inner"><img src="'.__ROOT__.$lastPath.$filen.'" width=140" height="120" border="0" align="absmiddle" style="margin:15px;" />
			<br/>
			<a href="javascript:void(0);" class="delectImg" imgs="'.$filen.'" path="'.$dir.'"></a></div>';   
    		break ;
  		 }else{
			echo '<div class="inner selectImg" imgs="'.$filen.'"><img src="'.__ROOT__.$lastPath.$filen.'" width=140" height="120" border="0" align="absmiddle" style="margin:15px;" />
			<br/>
			<a href="javascript:void(0);" class="selectImg" imgs="'.$filen.'" path="'.$dir.'"></a></div>';   
    		break ;
		}
	}
}
}
closedir($dir_res);
?>