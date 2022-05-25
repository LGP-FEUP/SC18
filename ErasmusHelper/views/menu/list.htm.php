<?php
/**
 * @var int $usersCount
 * @var int $uniModsCount
 * @var int $cityModsCount
 * @var int $countryModsCount
 * @var int $usersIncoming
 * @var int $usersOutgoing
 * @var string $type
 */

?>
<div class="row">
    <div class="row col-12 col-md-4 wr">
        <div class="col-12 wr">
            <div class="row justify-content-center">
                <div class="box col-12">
                    <div class="box-header">
                        <h1 style="text-align: center" class="box-title">Global Users registered:</h1>
                    </div>
                    <div class="box-content">
                        <h3 style="text-align: center"><?= $usersCount ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(isset($type)) {
            if(isset($usersOutgoing)) {
        ?>
        <div class="col-12 wr">
            <div class="row justify-content-center">
                <div class="box col-12">
                    <div class="box-header">
                        <h1 style="text-align: center" class="box-title">Users Outgoing from your <?= $type ?>:</h1>
                    </div>
                    <div class="box-content">
                        <h3 style="text-align: center"><?= $usersOutgoing ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
            if(isset($usersIncoming)) {
        ?>
        <div class="col-12 wr">
            <div class="row justify-content-center">
                <div class="box col-12">
                    <div class="box-header">
                        <h1 style="text-align: center" class="box-title">Users Incoming from your <?= $type ?>:</h1>
                    </div>
                    <div class="box-content">
                        <h3 style="text-align: center"><?= $usersIncoming ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        }
        if(isset($uniModsCount) && isset($cityModsCount) && isset($countryModsCount)) {
        ?>
        <div class="col-12 wr">
            <div class="row justify-content-center">
                <div class="box col-12">
                    <div class="box-header">
                        <h1 style="text-align: center" class="box-title">Number of Uni Moderators:</h1>
                    </div>
                    <div class="box-content">
                        <h3 style="text-align: center"><?= $uniModsCount ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 wr">
            <div class="row justify-content-center">
                <div class="box col-12">
                    <div class="box-header">
                        <h1 style="text-align: center" class="box-title">Number of City Moderators:</h1>
                    </div>
                    <div class="box-content">
                        <h3 style="text-align: center"><?= $cityModsCount ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 wr">
            <div class="row justify-content-center">
                <div class="box col-12">
                    <div class="box-header">
                        <h1 style="text-align: center" class="box-title">Number of Country Moderators:</h1>
                    </div>
                    <div class="box-content">
                        <h3 style="text-align: center"><?= $countryModsCount ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <div class="row col-12 col-md-8 wr">
        <div class="col-12 wr">
            <div class="row justify-content-center">
                <div class="box col-12">
                    <div class="box-header">
                        <h1 style="text-align: center" class="box-title">Erasmus Helper</h1>
                    </div>
                    <div class="box-content">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>                    </div>
                </div>
            </div>
        </div>
    </div>
</div>