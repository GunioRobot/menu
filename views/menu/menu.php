<?php if ($attr['before']!==FALSE) : echo $attr['before']; else :?>
<ul id="<?php echo $attr['id']?>" class="<?php echo $attr['class']?>">
<?php endif ?>
    <?php if (!empty($menu) && is_array($menu)) : foreach ($menu as $item) :?>
    <li <?php if (!empty($item['current'])) : ?> class="selected current" <?php endif; !empty($item['attribute']) && print($item['attribute'])?>  >
        <a href="<?php echo url::site(Arr::get($item, 'uri', '/')), $facebook->genFacebookParam(true)?>"><?php echo __($item['text'])?></a>
    </li>
    <?php endforeach; endif ?>
<?php echo ($attr['after']!==FALSE)?  $attr['after']:'</ul>';?>
