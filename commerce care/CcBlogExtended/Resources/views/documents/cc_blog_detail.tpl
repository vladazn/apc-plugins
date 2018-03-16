<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; utf-8">
<meta name="author" content=""/>
<meta name="copyright" content="" />

<title></title>
<style type="text/css">
body {
    {$Containers.Body.style}
}

.blog--image {
    width: 100%;
    height: 445px;
}    
    
div#head_logo {
    {$Containers.Logo.style}
}

div#head_sender {
    {$Containers.Header_Recipient.style}
}

div#header {
    {$Containers.Header.style}
}

div#head_left {
    {$Containers.Header_Box_Left.style}
}

div#head_right {
    {$Containers.Header_Box_Right.style}
}

div#head_bottom {
    {$Containers.Header_Box_Bottom.style}
}

div#content {
    {$Containers.Content.style}
}

td {
    {$Containers.Td.style}
}

td.name {
    {$Containers.Td_Name.style}
}

td.line {
    {$Containers.Td_Line.style}
}

td.head  {
    {$Containers.Td_Head.style}
}

#footer {
    {$Containers.Footer.style}
}

#amount {
    {$Containers.Content_Amount.style}
}

#sender {
    {$Containers.Header_Sender.style}
}

#info {
    {$Containers.Content_Info.style}
}
</style>
</head>

<body>
    <div id="head_logo">
        {$Containers.Logo.value}
    </div>
    <div id="content">
        <div class="blog--detail panel block-group">
            <div class="blog--detail-content blog--box block" itemscope itemtype="https://schema.org/BlogPosting">
               {* Image + Thumbnails *}
                <div class="blog--detail-images block">
                    <span 
                       title="{$alt}"
                       class="link--blog-image">
                        <img srcset="{$sArticle.preview.thumbnails[2].sourceSet}"
                              src="{$sArticle.preview.thumbnails[2].source}"
                              class="blog--image"
                              alt="{$alt}"
                              title="{$alt|truncate:160}"
                              itemprop="image" />
                    </span>
                </div>
                {* Detail Box Header *}
                <div class="blog--detail-header">
                    {* Article name *}
                    <h1 class="blog--detail-headline" itemprop="name">{$sArticle.title}</h1>
                    {* Metadata *}
                    <div class="blog--box-metadata">
                        {* Date *}
                        <span class="blog--metadata-date blog--metadata{if !$sArticle.author.name} is--first{/if}" itemprop="dateCreated">{$sArticle.displayDate|date_format:" %B %Y"}</span>
                    </div>
                </div>
                {* Detail Box Content *}
                <div class="blog--detail-box-content block">
                    {* Description *}
                    <div class="blog--detail-description block" itemprop="articleBody">    
                        {$sArticle.description}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        {$Containers.Footer.value}
    </div>
</body>
</html>
