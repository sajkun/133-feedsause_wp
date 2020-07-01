<?php

?>
<div class="cart-mini" id="fly-basket" v-bind:class="{'triggered': states.isTriggered, 'tapped': states.isShown, 'clicked': states.isShown}" data-cart='<?php echo json_encode($content)?>'>
  <a href="<?php echo $url ?>">
    <svg class="icon svg-icon-shopping-basket"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-shopping-basket"></use> </svg>
    <span class="counter">{{items_count}}</span>
  </a>

  <input type="hidden" value="<?php echo get_woocommerce_currency_symbol() ?>" ref="currency_symbol">

  <div class="cart-mini__dropdown" v-if="items_count > 0">
    <div class="cart-mini__dropdown-inner">
      <span class="cart-mini__tag">your cart</span>

      <div class="cart-mini__scroll">
        <div class="cart-mini__scroll-wrapper">
          <div class="cart-mini__item" v-for="(item, index) in items"  :key="index">
            <div class="row">
              <div class="col-9">
                <a href="" class="cart-mini__item-title">{{item.name}}</a>
              </div>
              <div class="col-3 textright">
                <span class="cart-mini__item-price"> {{format_price(item.price.line_total)}} </span>
              </div>
            </div><!-- row -->
            <span class="cart-mini__item-detail">
              <svg class="icon svg-icon-box"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-box"></use> </svg>
              {{item.count_items}} {{item.count_items === 1 ? 'Product' : 'Products'}}
            </span>
            <span class="cart-mini__item-detail">
              <svg class="icon svg-icon-items"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-items"></use> </svg>
              {{item.count_images}}  {{item.count_images === 1 ? 'Photo' : 'Photos'}}
            </span>
          </div><!-- cart-mini__item -->
        </div>
      </div>

      <div class="cart-mini__totals">
        <div class="row">
          <div class="col-7">
            <b>Total</b>
          </div>
          <div class="col-5 textright">
            <b ref="total_cart"><?php echo $total_cart?></b>
          </div>
        </div>
        <?php if ($add_ons): ?>
        <div class="" style="height: 5px"></div>
        <div class="row">
          <div class="col-7">
            Add-Ons
          </div>
          <div class="col-5 textright">
            <?php echo $add_ons?>
          </div>
        </div>
        <?php endif ?>

        <a href="<?php echo $url ?>" class="cart-mini__button">Review Order</a>
      </div>
    </div><!-- inner -->
  </div><!-- cart-mini__dropdown -->
</div>