<?php
/**
 * @file
 * Returns the HTML for the footer region.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728140
 */
?>

<div id="branding" class="branding branding-top <?php print $classes; ?>">
  <div class="limiter">
    <div class="branding-wrapper">
      <a href="<?php print $branding_text_link; ?>" target="_blank">
        <span id="branding_text_left">
          <?php print $branding_text_left; ?>
        </span>
        <span id="branding_text_right">
          <?php print $branding_text_right; ?>
        </span>
      </a>
    </div>
    <div class="branding-button-wrapper">
      <span>
      <a class="btn btn-primary btn-block" href="http://uconn.edu/search">
        <img alt="Search Site Icon" src="/<?php print(path_to_theme());?>/images/icon_search.gif">
      </a>
      </span>
      <span>
        <a class="btn btn-primary btn-block letters" href="http://uconn.edu/azindex.php">
          <img alt="A to Z Index Icon" src="/<?php print(path_to_theme());?>/images/icon_az.gif">
        </a>
      </span>
    </div>
    <?php if ($content): ?>
      <?php print $content; ?>
    <?php endif; ?>
  </div>
</div>
