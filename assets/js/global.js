var url = "http://dev.getadeal.ro/";var map = null;var globalZoom = 0;function displayMap(lat, lon) {    initialize(lat, lon);}function displayPartnerMap(lat, lon) {    // create the map    var myLatlng = new google.maps.LatLng(lat, lon);    var myOptions = {        zoom: (globalZoom ? globalZoom : 15),        center: new google.maps.LatLng(lat, lon),        mapTypeId: google.maps.MapTypeId.ROADMAP    }    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);    var marker = new google.maps.Marker({        position: myLatlng,        map: map,        title: ""    });    google.maps.event.addListener(map, 'click', function(event) {        marker.setMap(null);        var lat = event.latLng.lat();        var lng = event.latLng.lng();        $('.lat').val(lat);        $('.lng').val(lng);        marker = new google.maps.Marker({position: event.latLng, map: map});    });    var getCen = map.getCenter();    google.maps.event.addListener(map, 'resize', function(event) {        console.log('da');        console.log(getCen);        map.setCenter(new google.maps.LatLng(lat, lon));    });    var myLatlng = new google.maps.LatLng(lat, lon);}function initialize(lat, lon) {    // create the map    var myLatlng = new google.maps.LatLng(lat, lon);    var myOptions = {        zoom: (globalZoom ? globalZoom : 15),        center: new google.maps.LatLng(lat, lon),        mapTypeId: google.maps.MapTypeId.ROADMAP    }    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);    var marker = new google.maps.Marker({        position: myLatlng,        map: map,        title: ""    });    var myLatlng = new google.maps.LatLng(lat, lon);}function abonare() {    $('<a title="" href="template/templates/show_popup.php?iframe=true&width=620&height=356"></a>').prettyPhoto().click()}function change_city() {    $('#oras_form').submit();}function login() {    $('#login_form').fadeToggle(100);}function contul_meu() {    $('.contul_meu_container').fadeToggle(100);}$(document).ready(function() {    $(".header_categories").mouseleave(function() {        $('.subcats').fadeOut(100);    });    $('.subcats').mouseleave(function() {        $('.subcats').fadeOut(100);    });    $(".shopping_cart").mouseleave(function() {        $('#cart_header').fadeOut(100);    });    $(".shopping_cart").mouseenter(function() {        $('#cart_header').fadeIn(100);    });})function toggleLoginHeader() {    $('#header_login').fadeToggle(100);}function toggleMyAccount() {    $('.my_account .subcats').fadeToggle(100);}function show_subcats(cat) {    var top = ($('#parent_' + cat).offset().top);    var left = ($('#parent_' + cat).offset().left);    $('.categorii ul').fadeOut(50);    //$('#' + cat).offset({ top:top, left:left})    $('.header_categories .subcats').fadeOut(0);    $('#' + cat).fadeIn(0, function() {    });    $('#' + cat).mouseleave(function(e) {        $(this).fadeOut(0);    });}function close_subcats() {    $('.categorii ul').fadeOut(50);}function main_img_mouseover(elem) {    var id = $(elem).attr('id');    $('#anim_' + id).css({left: $(elem).offset().left, top: $(elem).offset().top})    $('#anim_' + id).fadeIn(150);}function main_img_mouseleave(elem) {    $('.lupa_hover').fadeOut();}function mouse_over_img(element) {    element.src = url + "assets/images_fdd/hover_lupa_1.png";}function mouse_out_img(element) {    element.src = url + "assets/images_fdd/lupa_1.png";}function mouse_over_img_cumpara(element) {    element.src = url + "assets/images_fdd/hover_cumpara_1.png";}function mouse_out_img_cumpara(element) {    element.src = url + "assets/images_fdd/carucior_1.png";}function triggerAddOfferPopup() {    var firstAttribute = "";    var secondAttribute = "";    var id_item = $('input[name="id_item"]').val();    var quantity = encodeURI($('input[name="quantity"]').val());    //generam url-ul     var getUrl = url + "admin/orders/addOrderOfferPopup/" + id_item + "/" + quantity;    $('#triggerAddItemPopup').attr("href", getUrl);    $('#triggerAddItemPopup').trigger("click");}function increment_offer_view(id_item) {    $.ajax({        type: "POST",        url: url + "oferte/increment_offer_view",        data: 'id_item=' + id_item,        dataType: 'json',        success: function(result) {        }})}function showAvailableDay(id_option, input) {    var selectedDate = $(input).val();    $.ajax({        type: "POST",        url: url + "partener/getOptionAvailablePosition",        data: 'id_option=' + id_option + "&date=" + selectedDate,        dataType: 'json',        success: function(result) {            alert('In data de ' + selectedDate + ' oferta dumneavoastra va fi pe pozitia ' + result.position);        }})}function updateQuantity(id_cartItem, type) {    console.log(type);    switch (type) {        case "plus":            {                $('#updateForm').append('<input type="hidden" name="plus"/>');            }            break;        case "minus":            {                $('#updateForm').append('<input type="hidden" name="minus"/>');            }            break;    }    $('#updateForm input[name="cartItem"]').val(id_cartItem);    $('#updateForm').submit();}function login_header() {    $('#header_login form').submit();}function load_partner_editor(width, height) {    if (!width)        width = "90%";    if (!height)        height = "200";    var op = {        filebrowserUploadUrl: url + 'Controllers/uploader/upload.php?type=Files',        width: width,        height: height,        toolbar:                [                    '/',                    {                        name: 'styles',                        items: ['Source', 'FontSize', 'Font', 'TextColor', 'BGColor', 'Bold', 'Italic', 'Strike']                    },                    {                        name: 'insert',                        items: ['Image', 'Table', 'PageBreak', 'Link', 'Unlink']                    },                    {                        name: 'basicstyles',                        items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']                    },                ]    }    CKEDITOR.replace('description', op);}function load_offer_editor(width, height) {    if (!width)        width = "90%";    if (!height)        height = "150";    var op = {        filebrowserUploadUrl: url + 'Controllers/uploader/upload.php?type=Files',        width: width,        height: height,        toolbar:                [                    '/',                    {                        name: 'styles',                        items: ['Source', 'FontSize', 'Font', 'TextColor', 'BGColor', 'Bold', 'Italic', 'Strike']                    },                    {                        name: 'insert',                        items: ['Image', 'Table', 'Link', 'Unlink']                    },                    {                        name: 'basicstyles',                        items: ['Bold', 'Italic', 'Strike', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']                    },                ]    }    CKEDITOR.replace('terms', op);    CKEDITOR.replace('benefits', op);}function selectSubcategory(categoryDOM, selectedSubcategory) {    id_category = $(categoryDOM).val();    if (id_category == 0) {        alert('Va rugam alegeti o categorie');        return false;    }    else {        $.ajax({            type: "GET",            url: url + "categorii/getSubcategory",            data: "id_category=" + id_category + '&selectedSubcategory=' + selectedSubcategory,            dataType: 'json',            success: function(result) {                if (result.type == "success") {                    $('select[name="subcategory"]').empty();                    $('select[name="subcategory"]').append(result.data);                }                else {                    alert("Eroare: " + result.msg);                }            }})    }}function new_image() {    newImages = 0;    var existingImages = $('#tabs-4 .image').length;    $("#tabs-4 input[name='image[]']").each(function(index) {        newImages++;    });    var total = existingImages + newImages;    if (total == 5) {        alert("Puteti uploada maxim 5 poze");        return false;    }    else {        var new_image_html = "<div class='image_group'><input onchange='new_image(this)' type='file' name='image[]'/></div>";        $('.add_images').append(new_image_html);    }}function set_primary_image(id_image) {    $.ajax({        type: "POST",        url: url + "partener/set_primary_image",        data: "id_image=" + id_image,        dataType: 'json',        success: function(result) {            $('#image_' + id_image).css('border', '1px solid blue');            $("#dialog-form").dialog("close");        }})}function delete_image(id_image) {    $.ajax({        type: "POST",        url: url + "partener/delete_image",        data: "id_image=" + id_image,        dataType: 'json',        success: function(result) {            if (result.type == "success") {                $('#image_' + id_image).fadeOut(400, function() {                    $('#image_' + id_image).remove();                })                $("#dialog-form").dialog("close");            }            else {                alert("Eroare: " + result.msg);            }        }})}function addOfferFormCategories() {    $('#select_categories input[type=checkbox]').each(function() {        if (this.checked) {            var input = $("<input>").attr("type", "hidden").attr("name", "categories[]").val($(this).val());            console.log(input);            $('#offerForm .categoriesInput').append(input);        }    });}function showSelectedCategories() {    $('#selectedCategories').empty();    var categories = '';    $('#select_categories input[type=checkbox]').each(function() {        if (this.checked) {            categories += ($(this).attr('category_name')) + ', ';        }    });    if (categories)        $('#selectedCategories').append('(' + categories.slice(0, -2) + ')');}function submitOfferForm() {    addOfferFormCategories();    $('#offerForm').submit();}function removeVariant(id_variant, action) {    if (action) {        $.ajax({            type: "POST",            url: url + "partener/toggleVariant",            data: "id_variant=" + id_variant + '&action=' + action,            dataType: 'json',            success: function(result) {                if (action == "active") {                    var msg1 = "Varianta Activa";                    var msg2 = "Dezactiveaza Varianta";                    var new_action = "inactive";                }                else {                    var msg1 = "Varianta Inactiva";                    var msg2 = "Activeaza Varianta";                    var new_action = "active";                }                /*                 $('#variant_' + id_variant + ' .variantHeader').html(msg1);                 $('#variant_' + id_variant + ' .removeVariant').html(msg2);                 $('#variant_' + id_variant + ' .removeVariant').attr('onclick', "removeVariant(" + id_variant + ",'" + new_action + "')");                 */                $('#variant_' + id_variant).fadeOut(300, function() {                    $('#variant_' + id_variant).remove();                });            }        });    } else        $('#variant_' + id_variant).fadeOut(300, function() {            $('#variant_' + id_variant).remove();        });}function addItemVariant() {    var rand = 1 + Math.floor(Math.random() * 99999);    var pret_intreg = '<tr><td width="128"><label>Pret Intreg</label></td><td class=""><input type="hidden" value="" name="id_attribute_value[]"><input name="id_attribute[]" value="1" type="hidden"><input  onkeyup="numericRestrict(this)"  name="attribute_value[]" value="" type="text"> lei</td></tr>';    var pret_redus = '<tr><td width="128"><label>Pret Redus</label></td><td class=""><input type="hidden" value="" name="id_attribute_value[]"><input name="id_attribute[]" value="2" type="hidden"><input onkeyup="numericRestrict(this)"  name="attribute_value[]" value="" type="text"> lei</td> </tr>';    var descriere = '<tr><td width="128"><label>Descriere</label></td><td class=""><input type="hidden" value="" name="id_attribute_value[]"><input name="id_attribute[]" value="3" type="hidden"><textarea  style="width: 264px;" name="attribute_value[]"></textarea></td></tr>';    var status = '<tr><td width="128"><label>Activa?</label></td><td class=""><input type="hidden" value="" name="id_attribute_value[]"><input name="id_attribute[]" value="6" type="hidden"><select name="attribute_value[]"><option value="1">Da</option><option value="0">Nu</option></select></td></tr>';    var attributes = pret_intreg + pret_redus + descriere + status;    var html = '<li id="variant_' + rand + '"><div class = "removeVariant" onclick = "removeVariant(' + rand + ',0)"> Sterge Varianta </div><table width = "100%" border = "0" class = "attributesTable"><input type="hidden" name="id_variant[]" value=""/></td></tr>' + attributes + '</table></li>';    $('.variants_table .variant_list ol').prepend(html);}function deleteCartItem(id) {        $('#deleteForm input[name="cartItem"]').val(id);        $('#deleteForm').submit();    }