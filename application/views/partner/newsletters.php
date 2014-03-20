<?php
/* @var $user Dealscount\Models\Entities\User */ $user
?>
<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="newsletters">

            <h1>Newsletter <span style="font-size: 12px;">(<?php echo (!$active_newsletter_option ? "0" : $active_newsletter_option[0]['active_options']) ?> credit) </span></h1>

            <div  class="info">
                Programeaza trimiterea unui newsletter cu toate ofertele active pe site:
                <?php
                if (!$active_newsletter_option)
                    echo "<div style='margin-top:30px;'>Pentru a trimite un newsletter este necesar sa <a href='" . base_url('partener/abonamente') . "'>cumparati</a> optiunea <b>Newsletter personal</b></div>";
                ?>
            </div>

            <?php if ($active_newsletter_option) { ?>
                <form id="scheduleNewsletterForm" method="post" action="<?php echo base_url('partener/schedule_newsletter') ?>">
                    <div class="left_side">
                        <table cellpadding="0" width="100%"  cellspacing="0" border="0">
                            <tr>
                                <td colspan="2">
                                    <?php if (isset($notification)) echo $this->view->show_message($notification) ?>
                                </td>
                            </tr>
                            <tr>
                                <td  width="130">
                                    <label>Titlu newsletter</label>
                                </td>
                                <td>
                                    <input class="nameInput" value="<?php echo set_value('name') ?>" type="text" name="name"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Programeaza</label>
                                </td>
                                <td>
                                    <div class="programeaza">
                                        <input readonly="readonly" title="Partenerii pot trimite un singur newsletter pe zi. Verificati in calendar zilele disponibile." class="datepicker" type="text" value="<?php echo set_value('scheduled') ?>"  name="scheduled"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 25px;">
                                    <label>Filtreaza</label>
                                </td>
                                <td style="padding-top: 25px;">
                                    <table class="filtersTable" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td>
                                                <table class="genderTable" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td>
                                                            <input <?php echo (isset($_POST['sex']) && in_array('m', $_POST['sex']) ? "checked='checked'" : false) ?> id="masculin" type="checkbox" value="m" name="sex[]"/>
                                                        </td>
                                                        <td>
                                                            <label for="masculin">Masculin</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input <?php echo (isset($_POST['sex']) && in_array('f', $_POST['sex']) ? "checked='checked'" : false) ?>  id="feminin" type="checkbox" value="f" name="sex[]"/>
                                                        </td>
                                                        <td>
                                                            <label for="feminin">Feminin</label>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table class="ageTable" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td>
                                                            <input id="18_25" <?php echo (isset($_POST['age']) && in_array('18-25', $_POST['age']) ? "checked='checked'" : false) ?>  value="18-25" type="checkbox" name="age[]"/>
                                                        </td>
                                                        <td>
                                                            <label for="18_25">18-25 ani</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input <?php echo (isset($_POST['age']) && in_array('25-30', $_POST['age']) ? "checked='checked'" : false) ?> id="25_30" value="25-30" type="checkbox" name="age[]"/>
                                                        </td>
                                                        <td>
                                                            <label for="25_30">25-30 ani</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input id="30_40" value="30-40" type="checkbox" <?php echo (isset($_POST['age']) && in_array('30-40', $_POST['age']) ? "checked='checked'" : false) ?> name="age[]"/>
                                                        </td>
                                                        <td>
                                                            <label for="30_40">30-40 ani</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input id="40_ani" value=">40" <?php echo (isset($_POST['age']) && in_array('>40', $_POST['age']) ? "checked='checked'" : false) ?> type="checkbox" name="age[]"/>
                                                        </td>
                                                        <td>
                                                            <label for="40_ani">>40 ani</label>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td class="cities">
                                                <select multiple="true" name="cities[]">
                                                    <?php foreach ($cities as $city) { ?>
                                                        <option <?php echo (isset($_POST['cities']) && in_array($city['city'], $_POST['cities']) ? "selected='selected'" : false) ?>value="<?php echo $city['city']; ?>"><?php echo $city['city']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div> <!-- left side end -->
                    <div class="rightSide">
                        <input type="button" onclick="$('#scheduleNewsletterForm').submit()" class="programeaza"/>
                        <a style="display: none;" href="" class="vizualizeaza"></a>
                    </div>
                </form>
            <?php } ?>


            <div class="newsletters_list">
                <?php
                $newsletters = $user->getPartnerNewsletters();

                if (count($newsletters) < 1) {
                    // echo "Nu ati trimis niciun newsletter";
                } else {
                    ?>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <th width="300" style="text-align: left;">
                                Titlu
                            </th>
                            <th>
                                Data
                            </th>
                            <th>
                                Trimis la
                            </th>
                            <th>
                                Au deschis
                            </th>
                            <th>
                                Accesari
                            </th>
                            <th>
                                Status
                            </th>
                            <th>

                            </th>
                            <th>

                            </th>
                        </tr>
                        <?php foreach ($newsletters as $newsletter) { ?>
                            <tr>
                                <td style="text-align: left;"> 
                                    <?php echo $newsletter->getName() ?>
                                </td>
                                <td>
                                    <?php echo $newsletter->getScheduled()->format("d-m-Y H:i"); ?>
                                </td>
                                <td>
                                    <?php echo ($newsletter->getSentTo() ? $newsletter->getSentTo() . ' persoane' : ' N/A' ) ?> 
                                </td>
                                <td>
                                    <?php echo ($newsletter->getOpened() ? $newsletter->getOpened() . ' persoane' : ' N/A' ) ?> 
                                </td>
                                <td>
                                    <?php echo ($newsletter->getOpened() ? $newsletter->getClicks() . ' persoane' : ' N/A' ) ?>
                                </td>
                                <td>
                                    <?php
                                    switch ($newsletter->getStatus()) {
                                        case DLConstants::$NEWSLETTER_PENDING: echo "In asteptare";
                                            break;
                                        case DLConstants::$NEWSLETTER_SENT: echo "<span style='color:green'>Trimis</span>";
                                            break;
                                        case DLConstants::$NEWSLETTER_SUSPENDED: echo "<span style='color:red'>Anulat</span>";
                                            break;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('partener/view_newsletter/' . $newsletter->getId_newsletter()) ?>">Vezi</a>
                                </td>
                                <td>
                                    <?php if ($newsletter->getStatus() == DLConstants::$NEWSLETTER_PENDING) { ?>
                                        <a href="<?php echo base_url('partener/cancel_newsletter/' . $newsletter->getId_newsletter()) ?>" style="color: #f00">Anuleaza</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>
            </div>

        </div>


    </div>
    <div id="clear"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".datepicker").datetimepicker({beforeShowDay: unavailable, timeFormat: 'HH:mm', dateFormat: "dd-mm-yy", minDate: new Date(), maxDate: new Date(<?php echo date("Y", strtotime($user->getCompanyDetails()->getAvailable_to()->format("Y-m-d"))) ?>,<?php echo date("m", strtotime($user->getCompanyDetails()->getAvailable_to()->format("Y-m-d"))) ?>,<?php echo date("d", strtotime($user->getCompanyDetails()->getAvailable_to()->format("Y-m-d"))) ?>)});
    })

    var unavailableDates = [<?php if($restricted_days) {foreach($restricted_days as $day) echo '"'.date("d-n-Y",strtotime($day['scheduled'])).'"'.',';}?>];
    function unavailable(date) {
        dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
        if ($.inArray(dmy, unavailableDates) == -1) {
            return [true, ""];
        } else {
            return [false, "", "Unavailable"];
        }
    }
</script>