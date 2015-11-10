<?php
namespace Aacp\OnlineConvertApiBundle\Validator;

use JsonSchema\RefResolver;
use JsonSchema\Uri\UriRetriever;
use JsonSchema\Validator;

class ConversionOptions implements Interfaced
{

    protected $validator;

    public function __construct(Validator $validator = null)
    {
        $this->validator = $validator;
        if (!$validator) {
            $this->validator = new Validator();
        }
    }


    /**
     * @param $data
     * @param $constraints
     * @return mixed
     */
    public function validate($data, $constraints)
    {
        $retriever = new RefResolver();
         $schema= $retriever->resolve($constraints);
        $this->validator->check($data, $schema);

        if ($this->validator->isValid()) {
            return true;
        }

        throw new NoValidOptionsException('Options no valid '. print_r($data, $constraints));
    }


}