<?php defined("_SMARTMEDIA") or die(); ?>
<div>
	<table cellpadding="0" cellspacing="0" border="0" style="background-color:#F0F7FC;border:1px solid #A5CAE4;border-radius:5px;">
		<tbody>
			<tr>
				<td style="background-color:#D7EDFC;padding:5px 10px;border-bottom:1px solid #A5CAE4;border-top-left-radius:4px;border-top-right-radius:4px;font-family:Trebuchet MS,Helvetica,Arial,sans-serif;font-size:11px;line-height:1.231;">
					<a href="<?=$host?>" style="color:#176093;text-decoration:none;"><?=$title?></a>
				</td>
			</tr>
			<tr>
				<td style="background-color:#FCFCFF;padding:1em;color:#141414;font-family:Trebuchet MS,Helvetica,Arial,sans-serif;font-size:13px;line-height:1.231;">
					<h2 style="font-size:18pt;font-weight:normal;margin:10px 0;"><a style="color:#176093;text-decoration:none;" href="<?=!empty($link)?$link:$host?>"><?=$subject?></a></h2>
					<div style="margin-top:0;"><?=$body?></div>
					<p><a href="<?=!empty($link)?$link:$host?>" style="color:#176093;text-decoration:none">Подробнее »</a></p>
					<p style="font-size:11px;color:#969696;">Это сообщение было отправлено Вам с сайта "<a href="<?=$host?>" style="color:#969696;"><?=$title?></a>", так как Вы являетесь его владельцем или Ваша почта была указанна на получение новых уведомлений на сайте.</p>
				</td>
			</tr>
			<tr>
				<td style="background-color:#F0F7FC;padding:5px 10px;border-top:1px solid #D7EDFC;border-bottom-left-radius:4px;border-bottom-right-radius:4px;text-align:right;font-family:Trebuchet MS,Helvetica,Arial,sans-serif;font-size:11px;line-height:1.231;">
					<a href="<?=$host?>" style="color:#176093;text-decoration:none;"><?=$host?></a>
				</td>
			</tr>
		</tbody>
	</table>
</div>