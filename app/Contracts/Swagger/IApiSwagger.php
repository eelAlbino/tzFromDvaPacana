<?php

namespace App\Contracts\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 * 	    title="Тестовое задание",
 *      version="1.0.0",
 *      description="Для проведения теста необходимо сделать следующее:<ul><li>Установить миграции с сидами.</li><li>Заполнить необходимые доступы к шлюзам в env файле.</li><li>Настроить очереди</li><li>Выполнить запрос на обновление элемента оплаты</li></ul>После обновления элемента при помощи очереди в фоновом режиме происходит отправка данных оплаты в соответствующий шлюз"
 * )
 */
interface IApiSwagger
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      description="Документация на сваггере для тестового задания"
     *      @OA\Contact(
     *          email=L5_SWAGGER_CONST_EMAIL
     *      )
     * ),
     *
     * @OA\Server(
     *      url=APP_URL,
     *      description="API"
     * )
     */

}
