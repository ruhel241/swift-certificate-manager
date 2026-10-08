<?php

namespace SwiftCertificateManager\Models;

use SwiftCertificateManager\Hooks\Handlers\AvailableOptions;
use SwiftCertificateManager\Models\SwifCeMaPayment;

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

        /*
         * Build WHERE conditions.
         */
        $where = [];
        $values = [];

        if ($status) {
            $where[] = 'status = %s';
            $values[] = $status;
        }

        if ($search) {
            $searchLike = '%' . $wpdb->esc_like($search) . '%';

            $where[] = '(
                CAST(id AS CHAR) LIKE %s
                OR course_name LIKE %s
                OR student_name LIKE %s
                OR graduation_date LIKE %s
                OR certificate_code LIKE %s
                OR status LIKE %s
                OR payment_status LIKE %s
            )';

            $values[] = $searchLike;
            $values[] = $searchLike;
            $values[] = $searchLike;
            $values[] = $searchLike;
            $values[] = $searchLike;
            $values[] = $searchLike;
            $values[] = $searchLike;
        }

        $whereSql = '';

        if (!empty($where)) {
            $whereSql = 'WHERE ' . implode(' AND ', $where);
        }

        /*
         * Total count.
         */
        $countQuery = "SELECT COUNT(*)
            FROM {$this->table}
            {$whereSql}";

        if (!empty($values)) {
            $total = (int) $wpdb->get_var(
                $wpdb->prepare($countQuery, $values)
            );
        } else {
            $total = (int) $wpdb->get_var($countQuery);
        }

        /*
         * Get paginated data.
         */
        $dataQuery = "SELECT *
            FROM {$this->table}
            {$whereSql}
            ORDER BY id DESC
            LIMIT %d OFFSET %d";

        $queryValues = $values;
        $queryValues[] = $perPage;
        $queryValues[] = $offset;

        $infos = $wpdb->get_results(
            $wpdb->prepare($dataQuery, $queryValues)
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

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT *
                FROM {$this->table}
                WHERE id = %d
                LIMIT 1",
                absint($id)
            )
        );
    }

    public function find($id) {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT *
                FROM {$this->table}
                WHERE id = %d
                LIMIT 1",
                absint($id)
            )
        );
    }

    public function getLastCertificate() {
        global $wpdb;

        return $wpdb->get_row(
            "SELECT *
            FROM {$this->table}
            ORDER BY id DESC
            LIMIT 1"
        );
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

    public function updateInfo($id, $data) {
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

    public function updateStatus($infoIds, $actionType) {
        global $wpdb;

        if (!is_array($infoIds)) {
            $infoIds = [$infoIds];
        }

        $infoIds = array_filter(
            array_map('absint', $infoIds)
        );

        if (empty($infoIds)) {
            return false;
        }

        $actionType = sanitize_text_field($actionType);

        $placeholders = implode(
            ', ',
            array_fill(0, count($infoIds), '%d')
        );

        /*
         * First values are for SET clause,
         * remaining values are the IDs.
         */
        $query = $wpdb->prepare(
            "UPDATE {$this->table}
            SET status = %s,
                updated_at = %s
            WHERE id IN ({$placeholders})",
            array_merge(
                [
                    $actionType,
                    gmdate('Y-m-d H:i:s'),
                ],
                $infoIds
            )
        );

        return $wpdb->query($query);
    }

    public function verifyCertificateCode($certificateCode) {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT *
                FROM {$this->table}
                WHERE certificate_code = %s
                AND status = %s
                LIMIT 1",
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

        $infoIds = array_filter(
            array_map('absint', $infoIds)
        );

        if (empty($infoIds)) {
            return false;
        }

        $payment = new SwifCeMaPayment();

        /*
         * Get the records first because we need
         * image_url and pdf_url before deleting them.
         */
        $placeholders = implode(
            ', ',
            array_fill(0, count($infoIds), '%d')
        );

        $infos = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT *
                FROM {$this->table}
                WHERE id IN ({$placeholders})",
                $infoIds
            )
        );

        if (empty($infos)) {
            return false;
        }

        foreach ($infos as $info) {

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
        }

        /*
         * Delete all certificate records in one query.
         */
        return $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$this->table}
                WHERE id IN ({$placeholders})",
                $infoIds
            )
        );
    }
}