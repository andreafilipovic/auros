
</div>
<div class="row">
    <div class="container homeProduct">
        <div class="col-lg-6 col-sm-12 col-md-12 productDesignCat"><h1>New design</h1></div>
        <div class="col-lg-6 col-sm-12 col-md-12 productDesignCat" id="categoryProdact">
            <ul id="meniCat">
                <?php
                    foreach($categories as $cat):?>
                <li class="item-cat"><a href="index.php?catId=<?=$cat->idCat?>" data-id="<?=$cat->idCat?>"><?=$cat->nameCat?></a></li>
                <?php endforeach?>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="container"> 
        <div class="col-lg-12 productDesignCat" id="sort">
            <p>Sort by price:</p>
            <select name="ddlSort" id="ddlSort">
            <option value="Select">Select</option>
                <option value="ASC">Low to high</option>
                <option value="DESC">High to low</option>
            </select>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div id="products" class="col-lg-12">
                    
                    <?php foreach($products as $prod):?>
                    <div class="col-md-12 col-sm-12 oneProduct polaroid">
                        <div class="col-lg-12">
                            <img src="assets/images/<?=$prod->picture?>" class="imgProduc col-lg-12">
                        </div>
                        <!-- <div class="col-12 polaroid-text"> -->
                            <div class="col-lg-12 namePrice">
                                <p><?=$prod->nameProduct?></p>
                                <p class="price">$<?=$prod->price?>.00</p>
                            </div>
                            <div class="col-lg-12 details" id="viewLink">
                                <a href="index.php?page=product&id=<?=$prod->idProduct?>" class="btnView">View</a>
                                <!-- <button class="myBtnOneProduct" data-id="">View</button> -->
                            </div>
                    <!-- </div> -->
                    </div>
                    <?php endforeach?>
        </div>         
    </div>
</div>
