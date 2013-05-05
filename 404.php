<?php get_header(); ?>
<div class="page">
<h2 class="page_title">页面未能找到</h2>
<h3>抱歉，您打开的页面未能找到。<br />您可以使用本站的搜索框搜索您想要的内容，如有不便深感抱歉！</h3>
<h3>系统将在 <span id="secondsDisplay">5</span> 秒钟之后带你返回首页。<h3>
</div>
<script type="text/javascript">  
  var i = 5;  
  var intervalid;  
    intervalid = setInterval("fun()", 1000);  
    function fun() {  
          if (i == 0) {  
                  window.location.href = "<?php bloginfo('url'); ?>";  
                        clearInterval(intervalid);  
                      }  
  document.getElementById("secondsDisplay").innerHTML = i;  
  i--;   
    }  
</script>
<?php get_sidebar(); ?>
<?php get_footer(); ?>