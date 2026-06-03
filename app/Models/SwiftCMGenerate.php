<?php

namespace SwiftCertificateManager\Models;

use SwiftCertificateManager\Hooks\Handlers\AvailableOptions;
use SwiftCertificateManager\Models\SwiftCMPayment;

class SwiftCMGenerate {

    protected $table = 'swiftcm_generates';
   
    public function getDatas($params)
    {
        // assume already sanitized, but still safe fallback
        $search      = $params['search'] ?? '';
        $status      = $params['status'] ?? '';
        $currentPage = $params['current_page'] ?? 1;
        $perPage     = $params['per_page'] ?? 10;

        $offset = ($currentPage - 1) * $perPage;

        $query = swiftcm_query()->table($this->table)
            ->orderBy('id', 'DESC');

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                ->orWhere('course_name', 'LIKE', "%{$search}%")
                ->orWhere('student_name', 'LIKE', "%{$search}%")
                ->orWhere('graduation_date', 'LIKE', "%{$search}%")
                ->orWhere('certificate_code', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('payment_status', 'LIKE', "%{$search}%");
            });
        }

        // total আগে count
        $total = (clone $query)->count();

        // pagination
        $infos = $query->offset($offset)->limit($perPage)->get();

        foreach ($infos as $info) {
            $info->human_created_at = human_time_diff(strtotime($info->created_at), time()) . ' ago';
        }

        return [
            'infos'        => $infos,
            'total'        => $total,
            'last_page'    => (int) ceil($total / $perPage),
            'current_page' => $currentPage,
        ];
    }
    
    public function getInfo($id)
    {
        return swiftcm_query()
            ->table($this->table)
            ->where('id', $id)
            ->first();
    }

    public function find($id)
    {
        $info = swiftcm_query()->table($this->table)->where('id', $id)->first();

        return $info;
    }

    public function insertGetId($data) {
        $save = swiftcm_query()->table($this->table)->insert($data);

        return $save;
    }


    public function updateInfo($id, $data) {
       
        $update = swiftcm_query()->table($this->table)
                ->where('id', $id)
                ->update($data);

        return $update; 
    }


    public function updateStatus($infoIds, $actionType) {
    
        $data = [
            'status'     => $actionType,
            'updated_at' => gmdate('Y-m-d H:i:s')
        ];

        swiftcm_query()->table($this->table)->whereIn('id', $infoIds)->update($data);
    }

    public function verifyCertificateCode($certificateCode) {
       
        $info = swiftcm_query()->table($this->table)
                ->where('certificate_code', $certificateCode)
                ->where('status', 'assign')
                ->first();

        return $info; 
    }

    public function deleteInfo($infoIds) {
        $payment = new SwiftCMPayment();

        $infos = swiftcm_query()->table($this->table)->whereIn('id', $infoIds)->get();

        foreach ($infos as $info) {
            swiftcm_query()->table($this->table)->where('id', $info->id)->delete();

            $payment->deletePaymentTransactionsByRequestId($info->id);

            // Removed certificate
            if (!empty($info->image_url) || !empty($info->pdf_url)) {
                $filenames = array_filter([$info->image_url, $info->pdf_url]);
                AvailableOptions::removedFile($filenames); 
            }
        }
    }
}