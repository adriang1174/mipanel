<!--{if $owner}-->
    <!--{if $print_switch}-->
		<link rel="stylesheet" type="text/css" href="<!--{if $print || $printall}--><!--{ownerurl}--><!--{else}-->owner/<!--{/if}--><!--{$owner}-->/stylesheet.v2.css" />
    <!--{else}-->
        <link rel="stylesheet" type="text/css" href="owner/<!--{$owner}-->/stylesheet.v2.css" />
    <!--{/if}-->
<!--{/if}-->
