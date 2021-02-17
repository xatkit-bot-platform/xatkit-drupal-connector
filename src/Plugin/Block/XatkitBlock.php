<?php

namespace Drupal\xatkit\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Xatkit' block.
 *
 * @Block(
 *  id = "xatkit_block",
 *  admin_label = @Translation("Chatbot: Xatkit"),
 * )
 */
class XatkitBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'xatkit',
    ];
  }

}
