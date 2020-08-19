<div class="container">

</div>


<div class="row">
    <div class="container">
        <div class="col-lg-12" id="productDetails">
        <?php foreach($data as $d):?>
            <div class="col-lg-6 col-sm-12 picture">
                <img src="assets/images/<?=$d->picture?>" alt="" class="col-lg-12">
            </div>
            <div class="col-lg-6 col-sm-12 detail-text">
                <h2><?=$d->nameProduct?></h2>
                <p class="detail-price">$<?=$d->price?>.99</p>
                <p class="detail-description"><?=$d->description?></p>
                <button data-id="<?=$d->idProduct?>" class="btnAddToCart"><i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i>Add To Cart</button>
                <p class="categories"><i class="categoriesName">Categories:</i> All, <?=$d->nameCat?></p>
            </div>
            <?php endforeach?>
        </div>
    </div>
</div>


<!-- Trigger/Open The Modal -->


<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="col-lg-12" id="productDetails">
        <?php foreach($data as $d):?>
            <div class="col-lg-6 col-sm-12 picture">
                <img src="assets/images/<?=$d->picture?>" alt="" class="col-lg-12">
            </div>
            <div class="col-lg-6 col-sm-12 detail-text">
                <h2><?=$d->nameProduct?></h2>
                <p class="detail-price">$<?=$d->price?>.99</p>
                <p class="detail-description"><?=$d->description?></p>
                <button data-id="<?=$d->idProduct?>" class="btnAddToCart"><i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i>Add To Cart</button>
                <p class="categories"><i class="categoriesName">Categories:</i> All, <?=$d->nameCat?></p>
            </div>
            <?php endforeach?>
        </div>
  </div>

</div>
