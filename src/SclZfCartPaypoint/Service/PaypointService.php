<?php

namespace SclZfCartPaypoint\Service;

use SclZfCartPayment\Mapper\PaymentMapperInterface;
use SclZfCartPayment\Service\CompletionService;
use SclZfCartPaypoint\Callback\Callback;
use SclZfCartPaypoint\Callback\StatusCode;
use SclZfCartPaypoint\Exception\DomainException;
use SclZfCartPaypoint\Exception\RuntimeException;

/**
 * Perform actions need to make payments through paypoint.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class PaypointService
{
    /**
     * The payment mapper.
     *
     * @var PaymentMapperInterface
     */
    protected $paymentMapper;

    /**
     * The payment completion service.
     *
     * @var CompletionService
     */
    protected $completionService;

    /**
     * Constructor.
     *
     * @param  PaymentMapperInterface $paymentMapper
     * @param  CompletionService      $completionService
     */
    public function __construct(
        PaymentMapperInterface $paymentMapper,
        CompletionService $completionService
    ) {
        $this->paymentMapper     = $paymentMapper;
        $this->completionService = $completionService;
    }

    /**
     * Returns the payment ID for the transaction.
     *
     * @param  string $transactionId
     * @return int
     * @throws DomainException When transaction ID is the incorrect format.
     * @todo   Better ID for fetching the payment.
     */
    protected function paymentId($transactionId)
    {
        $matches = array();

        if (!preg_match('/TX-([0-9]*)/', $transactionId, $matches)) {
            throw new DomainException(
                'Invalid transaction ID format "' . $transactionId . '"'
            );
        }

        return (int) $matches[1];
    }

    /**
     * Check if the transaction was successful.
     *
     * @param  Callback $callback
     * @return bool
     * @todo   Complete checks
     */
    protected function transactionSuccessful(Callback $callback)
    {
        return $callback->getCode()->value() === StatusCode::AUTHORISED;
    }

    /**
     * Takes the callback data and updates the payment details as necessary.
     *
     * @param  Callback $callback
     * @return bool
     * @throws RuntimeException When payment is not found in the database.
     */
    public function processCallback(Callback $callback)
    {
        $paymentId = $this->paymentId($callback->getTransactionId());

        $payment = $this->paymentMapper->findById($paymentId);

        if (null === $payment) {
            throw new RuntimeException(
                'Couldn\'t load payment with id "' . $paymentId . '"'
            );
        }

        // @todo Verify the payment is not in a completed state already.

        if ($this->transactionSuccessful($callback)) {
            $this->completionService->complete($payment);
            return true;
        }

        $this->completionService->fail($payment);
        return false;
    }
}
