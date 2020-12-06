<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>

<h3>Tracker Settings</h3>
<form action="<?php echo admin_url('options-general.php?page=duh_tracker_settings')?>" method="POST">

    <?php
      $checked = 'checked="checked"';
      foreach ($tabs as $tab_id => $tab_name) {
        printf('<input type="radio" name="active-page" id="%s" %s class="duh-hide-check">', $tab_id, $checked);
        $checked ='';
      }
    ?>
    <ul class="duh-tabs">
      <?php
      foreach ($tabs as $tab_id => $tab_name) {
        printf('<li> <label for="%s"> %s </label> </li>', $tab_id, $tab_name);
        $checked ='';
      }
      ?>
    </ul>

  <!-- *******************************
      GENERAL SETTINGS
    **********************************-->
    <div class="duh-page-settings-content general">
      <h3> Tracker page: </h3>
      <select name="<?php echo $slug ?>[tracker_page]">
        <?php foreach ($pages as $key => $p): ?>
          <option
            value="<?php echo $p->ID ?>"
            <?php echo isset($options['tracker_page']) && $p->ID == (int)$options['tracker_page']? 'selected="selected"': ''; ?>
            ><?php echo $p->post_title ?></option>
        <?php endforeach ?>
      </select>

      <h3> Studio page: </h3>
      <select name="<?php echo $slug ?>[studio_page]">
        <?php foreach ($pages as $key => $p): ?>
          <option
            value="<?php echo $p->ID ?>"
            <?php echo isset($options['studio_page']) && $p->ID == (int)$options['studio_page']? 'selected="selected"': ''; ?>
            ><?php echo $p->post_title ?></option>
        <?php endforeach ?>
      </select>

      <h3> Feedsauce’s Shoot Standards Page: </h3>
      <select name="<?php echo $slug ?>[standarts]">
        <?php foreach ($pages as $key => $p): ?>
          <option
            value="<?php echo $p->ID ?>"
            <?php echo isset($options['standarts']) && $p->ID == (int)$options['standarts']? 'selected="selected"': ''; ?>
            ><?php echo $p->post_title ?></option>
        <?php endforeach ?>
      </select>

      <div class="spacer-h-20"></div>

      <h3>Delivery:</h3>

      <table>
        <tr>
          <th>Fattrack: </th>
          <td><input type="number" name="<?php echo $slug ?>[turnaround][fasttrack]" value="<?php echo $options['turnaround']['fasttrack'] ?:''; ?>"></td>
          <td>days</td>
        </tr>
        <tr>
          <th>Regular: </th>
          <td><input type="number" name="<?php echo $slug ?>[turnaround][regular]" value="<?php echo $options['turnaround']['regular'] ?:''; ?>"></td>
          <td>days</td>
        </tr>
      </table>

      <div class="spacer-h-30"></div>
      <input type="submit" value="save" class="btn">
    </div><!-- general -->
  <!-- *******************************
     END  GENERAL SETTINGS
    **********************************-->

  <!-- *******************************
      ORDER SETTINGS
    **********************************-->
    <div class="duh-page-settings-content orders">

      <h4>Order Status after Creator started shoot</h4>

      <select name="<?php echo $slug ?>[orders_misc][shoot]">
        <?php  foreach ($order_statuses as $order_id => $order):
            $selected  = $order['slug'] == $options['orders_misc']['shoot'] ? 'selected ="selected"' : '';
            printf('<option value="%s" %s >%s</option>', $order['slug'], $selected, is_array($order)? $order['name'] : $order );
          ?>

        <?php endforeach ?>
      </select>

      <h4>Order Status after photos were uploaded</h4>

      <select name="<?php echo $slug ?>[orders_misc][uploaded]">
        <?php  foreach ($order_statuses as $order_id => $order):
            $selected  = $order['slug'] == $options['orders_misc']['uploaded']? 'selected ="selected"': '';
            printf('<option value="%s" %s >%s</option>', $order['slug'], $selected, is_array($order)? $order['name'] : $order );
          ?>

        <?php endforeach ?>
      </select>

      <div class="spacer-h-20"></div>
      <input type="submit" value="save" class="btn btn-primary">
      <div class="spacer-h-20"></div>

      <div class="flex" id="order-list-sort">
        <?php
         $counter = 0;
         foreach ($order_statuses as $order_id => $order):
          $order_id = $order['slug'];
         ?>
          <div class="block-item highlighted-field">
            <input type="hidden"
             name="<?php echo $slug ?>[orders][<?php echo $order_id ?>][slug]"
             value="<?php echo $order_id ?>">

            <input type="hidden"
              name="<?php echo $slug ?>[orders][<?php echo $order_id ?>][name]"
              value="<?php echo is_array($order)? $order['name'] : $order ?>"
              >
            <h3><?php echo is_array($order)? $order['name'] : $order ?></h3>

            <input type="hidden" name="<?php echo $slug ?>[orders][<?php echo $order_id ?>][order]" class="order" value="<?php echo $counter; ?>">

            <table class="duh-table-settings">
              <tr>
                <th>Tag Color: </th>
                <td>
                  <input type="text" class="color-field"  name="<?php echo $slug ?>[orders][<?php echo $order_id ?>][bg_color]" value="<?php echo $options ['orders'][$order_id]['bg_color']?: ''; ?>">
                </td>
              </tr>
              <tr>
                <th>Text Color: </th>
                <td>
                  <input type="text" class="color-field"  name="<?php echo $slug ?>[orders][<?php echo $order_id ?>][text_color]" value="<?php echo $options ['orders'][$order_id]['text_color']?: ''; ?>">
                </td>
              </tr>
              <tr>
                <th>Use on Frontdesk page</th>
                <td>
                  <input type="hidden" value="no" name="<?php echo $slug ?>[orders][<?php echo $order_id ?>][is_frontdesk]" >
                  <input
                   type="checkbox"
                   name="<?php echo $slug ?>[orders][<?php echo $order_id ?>][is_frontdesk]"
                   value="yes"
                   <?php echo 'yes' == $options['orders'][$order_id]['is_frontdesk']? 'checked="checked"' : ''; ?>
                   >
                </td>
              </tr>
              <tr>
                <th>Use on Studio page</th>
                <td>
                  <input type="hidden" value="no" name="<?php echo $slug ?>[orders][<?php echo $order_id ?>][is_studio]" >

                  <input
                   type="checkbox"
                   name="<?php echo $slug ?>[orders][<?php echo $order_id ?>][is_studio]"
                   value="yes"
                   <?php echo 'yes' == $options['orders'][$order_id]['is_studio']? 'checked="checked"' : ''; ?>
                   >
                </td>
              </tr>
            </table>
          </div>

        <?php
        $counter++;
          endforeach ?>
      </div>
      <input type="submit" value="save" class="btn btn-primary">
    </div><!-- orders -->
  <!-- *******************************
      END ORDER SETTINGS
    **********************************-->

  <!-- *******************************
      campaigns, brands, sourses
    **********************************-->
    <div class="duh-page-settings-content extra_data">
      <div class="flex">
        <div class="item-lg">
          <h3>Sources</h3>
          <textarea class="fullwidth" name="<?php echo $slug ?>[sources]" rows="10"><?php echo isset($options['sources'])? $options['sources'] : ''; ?></textarea>
          <i>Place every item on a new row</i>
        </div><!-- item-lg -->

        <div class="item-lg">
          <h3>Campaigns</h3>
          <textarea name="<?php echo $slug ?>[campaigns]" class="fullwidth" rows="10"><?php echo isset($options['campaigns'])? $options['campaigns'] : ''; ?></textarea>
          <i>Place every item on a new row</i>
        </div><!-- item-lg -->
      </div><!-- flex -->

      <div class="spacer-h-20"></div>
      <input type="submit" value="save" class="btn btn-primary">
    </div><!-- extra_data -->
  <!-- *******************************
      campaigns, brands, sourses
      END
    **********************************-->

  <!-- *******************************
      roles
    **********************************-->
    <div class="duh-page-settings-content roles">
      <div class="flex">
        <div class="item-lg">
          <h3>Selects Users' Roles for personal list</h3>

          <ul class="columns-2">
          <?php  foreach ($roles  as $role_id => $role) {
            $checked = isset($options['user_roles_to_use']) && in_array($role_id, $options['user_roles_to_use'])?
            'checked="checked"' : '';
            printf('<li><label><input type="hidden" name="%2$s[user_roles_to_use][%1$s]" value="">', $role_id,  $slug);
            printf('<label><input type="checkbox" name="%4$s[user_roles_to_use][%1$s]" value="%1$s" %2$s>%3$s</label></li>', $role_id, $checked, $role['name'], $slug);
          }?>
          </ul>
        </div>
        <div class="item-lg">
            <h3>Selects Users' Roles for Creatives</h3>

            <ul class="columns-2">
            <?php  foreach ($roles  as $role_id => $role) {
              $checked = isset($options['user_roles_to_use_creative']) && in_array($role_id, $options['user_roles_to_use_creative'])?
              'checked="checked"' : '';

              printf('<li><label><input type="hidden" name="%2$s[user_roles_to_use_creative][%1$s]" value="">', $role_id,  $slug);
              printf('<label><input type="checkbox" name="%4$s[user_roles_to_use_creative][%1$s]" value="%1$s" %2$s>%3$s</label></li>', $role_id, $checked, $role['name'], $slug);
            }?>
            </ul>
          </div>
        </div>

        <div class="spacer-h-20"></div>
        <input type="submit" value="save" class="btn btn-primary">
      </div>
  <!-- *******************************
      roles
      END
    **********************************-->

  <!-- *******************************
      dropbox
    **********************************-->
    <div class="duh-page-settings-content dropbox">
      <h3>Access token</h3>
      <input type="text" class="fullwidth" name="<?php echo $slug?>[dropbox][token]" value="<?php echo isset( $options['dropbox']['token'])? $options['dropbox']['token'] : ''; ?>">

      <div class="spacer-h-20"></div>
      <input type="submit" value="save" class="btn btn-primary">
    </div>
  <!-- *******************************
      dropbox
      END
    **********************************-->

    <div class="duh-page-settings-content frontdesk">
      <input type="submit" value="save" class="btn btn-primary">
    </div><!-- frontdesk -->


    <input type="hidden" value="yes" name="do_save">

</form>