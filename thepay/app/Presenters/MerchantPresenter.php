<?php declare(strict_types=1);

namespace App\Presenters;

use Contributte\ThePay\Helper\IDivMerchant;
use Contributte\ThePay\IPayment;
use Nette\Application\UI\Presenter;
use Tp\Payment;

class MerchantPresenter extends Presenter
{
	/**
	 * @var IDivMerchant
	 * @inject
	 */
	public $divMerchant;
	/**
	 * @var IPayment
	 * @inject
	 */
	public $tpPayment;

	public function renderDiv()
	{
		// TODO use exist $cartId
		$cartId = 10;
		// TODO use exist $userId
		$userId = 1;
		// TODO use exist $paymentMethodId
		$paymentMethodId = 1;

		$payment = $this->tpPayment->create();
		assert($payment instanceof Payment);

		$payment->setMethodId($paymentMethodId);
		$payment->setValue(1000.0);
		$payment->setCurrency('CZK');
		$payment->setMerchantData((string) $cartId);
		$payment->setMerchantSpecificSymbol((string) $userId);
		$payment->setReturnUrl($this->link('//Homepage:onlineConfirmation', ['cartId' => $cartId]));
		$payment->setBackToEshopUrl(
			'Homepage:offlineConfirmation',
			['cartId' => $cartId]
		);

		$divMerchant = $this->divMerchant->create($payment);

		echo $divMerchant->render();

		$this->terminate();
	}
}
