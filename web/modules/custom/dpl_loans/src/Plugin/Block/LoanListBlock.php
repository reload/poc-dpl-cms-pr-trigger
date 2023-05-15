<?php

namespace Drupal\dpl_loans\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\dpl_react_apps\Controller\DplReactAppsController;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides user loans list.
 *
 * @Block(
 *   id = "dpl_loans_list_block",
 *   admin_label = "List user loans"
 * )
 */
class LoanListBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  private ConfigFactoryInterface $configFactory;

  /**
   * LoanListBlock constructor.
   *
   * @param mixed[] $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   Drupal config factory to get FBS and Publizon settings.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $configFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configuration = $configuration;
    $this->configFactory = $configFactory;
  }

  /**
   * {@inheritDoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The service container.
   * @param mixed[] $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param int $plugin_definition
   *   The plugin implementation definition.
   *
   * @return \Drupal\dpl_loans\Plugin\Block\LoanListBlock|static
   *   Loan list block.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
    );
  }

  /**
   * Gets threshold config.
   *
   * @return string
   *   Returns the threshold config.
   */
  public function getThresholdConfig(): string {
    $generalSettings = $this->configFactory->get('dpl_library_agency.general_settings');
    return $generalSettings->get('threshold_config') ?? "{ 'colorThresholds': { 'danger': '0', 'warning': '6' } }";
  }

  /**
   * {@inheritDoc}
   *
   * @return mixed[]
   *   The app render array.
   */
  public function build() {
    $loanListSettings = $this->configFactory->get('dpl_loan_list.settings');
    $fbsConfig = $this->configFactory->get('dpl_fbs.settings');
    $publizonConfig = $this->configFactory->get('dpl_publizon.settings');
    $generalSettings = $this->configFactory->get('dpl_library_agency.general_settings');

    $data = [
      // Page size.
      "page-size-desktop" => $loanListSettings->get('page_size_desktop'),
      "page-size-mobile" => $loanListSettings->get('page_size_mobile'),
      // Config.
      "threshold-config" => $this->getThresholdConfig(),
      // Urls.
      "fbs-base-url" => $fbsConfig->get('base_url'),
      "publizon-base-url" => $publizonConfig->get('base_url'),
      'fees-page-url' => $generalSettings->get('fees_page_url'),
      'material-overdue-url' => $loanListSettings->get('material_overdue_url'),
      'dpl-cms-base-url' => DplReactAppsController::dplCmsBaseUrl(),
      // Texts.
      'group-modal-due-date-link-to-page-with-fees-text' => $this->t("Read more about fees", [], ['context' => 'Loan list']),
      'group-modal-due-date-renew-loan-close-modal-aria-label-text' => $this->t("Close renew loans modal", [], ['context' => 'Loan list (Aria)']),
      'group-modal-due-date-aria-description-text' => $this->t("This modal groups loans after due date and makes it possible to renew said loans", [], ['context' => 'Loan list (Aria)']),
      'group-modal-checkbox-text' => $this->t("Choose all renewable", [], ['context' => 'Loan list']),
      'group-modal-due-date-header-text' => $this->t("Due date @date", [], ['context' => 'Loan list']),
      'group-modal-due-date-warning-loan-overdue-text' => $this->t("The due date of return is exceeded, therefore you will be charged a fee, when the item is returned", [], ['context' => 'Loan list']),
      'group-modal-go-to-material-text' => $this->t("Go to material details", [], ['context' => 'Loan list']),
      'group-modal-return-library-text' => $this->t("Can be returned to all branches of the municipalities libraries", [], ['context' => 'Loan list']),
      'loan-list-aria-label-list-button-text' => $this->t("This button shows all loans in the list", [], ['context' => 'Loan list (Aria)']),
      'loan-list-aria-label-stack-button-text' => $this->t("This button filters the list, so only one the materials that have the same due date is shown", [], ['context' => 'Loan list (Aria)']),
      'group-modal-renew-loan-denied-inter-library-loan-text' => $this->t("The item has been lent to you by another library and renewal is therefore conditional of the acceptance by that library", [], ['context' => 'Loan list']),
      'group-modal-renew-loan-denied-max-renewals-reached-text' => $this->t("The item cannot be renewed further", [], ['context' => 'Loan list']),
      'group-modal-renew-loan-denied-reserved-text' => $this->t("The item is reserved by another patron", [], ['context' => 'Loan list']),
      'loan-list-digital-loans-empty-list-text' => $this->t("You have no digital loans at the moment", [], ['context' => 'Loan list']),
      'loan-list-digital-loans-title-text' => $this->t("Digital loans", [], ['context' => 'Loan list']),
      'loan-list-digital-physical-loans-empty-list-text' => $this->t("You have 0 loans at the moment", [], ['context' => 'Loan list']),
      'loan-list-due-date-modal-aria-label-text' => $this->t("This button opens a modal that covers the entire page and contains loans with the same due date as the loan currently in focus", [], ['context' => 'Loan list (Aria)']),
      'group-modal-hidden-label-checkbox-on-material-text' => $this->t("Select @label for renewal", [], ['context' => 'Loan list']),
      'loan-list-material-late-fee-text' => $this->t("You will be charged a fee, when the item is returned", [], ['context' => 'Loan list']),
      'loan-list-material-days-text' => $this->t("days", [], ['context' => 'Loan list']),
      'loan-list-material-day-text' => $this->t("day", [], ['context' => 'Loan list']),
      'loan-list-additional-materials-text' => [
        'type' => 'plural',
        'text' => [
          $this->t('+ 1 other material', [], ['context' => 'Loan list']),
          $this->t('+ @count other materials', [], ['context' => 'Loan list']),
        ],
      ],
      'loan-list-physical-loans-empty-list-text' => $this->t("You have no physical loans at the moment", [], ['context' => 'Loan list']),
      'loan-list-physical-loans-title-text' => $this->t("Physical loans", [], ['context' => 'Loan list']),
      'loan-list-renew-multiple-button-explanation-text' => $this->t("This button opens a modal that covers the entire page and contains loans with different due dates, if some of the loans in the modal are renewable you can renew them", [], ['context' => 'Loan list']),
      'loan-list-renew-multiple-button-text' => $this->t("Renew several", [], ['context' => 'Loan list']),
      'loan-list-status-badge-danger-text' => $this->t("Expired", [], ['context' => 'Loan list']),
      'loan-list-status-badge-warning-text' => $this->t("Expiring soon", [], ['context' => 'Loan list']),
      'loan-list-title-text' => $this->t("Your loans", [], ['context' => 'Loan list']),
      'loan-list-to-be-delivered-digital-material-text' => $this->t("Due date @date", [], ['context' => 'Loan list']),
      'group-modal-due-date-material-text' => $this->t("Due date @date", [], ['context' => 'Loan list']),
      'loan-list-to-be-delivered-text' => $this->t("Due date @date", [], ['context' => 'Loan list']),
      'material-and-author-text' => $this->t("and", [], ['context' => 'Loan list']),
      'material-by-author-text' => $this->t("By", [], ['context' => 'Loan list']),
      'material-details-close-modal-aria-label-text' => $this->t("Close material details modal", [], ['context' => 'Loan list (Aria)']),
      'material-details-digital-due-date-label-text' => $this->t("Expires", [], ['context' => 'Loan list']),
      'material-details-physical-due-date-label-text' => $this->t("Due date", [], ['context' => 'Loan list']),
      'material-details-go-to-ereolen-text' => $this->t("Go to eReolen", [], ['context' => 'Loan list']),
      'material-details-link-to-page-with-fees-text' => $this->t("Read more about fees", [], ['context' => 'Loan list']),
      'material-details-loan-date-label-text' => $this->t("Loan date", [], ['context' => 'Loan list']),
      'material-details-material-number-label-text' => $this->t("Material Item Number", [], ['context' => 'Loan list']),
      'material-details-modal-aria-description-text' => $this->t("This modal shows material details, and makes it possible to renew a material, of that material is renewable", [], ['context' => 'Loan list (Aria)']),
      'material-details-overdue-text' => $this->t("Expired", [], ['context' => 'Loan list']),
      'material-details-renew-loan-button-text' => $this->t("Renew your loans", [], ['context' => 'Loan list']),
      'material-details-warning-loan-overdue-text' => $this->t("The due date of return is exceeded, therefore you will be charged a fee, when the item is returned", [], ['context' => 'Loan list']),
      'publizon-audio-book-text' => $this->t("Audiobook", [], ['context' => 'Loan list']),
      'publizon-ebook-text' => $this->t("E-book", [], ['context' => 'Loan list']),
      'publizon-podcast-text' => $this->t("Podcast", [], ['context' => 'Loan list']),
      'group-modal-aria-description-text' => $this->t("This modal makes it possible to renew materials", [], ['context' => 'Loan list (Aria)']),
      'group-modal-button-text' => $this->t("Renewable (@count)", [], ['context' => 'Loan list']),
      'group-modal-close-modal-aria-label-text' => $this->t("Close modal with grouped loans", [], ['context' => 'Loan list (Aria)']),
      'group-modal-header-text' => $this->t("Renew several", [], ['context' => 'Loan list']),
      'result-pager-status-text' => $this->t("Showing @itemsShown out of @hitcount loans", [], ['context' => 'Loan list']),
      'show-more-text' => $this->t("show more", [], ['context' => 'Loan list']),
      'group-modal-go-to-material-aria-label-text' => $this->t("Go to @label material details", [], ['context' => 'Loan list (Aria)']),
    ] + DplReactAppsController::externalApiBaseUrls() + DplReactAppsController::getBlockedSettings();

    return [
      '#theme' => 'dpl_react_app',
      "#name" => 'loan-list',
      '#data' => $data,
    ];
  }

}