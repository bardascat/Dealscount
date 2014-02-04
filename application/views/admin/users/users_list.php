<script type="text/javascript">

    $(document).ready(function() {
        $('.list_buttons').buttonset();
    });
</script>
<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>

            <? require_once('views/admin/left_menu.php'); ?> 

            <td class='content index'>
                <!-- content -->
                <div class="paginator">
                    <form method="get" action="?" class="paginateForm">
                        Pagina: <input style="width: 20px; text-align: center; padding: 2px; font-size: 15px;" type="text" name="page" value="<? if (isset($_GET['page'])) echo $_GET['page'] ?>"/>
                        din  <?= round(count($this->users) / 30) ?>
                    </form>

                    <div class="searchForm">
                        <form method="get" action="<?= URL ?>admin/users/searchUser">
                            <input type="text" value="<? if (isset($_GET['search'])) echo $_GET['search'] ?>" name="search" placeholder="Cauta dupa nume sau email user"/>
                        </form>
                    </div>

                </div>

                <table width="100%" border="0" id="list_table" cellpadding="0" cellspcing="0">
                    <tr>
                        <th width="100" class="cell_left">
                            Id User
                        </th>
                        <th>
                            Nume User
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
                    <? /* @var $product Entity\Product */ foreach ($this->users as $user) { ?>
                        <tr>
                            <td width="10%"><a href="<?= URL ?>admin/users/view_user/<?= $user->getId_user() ?>"><?= $user->getId_user() ?></a></td>
                            <td width="30%"><?= $user->getNume() . ' ' . $user->getPrenume() ?></td>
                            <td width="30%"><?= $user->getEmail() ?></td>
                            <td><?= $user->getCreatedDate() ?></td>

                            <td width="20%" class="list_buttons cell_right">
                                <a href="<?= URL ?>admin/users/view_user/<?= $user->getId_user() ?>">Vizualizeaza</a>
                                <a href="javascript:triggerDeleteConfirm('.delete_<?= $user->getId_user() ?>',1)">Sterge</a>

                                <a style='display: none' class='delete_<?= $user->getId_user() ?>' href="<?= URL ?>admin/users/delete_user/<?= $user->getId_user() ?>">Sterge</a>
                            </td>
                        </tr>
                    <? } ?>
                </table

                <!-- end content -->
            </td>
        </tr>
    </table>

</div>