<div class="row">
    <div class="container adminPage">
        <div class="col-lg-12 razmak" id="allProductsCard">
        <h2>Product in cart</h2>   
        <?php foreach($products as $prod):?>
                    <div class="col-lg-4 col-md-4 col-sm-12 oneProduct">
                        <div class="col-lg-12">
                            <img src="assets/images/<?=$prod->picture?>" class="imgProduc col-lg-12">
                        </div>
                        
                        <div class="col-lg-12 namePrice">
                            <p><?=$prod->nameProduct?></p>
                            <p class="price">$ <?=$prod->price?>.00</p>
                        </div>
                        <div class="col-lg-12 details" id="viewLink">
                            <button class="btnRemoveCard" data-id="<?=$prod->idCart?>">Remove</button>
                        </div>
                    </div>
            <?php endforeach?>
        </div>
    </div>
</div>