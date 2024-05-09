<?php

namespace Enums;

enum StatusEnum: string
{
    case WAIT = 'ожидает модерации';
    case DENY = 'отклонен';
    case PUBLISHED = 'опубликован';
}