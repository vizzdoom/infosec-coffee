<?php ?>
<section class="page-section">
  <div class="container">
    <div class="product-item">
      <div class="product-item-title d-flex">
        <div class="bg-faded p-5 d-flex mr-auto rounded">
          <h2 class="section-heading mb-0">
            <span class="section-heading-upper">Delicious Treats, Good Eats</span>
            <span class="section-heading-lower">Bakery &amp; Kitchen</span>
          </h2>
        </div>
      </div>
      <img class="product-item-img mx-auto d-flex rounded img-fluid mb-3 mb-lg-0" src="img/products-02.jpg" alt="">
      <div class="product-item-description d-flex ml-auto">
        <div class="bg-faded p-5 rounded">
          <p class="mb-0">Our seasonal menu features delicious snacks, baked goods, and even full meals perfect for breakfast or lunchtime. We source our ingredients from local, oragnic farms whenever possible, alongside premium vendors for specialty goods.</p>
            <div class="text-center">
                <br/>
                <span class="section-heading-upper"><strong>Add to cart</strong></span>
                <hr/>
                <?php
                $productList = Storage::getInstance()->bakeryProducts;
                foreach ($productList as $product){
                    echo "<a href='?page=account&action=add&id={$product->id}'><input class='btn btn-warning' type='submit' value='{$product->getDescription()}'></a><br/><br/>";
                }
                ?>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="page-section">
  <div class="container">
    <div class="product-item">
      <div class="product-item-title d-flex">
        <div class="bg-faded p-5 d-flex ml-auto rounded">
          <h2 class="section-heading mb-0">
            <span class="section-heading-upper">From Around the World</span>
            <span class="section-heading-lower">Bulk Speciality Blends</span>
          </h2>
        </div>
      </div>
      <img class="product-item-img mx-auto d-flex rounded img-fluid mb-3 mb-lg-0" src="img/products-03.jpg" alt="">
      <div class="product-item-description d-flex mr-auto">
        <div class="bg-faded p-5 rounded">
          <p class="mb-0">Travelling the world for the very best quality coffee is something take pride in. When you visit us, you'll always find new blends from around the world, mainly from regions in Central and South America. We sell our blends in smaller to large bulk quantities. Please visit us in person for more details.</p>
            <div class="text-center">
                <br/>
                <span class="section-heading-upper"><strong>Add to cart</strong></span>
                <hr/>
                <?php
                $productList = Storage::getInstance()->beansProducts;
                foreach ($productList as $product){
                    echo "<a href='?page=account&action=add&id={$product->id}'><input class='btn btn-warning' type='submit' value='{$product->getDescription()}'></a><br/><br/>";
                }
                ?>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>