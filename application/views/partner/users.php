<?php
/* @var $user Dealscount\Models\Entities\User */ $user
?>

<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="users_page">
            <h1>Utilizatori</h1>

            <div class="offer_details_stats" style="padding-left: 0px;">
                <?php if (!$statsByCity && !$statsByAge && !$statsByGender) { ?>
                    Momentan nu sunt destule informatii pentru a genera statistici referitoare la utilizatorii dumneavoastra.
                <?php } else { ?>
                    <table>
                        <tr>
                            <?php if ($statsByCity) { ?>
                                <td style="padding-right: 60px;">
                                    <table>
                                        <?php foreach ($statsByCity as $city) { ?>
                                            <tr>
                                                <td>
                                                    <?php echo $city['city'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $city['percentage'] ?>%
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            <?php } ?>
                            <?php if ($statsByAge) { ?>
                                <td style="padding-right: 60px;">
                                    <table>
                                        <?php foreach ($statsByAge as $age) { ?>
                                            <tr>
                                                <td>
                                                    <?php echo $age['age'] ?> ani
                                                </td>
                                                <td>
                                                    <?php echo $age['percentage'] ?>%
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            <?php } ?>
                            <?php if ($statsByGender) { ?>
                                <td style="padding-right: 60px;">
                                    <table>
                                        <?php foreach ($statsByGender as $gender) { ?>
                                            <tr>
                                                <td>
                                                    <?php echo ($gender['gender'] == "f" ? "Feminin" : "Masculin"); ?>
                                                </td>
                                                <td>
                                                    <?php echo $gender['percentage'] ?>%
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            <?php } ?>
                        </tr>
                    </table>
                <?php } ?>
            </div>

            <?php if ($users_stats) { ?>
                <div class="users_list">

                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <th width="460">
                                Nume
                            </th>
                            <th width="200">
                                Vouchere descarcate
                            </th>
                            <th width="200">
                                Vouchere utilizate
                            </th>
                        </tr>
                        <?php foreach ($users_stats as $user) { ?>
                            <tr>
                                <td >
                                    <?php echo $user['lastname'] . ' ' . $user['firstname']; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $user['sales']; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $user['confirmed']; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>


        </div>

    </div>
    <div id="clear"></div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".datepickersimple").datepicker({dateFormat: "yy-mm-dd"});
    })
</script>
