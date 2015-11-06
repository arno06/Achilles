{if !$request_async}{include file="includes/template.head.tpl"}{/if}
<h1>Submit a link</h1>
<div class="form">
	{form_submit->display url="submit"}
</div>
{if !$request_async}{include file="includes/template.footer.tpl"}{/if}