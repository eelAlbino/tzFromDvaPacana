<?php

namespace App\Contracts\Swagger\Controllers;

use App\Http\Requests\StorePostRequest;
use OpenApi\Annotations as OA;

interface IPaymentControllerSwagger
{
    /**
     * @OA\Get(
     *    path="/api/payments/{paymentID}/touch",
     *    summary="Триггер обновления элемента оплаты",
     *    description="",
     *    operationId="payments_touch",
     *    tags={"Оплаты"},
     *    @OA\Parameter(
     *  	name="paymentID",
     *  	description="ID элемента оплаты",
     *  	required=true,
     *  	in="path",
     *  	@OA\Schema(
     *  		type="integer"
     *  	)
     *    ),
     * 	  @OA\Response(
     *        response=200,
     *        description="Элемент успешно обновлен",
     *		  @OA\JsonContent(
     *            required={"payload"},
     *	   		  @OA\Property(
     *                property="success",
     *                type="boolean",
     *                example=true
     *            )
     *         )
     *    ),
     * 	  @OA\Response(
     *        response=500,
     *        description="Элемент не обновлен",
     *		  @OA\JsonContent(
     *            required={"payload"},
     *	   		  @OA\Property(
     *                property="success",
     *                type="boolean",
     *                example=false
     *            ),
     *            @OA\Property(
     *				property="errors",
     *				type="array",
     *				@OA\Items(
     *					type="object",
     *					@OA\Property(
     *						property="code",
     *						description="Код ошибки",
     *						example="not_updated"
     *					),
     *					@OA\Property(
     *						property="message",
     *						description="Описание ошибки",
     *						example="Элемент не обновлен"
     *					)
     *				)
     *			)
     *         )
     *     ),
     *     @OA\Response(response=404, ref="#/components/responses/NotFound")
     * )
     *
     * Touch payment elem.
     *
     * @param int $id
     */
    public function touch(int $id);
}
