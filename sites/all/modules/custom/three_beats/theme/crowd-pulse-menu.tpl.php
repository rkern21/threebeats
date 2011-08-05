<?php
    $sql = db_query("SELECT * FROM `term_data` as td WHERE td.vid = 1");

?>
<styl>
    <div class="crowd-pulse">
        <div class="left crowd-pulse-header">
            <h1><?php echo t('Crowd Pulse'); ?></h1>
        </div>
        <div class="left crowd-pulse-menu">
            <ul>
	            <li  class="crowd-pulse-menu-all">
                    <a alt="all" href="javascript:void(0);" class="crowd_pulse_menu_item <?php print arg(1) ? '' : 'activetab'?>">All</a>
                </li>
                <?php
                    while ($row = db_fetch_object($sql)):
                   $color = variable_get('category_color_'.$row->tid,'#ffec09');
                   $class = variable_get('category_class_'.$row->tid,'crowd-pulse-menu-all')
                ?>
                    <li  class="<?php print $class ?>">
                        <a alt="<?php print($row->tid); ?>" href="javascript:void(0);" class="crowd_pulse_menu_item <?php print (arg(0) == 'home' && arg(1) == $row->tid) ? 'activetab' : ''; ?>"><?php print t($row->name); ?></a>
                    </li>
                <?php
                    endwhile;
                ?>
            </ul>
        </div>
        <div class="clear"></div>
    </div>


