<?php

/**
 * @file
 * Definition of Views\node\Plugin\views\argument\CreatedDay.
 */

namespace Views\node\Plugin\views\argument;

use Drupal\Core\Annotation\Plugin;
use Drupal\views\Plugin\views\argument\Date;
use Drupal\Component\Plugin\Discovery\DiscoveryInterface;

/**
 * Argument handler for a day (DD)
 *
 * @Plugin(
 *   id = "node_created_day",
 *   module = "node"
 * )
 */
class CreatedDay extends Date {

  /**
   * Constructs a CreatedDay object.
   */
  public function __construct(array $configuration, $plugin_id, DiscoveryInterface $discovery) {
    parent::__construct($configuration, $plugin_id, $discovery);

    $this->formula = views_date_sql_extract('DAY', "***table***.$this->realField");
    $this->format = 'j';
    $this->arg_format = 'd';
  }

  /**
   * Provide a link to the next level of the view
   */
  function summary_name($data) {
    $day = str_pad($data->{$this->name_alias}, 2, '0', STR_PAD_LEFT);
    // strtotime respects server timezone, so we need to set the time fixed as utc time
    return format_date(strtotime("2005" . "05" . $day . " 00:00:00 UTC"), 'custom', $this->format, 'UTC');
  }

  /**
   * Provide a link to the next level of the view
   */
  function title() {
    $day = str_pad($this->argument, 2, '0', STR_PAD_LEFT);
    return format_date(strtotime("2005" . "05" . $day . " 00:00:00 UTC"), 'custom', $this->format, 'UTC');
  }

  function summary_argument($data) {
    // Make sure the argument contains leading zeroes.
    return str_pad($data->{$this->base_alias}, 2, '0', STR_PAD_LEFT);
  }

}
