{extends file='frontend/index/index.tpl'}

{block name="frontend_index_content"}
    <div class="content apc--private-seminar">
        <div class="listing--container">
            <div class="listing">
                {* Actual listing *}
                {foreach $articles as $sArticle}
                    {include file="frontend/listing/box_article.tpl"}
                {/foreach}
            </div>
        </div>

        <div class='webinar--request-form'>
            {action controller=forms action=index id=$formId isCustom=true}
        </div>
    </div>
{/block}
