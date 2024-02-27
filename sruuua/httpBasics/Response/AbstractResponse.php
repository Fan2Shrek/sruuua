<?php

namespace Sruuua\HTTPBasics\Response;

abstract class AbstractResponse
{
    protected int $code;

    protected mixed $content = null;

    public function __construct(?int $code = 200, mixed $content = null)
    {
        $this->code = $code;
        $this->content = $content;
    }

    /**
     * @return mixed|null
     */
    public function getContent(): mixed
    {
        return $this->content;
    }

    /**
     * @param mixed|null $content
     */
    public function setContent(mixed $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function response()
    {
        $this();
    }

    public function __invoke()
    {
        http_response_code($this->getCode());
        if (null !== $this->content) {
            echo $this->content;
        }
    }
}
