<?php
if(!get_option("nt_siteclose") || is_user_logged_in() && current_user_can('administrator')){
    get_header();
?>
<div id="content">
    <div class="container">
        <?php if(is_home() || is_front_page()){ ?>
        <div class="col-lg-3 sidebar">
            <?php
            include("sidebar1.php");
            ?>
        </div>
        <div class="col-lg-6">
            <?php
                include("loop.php");
            ?>
        </div>
        <div class="col-lg-3 sidebar">
            <?php
                include("sidebar2.php");
            ?>
        </div>
        <?php }else{ ?>
            <div class="col-lg-11">
                <?php
                include("loop.php");
                ?>
            </div>
        <?php } ?>
    </div>
</div>
<?php
    get_footer();

}else{
    print get_option("nt_siteclosetext");
}
?>