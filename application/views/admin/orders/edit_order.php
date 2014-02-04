<? /* @var $order \NeoMvc\Models\Entity\Order */ $order = $this->order ?>

<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>

            <? require_once('views/admin/left_menu.php'); ?> 

            <td class='content index'>
                <div class="orderDetails">
                    <table  id='list_table' width="100%" ellpadding="0" cellspacing="0">
                        <tr>
                            <th width="5%">Cod Comandă</th>
                            <th width="19%">Informatii Client</th>
                            <th width="10%">Dată Comandă</th>
                            <th width="10%">Status Plată</th>
                            <th width="10%">Status Comandă</th>
                            <th width="10%">Metodă Plată</th>
                            <th width="10%">Pret Transport</th>
                            <th width="10%">Pret Total</th>
                            <th width="10%">Factură</th>
                        </tr>
                        <tr>
                            <td>
                                <?= $order->getOrderNumber() ?>
                            </td>
                            <td>
                                <?
                                $user = $order->getUser();
                                ?>
                                Nume:<?= $user->getNume() . ' ' . $user->getPrenume() ?><br/>
                                Email:<a href="mailto:<?= $user->getEmail() ?>"><?= $user->getEmail() ?></a><br/>
                                Telefon:<?= $user->getPhone() ?><br/>

                            </td>
                            <td>
                                <?= $order->getOrderedOn() ?>
                            </td>
                            <td>
                                <?= $this->getHumanPaymentStatus($order->getPayment_status()) ?>
                            </td>
                            <td>
                                <?= $this->getHumanOrderStatus($order->getOrderStatus()) ?>
                            </td>
                            <td>
                                <?= $this->getHumanPaymentMethod($order->getPayment_method()) ?>
                            </td>
                            <td>
                                <?= $order->getShipping_cost() ?> lei
                            </td>
                            <td>
                                <?= $order->getTotal() ?> lei
                            </td>
                            <td>
                                <?
                                if (!$order->getInvoice())
                                    echo "Inexistenta";
                                elseif (!$order->getInvoice()->getActive())
                                    echo "Inactivă";
                                else {
                                    ?>
                                    <a style="font-size: 11px" href="<?= URL ?>admin/orders/downloadInvoice/<?= $order->getId_order() ?>">
                                        Descarcă
                                    </a>
                                <? } ?>
                            </td>
                        </tr>
                    </table>
                </div>

                <form id="updateOrderForm" method="post" action="<?= URL ?>admin/orders/editOrderDo" enctype="multipart/form-data">
                    <input type="hidden" name="id_order" value="<?= $this->order->getId_order() ?>"/>
                    <div class="categoriesInput"></div>
                    <div id="submit_btn_right">
                        <input onclick="$('#updateOrderForm').submit()"  type="button" value="Salveaza" />
                    </div>
                    <!-- content -->
                    <span style="color: green; font-weight: bold"><?= NeoMvc\Libs\Session::get_flash_data("mesajCargus"); ?></span>
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Produse Cumpărate</a></li>
                            <li><a href="#tabs-2">Adresă Livrare</a></li>
                            <li><a href="#tabs-3">Adresă Facturare</a></li>
                            <li><a href="#tabs-4">Detalii Comandă</a></li>
                        </ul>
                        <div id="tabs-1">
                            <table class='itemsTable'  width='100%' border='0' id='list_table' cellpadding="0" cellspacing="0">
                                <tr>
                                    <th class='cell_left' width='10%'>

                                    </th>
                                    <th width='30%'>
                                        Produs
                                    </th>
                                    <th width='7%'>
                                        Cantitate
                                    </th>
                                    <th width='7%'>
                                        Total
                                    </th>
                                    <th width='7%'>
                                        Status
                                    </th>
                                    <th width='5%'>
                                        Partener
                                    </th>
                                    <th width='7%'>
                                        AWB
                                    </th>
                                    <th class='cell_right' width='20%'></th>
                                </tr>
                                <?
                                foreach ($order->getItems() as $orderItem) {
                                    $item = $orderItem->getItem();
                                    $variant = $orderItem->getProductVariant();
                                    ?>
                                    <tr id='<?= $orderItem->getId() ?>'>
                                        <td class='image'>
                                            <a target='_blank' href='<?= URL . $item->getSlug() ?>'>
                                                <img src='<?= $item->getMainImage("thumb") ?>' width='80'/>
                                            </a>
                                        </td>
                                        <td class='item'>
                                            <?
                                            echo $item->getName() . '<br/>';
                                            if ($variant) {
                                                ?>
                                                <span style='font-size: 10px; color: #00a9ff'>
                                                    <?
                                                    foreach ($variant->getAttributes() as $attributeValue) {
                                                        echo "<br/>" . $attributeValue->getAttribute()->getName() . ': ' . $attributeValue->getValue();
                                                    }
                                                    ?>

                                                </span>
                                                <?
                                            }

                                            //daca itemul este oferta, afisam si voucherele
                                            if ($item->getItem_type() == "offer"):
                                                ?>
                                                <a style="color:#00A9FF ;font-size: 11px;" href="<?= URL ?>admin/orders/editVouchersPopup/<?= $orderItem->getId() ?>" class="fancybox.iframe lista_vouchere">Vezi vouchere</a>
                                            <? endif; ?>
                                        </td>
                                        <td class='quantity'>
                                            <input type='text' name='quantity' value='<?= $orderItem->getQuantity() ?>'/>
                                        </td>
                                        <td><?= $orderItem->getTotal() ?> lei</td>
                                        <td><?= $this->getHumanOrderItemStatus($orderItem->getStatus()) ?></td>
                                        <td style="font-size: 10px;">
                                            <a href="<?= URL ?>admin/users/edit_company/<?= $item->getCompany()->getId_user() ?>/popup" class="popupPartener fancybox.iframe">
                                                <?= $item->getCompany()->getCompanyDetails()->getCompany_name() ?>
                                            </a>
                                        </td>
                                        <td style="font-size: 10px;">
                                            <?
                                            if ($item->getItem_type() == "offer")
                                                echo " - ";
                                            else
                                                echo $this->getAWBStatus($orderItem)
                                                ?>
                                        </td>
                                        <td class="list_buttons cell_right">
                                            <a href="javascript:updateOrderItemQuantity(<?= $orderItem->getId() ?>)">Salvează</a>
                                            <a href="<?= URL ?>admin/orders/deleteOrderItem/<?= $orderItem->getId() ?>">Sterge</a>
                                            <a href="<?= URL ?>admin/orders/setOrderItemStatus/<?= $orderItem->getId() ?>/<?
                                            if ($orderItem->getStatus() == "F")
                                                echo "C";
                                            elseif ($orderItem->getStatus() == "W")
                                                echo "F";
                                            else
                                                echo "F";
                                            ?>"><?
                                                   if ($orderItem->getStatus() == "F")
                                                       echo "Anulează";
                                                   else
                                                       echo "Confirmă"
                                                       ?></a>
                                        </td>
                                    </tr>
                                <? } ?>
                            </table>
                        </div>
                        <div id="tabs-2">
                            <table  border='0' width='100%' id='add_table'>
                                <?
                                /* @var $shippingAddress \NeoMvc\Models\Entity\ShippingAddress  */
                                $shippingAddress = $this->order->getShippingAddress();
                                if ($shippingAddress):
                                    ?>

                                    <tr>
                                        <td class='label'>
                                            <input type='hidden' name='id_address' value='<?= $shippingAddress->getId_shipping_address() ?>'/>
                                            <label>Nume Destinatar</label>
                                        </td>
                                        <td class='small_input'>
                                            <input type='text' name='shipping_name' value='<?= $shippingAddress->getShipping_name() ?>'/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label'>
                                            <input type='hidden' name='id_address' value='<?= $shippingAddress->getId_shipping_address() ?>'/>
                                            <label>Telefon Destinatar</label>
                                        </td>
                                        <td class='small_input'>
                                            <input type='text' name='shipping_phone' value='<?= $shippingAddress->getShipping_phone() ?>'/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label'>
                                            <label>CNP Destinatar</label>
                                        </td>
                                        <td class='small_input'>
                                            <input type='text' name='shipping_cnp' value='<?= $shippingAddress->getShipping_cnp() ?>'/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label'>
                                            <label>Oras Destinatar</label>
                                        </td>
                                        <td class='small_input'>
                                            <input type='text' name='shipping_city' value='<?= $shippingAddress->getShipping_city() ?>'/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label'>
                                            <label>Judet Destinatar</label>
                                        </td>
                                        <td class='small_input'>
                                            <select name="shipping_district_code">
                                                <?= $this->htmlCargus ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label'>
                                            <label>Adresa Destinatar</label>
                                        </td>
                                        <td class='input'>
                                            <input type='text' name='shipping_address' value='<?= $shippingAddress->getShipping_address() ?>'/>
                                        </td>
                                    </tr>
                                <? endif; ?>
                            </table>
                        </div>
                        <div id="tabs-3">
                            <table  border='0' width='100%' id='add_table'>

                                <?
                                /* @var $billingAddress \NeoMvc\Models\Entity\BillingAddress  */
                                $billingAddress = $this->order->getBillingAddress();
                                if ($billingAddress):
                                    switch ($billingAddress->getBilling_type()) {
                                        case "individual": {
                                                ?>
                                                <tr>
                                                    <td class='label' colspan="2">
                                                        Factura pe persoana fizica
                                                        <input type='hidden' name='id_billing_address' value='<?= $billingAddress->getId_billing_address() ?>'/>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class='label'>
                                                        <label>Nume</label>
                                                    </td>
                                                    <td class='small_input'>
                                                        <input type='text' name='billing_name' value='<?= $billingAddress->getBilling_name() ?>'/>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class='label'>
                                                        <label>CNP</label>
                                                    </td>
                                                    <td class='small_input'>
                                                        <input type='text' name='billing_cnp' value='<?= $billingAddress->getBilling_cnp() ?>'/>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class='label'>
                                                        <label>Judet</label>
                                                    </td>
                                                    <td class='small_input'>
                                                        <input type='text' name='billing_district' value='<?= $billingAddress->getBilling_cnp() ?>'/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='label'>
                                                        <label>Oras</label>
                                                    </td>
                                                    <td class='small_input'>
                                                        <input type='text' name='billing_city' value='<?= $billingAddress->getBilling_city() ?>'/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='label'>
                                                        <label>Adresa</label>
                                                    </td>
                                                    <td class='small_input'>
                                                        <input type='text' name='billing_address' value='<?= $billingAddress->getBilling_address() ?>'/>
                                                    </td>
                                                </tr>


                                                <?
                                            }break;
                                        case "legal": {
                                                ?>

                                                <tr>
                                                    <td class='label' colspan="2">
                                                        Factura pe persoana juridica
                                                        <input type='hidden' name='id_billing_address' value='<?= $billingAddress->getId_billing_address() ?>'/>
                                                    </td>

                                                </tr>
                                                
                                                 <tr>
                                                    <td class='label'>
                                                        <label>Companie</label>
                                                    </td>
                                                    <td class='small_input'>
                                                        <input type='text' name='billing_company_name' value='<?= $billingAddress->getBilling_company_name() ?>'/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='label'>
                                                        <label>Adresa Companie</label>
                                                    </td>
                                                    <td class='small_input'>
                                                        <input type='text' name='billing_company_address' value='<?= $billingAddress->getBilling_company_address() ?>'/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='label'>
                                                        <label>Banca </label>
                                                    </td>
                                                    <td class='small_input'>
                                                        <input type='text' name='billing_bank' value='<?= $billingAddress->getBilling_bank() ?>'/>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td class='label'>
                                                        <label>IBAN</label>
                                                    </td>
                                                    <td class='small_input'>
                                                        <input type='text' name='billing_iban' value='<?= $billingAddress->getBilling_iban() ?>'/>
                                                    </td>
                                                </tr>
                                                
                                                

                                                <?
                                            }break;
                                    }
                                    ?>


                                <? endif; ?>
                            </table>
                        </div>
                        <div id="tabs-4">
                            <table  border='0' width='100%' id='add_table'>
                                <tr>
                                    <td class='label'>
                                        <label>Cod Comanda: </label>
                                    </td>
                                    <td class='small_input'>
                                        <input type='text' disabled="true"  name='order_number'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Cost Total</label>
                                    </td>
                                    <td class='small_input'>
                                        <input type="text" disabled="disabled" name='total'/> lei
                                    </td>
                                </tr>

                                <tr>
                                    <td class='label'>
                                        <label>Cost transport</label>
                                    </td>
                                    <td class='small_input'>
                                        <input type="text" name='shipping_cost'/> lei
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Data Comanda</label>
                                    </td>
                                    <td class='small_input'>
                                        <input type="text" name='orderedOn'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Rate</label>
                                    </td>
                                    <td class='small_input'>
                                        <input type="text" name='installments'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Metoda de plata</label>
                                    </td>
                                    <td class='input'>
                                        <select name='payment_method'>
                                            <option value="card">Card</option>
                                            <option value="op">Transfer Bancar</option>
                                            <option value="ramburs">Ramburs</option>
                                            <option value="free">Gratuit</option>

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Stare Comanda: </label>
                                    </td>
                                    <td class='small_input'>
                                        <select name='order_status' style="padding: 0px">
                                            <option value="W">Neprocesata</option>
                                            <option value="W2">In curs de procesare</option>
                                            <option value="P">Procesata</option>
                                            <option value="F">Livrata</option>
                                            <option value="C">Anulata</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Status Plata</label>
                                    </td>
                                    <td class='input'>
                                        <select name='payment_status'>
                                            <option value="F">Finalizata</option>
                                            <option value="R">Refund</option>
                                            <option value="W">In asteptare</option>
                                            <option value="C">Anulata</option>
                                        </select>
                                    </td>
                                </tr>
                                <? if ($this->order->getShippedOn()) { ?>
                                    <tr>
                                        <td class='label'>
                                            <label>Livrata la data: </label>
                                        </td>
                                        <td class='input'>
                                            <input name='shippedOn' disabled="disabled" value='<?= $this->order->getShippedOn() ?>'/>
                                        </td>
                                    </tr>
                                <? } ?>
                            </table>
                        </div>
                    </div>
                </form>
                <!-- end content -->
            </td>
        </tr>
    </table>
