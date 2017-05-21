<?php

namespace Drupal\uikit_components\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;
use Drupal\Component\Utility\Html;

/**
 * Style plugin to render each item in a UIkit Grid component.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "uikit_view_grid",
 *   title = @Translation("UIkit Grid"),
 *   help = @Translation("Displays rows in a UIkit Grid component"),
 *   theme = "uikit_view_grid",
 *   display_types = {"normal"}
 * )
 */
class UIkitViewGrid extends StylePluginBase {
  /**
   * Overrides \Drupal\views\Plugin\views\style\StylePluginBase::usesRowPlugin.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * Overrides \Drupal\views\Plugin\views\style\StylePluginBase::usesRowClass.
   *
   * @var bool
   */
  protected $usesRowClass = TRUE;

  /**
   * Return the token-replaced row or column classes for the specified result.
   *
   * @param int $result_index
   *   The delta of the result item to get custom classes for.
   * @param string $type
   *   The type of custom grid class to return, either "row" or "col".
   *
   * @return string
   *   A space-delimited string of classes.
   */
  public function getCustomClass($result_index, $type) {
    if (isset($this->options[$type . '_class_custom'])) {
      $class = $this->options[$type . '_class_custom'];
      if ($this->usesFields() && $this->view->field) {
        $class = strip_tags($this->tokenizeValue($class, $result_index));
      }

      $classes = explode(' ', $class);
      foreach ($classes as &$class) {
        $class = Html::cleanCssIdentifier($class);
      }
      return implode(' ', $classes);
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    // Default grid view options.
    $options['columns'] = ['default' => '4'];
    $options['automatic_width'] = ['default' => TRUE];
    $options['alignment'] = ['default' => 'horizontal'];
    $options['col_class_custom'] = ['default' => ''];
    $options['col_class_default'] = ['default' => TRUE];
    $options['row_class_custom'] = ['default' => ''];
    $options['row_class_default'] = ['default' => TRUE];

    // UIkit grid view options.
    $options['width_small'] = ['default' => 'uk-grid-width-small-1-1'];
    $options['width_medium'] = ['default' => 'uk-grid-width-medium-1-2'];
    $options['width_large'] = ['default' => 'uk-grid-width-large-1-3'];
    $options['width_xlarge'] = ['default' => 'uk-grid-width-xlarge-1-4'];
    $options['grid_gutter'] = ['default' => 'default'];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $args = [
      '@href' => 'https://getuikit.com/v2/docs/grid.html#even-grid-columns',
      '@title' => 'Grid component - UIkit documentation',
    ];

    $breakpoints = [
      'small' => $this->t('Affects device widths of 480px and higher.'),
      'medium' => $this->t('Affects device widths of 768px and higher.'),
      'large' => $this->t('Affects device widths of 960px and higher.'),
      'xlarge' => $this->t('Affects device widths of 1220px and higher.'),
    ];

    $form['column_widths'] = [
      '#type' => 'details',
      '#title' => $this->t('Grid columns'),
      '#description' => $this->t("To create a grid whose child elements' widths are evenly split, we apply one class to the grid for each breakpoint. Each item in the grid is then automatically applied a width based on the number of columns selected for each breakpoint. See <a href='@href' target='_blank' title='@title'>Grid component</a> for more details.", $args),
      '#open' => TRUE,
    ];

    $form['column_widths']['container'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Responsive width'),
    ];

    foreach (['small', 'medium', 'large', 'xlarge'] as $size) {
      $form['column_widths']['container']["width_${size}"] = [
        '#type' => 'select',
        '#title' => $this->t("uk-grid-width-${size}-*"),
        '#required' => TRUE,
        '#default_value' => isset($this->options["width_${size}"]) ? $this->options["width_${size}"] : NULL,
        '#options' => [
          "uk-grid-width-${size}-1-1" => 1,
          "uk-grid-width-${size}-1-2" => 2,
          "uk-grid-width-${size}-1-3" => 3,
          "uk-grid-width-${size}-1-4" => 4,
          "uk-grid-width-${size}-1-5" => 5,
          "uk-grid-width-${size}-1-6" => 6,
          "uk-grid-width-${size}-1-10" => 10,
        ],
        '#description' => '<p>' . $breakpoints[$size] . '</p>',
      ];
    }

    $form['grid_gutter'] = [
      '#type' => 'select',
      '#title' => $this->t('Grid gutter'),
      '#required' => TRUE,
      '#default_value' => isset($this->options['grid_gutter']) ? $this->options['grid_gutter'] : NULL,
      '#options' => [
        'default' => $this->t('Default gutter'),
        'uk-grid-small' => $this->t('Small gutter'),
        'uk-grid-medium' => $this->t('Medium gutter'),
        'uk-grid-large' => $this->t('Large gutter'),
        'uk-grid-collapse' => $this->t('Collapse gutter'),
      ],
      '#description' => $this->t('<p>Grids automatically create a horizontal gutter between columns and a vertical one between two succeeding grids. By default, the grid gutter is wider on large screens.<br /><strong>Note</strong>: <em class="placeholder">Grid collapse</em> removes the grid gutter.</p>'),
    ];
  }

}
