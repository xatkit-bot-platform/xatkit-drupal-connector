<?php

namespace Drupal\xatkit\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\file\Entity\File;

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

    $xatkitSettings = [
      'server' => $config->get('xatkit.serverUrl'),
      'title' => $config->get('xatkit.windowTitle'),
      'subtitle' => $config->get('xatkit.windowSubtitle'),
    ];

    $image = $config->get('xatkit.altLogo');
    $file = File::load($image[0]);
    $imageUrl = file_create_url($file->getFileUri());

    if (!empty($imageUrl)) {
      $xatkitSettings['profileAvatar'] = $imageUrl;
      $xatkitSettings['launcherImage'] = $imageUrl;
    }
    kint($xatkitSettings);
    return [
      '#type' => 'html',
      '#theme' => 'xatkit',
      '#attached' => [
        'library' => [
          'xatkit/xatkit-assets',
        ],
        'drupalSettings' => [
          'xatkit' => $xatkitSettings,
        ],
      ],
    ];
  }

}
