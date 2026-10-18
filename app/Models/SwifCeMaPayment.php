<?php

namespace Arimtiaz\SwiftCertificateManager\Models;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Payment transactions model.
 */
class SwifCeMaPayment {

    /**
     * Payment transactions table.
     *
     * @var string
     */
    protected $table;

    /**
     * Initialize the payment model.
     */
    public function __construct() {
        global $wpdb;

        $this->table = $wpdb->prefix . 'swifcema_payments';
    }

    /**
     * Insert a payment record and return its ID.
     *
     * @param array $data Payment data.
     * @return int|false
     */
    public function insertGetId( $data ) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery -- Insert a payment record into the plugin's custom table.
        $inserted = $wpdb->insert(
            $this->table,
            $data
        );

        if ( false === $inserted ) {
            return false;
        }

        return (int) $wpdb->insert_id;
    }

    /**
     * Update a payment record.
     *
     * @param int   $id   Payment record ID.
     * @param array $data Data to update.
     * @return int|false
     */
    public function updateData( $id, $data ) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Update the plugin's custom payment table directly.
        return $wpdb->update(
            $this->table,
            $data,
            array(
                'id' => absint( $id ),
            ),
            null,
            array( '%d' )
        );
    }

    /**
     * Find a payment record by ID.
     *
     * @param int $id Payment record ID.
     * @return object|null|false
     */
    public function find( $id ) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Retrieve the current payment record.
        return $wpdb->get_row(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; ID is passed through a prepared placeholder.
                "SELECT * FROM {$this->table} WHERE id = %d",
                absint( $id )
            )
        );
    }

    /**
     * Find a payment record by entry hash.
     *
     * @param string $hash Entry hash.
     * @return object|null|false
     */
    public function getHash( $hash ) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Retrieve the current payment record by hash.
        return $wpdb->get_row(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; hash value uses a prepared placeholder.
                "SELECT * FROM {$this->table} WHERE entry_hash = %s",
                sanitize_text_field( $hash )
            )
        );
    }

    /**
     * Get paginated payment transactions.
     *
     * @param array $request Pagination request parameters.
     * @return array
     */
    public function getPaymentTransactions( $request ) {
        global $wpdb;

        $current_page = isset( $request['current_page'] )
            ? max( 1, absint( $request['current_page'] ) )
            : 1;

        $per_page = isset( $request['per_page'] )
            ? absint( $request['per_page'] )
            : 10;

        $per_page = min( 100, max( 1, $per_page ) );

        $offset = $per_page * ( $current_page - 1 );

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Count current payment records for pagination.
        $total = (int) $wpdb->get_var(
            // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; query has no external values.
            "SELECT COUNT(*) FROM {$this->table}"
        );

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Retrieve the requested page of payment transactions.
        $payment_transactions = $wpdb->get_results(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; limit and offset use prepared placeholders.
                "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT %d OFFSET %d",
                $per_page,
                $offset
            )
        );

        $last_page = $total > 0
            ? (int) ceil( $total / $per_page )
            : 0;

        return array(
            'payment_transactions' => $payment_transactions,
            'total'                => $total,
            'last_page'            => $last_page,
            'current_page'         => $current_page,
        );
    }

    /**
     * Find a payment record by request ID.
     *
     * @param int $request_id Request ID.
     * @return object|null|false
     */
    public function getByRequestId( $request_id ) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Look up the current payment record for a request.
        return $wpdb->get_row(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; request ID is prepared.
                "SELECT * FROM {$this->table} WHERE request_id = %d LIMIT 1",
                absint( $request_id )
            )
        );
    }

    /**
     * Find a payment by charge ID and payment method.
     *
     * @param string $charge_id Payment provider charge ID.
     * @param string $method    Payment method.
     * @return int|false
     */
    public function getByPaymentId( $charge_id, $method = 'paypal' ) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Retrieve the current payment record.
        $payment = $wpdb->get_row(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; charge ID and payment method use prepared placeholders.
                "SELECT * FROM {$this->table} WHERE charge_id = %s AND payment_method = %s LIMIT 1",
                $charge_id,
                $method
            )
        );

        if ( $payment ) {
            return (int) $payment->id;
        }

        return false;
    }

    /**
     * Delete payment records by their IDs.
     *
     * @param int|array $transaction_ids Transaction ID or IDs.
     * @return int|false Number of deleted rows, or false on failure.
     */
    public function deleteInfo( $transaction_ids ) {
        global $wpdb;

        if ( ! is_array( $transaction_ids ) ) {
            $transaction_ids = array( $transaction_ids );
        }

        $transaction_ids = array_values(
            array_unique(
                array_filter(
                    array_map( 'absint', $transaction_ids )
                )
            )
        );

        if ( empty( $transaction_ids ) ) {
            return false;
        }

        $deleted = 0;

        foreach ( $transaction_ids as $transaction_id ) {
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Delete a selected payment record from the plugin's custom table.
            $result = $wpdb->delete(
                $this->table,
                array(
                    'id' => $transaction_id,
                ),
                array( '%d' )
            );

            if ( false === $result ) {
                return false;
            }

            $deleted += $result;
        }

        return $deleted;
    }

    /**
     * Delete payment transactions by request ID.
     *
     * @param int $id Request ID.
     * @return int|false
     */
    public function deletePaymentTransactionsByRequestId( $id ) {
        global $wpdb;

        $id = absint( $id );

        if ( ! $id ) {
            return false;
        }

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Delete payment records associated with this request.
        return $wpdb->delete(
            $this->table,
            array(
                'request_id' => $id,
            ),
            array( '%d' )
        );
    }
}