<div class="row">
    <div class="container adminPage">
        <h1>Orders</h1>
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
        <div class="col-lg-12" id="newOrder">
        <h4 class="col-lg-12">Inser new order</h4>
            <form action="index.php?page=addOrder" method="POST">
                <select name="ddlUser" id="ddlUser" class="col-lg-4">
                    <option value="Select">Select user</option>
                    <?php foreach($users as $user):?>
                        <option value="<?=$user->idUser?>"><?=$user->fullName?></option>
                    <?php endforeach?>
                </select>
                <select name="ddlProduct" id="ddlProduct" class="col-lg-4">
                    <option value="Select">Select product</option>
                    <?php foreach($prod as $p):?>
                        <option value="<?=$p->idProduct?>"><?=$p->nameProduct?></option>
                    <?php endforeach?>
                    <input type="submit" name="btnAddNewOrder" id="btnAddNewOrder" value="Add new order" class="col-lg-3">
                </select>
            </form>
            <p id="error-name" class="col-lg-4 col-sm-12"></p>
            <p id="error-prod" class="col-lg-4 col-sm-12"></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="container">
        <div class="col-lg-12" id="allOrders">
            <table id="tableOrders">
                <tr id="zaglavlje">
                    <th class="col-lg-3">User</th>
                    <th class="col-lg-3">Product</th>
                    <th class="col-lg-3">Date</th>
                    <th class="col-lg-3">Delte</th>
                </tr>
            <tr id="oneOrder">
                <?php foreach($orders as $order):?>
                    <td class="col-lg-3 col-sm-12"><?=$order->fullName?></td>
                    <td class="col-lg-3 col-sm-12"><?=$order->nameProduct?></td>
                    <td class="col-lg-3 col-sm-12"><?= date("d.m.Y",strtotime($order->date))?></td>
                    <td class="col-lg-3 col-sm-12"><button class="btnDeleteOrder" data-id="<?=$order->idCart?>">Delete</button></td>
                <?php endforeach?>

                </tr>
                </table>
        </div>
    </div>
</div>
