<div class="row">
    <div class="container adminPage">
        <h1>Logs</h1>
    </div>
</div>
<div class="row">
    <div class="container">
        <div class="col-lg-12" id="adminMeni">
            <p><a href="index.php?page=admin">Products</a></p>
            <p><a href="index.php?page=orders">Orders</a></p>
            <p><a href="index.php?page=logs">Logs</a></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="container">
        <div class="col-lg-12">
            <table id="tableAction">
                <tr>
            <th class="col-lg-4">User</th>
            <th class="col-lg-4">Action</th>
            <th class="col-lg-4">Time</th>
        
        </tr>
        <tr class="col-lg-12" id="logs">
            <?php foreach($logs as $l):?>
            <td class="col-lg-4 col-sm-12"><?=$l->nameUser?></td>
            <td class="col-lg-4 col-sm-12"><?=$l->nameAction?></td>
            <td class="col-lg-4 col-sm-12"><?=date("d.m.Y H:i:s",strtotime($l->date))?></td>
            <?php endforeach?>
            </tr>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="container">
                <div class="col-lg-12" id="accessPages">
                <table class="col-lg-12 col-sm-12" id="tableAcces">
                <tr>
                    <th class="col-lg-2 col-sm-12">Index</th>
                    <th class="col-lg-2 col-sm-12">Author</th>
                    <th class="col-lg-2 col-sm-12">Contact</th>
                    <th class="col-lg-2 col-sm-12">Card</th>
                    <th class="col-lg-2 col-sm-12">Product</th>
                    <th class="col-lg-2 col-sm-12">About</th>
                </tr>
                <tr>
                    <?php foreach($proc as $p):?>
                        <td class="col-lg-2 col-sm-12"><?=$p?>%</td>
                    <?php endforeach;?>
                </tr>
                </table>
                </div>
    </div>
</div>