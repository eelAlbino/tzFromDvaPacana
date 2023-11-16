<?php

namespace App\Contracts\Swagger;

/**
 * @OA\Response(
 *		response="NotFound",
 *		description="Ничего не найдено",
 *		@OA\JsonContent(
 *	   		@OA\Property(
 *				property="success",
 *				type="boolean",
 *				example=false
 *			),
 *	   		@OA\Property(
 *				property="errors",
 *				type="array",
 *				@OA\Items(
 *					type="object",
 *					@OA\Property(
 *						property="code",
 *						description="Код ошибки",
 *						example="not_found"
 *					),
 *					@OA\Property(
 *						property="message",
 *						description="Описание ошибки",
 *						example="Элемент не найден"
 *					)
 *				)
 *			)
 *		)
 * 	)
 */

interface IResponseSwagger
{

}