</div>

<form id='updateOrderItemForm' method='post' action='<?= URL ?>admin/orders/updateOrderItemQuantity'>
    <input type='hidden' name='quantity'/>
    <input type='hidden' name='id_orderItem'/>
</form>
<style>.fancybox-skin {background: #FFF;}</style>
<script>
                            function updateOrderItemQuantity(id_orderItem) {
                                $('#updateOrderItemForm input[name="quantity"]').val($('#' + id_orderItem + " input[name='quantity']").val());
                                $('#updateOrderItemForm input[name="id_orderItem"]').val(id_orderItem);
                                $('#updateOrderItemForm').submit();

                            }

                            $(function() {
                                $(".popupPartener").fancybox({autoResize: false, height: 500, autoSize: false, width: 900, openEffect: 'none', closeEffect: 'none', afterShow: function() {
                                    }});
                                $(".awbDetails").fancybox({autoResize: false, width: 660, height: 400, autoSize: false, openEffect: 'none', closeEffect: 'none', beforeClose: function() {
                                        location.reload();
                                    }});
                                $(".lista_vouchere").fancybox({autoResize: false, height: 400, autoSize: false, width: 550, openEffect: 'none', closeEffect: 'none', beforeClose: function() {
                                        window.location = "";
                                    }});
                                $("#tabs").tabs();
                                $("input[type=submit]").button();
                                $("input[type=button]").button();
                                $(".jqueryButton").button();
                                $('.list_buttons').buttonset();
<? if ($order->getShippingAddress()): ?>
                                    $('select[name="shipping_district_code"]').val('<?= $order->getShippingAddress()->getShipping_district_code() ?>');
<? endif; ?>
                            });

</script>