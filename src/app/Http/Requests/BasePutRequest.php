<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * 共通リクエスト
 */
class BasePutRequest extends FormRequest
{

    /**
     * 各フィールドのバリデーション内容を記載
     *
     * @var array
     */
    protected $validation = [];

    /**
     * 各APIでリクエストボディで使用可能なカラムを記載
     * 登録更新系で使用
     *
     * @var array
     */
    protected $requestBodyAvailable = [];

    /**
     * 共通で許可されるべきリクエスト内容
     *
     * @var array
     */
    protected $baseRequestBodyAvailable = [
    ];

    /**
     * バリデーションルールが格納される
     *
     * @var array
     */
    protected $rules;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * sortとfieldsの内容を取得する
     *
     * @return void
     */
    protected function prepareForValidation()
    {
    }

    /**
     * fieldsとsortのバリデーション、クエリパラメータとリクエストボディが指定可能なものかを判定
     *
     * @param $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // GET, DELETE以外のメソッドの場合は、追加でリクエストボディが対応しているか見に行く
            $requestBody = $this->request->keys();
            $unacceptedRequestBody = array_diff($requestBody, $this->requestBodyAvailable);
            if ($unacceptedRequestBody !== []) {
                $validator->errors()->add('requestBody', "{$unacceptedRequestBody[0]}はリクエストボディに対応していません");
                return;
            }
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $res = response()->json([
            'type' => "",
            'title' => "Invalid Param Error",
            'detail' => $validator->errors()->first(),
            'code' => '400'
        ], 400);
        throw new HttpResponseException($res);
    }

    protected function passedValidation()
    {
    }

}
