<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class LoginRequest extends FormRequest implements ServerRequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
//        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function withProtocolVersion(string $version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    public function getHeader(string $name)
    {
        // TODO: Implement getHeader() method.
    }

    public function getHeaderLine(string $name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    public function withHeader(string $name, $value)
    {
        // TODO: Implement withHeader() method.
    }

    public function withAddedHeader(string $name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader(string $name)
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    public function getRequestTarget()
    {
        // TODO: Implement getRequestTarget() method.
    }

    public function withRequestTarget(string $requestTarget)
    {
        // TODO: Implement withRequestTarget() method.
    }

    public function withMethod(string $method)
    {
        // TODO: Implement withMethod() method.
    }

    public function withUri(UriInterface $uri, bool $preserveHost = false)
    {
        // TODO: Implement withUri() method.
    }

    public function getServerParams()
    {
        // TODO: Implement getServerParams() method.
    }

    public function getCookieParams()
    {
        // TODO: Implement getCookieParams() method.
    }

    public function withCookieParams(array $cookies)
    {
        // TODO: Implement withCookieParams() method.
    }

    public function getQueryParams()
    {
        // TODO: Implement getQueryParams() method.
    }

    public function withQueryParams(array $query)
    {
        // TODO: Implement withQueryParams() method.
    }

    public function getUploadedFiles()
    {
        // TODO: Implement getUploadedFiles() method.
    }

    public function withUploadedFiles(array $uploadedFiles)
    {
        // TODO: Implement withUploadedFiles() method.
    }

    public function getParsedBody()
    {
        // TODO: Implement getParsedBody() method.
    }

    public function withParsedBody($data)
    {
        // TODO: Implement withParsedBody() method.
    }

    public function getAttributes()
    {
        // TODO: Implement getAttributes() method.
    }

    public function getAttribute(string $name, $default = null)
    {
        // TODO: Implement getAttribute() method.
    }

    public function withAttribute(string $name, $value)
    {
        // TODO: Implement withAttribute() method.
    }

    public function withoutAttribute(string $name)
    {
        // TODO: Implement withoutAttribute() method.
    }
}
