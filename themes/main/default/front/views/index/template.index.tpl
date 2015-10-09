{if !$request_async}{include file="includes/template.head.tpl"}{/if}
<h1>Hello world</h1>
<div class="posts">
	<div class="day">
		<h2>Friday, October 9th 2015</h2>
		<div class="post">
			<div class="vote">
				<a href="">up</a>
				<a href="">down</a>
			</div>
			<div class="thumbnail">
				<a href=""><img src="{$path_to_theme}/imgs/default_image.png" alt="default image"></a>
			</div>
			<div class="details">
				<h3><a href="">BAIT x G.I. JOE x New Balance MT 580</a></h3>
				<ul class="categories">
					<li><a href="?cat=foo">Foo</a></li>
					<li><a href="?cat=bar">Bar</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="day">
		<h2>Thursday, October 8th 2015</h2>
		<div class="empty">
			Sorry, we couldn't find any posts.
		</div>
	</div>
</div>
{if !$request_async}{include file="includes/template.footer.tpl"}{/if}