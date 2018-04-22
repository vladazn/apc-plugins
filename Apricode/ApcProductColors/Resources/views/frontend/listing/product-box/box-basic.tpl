{extends file="parent:frontend/listing/product-box/box-basic.tpl"}

{block name='frontend_listing_box_article_name' append}
	<div class="apc_colors">
		{if $sArticle.add_colors}
				{foreach $sArticle.add_colors as $color}
					<i class='icon--danielbruce2' style='color:{$color}'></i>
				{/foreach}
		{/if}
	</div>
{/block}
