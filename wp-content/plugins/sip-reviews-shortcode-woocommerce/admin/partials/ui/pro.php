<?php

	$src_image = SIP_RSWC_URL . 'admin/assets/images/';
?>
<div class="sip-tab-content">
<style>
    .section{
        margin: -20px;
        padding-bottom: 70px;
        padding-top: 70px;
        font-family: "OpenSansRegular";
    }
    .section h1{
        text-align: center;
        color: #ed1c24;
        font-size: 70px;
        font-weight: 700;
        line-height: normal;
        display: inline-block;
        width: 100%;
        margin: 50px 0;
				text-transform: uppercase;
    }
    .section:nth-child(even){
        background-color: #fff;
    }
    .section:nth-child(odd){
        background-color: #ededed;
    }
    .section .section-title{
        display: table;
    }
    .section .section-title img{
        display: table-cell;
        float: left;
        vertical-align: middle;
        width: auto;
        margin-right: 15px;
    }
    .section .section-title h2{
        text-align: center;
        display: table-cell;
        vertical-align: middle;
        padding: 0;
        font-size: 25px;
        font-weight: 700;
        color: #ed1c24;
    }
    .section p{
        color: #888;
        font-size: 16px;
        margin: 25px 0;
    }
    .section ul li{
        margin-bottom: 4px;
    }
    .pro-wrap{
        max-width: 750px;
        margin-left: auto;
        margin-right: auto;
        padding: 50px 0 30px;
    }
    .pro-wrap:after{
        display: block;
        clear: both;
        content: '';
    }
    .pro-wrap .col-1,
    .pro-wrap .col-2{
        float: left;
        box-sizing: border-box;
        padding: 0 15px;
    }
    .pro-wrap .col-1 img{
        width: 100%;
    }
    .pro-wrap .col-1{
        width: 55%;
    }
    .pro-wrap .col-2{
        width: 45%;
    }
    .sip-reviews-call{
        background-color: #444;
        color: #fff;
        padding: 30px 30px;
    }
    .sip-reviews-call p{
        color:#fff;
        font-size: 14px;
        font-weight: 500;
        display: inline-block;
    }
    .sip-reviews-call a.button{
			    font-size: 20px;
			    margin-bottom: 30px;
			    background-color: #ed1c24;
			    border-color: #ad1c24;
			    border-radius: 0px;
			    color: #fff;
			    float: right;
			    border: none;
			    margin: 12px 16px;
			    padding: 12px 29px;
			    text-shadow: none;
			    font-weight: bold;
			    text-decoration: none;
			    height: 50px;
			    text-align: center;
			    box-shadow: none;    }
    .sip-reviews-call a.button:hover,
    .sip-reviews-call a.button:active,
    .sip-reviews-call a.button:focus{
			    background-color: #ad1c24;
			    border-color: #ad1c24;
			    color: #fff;    }
    .sip-reviews-call .hl{
        text-transform: uppercase;
        background: none;
        font-weight: 800;
        color: #fff;
    }

</style>
<div class="landing">
    <div class="section section-call section-odd">
        <div class="pro-wrap">
            <div class="sip-reviews-call">
                <p>
                    Upgrade to <span class="hl">PRO version</span> to benefit from all these awesome features!
                </p>
                <a href="<?php echo SIP_RSWC_PLUGIN_URL . '?utm_source=wordpress.org&utm_medium=SIP-panel&utm_content=v'. SIP_RSWC_VERSION .'&utm_campaign=' .SIP_RSWC_UTM_CAMPAIGN; ?>" target="_blank" class="sip-reviews-call-button button btn">UPGRADE</a>
            </div>
        </div>
    </div>
    <div class="section section-even clear">
        <h1>Pro Features</h1>
        <div class="pro-wrap">
            <div class="col-1">
                <img src=<?php echo $src_image . 'styles.png';?> alt="Multiple styles" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <h2>2 more awesome styles</h2>
                </div>
                <p>With these two beautifully crafted designs you have more options to display your product reviews in an engaging way.</p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear">
        <div class="pro-wrap">
            <div class="col-2">
                <div class="section-title">
                    <h2>Submit form shortcode</h2>
                </div>
                <p>If you display WooCommerce reviews in a normal post or page, perhaps you want to let customers submit their own reviews as well. With the pro version we have developed a new shortcode that will let you display the submit reviews form anywhere.</p>
            </div>
            <div class="col-1">
                <img src=<?php echo $src_image . 'review-form.png';?> alt="Submit a review shortcode" />
            </div>
        </div>
    </div>
    <div class="section section-even clear">
        <div class="pro-wrap">
            <div class="col-1">
                <img src=<?php echo $src_image . 'aggregated.png';?> alt="Aggregated reviews" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <h2>Aggregated reviews</h2>
                </div>
                <p>Do you use several SKUs for the same product? Do you want to display reviews of a whole category or categories instead of a single product? With the pro version you can do all this easily.</p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear">
        <div class="pro-wrap">
            <div class="col-2">
                <div class="section-title">
                    <h2>Multi language support</h2>
                </div>
                <p>Now you can translate the plugin to any language you want using language files, easy and fast!</p>
            </div>
            <div class="col-1">
                <img src=<?php echo $src_image . 'languages.png';?> alt="Multi-language" />
            </div>
        </div>
    </div>
    <div class="section section-call section-even">
			<div class="pro-wrap">
				<div class="sip-reviews-call">
						<p>
								Upgrade to <span class="hl">PRO version</span> to benefit from all these awesome features!
						</p>
						<a href="<?php echo SIP_RSWC_PLUGIN_URL . '?utm_source=wordpress.org&utm_medium=SIP-panel&utm_content=v'. SIP_RSWC_VERSION .'&utm_campaign=' .SIP_RSWC_UTM_CAMPAIGN; ?>" target="_blank" class="sip-reviews-call-button button btn">UPGRADE</a>
				</div>
			</div>
    </div>
</div>
</div>


<!-- affiliate/credit link -->
<?php include( SIP_RSWC_DIR . 'admin/partials/ui/affiliate.php'); ?>
