<?php

namespace Drupal\cactus_main\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;
use Drupal\field\Entity\FieldConfig;

/**
 * Provides a 'Article: category' Block.
 *
 * @Block(
 *   id = "article_category",
 *   admin_label = @Translation("Article: category"),
 *   category = @Translation("Cactus"),
 * )
 */
class ArticleCategoryBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    /** @var \Drupal\node\Entity\Node $node */
    $node = \Drupal::routeMatch()->getParameter('node');

    if (!$node) {
      return '';
    }

    $category = $node->get('field_category')->value;
    $field_category = FieldConfig::loadByName('node', 'article', 'field_category');
    $values = $field_category->getSetting('allowed_values');

    return [
      '#cache' => [
        'contexts' => ['route'],
        'tags' => ['node:' . $node->id()],
      ],
      '#markup' => Markup::create('<a href="/' . str_replace('_', '-', $category) . '">' . $values[$category] . '</a>'),
      '#attributes' => [
        'class' => ['article__category', $category],
      ],
    ];
  }

}
