<?php

namespace App\Http\Requests\Ticket;

use App\Http\Requests\Base\BaseGetRequest;
use Illuminate\Foundation\Http\FormRequest;

class GetTicketRequest extends BaseGetRequest
{
    /**
     * 各フィールドのバリデーション内容を記載
     *
     * @var array
     */
    protected $validation = [];

    /**
     * 各APIでクエリパラメータとして使用可能なカラムを記載
     *
     * @var array
     */
    protected $conditional = [
        "parent_id"
    ];


}
