<?php

namespace App\Contracts\Swagger\Models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Payment",
 *      description="Элемент оплаты",
 *      type="object",
 *      @OA\Property(
 *          property="guid",
 *          type="number",
 *          description="Внешний ID оплаты",
 *          example=123
 *      ),
 *      @OA\Property(
 *          property="customer_id",
 *          type="number",
 *          description="Внутренний ID покупателя",
 *          example=123
 *      ),
 *      @OA\Property(
 *          property="gateway_id",
 *          type="number",
 *          description="Внутренний ID шлюза",
 *          example=123
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="string",
 *          description="Внутренний код статуса",
 *          example="created"
 *      ),
 *      @OA\Property(
 *          property="amount",
 *          type="number",
 *          description="Число к оплате, в центах",
 *          example=5000
 *      ),
 *      @OA\Property(
 *          property="amount_paid",
 *          type="number",
 *          description="Уже оплачено, в центах",
 *          example=1000
 *      )
 * )
 */
interface IPaymentSwagger
{

}
