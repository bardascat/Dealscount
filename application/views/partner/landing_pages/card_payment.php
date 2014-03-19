<?php
/* @var $user Dealscount\Models\Entities\User */
/* @var $order Dealscount\Models\Entities\SubscriptionOptionOrder */
?>
<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="pagina_abonamente">

            <h1>Abonamente</h1>

            <div  class="info">
                <?php
                switch ($order->getPayment_status()) {
                    case DLConstants::$PAYMENT_STATUS_CONFIRMED: {
                            //daca este optiune simpla afisam un mesaj, daca este valabilitate afisam alt mesaj
                            ?>
                            Felicitari, ati cumparat cu succes <b><?php echo $order->getOption()->getName(); ?></b>
                            <?php if ($order->getOption()->getType() == "valabilitate") { ?>
                                <br/>Contul dumneavoastra este valabil pana la <b><?php echo $user->getCompanyDetails()->getAvailable_to()->format("d-m-Y") ?></b>
                            <?php } else { ?>
                                
                                <?php
                            }
                        }break;
                    case DLConstants::$PAYMENT_STATUS_PENDING: {
                            ?>
                                Plata dumneavoastra este in asteptare. Aceasta va fi procesata in scurt timp.
                            <?php
                        }break;
                    default: {
                            ?>
                                Plata dumneavoastra <b>nu</b> a fost finalizata. Pentru mai multe detalii contactati <?php echo DLConstants::$OFFICE_EMAIl?>
                            <?php
                        }break;
                }
                ?>

            </div>
        </div>
    </div>
    <div id="clear"></div>
</div>
