<div class="row">
    <div class="container adminPage">
        <h1>Admin</h1>
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
        <button id="addNewProductBtn" class="btn">Add new Product</button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 modal" id="modalInsert">
        <div class="container">
            <div class="modal-content col-lg-12">
                 <span class="closeInsert">&times;</span>
                 <form id="anja" action="index.php?page=insert"  method="POST" enctype="multipart/form-data" class="alignerh">
                 <h3>INSERT</h3>
                 <span class="col-lg-12">
                    <input type="text" placeholder="Product name" name="name" id="name" class="update-item"/>
                </span>
                <span id="error-name" class="col-lg-12"></span>
                <span class="col-lg-12">
                    <input type="number" name="price" placeholder="Price" id="price" class="update-item"/>
                </span>
                <span id="error-price" class="col-lg-12"></span>
                <spam class="col-lg-12">
                <textarea name="productDes" id="productDes" cols="23" rows="1" placeholder="Product description..." class="update-item"></textarea>
                </spam>
                <span class="error-des col-lg-12"></span>
                <span class="col-lg-12">
                    <select id="ddlCat" class="update-item" name="ddlCat">
    
                    <option value="Select">Select</option>
                        <?php foreach($cat as $c):?>
                        <option value="<?=$c->idCat?>"><?=$c->nameCat?></option>
                        <?php endforeach?>
                    </select>
                </span>
                <span id="error-cat" class="col-lg-12"></span>
                <span class="col-lg-12">
                <input type="file" name="pic" id="pic" class="update-item"/>
                </span>
                <span id="error-pic" class="col-lg-12"></span>
                <span class="col-lg-12 divBtnUpdate">
                    <input type="submit" class="btn "name="btnInsertNew" id="btnInsertNew" value="Add new" class="update-item" />
                </span>
            </form>
          </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="updateForm" class="col-lg-12 modal">
        <div class="container">
            <div class="modal-content col-lg-12">
                <span class="closeUpdate">&times;</span>
                 <form action="index.php?page=update" method="POST" enctype="multipart/form-data" class="alignerh">
                 <h3>UDATE</h3>
                 <span class="col-lg-12">
                    <input type="text" placeholder="Product name" name="nameUpdate" id="nameUpdate" class="update-item"/>
                </span>
                <span id="error-name-update" class="col-lg-12"></span>
                <span class="col-lg-12">
                    <input type="number" name="priceUpdate" placeholder="Price" id="priceUpdate" class="update-item"/>
                </span>
                <span id="error-price-update" class="col-lg-12"></span>
                <spam class="col-lg-12">
                <textarea name="desUpdate" id="desUpdate" cols="23" rows="10" placeholder="Product description..."></textarea>
                </spam>
                <span class="col-lg-12">
                    <select id="ddlCatUpdate" class="update-item" name="ddlCatUpdate">
                    <option value="Select">Select</option>
                        <?php foreach($cat as $c):?>
                        <option value="<?=$c->idCat?>"><?=$c->nameCat?></option>
                        <?php endforeach?>
                    </select>
                </span>
                <span id="error-cat-update" class="col-lg-12"></span>
                <span class="col-lg-12">
                <input type="file" name="picUpdate" id="picUpdate"/>
                </span>
                <span id="error-pic-update" class="col-lg-12"></span>
                <span class="col-lg-12 divBtnUpdate">
                    <input type="submit" name="btnUpdate" id="btnUpdate" value="Update" class="btnUpdate btn"/>
                </span>
                <input type="hidden" name="idProductUpdate" id="idProductUpdate"/>
            </form>
            
          </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="container">
        <div class="col-lg-12" id="allProductsAdmin">
        <?php foreach($products as $p):?>
                    <div class="col-lg-12 oneProdAdmin">
                        <div class="col-lg-2 col-sm-12 admin">
                            <img class="col-lg-12" src="assets/images/<?=$p->picture?>" alt="<?=$p->nameProduct?>">
                        </div>
                        <div class="col-lg-2 col-sm-12 admin descAdmin"><?=$p->description?></div>
                        <div class="col-lg-2 col-sm-12 admin"><?=$p->nameProduct?></div>
                        <div class="col-lg-2 col-sm-12 admin"><?=$p->nameCat?></div>
                        <div class="col-lg-2 col-sm-12 admin">$<?=$p->price?>.00</div>
                        <div class="col-lg-2 col-sm-12 admin">
                            <button class="deleteProduct btn" data-id="<?=$p->idProduct?>">Delete</button>
                            <button class="editProduct btn" data-obj='<?= \json_encode($p)?>'>Edit</button>
                        </div>
                    </div>
                <?php endforeach?>
        </div>
    </div>
</div>
