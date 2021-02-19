<?php

namespace Drupal\xatkit\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal;

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
    $config = \Drupal::service('config.factory')->getEditable('xatkit.settings');
    return [
      '#type' => 'html',
      '#theme' => 'xatkit',
      '#attached' => [
        'library' => [
          'xatkit/xatkit-assets',
        ],
        'drupalSettings' => [
          'xatkit' => [
            'server' => $config->get('xatkit.serverUrl'),
            'title' => $config->get('xatkit.windowTitle'),
            'subtitle' => $config->get('xatkit.windowSubtitle'),
          ],
        ],
      ],
    ];
  }

}
