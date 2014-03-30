<table width="100%" border="0" cellspacing="0" celppadding="0" class="beneficiariTable">
    <?php
    if (!$cartItem->getIs_gift()) {
        for ($i = 0; $i < $cartItem->getQuantity(); $i++) {
            ?>
            <tr>
                <td >
                    <input <?php if($cartItem->getQuantity()==1) echo "style='margin-top:6px;'"?> class="beneficiarInput" placeholder="Nume Beneficiar" type="text" name="name_<?= $cartItem->getId() ?>[]"/>
                </td>
            </tr>
            <?php
        }
    } else {
        //daca este cadou
        $friendsDetails = json_decode($cartItem->getDetails());

        for ($i = 0; $i < $cartItem->getQuantity(); $i++) {

            if (isset($friendsDetails[$i]))
                $friend = $friendsDetails[$i];
            else
                $friend = null;
            ?>
            <tr>
                <td width="200">
                    <input class="prietenInput" placeholder="Nume Prieten" value="<?= $friend->name ?>" type="text" name="name_<?= $cartItem->getId() ?>[]"/>
                </td>
                <td>
                    <input class="emailInput" placeholder="Email Prieten" value="<?= $friend->email ?>" type="text" name="email_<?= $cartItem->getId() ?>[]"/>
                </td>
            </tr>
            <?php
        }
    }
    ?>
</table>