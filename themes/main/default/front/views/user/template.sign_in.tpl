{if !$request_async}{include file="includes/template.head.tpl"}{/if}
<h1>Sign In</h1>
<div class="form">
	{if isset($content.error) && !empty($content.error)}
		<div class="error">{$content.error}</div>
	{/if}
	{form_sign_in->display url="sign-in"}
	<div class="reminder">
		<a href="recover-password">Forgot your password?</a> or you don't have an account yet? <a href="register">register</a>
	</div>
</div>
{if !$request_async}{include file="includes/template.footer.tpl"}{/if}