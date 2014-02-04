<script type="text/javascript">

    $(document).ready(function() {
        $('.list_buttons').buttonset();
    });
</script>
<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>

            <? require_once('views/admin/left_menu.php'); ?> 

            <td class='content index'>
                <!-- content -->

                <div class="paginator">
                    <form method="get" action="?" class="paginateForm">
                        Pagina: <input style="width: 20px; text-align: center; padding: 2px; font-size: 15px;" type="text" name="page" value="<? if (isset($_GET['page'])) echo $_GET['page'] ?>"/>
                        din  <?= $this->totalPages ?>
                    </form>

                    <div class="searchForm">
                        <form method="get" action="<?= URL ?>admin/offer/searchOffers">
                            <input type="text" value="<? if (isset($_GET['search'])) echo $_GET['search'] ?>" name="search" placeholder="Cauta dupa nume oferta"/>
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
                    <?
                    foreach ($this->offers as $offer) {
                        $offerDetails = $offer->getOffer();
                        if (!$offerDetails) {
                            exit("<b>EROARE: Item-ul " . $offer->getId_item() . ' nu are niciun produs/oferta asociata</b>');
                        }
                        ?>
                        <tr>
                            <td width="10%"><a href="<?= URL ?>admin/offer/editOffer/<?= $offer->getId_item() ?>"><?= $offer->getId_item() ?></a></td>
                            <td width="30%"><?= $offer->getName() ?></td>
                            <td width="30%"><?= $offerDetails->getSale_Price() ?> ron</td>
                            <td wdith="30%"><?= $offer->getCreatedDate() ?></td>

                            <td width="20%" class="list_buttons cell_right">
                                <a href="<?= URL ?>admin/offer/editOffer/<?= $offer->getId_item() ?>">Editeaza</a>
                                <a  href="javascript:triggerDeleteConfirm('.delete_<?= $offer->getId_item() ?>',1)">Sterge</a>
                                <a style='display: none;' class="delete_<?= $offer->getId_item() ?>" href="<?= URL ?>admin/offer/delete_offer/<?= $offer->getId_item() ?>">Sterge</a>
                            </td>
                        </tr>
                    <? } ?>
                </table

                <!-- end content -->
            </td>
        </tr>
    </table>

</div>