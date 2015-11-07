{if !$request_async}{include file="includes/template.head.tpl"}{/if}
<div id="view_post">
	<div class="intro">
		<div class="image"><img src="{$content.post.url_image_post}" alt="{$content.post.title_post}"></div>
		<h1>{$content.post.title_post}</h1>
	</div>
	<div class="resume">
		{$content.post.text_post}
	</div>
</div>
<div class="comments">

</div>
{if !$request_async}{include file="includes/template.footer.tpl"}{/if}