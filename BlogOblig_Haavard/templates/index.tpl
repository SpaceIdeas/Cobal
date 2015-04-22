{include file="header.tpl"}

{foreach from=$blogPosts item=blogPost}
<div class="row">
	<div class="col-sm-8 blog-main"> <!--blog   -->
    	<div class="blog-post">
        	<h2 class="blog-post-title">{$blogPost->getTitle()}</h2>
            <p class="blog-post-meta">{$blogPost->getDate()} by {$blogPost->getAuthorName()}</p>
            {$blogPost->getText()}
        </div>
    </div>
</div>
{/foreach}

{include file="footer.tpl"}