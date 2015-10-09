{if !$request_async}{include file="includes/template.head.tpl"}{/if}
<h1>Register</h1>
<div class="form">
	{if isset($content.error) && !empty($content.error)}
		<div class="error">{$content.error}</div>
	{/if}
	{form_register->display url="register"}
	<div class="reminder">
		All ready have an account? <a href="sign-in">Sign in</a>.
	</div>
</div>
{if !$request_async}{include file="includes/template.footer.tpl"}{/if}