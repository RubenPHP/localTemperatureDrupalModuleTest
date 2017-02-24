<?php

namespace Drupal\local_temperature\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Local Temperature' block.
 *
 * @Block(
 *   id = "local_temperature_block",
 *   admin_label = @Translation("Local Temperature Block"),
 *   category = @Translation("Custom")
 * )
 */

class TemperatureBlock extends BlockBase
{

    const DEFAULT_XML_TEMPERATURE_URL = 'http://www.aemet.es/xml/municipios/localidad_07009.xml';

    /**
     * Builds and returns the renderable array for this block plugin.
     *
     * If a block should not be rendered because it has no content, then this
     * method must also ensure to return no content: it must then only return an
     * empty array, or an empty array with #cache set (with cacheability metadata
     * indicating the circumstances for it being empty).
     *
     * @return array
     *   A renderable array representing the content of the block.
     *
     * @see \Drupal\block\BlockViewBuilder
     */
    public function build()
    {
        return array(
            '#theme' => 'local_temperature',
            '#icon' => 'icono bonito',
            '#current_temperature' => '66 C'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form = parent::blockForm($form, $form_state);
        $config = $this->getConfiguration();
        $form['xml_file_url'] = array(
            '#type' => 'textfield',
            '#title' => t('XML file'),
            '#default_value' => isset($config['xml_file_url']) ? $config['xml_file_url'] : self::DEFAULT_XML_TEMPERATURE_URL,
            '#description' => t('XML File URL.'),
        );
        return $form;
    }

    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->setConfigurationValue('xml_file_url', $form_state->getValue('xml_file_url'));
    }
}