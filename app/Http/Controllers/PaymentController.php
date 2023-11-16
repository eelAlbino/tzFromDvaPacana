<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Contracts\Swagger\Controllers\IPaymentControllerSwagger;

class PaymentController extends Controller implements IPaymentControllerSwagger
{

    /**
     * Триггер обновления элемента оплаты для отправки данных элемента на шлюз
     * 
     * @param int $id
     */
    public function touch(int $id)
    {
        $result = [
            'success' => false,
            'errors' => []
        ];
        $pageCode = 200;
        do {
            $payment = Payment::find($id);
            if (!$payment) {
                $result['errors'][]= [
                    'code' => 'not_found',
                    'message' => 'Элемент не найден'
                ];
                $pageCode = 404;
                break;
            }
            if (!$payment->touch()) {
                $result['errors'][]= [
                    'code' => 'not_updated',
                    'message' => 'Элемент не был обновлен'
                ];
                $pageCode = 500;
                break;
            }
            $result['success'] = true;
        } while (false);
        return response()->json($result, $pageCode);
    }
}
