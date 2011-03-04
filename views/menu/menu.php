<ul id="<?php echo $attr['id']?>" class="<?php echo $attr['class']?>">
    <?php foreach ($menu as $item) :?>
    <li <?php if ($currentUri==$item['uri']) : ?>id="current" <?php endif?>><a href="<?php echo url::site($item['uri'])?>"><?php echo __($item['text'])?></a></li>
    <?php endforeach ?>
</ul>