<?php
/**
 * @file
 * Display an appropriate icon for a forum post.
 *
 * Available variables:
 * - $new_posts: Indicates whether or not the topic contains new posts.
 * - $icon: The icon to display. May be one of 'hot', 'hot-new', 'new',
 *   'default', 'closed', or 'sticky'.
 * - $node_type: The type of the node that is displayed
 *
 * @see template_preprocess_forum_icon()
 * @see advanced_forum_preprocess_forum_icon()
 */
?>
<?php if ($new_posts): ?><a name="new"><?php endif; ?>

<?php if (!empty($icon)): ?>
  <?php print $icon; ?>
<?php endif; ?>

<?php if ($new_posts): ?></a><?php endif; ?>
