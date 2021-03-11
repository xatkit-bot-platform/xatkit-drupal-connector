<?php

namespace Drupal\xatkit\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Config\ConfigFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Provides a 'Xatkit' block.
 *
 * @Block(
 *  id = "xatkit_block",
 *  admin_label = @Translation("Chatbot: Xatkit"),
 * )
 */
class XatkitBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Configuration state Drupal Site.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;
  /**
   * File Usage serivce.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Construct method.
   */
  public function __construct(ConfigFactory $configFactory, EntityTypeManager $entity_type_manager) {
    $this->configFactory = $configFactory;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Create method.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('config.factory'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->getEditable('xatkit.settings');
    $xatkitSettings = [
      'server' => $config->get('xatkit.serverUrl'),
      'title' => $config->get('xatkit.windowTitle'),
      'subtitle' => $config->get('xatkit.windowSubtitle'),
    ];
    // If alternative logo is set.
    $altLogo = $config->get('xatkit.altLogo');
    if ($altLogo) {
      $file = $this->entityTypeManager->getStorage('file')->load($altLogo[0]);
      $imageUrl = file_create_url($file->getFileUri());
      if (!empty($imageUrl)) {
        $xatkitSettings['profileAvatar'] = $imageUrl;
        $xatkitSettings['launcherImage'] = $imageUrl;
      }
    }
    // Attach settings and libraries to the block.
    return [
      '#type' => 'html',
      '#theme' => 'xatkit',
      '#variables' => [
        'color' => $config->get('xatkit.color'),
        'left' => $config->get('xatkit.rtl'),
      ],
      '#attached' => [
        'library' => [
          'xatkit/xatkit-assets',
          'xatkit/xatkit-widget',
        ],
        'drupalSettings' => [
          'xatkit' => $xatkitSettings,
        ],
      ],
    ];
  }

}
