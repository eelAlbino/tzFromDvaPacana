<?php

namespace App\Contracts\Swagger\Models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="PaymentStatus",
 *      description="Статус оплаты",
 *      type="object",
 *      @OA\Property(
 *          property="code",
 *          type="string",
 *          description="Уникальный код. Хотел бы тут отметить, что в принципе по тз не описано, что именно со статусами делать надо, поэтому реализовал их так. Создание первоначальных статусов происходит через сидер",
 *          example="created"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Название",
 *          example="Создана"
 *      )
 * )
 */
interface IPaymentStatusSwagger
{

}
