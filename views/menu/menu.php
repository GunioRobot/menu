<?php if ($attr['before']!==FALSE) : echo $attr['before']; else :?>
<ul id="<?php echo $attr['id']?>" class="<?php echo $attr['class']?>">
<?php endif ?>
    <?php foreach ($menu as $item) :?>
    <li <?php if (!empty($item['current'])) : ?> class="selected current" <?php endif; !empty($item['attribute']) && print($item['attribute'])?>  >
        <a href="<?php echo url::site($item['uri'])?>"><?php echo __($item['text'])?></a>
    </li>
    <?php endforeach ?>
<?php echo ($attr['after']!==FALSE)?  $attr['after']:'</ul>';?>
