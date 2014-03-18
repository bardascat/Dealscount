<?php
/* @var $user Dealscount\Models\Entities\User */ $user
?>

<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="invoices_page">
            <h1>Facturi</h1>


            <?php
            $invoices = $user->getCompanyDetails()->getInvoices();
            if ($invoices) {
                ?>
                <div class="invoice_list">

                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <th style="text-align: left;" width="150">
                                Ati cumparat
                            </th>
                            <th width="150">
                                Factura
                            </th>
                            <th width="200">
                                Data
                            </th>
                            <th width="200">
                                Total de plata
                            </th>
                            <th width="200">
                               
                            </th>
                        </tr>
                        <?php
                        foreach ($invoices as $invoice) {
                            $product=json_decode($invoice->getProducts());
                            ?>
                            <tr>
                                <td style="text-align: left">
                                    <?php echo $product->nume ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $invoice->getSeries().''.$invoice->getNumber()?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $invoice->getGenerate_date()->format("d-m-Y"); ?>
                                </td>
                                <td style="text-align: center;">
                                     <?php echo $invoice->getTotal(); ?> lei
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?php echo base_url('partener/descarca_factura/'.$invoice->getId_invoice())?>">Descarca</a>
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
