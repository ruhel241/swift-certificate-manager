<?php

namespace Arimtiaz\SwiftCertificateManager\Models;

use Arimtiaz\SwiftCertificateManager\Hooks\Handlers\AvailableOptions;
use Arimtiaz\SwiftCertificateManager\Models\SwifCeMaPayment;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class SwifCeMaGenerate {

    protected $table;

    public function __construct() {
        global $wpdb;

        $this->table = $wpdb->prefix . 'swifcema_generates';
    }

    public function getDatas($params) {
        global $wpdb;

        $search = isset($params['search'])
            ? sanitize_text_field($params['search'])
            : '';

        $status = isset($params['status'])
            ? sanitize_text_field($params['status'])
            : '';

        $currentPage = isset($params['current_page'])
            ? absint($params['current_page'])
            : 1;

        $perPage = isset($params['per_page'])
            ? absint($params['per_page'])
            : 10;

        if ($currentPage < 1) {
            $currentPage = 1;
        }

        if ($perPage < 1) {
            $perPage = 10;
        }

        $offset = ($currentPage - 1) * $perPage;

        $searchLike = '' !== $search
            ? '%' . $wpdb->esc_like($search) . '%'
            : '';

        /*
         * The SQL structure is fixed. Empty filters are skipped by the
         * "%s = ''" checks, so no dynamic SQL needs to be built.
         */

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Count certificate records for pagination.
        $total = (int) $wpdb->get_var(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; all filter values use prepared placeholders.
                "SELECT COUNT(*) FROM {$this->table}
                WHERE ( %s = '' OR status = %s )
                AND ( %s = '' OR (
                    CAST(id AS CHAR) LIKE %s
                    OR course_name LIKE %s
                    OR student_name LIKE %s
                    OR graduation_date LIKE %s
                    OR certificate_code LIKE %s
                    OR status LIKE %s
                    OR payment_status LIKE %s
                ) )",
                $status,
                $status,
                $searchLike,
                $searchLike,
                $searchLike,
                $searchLike,
                $searchLike,
                $searchLike,
                $searchLike,
                $searchLike
            )
        );

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Retrieve the requested page of certificate records.
        $infos = $wpdb->get_results(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; all filter values use prepared placeholders.
                "SELECT * FROM {$this->table}
                WHERE ( %s = '' OR status = %s )
                AND ( %s = '' OR (
                    CAST(id AS CHAR) LIKE %s
                    OR course_name LIKE %s
                    OR student_name LIKE %s
                    OR graduation_date LIKE %s
                    OR certificate_code LIKE %s
                    OR status LIKE %s
                    OR payment_status LIKE %s
                ) )
                ORDER BY id DESC
                LIMIT %d OFFSET %d",
                $status,
                $status,
                $searchLike,
                $searchLike,
                $searchLike,
                $searchLike,
                $searchLike,
                $searchLike,
                $searchLike,
                $searchLike,
                $perPage,
                $offset
            )
        );

        foreach ($infos as $info) {
            $info->human_created_at = human_time_diff(
                strtotime($info->created_at),
                time()
            ) . ' ago';
        }

        return [
            'infos'        => $infos,
            'total'        => $total,
            'last_page'    => $total > 0
                ? (int) ceil($total / $perPage)
                : 0,
            'current_page' => $currentPage,
        ];
    }

    public function getInfo($id) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Retrieve the current certificate record.
        return $wpdb->get_row(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; ID is passed through a prepared placeholder.
                "SELECT * FROM {$this->table} WHERE id = %d LIMIT 1",
                absint($id)
            )
        );
    }

    public function find($id) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Retrieve the current certificate record.
        return $wpdb->get_row(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; ID is passed through a prepared placeholder.
                "SELECT * FROM {$this->table} WHERE id = %d LIMIT 1",
                absint($id)
            )
        );
    }

    public function getLastCertificate() {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; query has no external values.
        return $wpdb->get_row( "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT 1" );
    }

    public function insertGetId($data) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery -- Insert a certificate record into the plugin's custom table.
        $inserted = $wpdb->insert(
            $this->table,
            $data
        );

        if (false === $inserted) {
            return false;
        }

        return $wpdb->insert_id;
    }

    public function updateInfo($id, $data) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Update the plugin's custom certificate table directly.
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

    public function updateStatus($infoIds, $actionType) {
        global $wpdb;

        if (!is_array($infoIds)) {
            $infoIds = [$infoIds];
        }

        $infoIds = array_values(
            array_filter(
                array_map('absint', $infoIds)
            )
        );

        if (empty($infoIds)) {
            return false;
        }

        $actionType = sanitize_text_field($actionType);
        $updatedAt  = gmdate('Y-m-d H:i:s');
        $updated    = 0;

        foreach ($infoIds as $infoId) {
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Update the status of a selected certificate record.
            $result = $wpdb->update(
                $this->table,
                [
                    'status'     => $actionType,
                    'updated_at' => $updatedAt,
                ],
                [
                    'id' => $infoId,
                ],
                ['%s', '%s'],
                ['%d']
            );

            if (false === $result) {
                return false;
            }

            $updated += $result;
        }

        return $updated;
    }

    public function verifyCertificateCode($certificateCode) {
        global $wpdb;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Verify a certificate code against the custom table.
        return $wpdb->get_row(
            $wpdb->prepare(
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Trusted table identifier; values use prepared placeholders.
                "SELECT * FROM {$this->table} WHERE certificate_code = %s AND status = %s LIMIT 1",
                $certificateCode,
                'assign'
            )
        );
    }

    public function deleteInfo($infoIds) {
        global $wpdb;

        if (!is_array($infoIds)) {
            $infoIds = [$infoIds];
        }

        $infoIds = array_values(
            array_unique(
                array_filter(
                    array_map('absint', $infoIds)
                )
            )
        );

        if (empty($infoIds)) {
            return false;
        }

        $payment = new SwifCeMaPayment();
        $deleted = 0;
        $found   = false;

        foreach ($infoIds as $infoId) {

            /*
             * Get the record first because we need
             * image_url and pdf_url before deleting it.
             */
            $info = $this->find($infoId);

            if (empty($info)) {
                continue;
            }

            $found = true;

            /*
             * Delete payment transaction.
             */
            $payment->deletePaymentTransactionsByRequestId(
                $info->id
            );

            /*
             * Remove certificate files.
             */
            if (!empty($info->image_url) || !empty($info->pdf_url)) {

                $filenames = array_filter([
                    $info->image_url,
                    $info->pdf_url,
                ]);

                AvailableOptions::removedFile($filenames);
            }

            /*
             * Delete the certificate record.
             */
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Delete a selected certificate record from the plugin's custom table.
            $result = $wpdb->delete(
                $this->table,
                [
                    'id' => $infoId,
                ],
                ['%d']
            );

            if (false === $result) {
                return false;
            }

            $deleted += $result;
        }

        if (!$found) {
            return false;
        }

        return $deleted;
    }
}