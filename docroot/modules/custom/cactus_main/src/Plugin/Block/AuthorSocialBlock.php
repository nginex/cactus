<?php

namespace Drupal\cactus_main\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Link;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use Drupal\field\Entity\FieldConfig;
use Drupal\file\Entity\File;

/**
 * Provides a 'Article: social' Block.
 *
 * @Block(
 *   id = "author_social",
 *   admin_label = @Translation("Author: social"),
 *   category = @Translation("Cactus"),
 * )
 */
class AuthorSocialBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    /** @var \Drupal\node\Entity\Node $node */
    $node = \Drupal::routeMatch()->getParameter('node');

    if (!$node) {
      return '';
    }

    $items = [];

    if ($email = $node->get('field_email')->value) {
      $url = Url::fromUri('mailto:' . $email, [
        'attributes' => [
          'class' => [
            'social-item',
            'email',
          ],
          'title' => t('Send email to the author'),
        ],
      ]);
      $items[] = Link::fromTextAndUrl(t('Email'), $url)->toString();
    }

    $social = [
      '#theme' => 'item_list',
      '#items' => $items,
    ];

    return [
      '#cache' => [
        'contexts' => ['route'],
        'tags' => ['node:' . $node->id()],
      ],
      '#markup' => render($social),
      '#attributes' => [
        'class' => ['author__social'],
      ],
    ];
  }

}
