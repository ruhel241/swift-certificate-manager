<?php

namespace SwiftCertificateManager\Models;

class SwiftCMPayment
{
    protected $table;

    public function __construct() {
        global $wpdb;

        $this->table = $wpdb->prefix . 'swiftcm_payments';
    }

    public function insertGetId($data) {
        global $wpdb;

        $inserted = $wpdb->insert(
            $this->table,
            $data
        );

        if (false === $inserted) {
            return false;
        }

        return $wpdb->insert_id;
    }

    public function updateData($id, $data) {
        global $wpdb;

        return $wpdb->update(
            $this->table,
            $data,
            [
                'id' => absint($id),
            ],
            null,
            [
                '%d',
            ]
        );
    }

    public function find($id) {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table} WHERE id = %d",
                absint($id)
            )
        );
    }

    public function getHash($hash) {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table} WHERE entry_hash = %s",
                $hash
            )
        );
    }

    public function getPaymentTransactions($request) {
        global $wpdb;

        $currentPage = isset($request['current_page'])
            ? absint($request['current_page'])
            : 1;

        $perPage = isset($request['per_page'])
            ? absint($request['per_page'])
            : 10;

        if ($currentPage < 1) {
            $currentPage = 1;
        }

        if ($perPage < 1) {
            $perPage = 10;
        }

        $offset = $perPage * ($currentPage - 1);

        /*
         * Get total transactions.
         */
        $total = (int) $wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->table}"
        );

        /*
         * Get transactions for current page.
         */
        $paymentTransactions = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT *
                FROM {$this->table}
                ORDER BY id DESC
                LIMIT %d OFFSET %d",
                $perPage,
                $offset
            )
        );

        $lastPage = $total > 0
            ? (int) ceil($total / $perPage)
            : 0;

        return [
            'payment_transactions' => $paymentTransactions,
            'total'                => $total,
            'last_page'            => $lastPage,
            'current_page'         => $currentPage,
        ];
    }

    public function getByRequestId($requestId) {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT *
                FROM {$this->table}
                WHERE request_id = %d
                LIMIT 1",
                absint($requestId)
            )
        );
    }

    public function getByPaymentId($chargeId, $method = 'paypal') {
        global $wpdb;

        $payment = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT *
                FROM {$this->table}
                WHERE charge_id = %s
                AND payment_method = %s
                LIMIT 1",
                $chargeId,
                $method
            )
        );

        if ($payment) {
            return $payment->id;
        }

        return false;
    }

    public function deleteInfo($transactionIds) {
        global $wpdb;

        if (!is_array($transactionIds)) {
            $transactionIds = [$transactionIds];
        }

        $transactionIds = array_filter(
            array_map('absint', $transactionIds)
        );

        if (empty($transactionIds)) {
            return false;
        }

        /*
         * Create placeholders for IN query.
         *
         * Example:
         * WHERE id IN (%d, %d, %d)
         */
        $placeholders = implode(
            ', ',
            array_fill(0, count($transactionIds), '%d')
        );

        $query = $wpdb->prepare(
            "DELETE FROM {$this->table}
            WHERE id IN ({$placeholders})",
            $transactionIds
        );

        return $wpdb->query($query);
    }

    public function deletePaymentTransactionsByRequestId($id) {
        global $wpdb;

        $id = absint($id);

        if (!$id) {
            return false;
        }

        return $wpdb->delete(
            $this->table,
            [
                'request_id' => $id,
            ],
            [
                '%d',
            ]
        );
    }
}
