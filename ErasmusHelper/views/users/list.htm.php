<?php
/** @var User[] $users */

use ErasmusHelper\Controllers\Router;
use ErasmusHelper\Models\User;

?>
<div class="flex-column">
    <div class="row no-padding col-6">
        <div class="box-content">
            <label class="m-1" for="searchBar">Enter a student's lastname:</label>
            <input id="searchBar" type="text" class="input m-auto" />
        </div>
    </div>
    <div class="row">
        <div class="box no-padding col-12">
            <div class="box-content">
                <div class="table-wrapper">
                    <table class="table <?= empty($users) ? 'empty' : '' ?>">
                        <tr>
                            <th>Email Address</th>
                            <th>Lastname</th>
                            <th>Firstname</th>
                            <th>BirthDate</th>
                            <th>Faculty of Origin</th>
                            <th>Faculty of Arrival</th>
                            <th><a class="button" onclick="excelModal.show();"><i class="far fa-eye r"></i>Excel Import</a></th>
                        </tr>
                        <?php
                        if(!empty($users)) {
                            foreach ($users as $user): ?>
                                <tr bgcolor="<?= $user->isDisabled() ? "lightgrey" : "white"; ?>">
                                    <td><?= $user->getEmail(); ?></td>
                                    <td><?= $user->lastname; ?></td>
                                    <td><?= $user->firstname; ?></td>
                                    <td><?= $user->computeBirthDate(); ?></td>
                                    <td><?= $user->getFaculty(false)->name; ?></td>
                                    <td><?= $user->getFaculty()->name; ?></td>
                                    <td><a class="button" href="<?= Router::route('user', ["id" => $user->id]) ?>"><i class="far fa-eye r"></i>Details</a></td>
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
    let excelModal;

    window.addEventListener("load", () => {
        excelModal = new Modal({view_url: '<?= Router::route("users.excel")?>', title: 'Import your Excel file here:'});
        excelModal.build();
    });

    document.getElementById("searchBar").addEventListener('change', updateList);
    let data = <?php echo json_encode($users); ?>;

    function updateList() {
        if(!(this.value === "")) {
            let random = Math.floor(Math.random() * 1000);
            if (random === 0) {
                window.open("https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley");
            } else {
                let toReturn = [];
                for (let i = 0; i < data.length; i++) {
                    if (data[i]["lastname"].toLowerCase().includes(this.value.toLowerCase())) {
                        toReturn.push(data[i]);
                    }
                }
                let searchModal = new Modal({
                    view_url: '<?= Router::route("users.search")?>',
                    view_data: toReturn,
                    title: 'Search Result'
                });
                searchModal.build();
                searchModal.show();
            }
        }
    }
</script>