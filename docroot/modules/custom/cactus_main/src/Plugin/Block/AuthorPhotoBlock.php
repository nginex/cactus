<?php

namespace Drupal\cactus_main\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\file\Entity\File;

/**
 * Provides a 'Article: photo' Block.
 *
 * @Block(
 *   id = "author_photo",
 *   admin_label = @Translation("Author: photo"),
 *   category = @Translation("Cactus"),
 * )
 */
class AuthorPhotoBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    /** @var \Drupal\node\Entity\Node $node */
    $node = \Drupal::routeMatch()->getParameter('node');

    if (!$node) {
      return '';
    }

    $image = File::load($node->get('field_photo')->target_id);

    $image = [
      '#theme' => 'image_style',
      '#style_name' => '200x200sc',
      '#uri' => $image->getFileUri(),
    ];

    return [
      '#cache' => [
        'contexts' => ['route'],
        'tags' => ['node:' . $node->id()],
      ],
      '#markup' => render($image),
      '#attributes' => [
        'class' => ['author__photo'],
      ],
    ];
  }

}
