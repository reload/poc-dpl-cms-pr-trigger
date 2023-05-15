<?php

namespace Drupal\dpl_reservations\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\dpl_react_apps\Controller\DplReactAppsController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\dpl_library_agency\Branch\BranchRepositoryInterface;
use Drupal\dpl_library_agency\BranchSettings;

/**
 * Provides user reservations list.
 *
 * @Block(
 *   id = "dpl_reservations_list_block",
 *   admin_label = "List user reservations"
 * )
 */
class ReservationListBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  private ConfigFactoryInterface $configFactory;

  /**
   * ReservationListBlock constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param array $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   Drupal config factory to get FBS and Publizon settings.
   * @param \Drupal\dpl_library_agency\BranchSettings $branchSettings
   *   The branchsettings for branch config.
   * @param \Drupal\dpl_library_agency\Branch\BranchRepositoryInterface $branchRepository
   *   The branchsettings for getting branches.
   */
  public function __construct(array $configuration, string $plugin_id, array $plugin_definition, ConfigFactoryInterface $configFactory, protected BranchSettings $branchSettings, protected BranchRepositoryInterface $branchRepository) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configuration = $configuration;
    $this->configFactory = $configFactory;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('dpl_library_agency.branch_settings'),
      $container->get('dpl_library_agency.branch.repository'),
    );
  }

  /**
   * {@inheritDoc}
   *
   * @return mixed[]
   *   The app render array.
   */
  public function build(): array {
    $reservation_list_settings = $this->configFactory->get('dpl_reservation_list.settings');
    $fbsConfig = $this->configFactory->get('dpl_fbs.settings');
    $publizonConfig = $this->configFactory->get('dpl_publizon.settings');
    $dateConfig = $reservation_list_settings->get('pause_reservation_start_date_config') ?? '';

    $data = [
      // Branches.
      'blacklisted-pickup-branches-config' => DplReactAppsController::buildBranchesListProp($this->branchSettings->getExcludedReservationBranches()),
      'blacklisted-search-branches-config' => DplReactAppsController::buildBranchesListProp($this->branchSettings->getExcludedSearchBranches()),
      'blacklisted-availability-branches-config' => DplReactAppsController::buildBranchesListProp($this->branchSettings->getExcludedAvailabilityBranches()),
      'branches-config' => DplReactAppsController::buildBranchesJsonProp($this->branchRepository->getBranches()),
      // Url.
      'ereolen-my-page-url' => $reservation_list_settings->get('ereolen_my_page_url'),
      'pause-reservation-info-url' => $reservation_list_settings->get('pause_reservation_info_url'),
      'pause-reservation-start-date-config' => $dateConfig,
      // Config.
      "threshold-config" => $this->configFactory->get('dpl_library_agency.general_settings')->get('threshold_config'),
      "page-size-desktop" => $reservation_list_settings->get('page_size_desktop'),
      "page-size-mobile" => $reservation_list_settings->get('page_size_mobile'),
      "fbs-base-url" => $fbsConfig->get('base_url'),
      "publizon-base-url" => $publizonConfig->get('base_url'),
      // Texts.
      'reservation-list-header-text' => $this->t('Your reservations', [], ['context' => 'Reservation list']),
      'reservation-list-physical-reservations-header-text' => $this->t('Physical reservations', [], ['context' => 'Reservation list']),
      'reservation-list-pause-reservation-text' => $this->t('Pause reservations on physical items', [], ['context' => 'Reservation list']),
      'reservation-list-digital-reservations-header-text' => $this->t('Digital reservations', [], ['context' => 'Reservation list']),
      'reservation-list-ready-for-pickup-title-text' => $this->t('Ready for pickup', [], ['context' => 'Reservation list']),
      'reservation-list-ready-for-pickup-empty-text' => $this->t('At the moment you have 0 reservations ready for pickup', [], ['context' => 'Reservation list']),
      'reservation-list-physical-reservations-empty-text' => $this->t('At the moment you have 0 physical reservations', [], ['context' => 'Reservation list']),
      'reservation-list-all-empty-text' => $this->t('At the moment you have 0 reservations', [], ['context' => 'Reservation list']),
      'reservation-list-digital-reservations-empty-text' => $this->t('At the moment you have 0 reservations on digital items', [], ['context' => 'Reservation list']),
      'reservation-list-ready-text' => $this->t('Ready', [], ['context' => 'Reservation list']),
      'material-by-author-text' => $this->t('By', [], ['context' => 'Reservation list']),
      'material-and-author-text' => $this->t('and', [], ['context' => 'Reservation list']),
      'reservation-list-number-in-queue-text' => $this->t('There are @count people in the queue before you', [], ['context' => 'Reservation list']),
      'reservation-list-first-in-queue-text' => $this->t('You are at the front of the queue', [], ['context' => 'Reservation list']),
      'reservation-list-in-queue-text' => $this->t('queued', [], ['context' => 'Reservation list']),
      'reservation-pick-up-latest-text' => $this->t('Pick up before @date', [], ['context' => 'Reservation list']),
      'publizonEbook-text' => $this->t('E-book', [], ['context' => 'Reservation list']),
      'publizon-audio-book-text' => $this->t('Audiobook', [], ['context' => 'Reservation list']),
      'publizon-podcast-text' => $this->t('Podcast', [], ['context' => 'Reservation list']),
      'reservation-list-loan-before-text' => $this->t('Borrow before @date', [], ['context' => 'Reservation list']),
      'reservation-list-available-in-text' => $this->t('Available in @count days', [], ['context' => 'Reservation list']),
      'reservation-list-days-text' => $this->t('days', [], ['context' => 'Reservation list']),
      'reservation-list-day-text' => $this->t('day', [], ['context' => 'Reservation list']),
      'reservation-details-button-remove-text' => $this->t('Remove your reservation', [], ['context' => 'Reservation list']),
      'reservation-details-others-in-queue-text' => $this->t('Others are queueing for this material', [], ['context' => 'Reservation list']),
      'reservation-details-number-in-queue-label-text' => $this->t('@count queued', [], ['context' => 'Reservation list']),
      'reservation-details-status-title-text' => $this->t('Status', [], ['context' => 'Reservation list']),
      'reservation-details-expires-title-text' => $this->t('Pickup deadline', [], ['context' => 'Reservation list']),
      'reservation-details-digital-material-expires-title-text' => $this->t('Borrow before', [], ['context' => 'Reservation list']),
      'reservation-details-pick-up-at-title-text' => $this->t('Pickup branch', [], ['context' => 'Reservation list']),
      'reservation-details-change-text' => $this->t('Apply changes', [], ['context' => 'Reservation list']),
      'reservation-details-pickup-deadline-title-text' => $this->t('Pickup deadline', [], ['context' => 'Reservation list']),
      'reservation-details-date-of-reservation-title-text' => $this->t('Date of reservation', [], ['context' => 'Reservation list']),
      'reservation-details-no-interest-after-title-text' => $this->t('Not interested after', [], ['context' => 'Reservation list']),
      'reservation-details-ready-for-loan-text' => $this->t('Ready for pickup', [], ['context' => 'Reservation list']),
      'reservation-details-remove-digital-reservation-text' => $this->t('Remove your reservation', [], ['context' => 'Reservation list']),
      'reservation-details-digital-reservation-go-to-ereolen-text' => $this->t('Go to eReolen', [], ['context' => 'Reservation list']),
      'reservation-details-borrow-before-text' => $this->t('Borrow before @date', [], ['context' => 'Reservation list']),
      'reservation-details-expires-text' => $this->t('Your reservation expires @date!', [], ['context' => 'Reservation list']),
      'reservation-details-save-text' => $this->t('Save', [], ['context' => 'Reservation list']),
      'reservation-details-cancel-text' => $this->t('Cancel', [], ['context' => 'Reservation list']),
      'delete-reservation-modal-header-text' => [
        'type' => 'plural',
        'text' => [
          $this->t('Cancel reservation', [], ['context' => 'Reservation list']),
          $this->t('Cancel reservations', [], ['context' => 'Reservation list']),
        ],
      ],
      'delete-reservation-modal-delete-question-text' => $this->t('Do you want to cancel your reservation?', [], ['context' => 'Reservation list']),
      'delete-reservation-modal-delete-button-text' => $this->t('Cancel reservation', [], ['context' => 'Reservation list']),
      'delete-reservation-modal-not-regrettable-text' => $this->t('You cannot regret this action', [], ['context' => 'Reservation list']),
      'delete-reservation-modal-close-modal-text' => $this->t('Close delete reservation modal', [], ['context' => 'Reservation list']),
      'delete-reservation-modal-aria-description-text' => $this->t('This button opens a modal that covers the entire page and contains the possibility to delete a selected reservation, or multiple selected reservations', [], ['context' => 'Reservation list (Aria)']),
      'reservation-list-on-hold-aria-text' => $this->t('Reservations have been paused in the following time span:', [], ['context' => 'Reservation list (Aria)']),
      'reservation-list-pause-reservation-aria-modal-text' => $this->t('This button opens a modal that covers the entire page and contains the possibility to pause physical reservations', [], ['context' => 'Reservation list (Aria)']),
      'pause-reservation-modal-aria-description-text' => $this->t('This modal makes it possible to pause your physical reservations', [], ['context' => 'Reservation list (Aria)']),
      'pause-reservation-modal-header-text' => $this->t('Pause reservations on physical items', [], ['context' => 'Reservation list']),
      'pause-reservation-modal-body-text' => $this->t('Pause your reservations early, since reservations that are already being processed, will not be paused.', [], ['context' => 'Reservation list']),
      'pause-reservation-modal-close-modal-text' => $this->t('Close pause reservations modal', [], ['context' => 'Reservation list']),
      'date-inputs-start-date-label-text' => $this->t('Start date', [], ['context' => 'Reservation list']),
      'material-details-close-modal-aria-label-text' => $this->t("Close material details modal", [], ['context' => 'Reservation list (Aria)']),
      'date-inputs-end-date-label-text' => $this->t('End date', [], ['context' => 'Reservation list']),
      'pause-reservation-modal-below-inputs-text-text' => $this->t('Pause reservation below inputs text', [], ['context' => 'Reservation list']),
      'pause-reservation-modal-link-text' => $this->t('Read more about pausing reservertions and what that means here', [], ['context' => 'Reservation list']),
      'pause-reservation-modal-save-button-label-text' => $this->t('Save', [], ['context' => 'Reservation list']),
      'one-month-text' => $this->t('1 month', [], ['context' => 'Reservation list']),
      'two-months-text' => $this->t('2 months', [], ['context' => 'Reservation list']),
      'three-months-text' => $this->t('3 months', [], ['context' => 'Reservation list']),
      'six-months-text' => $this->t('6 months', [], ['context' => 'Reservation list']),
      'one-year-text' => $this->t('1 year', [], ['context' => 'Reservation list']),
      'list-details-nothing-selected-label-text' => $this->t('Pick', [], ['context' => 'Reservation list']),
      'show-more-text' => $this->t('show more', [], ['context' => 'Reservation list']),
      'result-pager-status-text' => $this->t('Showing @itemsShown out of @hitcount results', [], ['context' => 'Reservation list']),
      'reservation-list-status-icon-ready-for-pickup-aria-label-text' => $this->t('This material is ready for pickup', [], ['context' => 'Reservation list (Aria)']),
      'reservation-list-status-icon-queued-aria-label-text' => [
        'type' => 'plural',
        'text' => [
          $this->t('You are the only person queued for this material', [], ['context' => 'Reservation list (Aria)']),
          $this->t('This material has @count people in queue before you', [], ['context' => 'Reservation list (Aria)']),
        ],
      ],
      'reservation-list-status-icon-ready-in-aria-label-text' => [
        'type' => 'plural',
        'text' => [
          $this->t('This material is ready in 1 day', [], ['context' => 'Reservation list (Aria)']),
          $this->t('This material is ready in @count days', [], ['context' => 'Reservation list (Aria)']),
        ],
      ],
    ] + DplReactAppsController::externalApiBaseUrls() + DplReactAppsController::getBlockedSettings();

    return [
      '#theme' => 'dpl_react_app',
      "#name" => 'reservation-list',
      '#data' => $data,
    ];
  }

}