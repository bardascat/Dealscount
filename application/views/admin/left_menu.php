<td width='160' class='menu'>
    <!-- menu -->

    <table border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>
            <th>Produse</th>
        </tr>
        <tr>
            <td>
                <a href='<?= base_url() ?>admin/product/categories'>Categorii produse</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href='<?= base_url() ?>admin/product/products_list'>Listă Produse</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href='<?= base_url() ?>admin/product/add_product'>Adauga Produs</a>
            </td>
        </tr>

    </table>
    
    <table border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>
            <th>Oferte</th>
        </tr>
        <tr>
            <td>
                <a href='<?= base_url() ?>admin/offer/categories'>Categorii oferte</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href='<?= base_url() ?>admin/offer/offers_list'>Listă Oferte</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href='<?= base_url() ?>admin/offer/add_offer'>Adauga Oferta</a>
            </td>
        </tr>

    </table>
    <table border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>
            <th>Comenzi</th>
        </tr>
        <tr>
            <td>
                <a href='<?= base_url() ?>admin/orders/orders_list'>Listă Comenzi</a>
            </td>
        </tr>  
    </table>
    <table border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>
            <th>Pagini</th>
        </tr>
        <tr>
            <td>
                <a href='<?= base_url() ?>admin/pages/home'>HomePage</a>
            </td>
        </tr>  
        <?php // foreach ($this->pages as $page) { ?>
       
            <tr>
                <td>
                    <a href='<?= base_url() ?>admin/pages/updatePage/<?php //$page->getId_page() ?>'><?php  //$page->getName() ?></a>
                </td>
            </tr>
      
        <?php // } ?>
    </table>
    <table border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>
            <th>Useri</th>
        </tr>
        <tr>
            <td>
                <a href='<?= base_url() ?>admin/users/users_list'>Lista Useri</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href='<?= base_url() ?>admin/users/company_list'>Listă Parteneri</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href='<?= base_url() ?>admin/users/add_company'>Adauga Partener</a>
            </td>
        </tr>

    </table>

    <table border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>
            <th>Administrative</th>
        </tr>
        <tr>
            <td>
                <a href='<?= base_url() ?>admin/index/logout'>Logout</a>
            </td>
        </tr>

    </table>

    <!-- end menu -->

</td>