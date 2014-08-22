<?php
include "phpqrcode.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
							
	<form id="iform" name="iform" method="post" action="">
	<h5>存储的信息<font color="#FF0000">可输入任意信息</font></h5>
	<textarea name="content" id="content">
	<?php echo $_POST['content']; ?>
	</textarea>
	<h5>图片文件名<font color="#FF0000">暂时只支持数据和大小写字母</font></h5>
	<textarea name="content1" id="content1">
	<?php echo $_POST['content1']; ?>
	</textarea>
	<h5>输入存储的信息和图片文件名后，点击这里就可以生成二维码图片</h5>
	<input name="go" type="submit" id="go" onclick="" value="点击确认生成" />
	<input name="done" type="hidden" value="done" />
	</form>

<?php 
if ($_POST['done']){
if ($_POST['content']){//判断是否输入二维码内容
   if($_POST['content1']){//判断是否输入二维码文件名
	$c = $_POST['content'];/*用户输入*/
	$len = strlen($c);//用户输入字符长度
	   if ($len <= 360){
	    $file = fopen("t.txt","r+");//读写方式打开t.txt，将文件指针指向文件头
	    flock($file,LOCK_EX);//锁定或释放文件
/*
file 必须是一个已经打开的文件指针。
lock 参数可以是以下值之一：
要取得共享锁定（读取的程序），将 lock 设为 LOCK_SH（PHP 4.0.1 以前的版本设置为 1）。
要取得独占锁定（写入的程序），将 lock 设为 LOCK_EX（PHP 4.0.1 以前的版本中设置为 2）。
要释放锁定（无论共享或独占），将 lock 设为 LOCK_UN（PHP 4.0.1 以前的版本中设置为 3）。
如果不希望 flock() 在锁定时堵塞，则给 lock 加上 LOCK_NB（PHP 4.0.1 以前的版本中设置为 4）。
*/
	      if($file) {
	       $get_file = fgetss($file);//从打开的文件中读取一行并过滤掉 HTML 和 PHP 标记
	       $t = $get_file+1;
	       $file2 = fopen("t.txt","w+");
	       fwrite($file2,$t);	
	       }
	    flock($file,LOCK_UN);
	    fclose($file);
	    fclose($file2);
		$sc = md5($_POST['content1']);
		//$sc = urlencode($_POST['content1']);
	   QRcode::png($c, 'png/'.$sc.'.png');	
	   echo '<img src="http://imobile/php2qr/png/'.$sc.'.png" /><br />存储的信息：<font color="#FF0000">'.$c.'</font><br /><br />图片文件原始名：<font color="#FF0000">'.$_POST['content1'].'</font><br /><br />图片文件名加密：<font color="#FF0000">'.$sc.'</font>'; 
	   }
	   else {
	     echo '亲！信息量过大。';
	   }	
    }
    else {
     echo '亲！你没有输入图片文件名。';
    }
}	
    else {
     echo '亲！你没有输入存储的信息。';
    }
}
else {
  echo '二维码将会出现在这里。';
}
	?>