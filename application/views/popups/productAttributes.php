<script>
    $(document).ready(function() {

        $(".attribute").button();
    });
</script>
<div id="popup">
    <div class="info">Alegeti proprietarea produsului ! sau <a href="javascript:addNewProperty()">adăugați</a> una noua</div>
    <div class="newProperty">
        <form method="post" action="<?= URL ?>admin/product/addAttribute">
            <div class="label">Nume Proprietate</div>
            <div class="input"><input type="text" name="attributeName"/></div>
            <div class="blueButton" onclick="$('.newProperty form').submit()" style="margin-left: 5px;">Adaugă</div>
        </form>
    </div>
    <div class="attributes">
        <?
        if ($this->attributes)
            foreach ($this->attributes as $attribute) {
                ?>
                <div onclick="addAttribute('<?= $attribute->getName() ?>',<?= $attribute->getId_attribute() ?>)" class="attribute"><?= $attribute->getName() ?></div>
            <? } ?>
    </div>
</div>

<script>
    function addNewProperty() {
        $('.newProperty').slideToggle(150);
    }
    function addAttribute(name,id_attribute) {
        var html='<tr id="id_attribute_'+id_attribute+'"><td width="90"><label>'+name+'</label></td><td class="input"><input type="hidden" name="id_attribute[]" value="'+id_attribute+'"/><input type="hidden" name="id_attribute_value[]" value=""/><input type="text" name="attribute_value[]" value=""/></td><td><div class="removeAttribute" onclick="parent.removeAttribute('+id_attribute+',<?=$this->id_variant?>)">Remove</div></td></tr>';
        parent.addAttribute(html,<?=$this->id_variant?>);
    }
</script>
