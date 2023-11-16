<?php

namespace App\Contracts\Swagger\Models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="PaymentGateway",
 *      description="Шлюз оплаты",
 *      type="object",
 *      @OA\Property(
 *          property="code",
 *          type="string",
 *          description="Уникальный код. Для шлюзов, указанных в задаче, через сидеры создаются элементы с кодами test_first и test_second",
 *          example="test_first"
 *      ),
 *      @OA\Property(
 *          property="callback_url",
 *          type="string",
 *          description="Url для передачи данных при изменении состояния платежа",
 *          example="https:/example.com/api/callback"
 *      ),
 *      @OA\Property(
 *          property="callback_limit_day",
 *          type="number",
 *          description="Лимит, после прохождения которого проведение платежей останавливается до следующего дня.",
 *          example="https:/example.com/api/callback"
 *      ),
 * )
 */
interface IPaymentGatewaySwagger
{

}
