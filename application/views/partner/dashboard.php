<?php
/* @var $user Dealscount\Models\Entities\User */ $user
?>

<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="dashboard_page">
            <h1>Informatii cont</h1>

            <div  class="info">
                <?php if ($user->getCompanyDetails()->getAvailable_to() && $user->getCompanyDetails()->getAvailable_to()->format("Y-m-d") >= date("Y-m-d")) { ?>
                    <span>Cont valabil pana la:</span>
                    <span style="font-weight: bold; margin-left: 4px;">
                        <?php echo $user->getCompanyDetails()->getAvailable_to()->format("d-m-Y") ?>
                    </span>
                    <?php
                    if (!$active_options)
                        echo "<div>Nu aveti nicio optiune activa.</div>";
                    else {
                        ?>
                        <table width="500">
                            <tr>
                                <td width="140" style="vertical-align: top; padding-top: 10px;">
                                    Extraoptiuni active:
                                </td>
                                <td style="padding-top: 10px;">
                                    <?php foreach ($active_options as $option) { ?>
                                        <div style="padding-bottom: 5px;">
                                            <b><?php echo $option[0]->getName() ?></b> <span>(Credite <?php echo $option['active_options']?>)</span>
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                        <?php
                    }
                } else {
                    if (!$user->getCompanyDetails()->getAvailable_to()) {
                        ?>
                        Pentru a posta oferte este necesar sa <a href="<?php echo base_url('partener/abonamente') ?>">alegeti</a> un tip de abonament, anual sau lunar.
                    <?php } else {
                        ?>
                        Valabilitatea contului dumneavoastra a expirat in data de <b><?php echo $user->getCompanyDetails()->getAvailable_to()->format("d-m-Y"); ?></b>
                        <?php
                    }
                }
                ?>
            </div>

            <h1>
                Statistici
            </h1>
            <div class="filter_table">
                <form id="searchStats" method="GET" action="">
                    <table>
                        <tr>
                            <td >
                                <label>Afiseaza</label>
                            </td>
                            <td>
                                <div class="programeaza">
                                    <div class="de_la">De la</div>
                                    <input class="datepickersimple" value="<?php echo $this->input->get("from") ?>" name="from"/>
                                </div>
                            </td>
                            <td style="padding-left: 30px;">
                                <div class="programeaza">
                                    <div class="pana_la">Pana la la</div>
                                    <input class="datepickersimple" value="<?php echo $this->input->get("to") ?>" name="to"/>
                                </div>
                            </td>
                            <td>
                                <img style="cursor: pointer;" onclick="$('#searchStats').submit()" src="<?php echo base_url('assets/images_fdd/lupa.png') ?>"/>
                            </td>
                            <td style="padding-left: 20px;">
                                <a href="<?php echo base_url('partener?from=' . date("Y-m-d", strtotime(date("Y-m-d") . ' -1 month')) . '&to=' . date("Y-m-d")) ?>">Ultimele 30 zile</a>
                            </td>
                            <td style="padding-left: 20px;">
                                <a href="<?php echo base_url('partener?from=' . date("Y-m-d", strtotime(date("Y-m-d") . ' -2 month')) . '&to=' . date("Y-m-d")) ?>">Ultimele 60 zile</a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

            <div class="stats">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            Total Vizualizari:
                        </td>
                        <td>
                            <b> <?php echo $stats['total_views'] ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Descarcate:
                        </td>
                        <td>
                            <b> <?php echo $stats['total_sales'] ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Utilizate:
                        </td>
                        <td>
                            <b> <?php echo $stats['confirmed'] ?></b>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
    <div id="clear"></div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".datepickersimple").datepicker({dateFormat: "yy-mm-dd"});
    })
</script>
