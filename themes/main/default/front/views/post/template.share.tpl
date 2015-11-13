{if !$request_async}{include file="includes/template.head.tpl"}{/if}
<h1>Share a link</h1>
<div class="form">
	{form_share->display url="share"}
</div>
{if !$request_async}{include file="includes/template.footer.tpl"}{/if}