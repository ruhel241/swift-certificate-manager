<?php

namespace SwiftCertificateManager\Models;

class Payment
{
    protected $table = "swiftcm_payments";

    public function insertGetId($data) {
        $save = SwiftCertificateManagerQuery()->table($this->table)->insert($data);

        return $save;
    }

     public function updateData($id, $data)
     {
         return SwiftCertificateManagerQuery()->table($this->table)->where('id', $id)->update($data);
     }

     public function find($id)
     {
         return SwiftCertificateManagerQuery()->table($this->table)->where('id', $id)->first();
     }

    public function getHash($hash)
    {
        return SwiftCertificateManagerQuery()->table($this->table)->where('entry_hash', $hash)->first();
    }

    // public function delete($id, $column = 'id')
    // {
    //     return SwiftCertificateManagerQuery()->table($this->table)->where('entry_id', $id)->delete();
    // }

     public function getPaymentTransactions($request)
     {
         $currentPage  = sanitize_text_field($request['current_page']);
         $perPage      = sanitize_text_field($request['per_page']);
         $offset       = $perPage * ($currentPage - 1);

         $transactions = SwiftCertificateManagerQuery()->table($this->table)
//             ->where('payment_status', 'paid')
             ->orderBy('id', 'DESC')
             ->offset($offset)
             ->limit($perPage);

         $paymentTransactions = $transactions->get();

         $total = $transactions->count();

         $lastPage = (int) ceil($total / $perPage);

         $data = [
             'payment_transactions' => $paymentTransactions,
             'total'     => $total,
             'last_page' => $lastPage,
             'current_page' => intval($currentPage),
         ];

         return $data;
     }

    public function getQuery()
    {
        return SwiftCertificateManagerQuery()->table($this->table);
    }


    public function getByPaymentId($chargeId, $method = 'paypal')
    {
        $payment =  SwiftCertificateManagerQuery()->table($this->table)
            ->where('charge_id', $chargeId)
            ->where('payment_method', $method)
            ->first();

        if ($payment) {
            return $payment->id;
        }

        return false;
    }

    public function deleteInfo($transactionIds) {
        $transactions = SwiftCertificateManagerQuery()->table($this->table)->whereIn('id', $transactionIds)->get();

        foreach ($transactions as $transaction) {
            SwiftCertificateManagerQuery()->table($this->table)->where('id', $transaction->id)->delete();
        }
    }
}
