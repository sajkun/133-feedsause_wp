<p class="single-recipe__estimates">
  <input type="hidden" ref="days_offset" value="<?php echo $days_offset ?>">
  <input type="hidden" ref="ready_date" value="<?php echo $ready_date_full ?>">
  <input type="hidden" ref="limit_time" value="<?php echo date('Y-m-d 16:00:00 e '); ?>">
  <i class="icon-time"></i>
  <b><?php _e('Download your photos by','theme-translations'); ?> </b>

  <span class="date" v-if="!ready_date"><?php echo $ready_date; ?></span>
  <span class="date">{{ready_date_formatted}}</span>
  <br>
  <?php _e(' If you order within','theme-translations'); ?>
  <span class="time" v-if="!counter">
     -- hrs -- mins -- s
  </span>

  <span class="time">
    {{counter}}
  </span>
</p>

