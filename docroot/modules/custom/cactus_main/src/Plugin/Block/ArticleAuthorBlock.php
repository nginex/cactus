<?php

namespace Drupal\cactus_main\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;

/**
 * Provides a 'Article: category' Block.
 *
 * @Block(
 *   id = "article_author_and_date",
 *   admin_label = @Translation("Article: author and date"),
 *   category = @Translation("Cactus"),
 * )
 */
class ArticleAuthorBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    /** @var \Drupal\node\Entity\Node $node */
    $node = \Drupal::routeMatch()->getParameter('node');

    if (!$node) {
      return '';
    }

    /** @var \Drupal\node\Entity\Node $author */
    $authors = $node->get('field_authors')->getValue();
    $authors = array_column($authors, 'target_id');

    /** @var \Drupal\node\Entity\Node[] $authors_nodes */
    $authors_nodes = Node::loadMultiple($authors);
    $authors_items = [];
    foreach ($authors_nodes as $authors_node) {
      $item = [];
      $image = File::load($authors_node->get('field_photo')->target_id);
      $image = [
        '#theme' => 'image_style',
        '#style_name' => '200x200sc',
        '#uri' => $image->getFileUri(),
      ];

      $item['image'] = $authors_node->toLink(render($image))->toRenderable();
      $item['image']['#attributes']['class'][] = 'author__image';
      $item['name'] = $authors_node->toLink()->toRenderable();

      $authors_items[] = render($item);
    }

    $output = [];
    $output['authors'] = [
      '#theme' => 'item_list',
      '#items' => $authors_items,
    ];
    $output['date'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => date('d F, Y', $node->getCreatedTime()),
      '#attributes' => [
        'class' => ['article__date'],
      ],
    ];

    return [
      '#markup' => '',
      '#cache' => [
        'contexts' => ['route'],
        'tags' => ['node:' . $node->id()],
      ],
      '#attributes' => [
        'class' => ['article__authors-and-date'],
      ],
      'output' => $output,
    ];
  }

}
