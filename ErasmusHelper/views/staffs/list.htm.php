<?php
/**
 * @var StaffModel[] $staffs
 */

use ErasmusHelper\App;
use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\CityModerator;
use ErasmusHelper\Models\CountryModerator;
use ErasmusHelper\Models\StaffModel;
use ErasmusHelper\Models\UniModerator;

?>
<div class="flex-column">
    <div class="row no-padding col-6">
        <div class="box-content">
            <label class="m-1" for="searchBar">Enter a staff's email address:</label>
            <input id="searchBar" type="text" class="input m-auto" />
        </div>
    </div>
    <div class="row">
        <div class="box no-padding col-12">
            <div class="box-content">
                <div class="table-wrapper">
                    <table class="table <?= empty($staffs) ? 'empty' : '' ?>">
                        <tr>
                            <th>Identifier</th>
                            <th>Email Address</th>
                            <th>Level</th>
                            <th><a class="button" href="<?= Router::route('staff.create.page') ?>" ><i class="fas fa-plus r"></i>Add a staff member</a></th>
                        </tr>
                        <?php if(!empty($staffs)) {
                            foreach ($staffs as $staff): ?>
                                <tr bgcolor="<?= $staff->disabled ? "lightgrey" : "white"; ?>">
                                    <td><?= $staff->id; ?></td>
                                    <td><?= $staff->email; ?></td>
                                    <td><?= App::getPrivilegeName($staff::PRIVILEGE_LEVEL); ?></td>
                                    <td><a class="button" href="<?= Router::route('staff', ["id" => $staff->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
                                </tr>
                            <?php endforeach;
                        } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("searchBar").addEventListener('change', updateList);
    let data = <?php echo json_encode($staffs, JSON_HEX_TAG); ?>;

    function updateList() {
        if(!(this.value === "")) {
            let toReturn = [];
            for (let i = 0; i < data.length; i++) {
                if (data[i]["email"].toLowerCase().includes(this.value.toLowerCase())) {
                    toReturn.push(data[i]);
                }
            }
            let searchModal = new Modal({
                view_url: '<?= Router::route("staffs.search")?>',
                view_data: toReturn,
                title: 'Search Result'
            });
            searchModal.build();
            searchModal.show();
        }
    }
</script>