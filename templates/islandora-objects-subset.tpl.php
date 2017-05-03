<?php

/**
 * @file
 * Render a bunch of objects in a list or grid view.
 */
?>
<div class="islandora-basic-collection-wrapper">
  <div class="islandora-object-info-wrapper">

    <?php if (isset($collection_image_ds)): ?>
      <div class="collection-image-wrapper" style="background-image: url(/islandora/object/<?php print urlencode($islandora_object->id); ?>/datastream/<?php print $collection_image_ds;?>/view); background-size: cover; background-repeat: no-repeat; background-position: center;"></div>
    <?php endif; ?>

    <?php if (isset($islandora_latest_objects)): ?>
      <div class="collection-latest-objects-wrapper"><h1 class="title">Most Viewed</h1><?php print $islandora_latest_objects; ?></div>
    <?php endif; ?>

    <?php if (isset($meta_description)): ?>
      <div class="collection-description-wrapper">
        <h1><?php print t("About This Collection"); ?></h1>
        <p><?php print $meta_description; ?></p>
      </div>
    <?php endif; ?>

  </div>

  <div class="islandora-objects clearfix islandora-basic-collection">
    <span class="islandora-objects-display-switch islandora-basic-collection-display-switch">
      <ul class="links inline ul-display-switch">
        <?php foreach ($display_links as $link): ?>
        <li>
          <a <?php print drupal_attributes($link['attributes']) ?> href="<?php print $link['href'];?>" title="<?php print filter_xss($link['title']) ?>"><?php print filter_xss($link['title']) ?></a>
        </li>
        <?php endforeach ?>
      </ul>
    </span>
    <?php print $pager; ?>
    <?php print $content; ?>
    <?php print $pager; ?>
  </div>
</div>
