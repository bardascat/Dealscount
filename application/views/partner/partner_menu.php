<?php /* @var $user \Dealscount\Models\Entities\User */ ?>
<table class="header" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td class="name">
            <?php echo $user->getCompanyDetails()->getCommercial_name(); ?>
        </td>
        <td class="minimenu">
            <ul>
                <li class="date_cont <?php if ($this->uri->segment(2) == "date-cont") echo "selected"; ?>">
                    <a href="<?php echo base_url('partener/date-cont') ?>">
                        Date cont
                    </a>
                </li>
                <li class="abonamente">
                    <a href="<?php echo base_url('partener/abonamente') ?>">
                        Abonamente
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('partener/logout') ?>">
                        Logout
                    </a>
                </li>
            </ul>
        </td>
    </tr>
</table>

<div class="partner_menu">
    <ul>
        <li class="dashboard <?php if (!$this->uri->segment(2)) echo "selected"; ?>">
            <a href="<?php echo base_url('partener') ?>">Dashboard</a>
        </li>
        <li class="settings <?php if ($this->uri->segment(2) == "oferte") echo "selected"; ?>">
            <a href="<?php echo base_url('partener/oferte') ?>">Ofertele mele</a>
        </li>
        <li class="new_offer <?php if ($this->uri->segment(2) == "oferta-noua") echo "selected"; ?>">
            <a href="<?php echo base_url('partener/oferta-noua') ?>">Oferta noua</a>
        </li>
        <li class="users <?php if ($this->uri->segment(2) == "utilizatori") echo "selected"; ?>">
            <a href="<?php echo base_url('partener/utilizatori') ?>">Utilizatori</a>
        </li>
        <li class="newsletter <?php if ($this->uri->segment(2) == "newsletter") echo "selected"; ?>">
            <a href="<?php echo base_url('partener/newsletter') ?>">Newsletter</a>
        </li>
        <li class="invoice <?php if ($this->uri->segment(2) == "facturi") echo "selected"; ?>">
            <a href="<?php echo base_url('partener/facturi') ?>">Facturi</a>
        </li>
        <li class="vouchers <?php if ($this->uri->segment(2) == "vouchere") echo "selected"; ?>">
            <a href="<?php echo base_url('partener/vouchere') ?>">Vouchere</a>
        </li>
    </ul>
</div>