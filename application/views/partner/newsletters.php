<?php
/* @var $user Dealscount\Models\Entities\User */ $user
?>
<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="newsletters">

            <h1>Newsletter</h1>

            <div  class="info">
                Programeaza trimiterea unui newsletter cu toate ofertele active pe site:
            </div>

            <form id="scheduleNewsletterForm" method="post" action="<?php echo base_url('partener/schedule_newsletter') ?>">
                <div class="left_side">
                    <table cellpadding="0" width="100%"  cellspacing="0" border="0">
                        <tr>
                            <td  width="120">
                                <label>Titlu newsletter</label>
                            </td>
                            <td>
                                <input class="nameInput" type="text" name="name"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Programeaza</label>
                            </td>
                            <td>
                                <div class="programeaza">
                                    <input class="datepicker" type="text" name="scheduled"/>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 25px;">
                                <label>Filtreaza</label>
                            </td>
                            <td style="padding-top: 25px;">
                                <table class="filtersTable" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td>
                                            <table class="genderTable" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td>
                                                        <input id="masculin" type="checkbox" value="m" name="sex[]"/>
                                                    </td>
                                                    <td>
                                                        <label for="masculin">Masculin</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input id="feminin" type="checkbox" value="f" name="sex[]"/>
                                                    </td>
                                                    <td>
                                                        <label for="feminin">Feminin</label>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table class="ageTable" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td>
                                                        <input id="18_25" value="18-25" type="checkbox" name="age[]"/>
                                                    </td>
                                                    <td>
                                                        <label for="18_25">18-25 ani</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input id="25_30" value="25-30" type="checkbox" name="age[]"/>
                                                    </td>
                                                    <td>
                                                        <label for="25_30">25-30 ani</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input id="30_40" value="30-40" type="checkbox" name="age[]"/>
                                                    </td>
                                                    <td>
                                                        <label for="30_40">30-40 ani</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input id="40_ani" value=">40" type="checkbox" name="age[]"/>
                                                    </td>
                                                    <td>
                                                        <label for="40_ani">>40 ani</label>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="cities">
                                            <select multiple="true" name="cities">
                                                <option value="Bucuresti">Bucuresti</option>
                                                <option value="Bucuresti">Bucuresti</option>
                                                <option value="Bucuresti">Bucuresti</option>
                                                <option value="Bucuresti">Bucuresti</option>
                                                <option value="Bucuresti">Bucuresti</option>
                                                <option value="Bucuresti">Bucuresti</option>
                                                <option value="Bucuresti">Bucuresti</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div> <!-- left side end -->
                <div class="rightSide">
                    <input type="button" onclick="$('#scheduleNewsletterForm').submit()" class="programeaza"/>
                    <a href="<?php base_url("partnener/newsletter/vizualizare") ?>" class="vizualizeaza"></a>
                </div>
            </form>

            <div class="newsletters_list">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <th>
                            Titlu
                        </th>
                        <th>
                            Data
                        </th>
                        <th>
                            Trimis la
                        </th>
                        <th>
                            Au deschis
                        </th>
                        <th>
                            Accesari
                        </th>
                        <th>
                            Vezi
                        </th>
                        <th>
                            Anuleaza
                        </th>
                    </tr>
                    <tr>
                        <td>
                            Oferte la infrumusetare cu doar 2 lei etc
                        </td>
                        <td>
                            22.0.2014
                        </td>
                        <td>
                            30 persoane
                        </td>
                        <td>
                            30 persoane
                        </td>
                        <td>
                            30 persoane
                        </td>
                        <td>
                            vezi
                        </td>
                        <td>
                            Anuleaza
                        </td>
                    </tr>
                </table>
            </div>

        </div>


    </div>
    <div id="clear"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".datepicker").datetimepicker({timeFormat: 'HH:mm', dateFormat: "dd-mm-yy"});
    })
</script>