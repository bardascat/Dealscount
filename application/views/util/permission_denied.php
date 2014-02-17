<?php /* @var  $offers \Dealscount\Models\Entities\Item */ $offers; 

?>
<div class="content" style="margin-left: 194px; min-height: 900px;">
    <!-- infobar -->
    <div class="info_bar">
        <div class="breadcrumbs">
            <b>Nu aveti permisiune pentru resursa ceruta.</b>
        </div>

    </div>
    
</div>

<script type="text/javascript">
                                        function optBox(id) {
                                            var html = $('#offer_' + id).html();

                                            $.fancybox.open({
                                                content: html,
                                                width: 580,
                                                autoSize: true,
                                                closeClick: false,
                                                openEffect: 'none',
                                                closeEffect: 'none'
                                            });
                                        }

                                        $(document).ready(function() {
                                            
                                            //$('<a title="" href="template/templates/show_popup.php?iframe=true&width=620&height=356"></a>').prettyPhoto().click()
                                        });
                                        function closeBox() {

                                            jQuery.prettyPhoto.close();

                                        }



</script>


