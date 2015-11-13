{if !$request_async}{include file="includes/template.head.tpl"}{/if}
<div id="view_post">
	<div class="intro">
		<div class="image"><img src="{$content.post.url_image_post}" alt="{$content.post.title_post}"></div>
		<div class="details">
			<h1>{$content.post.title_post}</h1>
			<div class="resume">
				{$content.post.text_post}
				<div class="by">
					Shared by <a href="profil/{$content.post.pseudo_user}">{$content.post.pseudo_user}</a> on {$content.post.added_date_post}
				</div>
			</div>
		</div>
	</div>
</div>
<div class="comments">

</div>
{if !$request_async}{include file="includes/template.footer.tpl"}{/if}