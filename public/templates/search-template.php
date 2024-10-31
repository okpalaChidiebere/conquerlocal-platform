<?php
/**
 * the template file to display content search result page
 * instead create a folder 'buddyboss-global-search' inside your theme, copy this file over there, and make changes there
 */


Help_Center_Search::instance()->prepare_search_page(); //first prepare the page :)

?>
<div style=" display: flex; flex-direction: row">
        <!-- Start CL filter-->
    <div style="flex: 0 0 260px; margin-right: 20px">
        <h3 class="results-group-title"><span>Filter your results</span></h3>
        <h4 style="font-size: 14px; font-weight: 600; letter-spacing: 0; line-height: 19px;text-transform: uppercase;">Resources</h4>
        <?php if(Help_Center_Search::instance()->has_search_results()) cl_search_filters(); ?>
    </div>
    <!-- End CL filter-->
        
    <div style="flex: 1;">
       <?php cl_search_results(); ?>
    </div>
</div>