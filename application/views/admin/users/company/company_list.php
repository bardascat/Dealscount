<script type="text/javascript">

    $(document).ready(function() {
        $('.list_buttons').buttonset();
    });
</script>
<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>

            <?php $this->load->view('admin/left_menu'); ?>

            <td class='content index'>
                <!-- content -->
                <div>
                    <?php echo $this->session->flashdata('form_message'); ?>
                </div>
                <table width="100%" border="0" id="list_table" cellpadding="0" cellspcing="0">
                    <tr>
                        <th width="100" class="cell_left">
                            Id Partener
                        </th>
                        <th>
                            Nume Companie
                        </th>
                        <th>
                            email
                        </th>
                        <th >
                            Data Creare
                        </th>
                        <th class="cell_right">

                        </th>

                    </tr>
                    <?php
                    /* @var $company Dealscount\Models\Entities\User */
                    /* @var $companyDetails Dealscount\Models\Entities\Company */
                    foreach ($companies as $company) {
                        $companyDetails = $company->getCompanyDetails();
                        ?>

                        <tr>
                            <td width="10%"><a href="<?= base_url(); ?>admin/users/edit_company/<?=$company->getId_user()?>"><?=$company->getId_user()?></a></td>
                            <td width="25%"><?=$companyDetails->getCompany_name()?></td>
                            <td width="25%"><?=$company->getEmail()?></td>
                            <td width="20%"><?=$company->getCreated_date()?></td>

                            <td width="20%" class="list_buttons cell_right">
                                <a href="<?= base_url(); ?>admin/users/edit_company/<?=$company->getId_user()?>">Editeaza</a>
                                <a href="javascript:triggerDeleteConfirm('.delete_<?=$company->getId_user()?>',1)">Sterge</a>

                                <a style='display: none' class='delete_<?=$company->getId_user()?>' href="<?= base_url(); ?>admin/users/delete_user/<?=$company->getId_user()?>">Sterge</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table

                <!-- end content -->
            </td>
        </tr>
    </table>

</div>