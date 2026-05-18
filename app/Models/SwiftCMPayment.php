<?php

namespace SwiftCertificateManager\Models;

class SwiftCMPayment
{
    protected $table = "swiftcm_payments";

    public function insertGetId($data) {
        $save = swiftcm_query()->table($this->table)->insert($data);

        return $save;
    }

     public function updateData($id, $data)
     {
         return swiftcm_query()->table($this->table)->where('id', $id)->update($data);
     }

     public function find($id)
     {
         return swiftcm_query()->table($this->table)->where('id', $id)->first();
     }

    public function getHash($hash)
    {
        return swiftcm_query()->table($this->table)->where('entry_hash', $hash)->first();
    }

    // public function delete($id, $column = 'id')
    // {
    //     return swiftcm_query()->table($this->table)->where('entry_id', $id)->delete();
    // }

     public function getPaymentTransactions($request)
     {
         $currentPage  = sanitize_text_field($request['current_page']);
         $perPage      = sanitize_text_field($request['per_page']);
         $offset       = $perPage * ($currentPage - 1);

         $transactions = swiftcm_query()->table($this->table)
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
        return swiftcm_query()->table($this->table);
    }


    public function getByPaymentId($chargeId, $method = 'paypal')
    {
        $payment =  swiftcm_query()->table($this->table)
            ->where('charge_id', $chargeId)
            ->where('payment_method', $method)
            ->first();

        if ($payment) {
            return $payment->id;
        }

        return false;
    }

    public function deleteInfo($transactionIds) {
        $transactions = swiftcm_query()->table($this->table)->whereIn('id', $transactionIds)->get();

        foreach ($transactions as $transaction) {
            swiftcm_query()->table($this->table)->where('id', $transaction->id)->delete();
        }
    }

	public function deletePaymentTransactionsByRequestId($id) {
        $id = absint($id);
    
        if (!$id) {
            return;
        }
    
        swiftcm_query()->table($this->table)->where('request_id', $id)->delete();
    }
}
