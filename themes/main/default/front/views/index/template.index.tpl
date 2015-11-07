{if !$request_async}{include file="includes/template.head.tpl"}{/if}
<div class="posts">
	{foreach from=$content.posts item="posts" key="day"}
		<div class="day">
			<h2>{$day}</h2>
			{foreach from=$posts item="post"}
				<div class="post">
					<div class="vote">
						<a href="" title="Kudo to that" class="up"><span></span></a>
						<a href="" title="Oh my god no!" class="down"><span></span></a>
					</div>
					<div class="thumbnail">
						<a href="post/{$post.permalink_post}"><img src="{$post.url_image_post}" alt="default image"></a>
					</div>
					<div class="details">
						<h3><a href="{$post.url_post}" target="_blank">{$post.title_post}</a></h3>
						<ul class="categories">
							{foreach from=$post.categories item="cat"}
							<li><a href="?cat={$cat.permalink_category}">{$cat.name_category}</a></li>
							{/foreach}
						</ul>
					</div>
				</div>
			{foreachelse}
				<div class="empty">
					Sorry, we couldn't find any posts.
				</div>
			{/foreach}
		</div>
	{/foreach}
</div>
{if !$request_async}{include file="includes/template.footer.tpl"}{/if}