<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * 共通リクエスト
 */
class BasePostRequest extends FormRequest
{

    /**
     * 各フィールドのバリデーション内容を記載
     *
     * @var array
     */
    protected $validation = [];

    /**
     * limit, pageのバリデーション内容
     *
     * @var array
     */
    protected $baseValidation = [
        'limit' => ['integer', 'min:1'],
        'page' => ['integer', 'min:1'],
    ];

    /**
     * 各APIでsort可能なカラムを記載
     *
     * @var array
     */
    protected $sortable = [];

    /**
     * 各APIでfields可能なカラムを記載
     *
     * @var array
     */
    protected $selectable = [];

    /**
     * 各APIでクエリパラメータとして使用可能なカラムを記載
     *
     * @var array
     */
    protected $conditional = [];

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
     * 指定可能なソート順を記載
     *
     * @var array
     */
    protected $asCending = ['asc', 'desc'];

    /**
     * クエリパラメータでfieldsに記載されているものが格納される
     *
     * @var array
     */
    protected $fieldsQuery = [];

    /**
     * クエリパラメータでsortに記載されているものが格納される
     * sort１つにつき、[fields=>xx, asCending=>yy]の配列で格納される
     *
     * @var array
     */
    protected $sortQuery = [];

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
        if ($this->has('sort')) {
            $sortArray = explode(',', $this->sort);
            foreach ($sortArray as $sort) {
                $each['field'] = explode(':', $sort)[0];
                $each['asCending'] = explode(':', $sort)[1];
                $this->sortQuery[] = $each;
            }
        }

        if ($this->has('fields')) {
            $fieldsArray = explode(',', $this->fields);
            foreach ($fieldsArray as $field) {
                $this->fieldsQuery[] = $field;
            }
        }

        $this->rules = array_merge($this->baseValidation, $this->validation);
        $this->requestBodyAvailable = array_merge($this->baseRequestBodyAvailable, $this->requestBodyAvailable);
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
            $unacceptedFields = array_diff($this->fieldsQuery, $this->selectable);
            if ($unacceptedFields !== []) {
                $validator->errors()->add('fields', "{$unacceptedFields[0]}はfieldsに対応していません");
                return;
            }

            $queryParam = array_filter($this->query(), function ($key) {
                return !in_array($key, ['fields', 'sort', 'limit', 'page','q']);
            }, ARRAY_FILTER_USE_KEY);
            $unacceptedQueryParam = array_diff(array_keys($queryParam), $this->conditional);
            if ($unacceptedQueryParam !== []) {
                $validator->errors()->add('query_param', "{$unacceptedQueryParam[0]}はクエリパラメータに対応していません");
                return;
            }
            foreach ($this->sortQuery as $sort) {
                if (!in_array($sort['field'], $this->sortable)) {
                    $validator->errors()->add('sort', "{$sort['field']}はsortに対応していません");
                    return;
                }
                if (!in_array($sort['asCending'], $this->asCending)) {
                    $validator->errors()->add('sort', "{$sort['asCending']}はsortに対応していません");
                    return;
                }
            }

            $method = $this->method();
            if ($method != 'GET' && $method != 'DELETE') {
                // GET, DELETE以外のメソッドの場合は、追加でリクエストボディが対応しているか見に行く
                $requestBody = $this->request->keys();
                $unacceptedRequestBody = array_diff($requestBody, $this->requestBodyAvailable);
                if ($unacceptedRequestBody !== []) {
                    $validator->errors()->add('requestBody', "{$unacceptedRequestBody[0]}はリクエストボディに対応していません");
                    return;
                }
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

    /**
     * リクエストクラスに定義されている配列を元に、QueryConditionHelperのコンストラクタ用の配列を作成する
     * レンジピッカーから投げられるクエリは-from, -toが付くので、-from, -toを取り除いたものを取得する
     *
     * @param array $array
     * @return array
     * @throws Exception
     */
    protected function getArrayForQueryConditionHelper(array $array):array
    {
        $result = [];
        foreach ($array as $value) {
            $key = $value;
            if (strpos($key, '-from')) {
                $value = str_replace('-from', '', $value);
            }
            if (strpos($key, '-to')) {
                $value = str_replace('-to', '', $value);
            }
            $result[$key] = $value;
        }
        return $result;
    }

    public static function getConditionalArrayForQueryConditionHelper():array
    {
        $self = new static;
        return $self->getArrayForQueryConditionHelper($self->conditional);
    }

    public static function getSortableArrayForQueryConditionHelper():array
    {
        $self = new static;
        return $self->getArrayForQueryConditionHelper($self->sortable);
    }
}
