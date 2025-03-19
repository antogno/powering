<nav class="navbar navbar-expand-sm bg-light p-2">
	<a class="navbar-brand text-primary" href="/">
		<img src="../../assets/images/logo.png" alt="{$app_name}" height="30px">
	</a>

	{if !empty($links)}
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				{foreach $links as $link}
					<li class="nav-item">
						<a class="nav-link {if $link.is_current}active{/if}" {if $link.is_current}aria-current="page"{/if} href="{$link.url}">
							{if $link.icon_class}
								<i class="{$link.icon_class}"></i>
							{/if}
							{$link.label}
						</a>
					</li>
				{/foreach}
			</ul>
		</div>
	{/if}
</nav>
