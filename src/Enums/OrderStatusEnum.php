<?php

namespace App\Enums;

enum OrderStatusEnum: string {
    case Pending = 'Ожидает обработки';
    case Approved = 'Принят, в сборке';
    case Rejected = 'Отменен';
    case Delivery = 'Передан в доставку';
    case Await = 'Ожидает получения';
    case Success = 'Выполнен';
}
