<?php
declare(strict_types=1);

namespace Rstrawbe\Rates\Validators;


use Psr\Http\Message\ResponseInterface;
use Rakit\Validation\Validator;
use Rstrawbe\Rates\Dto\RatesResponse;
use Rstrawbe\Rates\Dto\Request\RatesParams;
use Rstrawbe\Rates\Exceptions\Validation\RatesResponseException;

class RatesResponseValidator
{
    /**
     * @throws RatesResponseException
     */
    public function validated(ResponseInterface $response, RatesParams $params): RatesResponse
    {
        $json = (string)$response->getBody();
        $data = \json_decode($json, true);
        if (!is_array($data)) {
            throw new RatesResponseException('Invalid JSON response');
        }

        $validator = new Validator;
        $validation = $validator->validate($data, [
            'disclaimer' => 'required',
            'license' => 'required',
            'timestamp' => 'required|integer',
            'base' => 'required|in:' . $params->getBase(),
            'rates' => 'required|array',
            'rates.*' => 'required|numeric',
        ]);


        if ($validation->fails()) {
            throw new RatesResponseException($validation->errors()->all()[0]);
        }

        return RatesResponse::fromArray($data);
    }
}