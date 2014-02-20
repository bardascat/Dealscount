
<div id="footer">
    <div class="inner_footer">
        <div class="nav">
            <ul>
                <li>
                    <a href="http://{$project_url}/about.php">Despre noi</a>
                </li>
                <li>
                    <a href="http://{$project_url}/terms.php">Termeni si conditii</a>
                </li>
                <li>
                    <a href="http://{$project_url}/suggest.php">Sugereaza o afacere</a>
                </li>
                <li>
                    <a href="http://{$project_url}/partner.php">Parteneri</a>
                </li>
                <li>
                    <a href="http://{$project_url}/contact.php">Contact</a>
                </li>
                <li>
                    <a target="_blank" href="http://www.anpc.gov.ro/">ANPC</a>
                </li>
            </ul>
        </div>

        <div class="newsletter">
            <div class="title">Newsletter</div>
            <form method="post" action="?">
                <input type="text" name="newsl" class="query_field" value="Adresa e-mail" 
                       onfocus="if (this.value == 'Adresa e-mail') {
                                   this.value = '';
                               }" onblur="if (this.value == '') {
                                           this.value = 'Adresa e-mail';
                                       }" />
                <input type="submit" value=""/>
            </form>

            <div class="soccial">
                <span>Urmareste-ne</span>
                <div class="imgs">
                    <img href="http://www.facebook.com/GetADeal.ro" target="_blank" src="<?php echo base_url() ?>assets/images_fdd/fb.png"/>
                    <img href="https://twitter.com/getadealro" target="_blank" src="<?php echo base_url() ?>assets/images_fdd/twiter.png"/>
                    <img href="http://feeds.seomonitor.ro/GetADeal" src="<?php echo base_url() ?>assets/images_fdd/rss.png"/>
                </div>
            </div>
        </div>

    </div>

</div>
</div><!-- end wrapper -->

</body>




<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-20288491-1']);
    _gaq.push(['_setDomainName', 'getadeal.ro']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();

</script>

</body>
</html>





