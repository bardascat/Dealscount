<script type="text/javascript">

    $(document).ready(function() {
        $('.list_buttons').buttonset();
    });
</script>
<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>

            <?php $this->load->view('admin/left_menu'); ?>

            <td class='content index'>
                <!-- content -->
                <?php if (count($offers)) { ?>
                <div class="paginator">
                    <form method="get" action="?" class="paginateForm">
                        Pagina: <input style="width: 20px; text-align: center; padding: 2px; font-size: 15px;" type="text" name="page" value="<?php if (isset($_GET['page'])) echo $_GET['page'] ?>"/>
                        din  <?php echo $totalPages ?>
                    </form>

                    <div class="searchForm">
                        <form method="get" action="<?php echo base_url() ?>admin/offer/searchOffers">
                            <input type="text" value="<?php if (isset($_GET['search'])) echo $_GET['search'] ?>" name="search" placeholder="Cauta dupa nume oferta"/>
                        </form>
                    </div>

                </div>
                
                    <table width="100%" border="0" id="list_table" cellpadding="0" cellspcing="0">
                        <tr>
                            <th width="100" class="cell_left">
                                Id Oferta
                            </th>
                            <th>
                                Nume
                            </th>
                            <th>
                                Pret Redus
                            </th>
                            <th >
                                Adaugat La
                            </th>
                            <th class="cell_right">

                            </th>

                        </tr>
                        <?php
                        foreach ($offers as $offer) {
                            $offerDetails = $offer->getOffer();
                            if (!$offerDetails) {
                                exit("<b>EROARE: Item-ul " . $offer->getId_item() . ' nu are niciun produs/oferta asociata</b>');
                            }
                            ?>
                            <tr>
                                <td width="10%"><a href="<?= base_url() ?>admin/offer/editOffer/<?= $offer->getId_item() ?>"><?= $offer->getId_item() ?></a></td>
                                <td width="30%"></td>
                                <td width="30%"> ron</td>
                                <td wdith="30%"></td>

                                <td width="20%" class="list_buttons cell_right">
                                    <a href="<?= base_url() ?>admin/offer/editOffer/<?= $offer->getId_item() ?>">Editeaza</a>
                                    <a  href="javascript:triggerDeleteConfirm('.delete_<?= $offer->getId_item() ?>',1)">Sterge</a>
                                    <a style='display: none;' class="delete_<?= $offer->getId_item() ?>" href="<?= base_url() ?>admin/offer/delete_offer/<?= $offer->getId_item() ?>">Sterge</a>
                                </td>
                            </tr>
                        <?php } ?>

                        ?>
                    </table
                <?php } else { ?>
                    <h2>Momentan nu exista nicio oferta.</h2>  
                <?php } ?>

            </td>
        </tr>
    </table>

</div>